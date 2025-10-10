<?php

namespace App\Livewire\Auth;

use Livewire\Component;

class LoginComponent extends Component
{
    public function render()
    {
        return view('livewire.auth.login-component')->layout('layouts.user.app');
    }
}
