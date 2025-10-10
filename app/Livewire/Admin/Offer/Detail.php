<?php

namespace App\Livewire\Admin\Offer;

use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItems;
use App\Traits\HasToastNotification;
use Livewire\Component;

class Detail extends Component
{
    use HasToastNotification;
    public $id = "";
    public $status = "";
    public $total_user_count;
    public $total_order_amount;
    public $total_discount_amount;
    public $user_orders;

    public function mount($id)
    {
        $this->id = $id;
        $find_offer = Offer::find($this->id);
        $this->status = $find_offer->status;

        $orderIds = OrderItems::where('offer_id', $this->id)
            ->pluck('order_id')
            ->unique();

        $orders = Order::whereIn('id', $orderIds);

        $this->total_user_count      = $orders->distinct('logged_in_user_id')->count('logged_in_user_id');
        $this->total_order_amount = $orders
            ->selectRaw('SUM(CAST(subtotal AS SIGNED)) as total')
            ->value('total');

        $this->total_discount_amount = $orders
            ->selectRaw('SUM(CAST(offer_discount AS DECIMAL(15,2))) as total')
            ->value('total');


        $this->user_orders = Order::whereIn('id', $orderIds)->get();
    }

    public function editStatus()
    {
        $find_offer = Offer::find($this->id);
        $find_offer->status = $this->status;
        $find_offer->save();
        $this->toastSuccess("Status Updated Successfully...");
    }

    public function render()
    {
        return view('livewire.admin.offer.detail')->layout('layouts.admin.app');
    }
}
