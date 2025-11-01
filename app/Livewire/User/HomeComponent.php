<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Banner;

class HomeComponent extends Component
{
    public $slider_banner = [];

    public function mount(){
        $this->slider_banner = Banner::where('status', 1)->where('banner_type', 'slider_banner')->get();
    }

    public function render()
    {
        return view('livewire.user.home-component')->layout('layouts.user.app');
    }
}
