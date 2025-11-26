<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderComponent extends Component
{
    public function render()
    {
        $user_orders = Order::where('logged_in_user_id', Auth::user()->id)->where('status', 1)->orderBy('id', 'desc')->get();
        return view('livewire.user.order-component', compact('user_orders'))->layout('layouts.user.app');
    }
}
