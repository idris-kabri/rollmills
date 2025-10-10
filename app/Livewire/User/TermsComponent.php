<?php

namespace App\Livewire\User;

use Livewire\Component;

class TermsComponent extends Component
{
    public function render()
    {
        return view('livewire.user.terms-component')->layout('layouts.user.app');
    }
}
