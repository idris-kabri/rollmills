<?php

namespace App\Livewire\User;

use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\Attributes\Url;

class AllCategory extends Component
{
    #[Url]
    public $search = '';

    public $parentCategories = [];
    public $subCategories = [];
    public $selectedParent = null;  // NEW

    public function selectParent($parentId)
    {
        $this->selectedParent = $parentId;

        $this->subCategories = ProductCategory::where('parent_id', $parentId)->get();
    }

    public function render()
    {
        // Parent categories
        $this->parentCategories = ProductCategory::whereNull('parent_id')
            ->when($this->search, function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%');
            })
            ->get();

        return view('livewire.user.all-category')
            ->layout('layouts.user.app');
    }
}
