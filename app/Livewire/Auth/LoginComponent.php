<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

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

    public function updatedOtp($value, $index)
    {
        $otpCode = implode('', $this->otp);
        if (strlen($otpCode) === 4) {
            $this->enteredOtp = $otpCode;
        }
    }

    public function messageSend($otp)
    {
        try {
            $token = 'EAAWBZAOKnVrMBQMBZCU8kWa8fXMZADlKZAE9euLlFQuxkWhA92Q4ZBtmg9CYJAnMmQFgC19Dg81TK8cC7F63KLif27C2C1jx9zYWNIX3FseLhShZCWBgZBGSFTcLRbiKVudbtZBhk4SN8SjX9ZBOSv58V5yitVJ3gzPuZBmiZCmcXUJZBpgCIIja8tpvNm12eGklREFPQQZDZD';
            $phoneNumberId = '729760939534730';
            $apiVersion = 'v17.0';

            $url = "https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages";

            $payload = [
                'messaging_product' => 'whatsapp',
                'to' => '91' . $this->mobile,
                'type' => 'template',
                'template' => [
                    'name' => 'login_otp',
                    'language' => ['code' => 'en'],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => [['type' => 'text', 'text' => (string) $otp]],
                        ],
                    ],
                ],
            ];

            $response = Http::withToken($token)->post($url, $payload);

            \Log::info('WhatsApp Response:', [$response->body()]);
            if ($response->successful()) {
                return true;
            } else {
                \Log::warning('OTP failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                return false;
            }
        } catch (\Exception $e) {
            \Log::error('WhatsApp OTP exception: ' . $e->getMessage());
            return false;
        }
    }

    public function updatedMobile($value)
    {
        $this->mobile = preg_replace('/\D/', '', (string) $value);

        if (strlen($this->mobile) === 10) {
            $check_user = User::where('mobile', $this->mobile)->first();
            $otp = rand(1000, 9999);
            if ($check_user) {
                if ($check_user->role == 'admin') {
                    $this->password_section_show = true;
                } else {
                    $this->messageSend($otp);
                    $check_user->otp = $otp;
                    $check_user->save();
                    $this->otp_section_show = true;
                }
            } else {
                $user = new User();
                $user->role = 'user';
                $user->mobile = $this->mobile;
                $user->otp = $otp;
                $user->save();
                wawiContact($user);
                $this->messageSend($otp);
                $this->otp_section_show = true;
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

                    $get_all_whislist = Cart::instance('wishlist')->content();
                    Cart::instance('wishlist')->restore(Auth::user()->mobile);
                    Cart::instance('wishlist')->store(Auth::user()->mobile);

                    $get_all_cart = Cart::instance('cart')->content();
                    Cart::instance('cart')->restore(Auth::user()->mobile);
                    Cart::instance('cart')->store(Auth::user()->mobile);

                    return redirect('/');
                } else {
                    $this->addError('otp', 'You Enter Wrong Otp!');
                }
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.auth.login-component')->layout('layouts.user.app');
    }
}
