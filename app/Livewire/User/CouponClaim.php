<?php

namespace App\Livewire\User;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Traits\HasToastNotification;
use Livewire\Component;

class CouponClaim extends Component
{
    use HasToastNotification;
    public $step = 1; // 1: Mobile, 2: OTP, 3: Coupon Shown
    public $mobile = '';
    public $otp = ['', '', '', '']; // Array for 4 digits
    public $user_id;
    public $couponCode;

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

        if ($user) {
            $otpCode = rand(1000, 9999);
            $user->otp = $otpCode;
            $user->save();

            $this->step = 2;
        } else {
            $this->addError('mobile', 'User not found with this mobile number.');
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

            // LOGIN USER (Optional: If you want to actually log them in via Laravel)
            // auth()->login($user); 

            // DISPATCH EVENT TO CLOSE MODAL
            $this->dispatch('close-modal');
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
        $tags = ['VIP', 'GOLD', 'PRIME', 'MEGA', 'STAR', 'EXC', 'PLUS', 'PRO', 'FEST', 'WOW'];
        $randomTag = $tags[array_rand($tags)];
        $randomNumber = rand(10, 99);
        $couponCode = strtoupper($user->name) . "-" . $randomTag . "-" . $randomNumber;
        $coupon = new Coupon;
        $coupon->title = "Coupon for Order #" . $order->id;
        $coupon->coupon_code = $couponCode;
        $coupon->minimum_order_value = $settings->where('key', 'coupon_min_order_value')->first()->value ?? 0;
        $coupon->discount_type = $settings->where('key', 'coupon_discount_type')->first()->value ?? 0;
        $coupon->discount_value = $settings->where('key', 'discount_value')->first()->value ?? 0;
        $coupon->maximum_discount_amount = $settings->where('key', 'coupon_max_discount')->first()->value ?? 0;
        $coupon->usage_limit = 1;
        $coupon->total_usage = 1;
        $coupon->expiry_date = $settings->where('key', 'coupon_expiry')->first()->value ?? 0;
        $coupon->order_id = $order->id;
        $coupon->save();

        $this->couponCode = $couponCode;
        $this->step = 4;
        $this->toastSuccess("Coupon Availed Successfully!");
    }

    public function render()
    {
        $user_orders = "";
        if ($this->step == 3 && $this->user_id) {
            $user_orders = Order::where('logged_in_user_id', $this->user_id)->whhere("is_coupon_avail", 0)
                ->where('status', '!=', 0)
                ->orderBy('id', 'desc')
                ->get();
        }
        return view('livewire.user.coupon-claim', compact('user_orders'))->layout('layouts.user.app');
    }
}
