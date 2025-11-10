<?php

namespace App\Livewire\User;

use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\Product;

use Livewire\Component;
use Livewire\WithPagination;

class ShopComponent extends Component
{
    use WithPagination;
    public $minFilterPrice = 0;
    public $maxFilterPrice = 1000;
    protected string $paginationTheme = 'bootstrap';

    public $categories = [];
    public $product_count = 0;
    public $limit = 50;
    public $sortby = 'featured';
    public $shop_page_banner = [];
    public $deals_of_the_day_products = [];
    public $new_products = [];

    public function mount()
    {
        $this->shop_page_banner = Banner::where('status', 1)->where('banner_type', 'shop_page_banner')->first();
        $this->deals_of_the_day_products = Product::where('status', 1)->orderBy('sale_to_date', 'desc')->limit(4)->get();
        $this->categories = ProductCategory::where('status', 1)->orderBy('name', 'asc')->where('parent_id', null)->get();
        $this->new_products = Product::where('status', 1)->orderBy('created_at', 'desc')->limit(4)->get();
        $this->updateProductCount();
    }

    public function setPriceRange($data)
    {
        $this->minFilterPrice = $data['min'];
        $this->maxFilterPrice = $data['max'];
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        $this->updateProductCount();
    }

    public function setSortBy($sortby)
    {
        $this->sortby = $sortby;
        $this->updateProductCount();
    }

    private function updateProductCount()
    {
        if ($this->sortby == 'featured') {
            $this->product_count = Product::where('status', 1)->where('is_featured', 1)->where('parent_id', null)->count();
        } elseif ($this->sortby == 'new') {
            $this->product_count = Product::where('status', 1)->where('parent_id', null)->count();
        }
    }

    public function render()
    {
        if ($this->sortby == 'featured') {
            $products = Product::where('status', 1)->where('is_featured', 1)->where('parent_id', null)->orderBy('created_at', 'desc')->paginate($this->limit);
        } elseif ($this->sortby == 'new') {
            $products = Product::where('status', 1)->orderBy('created_at', 'desc')->where('parent_id', null)->paginate($this->limit);
        }
        return view('livewire.user.shop-component', compact('products'))->layout('layouts.user.app');
    }
}
