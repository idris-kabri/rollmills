<?php

namespace App\Livewire\Admin\OrderItemReturn;

use App\Models\OrderReturnRequest;
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
        $orderReturns = OrderReturnRequest::with('fetchCustomer')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('fetchCustomer', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                        ->orWhere('reason', 'like', '%' . $this->search . '%')
                        ->orWhere('remarks', 'like', '%' . $this->search . '%');
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
        return view('livewire.admin.order-item-return.index', compact('orderReturns'))->layout('layouts.admin.app');
    }
}
