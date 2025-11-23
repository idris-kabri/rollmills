<?php

namespace App\Livewire\User\Component;

use Livewire\Component;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryAssign;
use Illuminate\Support\Facades\Cache;

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

        $this->products = Product::all();
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
        $categories = Cache::remember('product_categories', 3600, function () {
            return ProductCategory::whereNull('parent_id')
                ->get();
        });
        // $products = Product::take(8)->get();

        return view('livewire.user.component.search-component', compact("categories"));
    }
}
