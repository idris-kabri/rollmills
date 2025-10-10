<?php

namespace App\Livewire\Admin\ContactUs;

use App\Models\ContactUs;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $search;
    use WithPagination;
    public function render()
    {
        $contacts = ContactUs::orderBy("id","desc")->
        where("name","LIKE","%{$this->search}%")->
        orWhere("email","LIKE","%{$this->search}%")->
        orWhere("phone","LIKE","%{$this->search}%")
        ->paginate(10);
        return view('livewire.admin.contact-us.index',compact("contacts"))->layout('layouts.admin.app');
    }
}
