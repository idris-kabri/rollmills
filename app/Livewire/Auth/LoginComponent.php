<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cart;
use Illuminate\Support\Facades\Validator;

class LoginComponent extends Component
{
    use HasToastNotification;
    public $email;
    public $password;
    public $forget_password_email;
    public function render()
    {
        return view('livewire.auth.login-component')->layout('layouts.user.app');
    }

    public function loginCheck()
    {
        $this->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', $this->email)->first();
            if ($user && Hash::check($this->password, $user->password)) {
                // Auth::attempt(['email' => $this->email, 'password' => $this->password]); 
                Auth::login($user);
                $this->toastSuccess('Logged In Successfully!');
                if (Auth::user()->role == 'admin') {
                    return redirect("/admin");
                } else { 
                    $get_all_whislist = Cart::instance('wishlist')->content(); 
                    Cart::instance('wishlist')->restore(Auth::user()->email); 
                    Cart::instance('wishlist')->store(Auth::user()->email);  

                    $get_all_cart = Cart::instance('cart')->content(); 
                    Cart::instance('cart')->restore(Auth::user()->email);
                    Cart::instance('cart')->store(Auth::user()->email);
                    
                    return redirect("/");
                }
            } else {
                $this->addError('password', 'Invalid password.');
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }
}
