<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Banner;

class HomeComponent extends Component
{
    public $slider_banner = [];
    public $top_side_banner = [];
    public $middle_page_banner = [];
    public $best_deal_banner = [];

    public function mount(){
        $this->slider_banner = Banner::where('status', 1)->where('banner_type', 'slider_banner')->get();
        $this->top_side_banner = Banner::where('status', 1)->where('banner_type', 'top_side_banner')->first();
        $this->middle_page_banner = Banner::where('status', 1)->where('banner_type', 'middle_page_banner')->get();
        $this->best_deal_banner = Banner::where('status', 1)->where('banner_type', 'daily_best_deals')->first();
    }

    public function render()
    {
        return view('livewire.user.home-component')->layout('layouts.user.app');
    }
}
