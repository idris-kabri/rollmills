<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;

class OrderDetail extends Component
{
    public $id;

    public function mount($id){
        $this->id = $id;
    }

    public function render()
    {
        $order = Order::find($this->id);
        return view('livewire.user.order-detail', compact('order'))->layout('layouts.user.app');
    }
}
