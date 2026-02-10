<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\Transaction; // <--- Added missing import
use App\Traits\HasToastNotification;
use Carbon\Carbon;
use Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;

class CodConversionComponent extends Component
{
    use HasToastNotification;

    public $step = 1; // 1: Mobile, 2: OTP, 3: Order List, 4: Success
    public $mobile = '';
    public $otp = ['', '', '', '']; // Array for 4 digits
    public $user_id;
    public $couponCode;
    public $coupon;
    public $id = '';

    // Payment Variables
    #[Url]
    public $transaction_id = '';
    #[Url]
    public $payment_id = '';
    #[Url]
    public $order_id = ''; // Logic uses this, but URL sends 'id'

    public $confirmMessage = '';
    public $confirmAction = '';

    // Validation rules
    protected $rules = [
        'mobile' => 'required|digits:10',
        'otp.*' => 'required|numeric|digits:1',
    ];

    public function mount($id)
    {
        $this->id = $id;
        // 1. Manually grab URL parameters to ensure they are available immediately
        $this->transaction_id = request()->query('transaction_id');
        $this->payment_id = request()->query('payment_id');
        $this->order_id = request()->query('id'); // JS sends '&id=...', so we grab 'id'

        // 2. Handle Auth State
        if (Auth::check()) {
            $this->step = 3;
            $this->user_id = Auth::user()->id;
        }

        // 3. Handle Payment Success Return
        if ($this->transaction_id) {
            // Fix: Find the transaction by the ID passed back from Razorpay
            $transaction = Transaction::find($this->transaction_id);

            if ($transaction) {
                // Update Transaction
                $transaction->status = 1; // Mark as Paid
                $transaction->payment_id = $this->payment_id;
                $transaction->save();

                $amount = $transaction->amount;

                // Update Order
                $order = Order::find($this->id);

                if ($order) {
                    $order->paid_amount = $amount;
                    $discount = $order->total - $amount; // Calculate discount given (if any)

                    // Update Order Financials
                    $order->total = $amount;
                    $order->total_bonus = $discount;
                    $order->remaining_amount = 0;
                    $order->is_cod = 0; // Convert COD to Prepaid

                    // Adjust Delivery Charges
                    $cod_charges = $order->cod_charges;
                    $order->cod_charges = 0;
                    $order->total_delievery_charges = $order->total_delievery_charges - $cod_charges;

                    $order->save();

                    // Update Order Items (Bonus Calculation logic)
                    $order_items = $order->getOrderItems;
                    foreach ($order_items as $order_item) {
                        $official_price = $order_item->sale_default_price;
                        $bonus_amount = ($official_price * 10) / 100;

                        $order_item->bonus = $bonus_amount;
                        $total = $order_item->total;

                        // Recalculate item total
                        $order_item->total = $total - $bonus_amount * $order_item->quantity;
                        $order_item->save();
                    }

                    $parameters = [$order->getBillAddress->name, $this->order_id, $amount];

                    sendParameterTemplateWawi('cod_conversion_success', 'en_us', $order->getBillAddress->mobile, $parameters);

                    // 4. Trigger Success Screen
                    $this->step = 4;
                    $this->user_id = $order->logged_in_user_id;
                }
            }
        }
    }

    public function askClaim($order_id)
    {
        $this->confirmMessage = 'Are you sure you want to avail coupon for Order #' . $order_id . '?';
        $this->confirmAction = "applyCoupon('$order_id')";
        $this->dispatch('open-coupon-claim-modal');
    }

    public function sendOTP()
    {
        $this->validate(['mobile' => 'required|digits:10']);

        $user = User::where('mobile', $this->mobile)->first();
        $otpCode = rand(1000, 9999);

        if ($user) {
            $user->otp = $otpCode;
            $user->save();
            // Assuming messageSend is a global helper
            messageSend($this->mobile, $otpCode, 'login_otp');
        } else {
            $user = new User();
            $user->role = 'user';
            $user->mobile = $this->mobile;
            $user->otp = $otpCode;
            $user->save();
            messageSend($this->mobile, $otpCode, 'login_otp');
        }
        $this->step = 2;
    }

    public function backMain()
    {
        $this->step = 3;
    }

    public function verifyOTP()
    {
        $this->validate([
            'otp.0' => 'required|numeric',
            'otp.1' => 'required|numeric',
            'otp.2' => 'required|numeric',
            'otp.3' => 'required|numeric',
        ]);

        $enteredOtp = implode('', $this->otp);
        $user = User::where('mobile', $this->mobile)->where('otp', $enteredOtp)->first();

        if ($user) {
            $this->user_id = $user->id;
            $this->step = 3;
            $this->dispatch('close-modal');
            Auth::login($user);

            // Uncomment if you need cart restoration logic
            // Cart::instance('wishlist')->restore(Auth::user()->mobile);
            // Cart::instance('cart')->restore(Auth::user()->mobile);
        } else {
            $this->addError('otp', 'Invalid OTP. Please try again.');
            $this->reset('otp');
        }
    }

    public function resend()
    {
        $this->sendOTP();
        $this->dispatch('reset-timer');
    }

    public function payNow($id, $amount)
    {
        $user = User::find($this->user_id);

        // Ensure razorPayPayment helper returns the transaction object properly
        $transaction = razorPayPayment($amount, $this->user_id, $id, 'orders', 'Order Placed Using Online Payment');

        $this->dispatch('initiate-razorpay', [
            'transaction_id' => $transaction->transaction_id,
            'razorpay_order_id' => $transaction->id, // Razorpay Order ID (starts with order_)
            'amount' => $transaction->amount,
            'description' => $transaction->description,
            'name' => $user->name ?? 'Customer',
            'email' => $user->email ?? 'customer@example.com',
            'customer_name' => $user->name ?? 'Customer',
            'customer_email' => $user->email ?? 'customer@example.com',
            'id' => $id, // Order ID from database
            'success_url' => route('pay-now', ['id' => $this->id]), // This ensures user comes back to this page
        ]);
    }

    public function render()
    {
        $user_orders = [];

        if ($this->step == 3 && $this->user_id) {
            $user_orders = Order::where('id', $this->id)->where('is_cod', 1)->where('status', 1)->orderBy('id', 'desc')->first();
        }

        // Passing $id to view for the Success Screen (Step 4)
        return view('livewire.user.cod-conversion-component', [
            'user_orders' => $user_orders,
            'id' => $this->order_id, // Ensure view gets the ID for Success Screen
        ])->layout('layouts.user.app');
    }
}
