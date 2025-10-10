<?php

namespace App\Livewire\User;

use Livewire\Component;

class ShopComponent extends Component
{
    public function render()
    {
        return view('livewire.user.shop-component')->layout('layouts.user.app');
    }
}
