<?php

namespace App\Livewire\Admin\Order;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $search;
    public $status;
    public $formDate;
    public $toDate;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = Order::with('getUser')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('getUser', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                        ->orWhere('subtotal', 'like', '%' . $this->search . '%')
                        ->orWhere('coupon_discount', 'like', '%' . $this->search . '%')
                        ->orWhere('offer_discount', 'like', '%' . $this->search . '%')
                        ->orWhere('gift_card_discount', 'like', '%' . $this->search . '%')
                        ->orWhere('paid_amount', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->formDate && $this->toDate, function ($query) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$this->formDate, $this->toDate]);
            })
            ->when($this->status !== null && $this->status !== '', function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('livewire.admin.order.index', compact('orders'))->layout('layouts.admin.app');
    }
}
