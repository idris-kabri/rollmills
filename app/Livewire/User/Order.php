<?php

namespace App\Livewire\User;

use Livewire\Component;

class Order extends Component
{
    public function render()
    {
        return view('livewire.user.order')->layout('layouts.user.app');
    }
}
