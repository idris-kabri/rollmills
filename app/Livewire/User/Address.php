<?php

namespace App\Livewire\User;

use Livewire\Component;

class Address extends Component
{
    public function render()
    {
        return view('livewire.user.address')->layout('layouts.user.app');
    }
}
