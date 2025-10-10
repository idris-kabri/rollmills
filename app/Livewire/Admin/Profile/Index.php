<?php

namespace App\Livewire\Admin\Profile;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount($id){
        $this->id = $id;
        $user = User::find($id);
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateUser(){
        $this->validate([
            'password' => 'min:6|sometimes|nullable|confirmed',
        ]);
        $user = User::find($this->id);
        $user->name = $this->name;
        if($this->password != null && isset($this->password)){
            $user->password = $this->password;
        }
        $user->save();
        $this->dispatch('success', ['message' => 'User profile updated successfully']);
    }

    public function render()
    {   
        return view('livewire.admin.profile.index')->layout('layouts.admin.app');
    }
}
