<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use App\Models\Transaction;
use App\Traits\HasToastNotification;
use Livewire\Component;

use function Symfony\Component\Clock\now;

class View extends Component
{
    use HasToastNotification;
    public $order;
    public $status;
    public $order_transaction;
    public function mount($id)
    {
        $this->order = Order::find($id);
        $this->order_transaction = Transaction::where('refrence_id', $id)->where('refrence_table', 'orders')->first();
        $this->status = $this->order->status;
    }

    public function orderStatusChange()
    {
        $this->order->status = $this->status;
        if ($this->status == 2) {
            $this->order->shipped_at = now();
        } elseif ($this->status == 3) {
            $this->order->complete_at = now();
        }
        $this->order->save();
        $this->toastSuccess('Order Status Change Successfully!');
        $url = '/admin/orders/view/' . $this->order->id;
        $this->redirectWithDelay($url);
    }
    public function render()
    {
        return view('livewire.admin.order.view')->layout('layouts.admin.app');
    }
}
