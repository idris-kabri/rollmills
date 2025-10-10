<?php

namespace App\Livewire\User;

use Livewire\Component;

class WishlistComponent extends Component
{
    public function render()
    {
        return view('livewire.user.wishlist-component')->layout('layouts.user.app');
    }
}
