<?php

namespace App\Livewire\User\Component;

use Livewire\Component;

class ProductSaleCard extends Component
{
    public $product = [];
    public $parameter = '';
    public $get_sold = false;

    public function mount($product, $parameter = null, $get_sold = false)
    {
        $this->product = $product;
        if($parameter != null && $parameter != '') {
            $this->parameter = $parameter;
        }
        $this->get_sold = $get_sold;
    }
    
    public function render()
    {
        return view('livewire.user.component.product-sale-card');
    }
}
