<?php

namespace App\Livewire\User;

use Livewire\Component;

class ShopDetailComponent extends Component
{
    public function render()
    {
        return view('livewire.user.shop-detail-component')->layout('layouts.user.app');
    }
}
