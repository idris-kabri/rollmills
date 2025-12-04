<?php

namespace App\Livewire\Admin\OrderItemReturn;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Models\OrderReturnRequest; // Model name verify karein
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Livewire\Component;
use Livewire\WithFileUploads;

use function Symfony\Component\Clock\now;

class Create extends Component
{
    use WithFileUploads, HasToastNotification;

    public $order_id;
    public $order_items = [];
    public $item_id = '';
    public $reason = '';
    public $user_id = '';
    public $status = '';
    public $remarks = '';
    public $images = [];

    public function updatedOrderId($value)
    {
        $this->order_items = [];
        $this->item_id = '';

        if (!empty($value)) {
            $order = Order::where('id', $value)->first();
            if ($order) {
                $this->order_items = OrderItems::with('getProduct')->where('order_id', $order->id)->get();
            }
        }
    }

    public function store()
    {
        $this->validate([
            'order_id' => 'required|exists:orders,id',
            'item_id' => 'required',
            'reason' => 'required',
            'status' => 'required|in:0,1,2,3,4',
            'images.*' => 'image|max:2048',
        ]);

        $get_customer = Order::find($this->order_id);
        $this->user_id = $get_customer->getUser->id;
        $imagePaths = [];
        if (!empty($this->images)) {
            foreach ($this->images as $image) {
                $imagePaths[] = $image->store('order-return-images', 'public');
            }
        }

        $store = new OrderReturnRequest();
        $store->order_id = $this->order_id;
        $store->order_item_id = $this->item_id;
        $store->customer_id = $this->user_id;
        $store->changed_by = FacadesAuth::user()->id;
        $store->changed_at = now();
        $store->reason = $this->reason;
        $store->remarks = $this->remarks;
        $store->status = $this->status;
        $store->images = json_encode($imagePaths);
        $store->save();
        $this->toastSuccess('Return Request Created Successfully');

        return redirect()->route('admin.order-return.index');
    }


    public function render()
    {
        return view('livewire.admin.order-item-return.create')
            ->layout('layouts.admin.app');
    }
}
