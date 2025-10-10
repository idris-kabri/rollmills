<?php

namespace App\Livewire\Admin\ContactUs;

use App\Models\ContactUs;
use Livewire\Component;

class Detail extends Component
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $time;
    public $subject;
    public $messege;
    public $status = 0;

    public function mount($id){
        $this->id = $id;
        $contact = ContactUs::find($id);
        $this->name =  $contact->name;
        $this->email =  $contact->email;
        $this->phone =  $contact->phone;
        $this->time =  $contact->created_at;
        $this->subject =  $contact->subject;
        $this->messege =  $contact->message;
        $this->status =  $contact->status;
    }

    public function update(){
        $contact = ContactUs::find($this->id);
        $contact->status = $this->status;
        $contact->save();
        return redirect()->route("admin.contact.us.index");
    }
    public function render()
    {
        return view('livewire.admin.contact-us.detail')->layout('layouts.admin.app');
    }
}
