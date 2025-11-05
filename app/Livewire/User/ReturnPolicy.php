<?php

namespace App\Livewire\User;

use Livewire\Component;

class ReturnPolicy extends Component
{
    public function render()
    {
        return view('livewire.user.return-policy')->layout('layouts.user.app');
    }
}
