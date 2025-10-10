<?php

namespace App\Livewire\Admin\Transactions;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $transactions = Transaction::orderBy("id", "desc")->paginate(10);
        return view('livewire.admin.transactions.index',compact("transactions"))->layout('layouts.admin.app');
    }
}
