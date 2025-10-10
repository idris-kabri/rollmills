<?php

namespace App\Livewire\Admin\Customers;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search;
    public function render()
    {
        $users = User::where("role", "User")
            ->where(function ($query) {
                $query->orWhere("name", "like", "%{$this->search}%")
                    ->orWhere("email", "like", "%{$this->search}%");
            })
            ->orderBy("id", "desc")
            ->paginate(10);

        return view('livewire.admin.customers.index', compact("users"))->layout('layouts.admin.app');
    }
}
