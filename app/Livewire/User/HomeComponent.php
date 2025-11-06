<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductCategoryAssign;

class HomeComponent extends Component
{
    public $slider_banner = [];
    public $top_side_banner = [];
    public $middle_page_banner = [];
    public $best_deal_banner = [];
    public $parentCategory = [];
    public $seleted_popular_product_category = "all";
    public $popular_products = [];

    public function mount(){
        $this->slider_banner = Banner::where('status', 1)->where('banner_type', 'slider_banner')->get();
        $this->top_side_banner = Banner::where('status', 1)->where('banner_type', 'top_side_banner')->first();
        $this->middle_page_banner = Banner::where('status', 1)->where('banner_type', 'middle_page_banner')->get();
        $this->best_deal_banner = Banner::where('status', 1)->where('banner_type', 'daily_best_deals')->first();
        $this->popular_products = Product::where('status', 1)->where('is_featured', 1)->where('parent_id', null)->orderBy('created_at', 'desc')->limit(15)->get();
        $this->parentCategory = ProductCategory::where('parent_id', null)->get()->map(function($item){
            $product_sum = 0;
            $product_sum += $item->getProductCategoryAssign->count();
            $subcategroy = ProductCategory::where('parent_id', $item->id)->get();
            foreach($subcategroy as $sub){
                $product_sum += $sub->getProductCategoryAssign->count();
            }
            $item->product_sum = $product_sum;
            return $item;
        });
    }

    public function setPopularProductCategory($category){
        $this->seleted_popular_product_category = $category;
        if($category == "all"){
            $this->popular_products = Product::where('status', 1)->where('is_featured', 1)->where('parent_id', null)->orderBy('created_at', 'desc')->limit(15)->get();
        }else{
            $product_category_assign = ProductCategoryAssign::where('category_id', $category)->pluck('product_id');
            $this->popular_products = Product::where('status', 1)->where('is_featured', 1)->whereIn('id', $product_category_assign)->orderBy('created_at', 'desc')->limit(15)->get();
        }
    }

    public function render()
    {
        return view('livewire.user.home-component')->layout('layouts.user.app');
    }
}
