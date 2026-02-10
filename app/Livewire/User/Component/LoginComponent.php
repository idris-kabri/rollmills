<?php

namespace App\Livewire\User\Component;

use Livewire\Component;
use App\Models\User;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class LoginComponent extends Component
{
    use HasToastNotification;
    public $mobile;
    public $password;
    public $forget_password_email;
    public $otp_section_show = false;
    public $password_section_show = false;
    public $otp = ['', '', '', ''];
    public $enteredOtp = null;
    public $is_new_user = false;

    public function updatedOtp($value, $index)
    {
        $otpCode = implode('', $this->otp);
        if (strlen($otpCode) === 4) {
            $this->enteredOtp = $otpCode;
        }
    }

    public function sendOTP()
    {
        if (strlen($this->mobile) === 10) {
            $check_user = User::where('mobile', $this->mobile)->first();
            $otp = rand(1000, 9999);
            if ($check_user) {
                if ($check_user->role == 'admin') {
                    $this->password_section_show = true;
                    $this->dispatch('password-show');
                } else {
                    messageSend($this->mobile, $otp, 'login_otp');
                    $check_user->otp = $otp;
                    $check_user->save();
                    $this->otp_section_show = true;
                    $this->dispatch('otp-show');
                }
            } else {
                $user = new User();
                $user->role = 'user';
                $user->mobile = $this->mobile;
                $user->otp = $otp;
                $user->save();
                $this->is_new_user = true;
                wawiContact($user);
                messageSend($this->mobile, $otp, 'login_otp');
                $this->otp_section_show = true;
                $this->dispatch('');
            }
        } else {
            $this->otp_section_show = false;
        }
    }

    public function loginCheck()
    {
        $this->validate([
            'mobile' => 'required|exists:users,mobile',
            'password' => 'sometimes',
        ]);

        try {
            $user = User::where('mobile', $this->mobile)->first();
            if ($this->password) {
                if ($user && Hash::check($this->password, $user->password)) {
                    Auth::login($user);
                    $this->toastSuccess('Logged In Successfully!');
                    if (Auth::user()->role == 'admin') {
                        return redirect('/admin');
                    }
                } else {
                    $this->addError('password', 'Invalid password.');
                }
            } else {
                $user = User::where('mobile', $this->mobile)->where('otp', $this->enteredOtp)->first();
                if ($user) {
                    Auth::login($user);

                    // $get_all_whislist = Cart::instance('wishlist')->content();
                    // Cart::instance('wishlist')->restore(Auth::user()->mobile);
                    // Cart::instance('wishlist')->store(Auth::user()->mobile);

                    // $get_all_cart = Cart::instance('cart')->content();
                    // Cart::instance('cart')->restore(Auth::user()->mobile);
                    // Cart::instance('cart')->store(Auth::user()->mobile);
                    if ($this->is_new_user) {
                        sendNormalTemplateWawi('welcome_message2', 'en_us', $this->mobile);
                    }

                    return $this->dispatch('refresh-login');
                } else {
                    $this->addError('otp', 'You Enter Wrong Otp!');
                }
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }
    public function resend()
    {
        $check_user = User::where('mobile', $this->mobile)->first();
        $otp = rand(1000, 9999);
        $check_user->otp = $otp;
        $check_user->save();
        messageSend($this->mobile, $otp, 'login_otp');

        $this->toastSuccess('OTP Resend Successfully!');
        $this->dispatch('resend-otp');
    }
    public function render()
    {
        return view('livewire.user.component.login-component');
    }
}
