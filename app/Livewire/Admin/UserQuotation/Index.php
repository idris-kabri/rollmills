<?php

namespace App\Livewire\Admin\UserQuotation;

use App\Models\Quotation;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{ 
    use WithPagination, HasToastNotification;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function render()
    { 
        $search = $this->search;  
        $quotations = Quotation::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile_number', 'like', "%{$search}%")
                    ->orWhere('remarks', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('livewire.admin.user-quotation.index',compact('quotations'))->layout('layouts.admin.app');
    }
}
