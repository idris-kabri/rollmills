<?php

namespace App\Livewire\User;

use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ContactComponent extends Component
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $user_id = null;
    
    public function mount()
    {
        if(Auth::check()){
            $this->user_id = Auth::user()->id;
        }
    }
    public function store(){
        $validate = $this->validate([
            "name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "subject" => "required",
            "message" => "required"
        ]);

        $store = new ContactUs();
        $store->name = $this->name;
        $store->email = $this->email;
        $store->phone = $this->phone;
        $store->subject = $this->subject;
        $store->message = $this->message;
        $store->user_id = $this->user_id;
        $store->save();

        $this->reset(["name","email","phone","subject","message"]);

        session()->flash('success', 'Your message has been sent successfully!');
    }
    public function render()
    {
        return view('livewire.user.contact-component')->layout('layouts.user.app');
    }
}
