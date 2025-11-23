<?php

namespace App\Livewire\User;

use App\Traits\HasToastNotification;
use Livewire\Component;

class OrderCompleted extends Component
{  
    use HasToastNotification;
    
    public function mount(){ 
        if (session()->has("success")) {
            $this->toastSuccess('Your order placed successfully!');
        } 
        session()->forget('success');
    }
    public function render()
    {
        return view('livewire.user.order-completed')->layout('layouts.user.app');
    }
}
