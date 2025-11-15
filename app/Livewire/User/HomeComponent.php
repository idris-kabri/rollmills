<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Banner;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductCategoryAssign;
use Carbon\Carbon;
use App\Traits\HasToastNotification;

class HomeComponent extends Component
{
    use HasToastNotification;
    public $slider_banner = [];
    public $top_side_banner = [];
    public $middle_page_banner = [];
    public $best_deal_banner = [];
    public $parentCategory = [];
    public $seleted_popular_product_category = 'all';
    public $sale_products = [];
    public $sale_product_filter = 'featured';
    public $deals_of_the_day_products = [];
    public $top_selling = [];
    public $trending_products = [];
    public $latest_products = [];
    public $top_rated_products = [];
    public $users_look_for = [];
    public $user_look_for_banner = [];

    public function mount()
    {
        $this->slider_banner = Banner::where('status', 1)->where('banner_type', 'slider_banner')->get();
        $this->top_side_banner = Banner::where('status', 1)->where('banner_type', 'top_side_banner')->first();
        $this->middle_page_banner = Banner::where('status', 1)->where('banner_type', 'middle_page_banner')->get();
        $this->best_deal_banner = Banner::where('status', 1)->where('banner_type', 'daily_best_deals')->first();
        $this->user_look_for_banner = Banner::where('status', 1)->where('banner_type', 'user_looks_for')->first();
        $this->popular_products = Product::where('status', 1)->where('is_featured', 1)->whereNull('parent_id')->inRandomOrder()->limit(15)->get();
        $this->deals_of_the_day_products = Product::where('status', 1)->orderBy('sale_to_date', 'asc')->limit(4)->get();
        if ($this->deals_of_the_day_products->count() == 0) {
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
        $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_from_date', '<=', $today)->where('sale_to_date', '>=', $today)->where('is_featured', 1)->inRandomOrder()->limit(4)->get();
        if (count($this->sale_products) == 0) {
            $this->sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_default_price', '>', 0)->where('is_featured', 1)->inRandomOrder()->limit(4)->get();
        }
        $this->top_selling = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->inRandomOrder()->limit(3)->get();
        $this->trending_products = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->inRandomOrder()->limit(3)->get();
        $this->latest_products = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->orderBy('created_at', 'desc')->inRandomOrder()->limit(3)->get();
        $this->top_rated_products = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->inRandomOrder()->limit(3)->get();
        $this->users_look_for = Product::where('status', 1)->where('parent_id', null)->where('is_featured', 1)->orderBy('price', 'asc')->inRandomOrder()->limit(4)->get();
    }

    public function setPopularProductCategory($category)
    {
        $this->seleted_popular_product_category = $category;
    }

    public function setSaleProductCategory($category)
    {
        $this->sale_product_filter = $category;
    }

    public function getDefaultVariation($parentId)
    {
        $defaultAttributes = ProductAttributeAssign::whereHas('product', function ($q) use ($parentId) {
            $q->where('parent_id', $parentId);
        })
            ->where('is_default', 1)
            ->pluck('title')
            ->unique()
            ->toArray();

        if (!empty($defaultAttributes)) {
            $attributeName = implode(',', $defaultAttributes);

            return Product::where('parent_id', $parentId)->where('attributes_name', $attributeName)->first();
        } else {
            return Product::find($parentId);
        }
    }

    public function addToCart($id)
    {
        // $product = Product::find($id);
        $defaultProduct = $this->getDefaultVariation($id);

        $addToCart = finalAddToCart($defaultProduct, $this->quantity);
        if ($addToCart == false) {
            $this->toastWarning('Already Exist In Your Cart!');
        } else {
            $this->toastSuccess('Successfully Added In Your Cart!');
        }
    }

    public function render()
    {
        $today = Carbon::now();
        if ($this->seleted_popular_product_category == 'all') {
            $popular_products = Product::where('status', 1)->where('is_featured', 1)->where('parent_id', null)->inRandomOrder()->limit(15)->get();
        } else {
            $product_category_assign = ProductCategoryAssign::where('category_id', $this->seleted_popular_product_category)->pluck('product_id');
            $popular_products = Product::where('status', 1)->where('is_featured', 1)->whereIn('id', $product_category_assign)->inRandomOrder()->limit(15)->get();
        }

        if ($this->sale_product_filter == 'featured') {
            $sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_from_date', '<=', $today)->where('sale_to_date', '>=', $today)->where('is_featured', 1)->inRandomOrder()->limit(15)->get();
            if (count($sale_products) == 0) {
                $sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_default_price', '>', 0)->where('is_featured', 1)->inRandomOrder()->limit(15)->get();
            }
        } else {
            $sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_from_date', '<=', $today)->where('sale_to_date', '>=', $today)->orderBy('created_at', 'desc')->limit(15)->get();
            if (count($sale_products) == 0) {
                $sale_products = Product::where('status', 1)->where('parent_id', null)->where('sale_default_price', '>', 0)->orderBy('created_at', 'desc')->limit(15)->get();
            }
        }
        return view('livewire.user.home-component', compact('popular_products', 'sale_products'))->layout('layouts.user.app');
    }
}
