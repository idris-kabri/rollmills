<?php

namespace App\Livewire\Admin\GiftCardItem;

use App\Models\GiftCardItem;
use App\Models\Order;
use Livewire\Component;

class View extends Component
{ 
    public $order; 
    public $gift_card_item; 

    public function mount($id){ 
        $this->order = Order::where('status',1)->where('gift_card_item_id',$id)->first();
        $this->gift_card_item = GiftCardItem::find($id);
    }
    public function render()
    {
        return view('livewire.admin.gift-card-item.view')->layout('layouts.admin.app');
    }
}
