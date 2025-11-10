<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductCategoryAssign;
use Carbon\Carbon;

class HomeComponent extends Component
{
    public $slider_banner = [];
    public $top_side_banner = [];
    public $middle_page_banner = [];
    public $best_deal_banner = [];
    public $parentCategory = [];
    public $seleted_popular_product_category = 'all';
    public $popular_products = [];
    public $sale_products = [];
    public $sale_product_filter = 'featured';
    public $deals_of_the_day_products = [];
    public $top_selling = [];
    public $trending_products = [];
    public $latest_products = [];
    public $top_rated_products = [];

    public function mount()
    {
        $this->slider_banner = Banner::where('status', 1)->where('banner_type', 'slider_banner')->get();
        $this->top_side_banner = Banner::where('status', 1)->where('banner_type', 'top_side_banner')->first();
        $this->middle_page_banner = Banner::where('status', 1)->where('banner_type', 'middle_page_banner')->get();
        $this->best_deal_banner = Banner::where('status', 1)->where('banner_type', 'daily_best_deals')->first();
        $this->popular_products = Product::where('status', 1)->where('is_featured', 1)->whereNull('parent_id')->inRandomOrder()->limit(15)->get();
        $this->deals_of_the_day_products = Product::where('status', 1)->orderBy('sale_to_date', 'asc')->limit(4)->get();
        if($this->deals_of_the_day_products->count() == 0){
            $this->deals_of_the_day_products = Product::where('status', 1)->inRandomOrder()->limit(4)->get();
        }
        $this->parentCategory = ProductCategory::where('parent_id', null)
            ->get()
            ->map(function ($item) {
                $product_sum = 0;
                $product_sum += $item->getProductCategoryAssign->count();
                $subcategroy = ProductCategory::where('parent_id', $item->id)->get();
                foreach ($subcategroy as $sub) {
                    $product_sum += $sub->getProductCategoryAssign->count();
                }
                $item->product_sum = $product_sum;
                return $item;
            });
        $today = Carbon::now();
        $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_from_date', '<=', $today)->where('sale_to_date', '>=', $today)->where('is_featured', 1)->inRandomOrder()->limit(15)->get();
        if ($this->sale_products->count() == 0) {
            $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_default_price', '>', 0)->where('is_featured', 1)->inRandomOrder()->limit(15)->get();
        }
        $this->top_selling = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->inRandomOrder()->limit(3)->get();
        $this->trending_products = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->inRandomOrder()->limit(3)->get();
        $this->latest_products = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->orderBy('created_at', 'desc')->inRandomOrder()->limit(3)->get();
        $this->top_rated_products = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->inRandomOrder()->limit(3)->get();
    }

    public function setPopularProductCategory($category)
    {
        $this->seleted_popular_product_category = $category;
        if ($category == 'all') {
            $this->popular_products = [];
            $this->popular_products = Product::where('status', 1)->where('is_featured', 1)->where('parent_id', null)->inRandomOrder()->limit(15)->get();
        } else {
            $this->popular_products = [];
            $product_category_assign = ProductCategoryAssign::where('category_id', $category)->pluck('product_id');
            $this->popular_products = Product::where('status', 1)->where('is_featured', 1)->whereIn('id', $product_category_assign)->inRandomOrder()->limit(15)->get();
        }
    }

    public function setSaleProductCategory($category)
    {
        $today = Carbon::now();
        $this->sale_product_filter = $category;
        if ($category == 'featured') {
            $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_from_date', '<=', $today)->where('sale_to_date', '>=', $today)->where('is_featured', 1)->inRandomOrder()->limit(15)->get();
            if ($this->sale_products->count() == 0) {
                $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_default_price', '>', 0)->where('is_featured', 1)->inRandomOrder()->limit(15)->get();
            }
        } else {
            $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_from_date', '<=', $today)->where('sale_to_date', '>=', $today)->orderBy('created_at', 'desc')->limit(15)->get();
            if ($this->sale_products->count() == 0) {
                $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_default_price', '>', 0)->orderBy('created_at', 'desc')->limit(15)->get();
            }
        }
    }

    public function render()
    {
        return view('livewire.user.home-component')->layout('layouts.user.app');
    }
}
