<?php

namespace App\Livewire\User;

use Livewire\Component;

class ShippingPolicy extends Component
{
    public function render()
    {
        return view('livewire.user.shipping-policy')->layout('layouts.user.app');
    }
}
