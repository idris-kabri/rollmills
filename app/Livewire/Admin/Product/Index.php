<?php

namespace App\Livewire\Admin\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{  
    use WithPagination; 
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $products = Product::where(function ($query) {
            $query->where('name', 'LIKE', "%{$this->search}%")
                ->orWhere('price', 'LIKE', "%{$this->search}%")
                ->orWhere('sale_price', 'LIKE', "%{$this->search}%");
        })->orderBy('id','desc')->where('parent_id', null)->paginate(10);
        
        return view('livewire.admin.product.index', [
            'products' =>  $products
        ])->layout('layouts.admin.app');
    }
}
