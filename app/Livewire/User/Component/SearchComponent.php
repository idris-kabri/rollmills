<?php

namespace App\Livewire\User\Component;

use Livewire\Component;

class SearchComponent extends Component
{
    public $is_search = false;
    public $search = "";
    public $products = [];
    public $category = "";

    public function serachFunction()
    {
        $this->is_search = true;
        $product_query = Product::where('active_inactive_status', 1);

        if ($this->category != '' && $this->category != null) {
            $product_query->whereHas('categoryAssigns', function ($query) {
                $query->where('category_id', $this->category);
            })->where("out_of_stock", 0);
        }
        if ($this->search != '' && $this->search != null) {
            $product_query->where(function ($query) {
                $query->where("name", "like", "%{$this->search}%");
            })->where("out_of_stock", 0);
        }

        $this->products = $product_query->orderBy('id', 'desc')->take(8)->get();
    }

    public function updatedSearch()
    {
        $this->serachFunction();
    }

    public function updatedCategory()
    {
        $this->serachFunction();
    }
    public function render()
    {
        return view('livewire.user.component.search-component');
    }
}
