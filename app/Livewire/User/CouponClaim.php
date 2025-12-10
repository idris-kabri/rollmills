<?php

namespace App\Livewire\User;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CouponClaim extends Component
{
    use HasToastNotification;
    public $step = 1; // 1: Mobile, 2: OTP, 3: Coupon Shown
    public $mobile = '';
    public $otp = ['', '', '', '']; // Array for 4 digits
    public $user_id;
    public $couponCode;
    public $coupon;

    // Validation rules
    protected $rules = [
        'mobile' => 'required|digits:10',
        'otp.*' => 'required|numeric|digits:1',
    ];

    public function sendOTP()
    {
        $this->validate(['mobile' => 'required|digits:10']);
        
        // Find or Create user logic (Adjust based on your needs)
        $user = User::where('mobile', $this->mobile)->first();
        
        $otpCode = rand(1000, 9999);
        if ($user) {
            $user->otp = $otpCode;
            $user->save();
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

    public function mount()
    {
        if (Auth::check()) {
            $this->step = 3;
            $this->user_id = Auth::user()->id;
        }
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

        $user = User::where('mobile', $this->mobile)
            ->where('otp', $enteredOtp)
            ->first();

        if ($user) {
            $this->user_id = $user->id;
            $this->step = 3;
            $this->dispatch('close-modal');
            Auth::login($user);
        } else {
            $this->addError('otp', 'Invalid OTP. Please try again.');
            $this->reset('otp');
        }
    }

    public function resend()
    {
        $this->sendOTP();
        $this->dispatch('reset-timer'); // Event for AlpineJS
    }

    public function applyCoupon($id)
    {
        $order = Order::find($id);
        if ($order && $order->logged_in_user_id == $this->user_id) {
            $order->is_coupon_avail = 1;
            $order->save();
            session()->flash('message', 'Coupon applied successfully!');
        } else {
            session()->flash('error', 'Unable to apply coupon. Please try again.');
        }
        $user = User::find($this->user_id);
        $settings = Setting::all();


        // Get first name only
        $nameParts = preg_split('/\s+/', trim($user->name));
        $firstName = $nameParts[0]; // only first name

        $randomNumber = rand(10, 200);

        // Build coupon code with first name only
        $couponCode = $firstName . $randomNumber;


        $coupon = new Coupon;
        $coupon->title = "Coupon for Order #" . $order->id;
        $coupon->coupon_code = $couponCode;
        $coupon->minimum_order_value = $settings->where('label', 'coupon_min_order_value')->first()->value ?? 0;
        $coupon->discount_type = $settings->where('label', 'coupon_discount_type')->first()->value ?? 0;
        $coupon->discount_value = $settings->where('label', 'discount_value')->first()->value ?? 0;
        $coupon->maximum_discount_amount = $settings->where('label', 'coupon_max_discount')->first()->value ?? 0;
        $coupon->usage_limit = 1;
        $coupon->total_usage = 1;
        $coupon->category = "";
        $coupon->expiry_date = Carbon::now()->addDays((int)$settings->where('label', 'coupon_expiry')->first()->value)->format('Y-m-d');
        $coupon->order_id = $order->id;
        $coupon->save();

        $this->coupon = $coupon;

        $this->couponCode = $couponCode;
        $this->step = 4;
        $this->toastSuccess("Coupon Availed Successfully!");
    }

    public function render()
    {
        $user_orders = "";
        if ($this->step == 3 && $this->user_id) {
            $user_orders = Order::where('logged_in_user_id', $this->user_id)->where("is_coupon_avail", 0)
                ->where('status', '!=', 0)
                ->orderBy('id', 'desc')
                ->get();
        }
        return view('livewire.user.coupon-claim', compact('user_orders'))->layout('layouts.user.app');
    }
}
