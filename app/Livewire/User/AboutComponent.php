<?php

namespace App\Livewire\User;

use Livewire\Component;

class AboutComponent extends Component
{
    public function render()
    {
        return view('livewire.user.about-component')->layout('layouts.user.app');
    }
}
