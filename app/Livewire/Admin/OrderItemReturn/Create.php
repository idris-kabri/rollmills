<?php

namespace App\Livewire\Admin\OrderItemReturn;

use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Models\OrderReturnRequest; // Model name verify karein
use Illuminate\Container\Attributes\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

use function Symfony\Component\Clock\now;

class Create extends Component
{
    use WithFileUploads;

    public $order_id;
    public $order_items = []; // Dropdown items ke liye
    public $item_id = '';
    public $user_id = '';
    public $reason = '';
    public $status = ''; // Default empty
    public $remarks = '';
    public $images = [];

    // Dropdown data
    public $customers = [];

    public function mount()
    {
        // Customers load karein (ID, Name, Email/Phone for search)
        $this->customers = User::where("role", "user")->get();
    }

    // Order ID change hone par items fetch karein
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
            'user_id' => 'required',
            'reason' => 'required',
            'status' => 'required|in:0,1,2,3,4',
            'images.*' => 'image|max:2048',
        ]);

        // Store images and return array of file paths
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
        $store->changed_by = Auth::user()->id;
        $store->changed_at = now();
        $store->reason = $this->reason;
        $store->remarks = $this->remarks;
        $store->status = $this->status;

        // 👇 Save images into column as JSON
        $store->images = json_encode($imagePaths);

        $store->save();

        return redirect()->route('admin.order-item-return.index');
    }


    public function render()
    {
        return view('livewire.admin.order-item-return.create')
            ->layout('layouts.admin.app');
    }
}
