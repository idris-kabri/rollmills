<?php

namespace App\Livewire\Admin\Brand;

use Livewire\Component;
use Livewire\WithFileUploads;

class CreateLogo extends Component
{
    use WithFileUploads;

    public $image;
    public function render()
    {
        return view('livewire.admin.brand.create-logo');
    }
}
