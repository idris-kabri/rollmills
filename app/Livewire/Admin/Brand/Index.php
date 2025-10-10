<?php

namespace App\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HasToastNotification; 
    protected $paginationTheme = 'bootstrap';
    public $search;

    public function render()
    {
        $brands = Brand::where(function ($query) {
            $query->where('name', 'LIKE', "%{$this->search}%")
                ->orWhere('seo_title', 'LIKE', "%{$this->search}%")
                ->orWhere('seo_description', 'LIKE', "%{$this->search}%")
                ->orWhere('seo_meta', 'LIKE', "%{$this->search}%");
        })->paginate(10);

        return view('livewire.admin.brand.index', ['brands' => $brands])->layout('layouts.admin.app');
    }
    public function deleteBrand($id)
    {
        Brand::where('id', $id)->delete();
        $this->toastError('Brand Deleted Successfully!');
    }
}
