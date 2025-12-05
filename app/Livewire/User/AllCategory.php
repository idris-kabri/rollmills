<?php

namespace App\Livewire\User;

use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\Attributes\Url;

class AllCategory extends Component
{
    #[Url]
    public $search = '';

    public function render()
    {
        $categories = ProductCategory::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.user.all-category', [
            'categories' => $categories
        ])->layout('layouts.user.app');
    }
}
