<?php

namespace App\Livewire\User;

use Livewire\Component;

class CouponClaim extends Component
{
    public function render()
    {
        return view('livewire.user.coupon-claim')->layout('layouts.user.app');
    }
}
