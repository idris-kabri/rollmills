<?php

namespace App\Livewire\User\Component;

use Livewire\Component;
use App\Traits\HasToastNotification;

class HeaderCartComponent extends Component
{
    use HasToastNotification;
    public function removeFromCart($rowId){
        $removeCart = finalRemoveFromCart($rowId); 
        if($removeCart){ 
            $this->toastError('Product Remove Successfully From Your Cart!');
        }
    }
    
    public function render()
    {
        return view('livewire.user.component.header-cart-component');
    }
}
