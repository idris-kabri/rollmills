<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;


class AccountComponent extends Component
{
    public function logoutUser()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.user.account-component')->layout('layouts.user.app');
    }
}
