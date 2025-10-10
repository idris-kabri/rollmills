<?php

namespace App\Livewire\Admin\Transactions;

use App\Models\Transaction;
use Livewire\Component;

class Edit extends Component
{
    public $transactionId;
    
    public function mount($id){
        $this->transactionId = $id;
    }

    public function render()
    {   
        $transaction = Transaction::find($this->transactionId);
        return view('livewire.admin.transactions.edit',compact("transaction"))->layout('layouts.admin.app');
    }
}
