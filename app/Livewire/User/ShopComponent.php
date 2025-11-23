<?php

namespace App\Livewire\User;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeAssign;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\ProductCategoryAssign;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;
use Cart;
use Illuminate\Http\Request;
use App\Models\Banner;

class ShopComponent extends Component
{
    use WithPagination, HasToastNotification;
    protected $paginationTheme = 'bootstrap';
    public $paginationValue = 25;
    public $selectedBrands = [];
    public $finalBrands = [];
    public $sortBy = 'featured';
    public $expandedCategories = [];
    public $selectedCategory;
    public $quantity = 1;
    public $selectedProductAttribute;
    public $wishlistIds = [];
    public $cartIds = [];
    public $productsMinAmount;
    public $productsMaxAmount;
    public $minPrice;
    public $maxPrice;
    public $getCategoryId;
    public $getBrandId;
    public $selectedProductId = null;
    public $search;
    public $shop_page_banner = [];
    public $deals_of_the_day_products = [];
    public $new_products = [];
    public $product_count = 0;
    public $limit = 50;

    public function mount(Request $request)
    {
        $this->search = $request->search;
        $this->wishlistIds = Cart::instance('wishlist')->content()->pluck('id')->toArray();
        $this->cartIds = Cart::instance('cart')->content()->pluck('id')->toArray();
        $this->new_products = Product::where('status', 1)->orderBy('created_at', 'desc')->limit(4)->get();
        $this->shop_page_banner = Banner::where('status', 1)->where('banner_type', 'shop_page_banner')->first();
        $this->deals_of_the_day_products = Product::where('status', 1)->orderBy('sale_to_date', 'desc')->limit(4)->get();

        //when get category_id in request
        $this->getCategoryId = intval($request->get('category_id'));
        if (!empty($this->getCategoryId)) {
            $productCategory = ProductCategory::where('id', $this->getCategoryId)->first();
            $this->categoryWiseProduct($this->getCategoryId);
            $this->toggleCategory($productCategory->parent_id);
        }

        //when get brand_id in request
        $this->getBrandId = intval($request->get('brand_id'));
        if (!empty($this->getBrandId)) {
            $this->setBrands($this->getBrandId);
        }

        $this->productsMaxAmount = Product::max('price');
        $this->productsMinAmount = Product::min('price');

        $this->minPrice = $this->productsMinAmount;
        $this->maxPrice = $this->productsMaxAmount;
        $this->updateProductCount();
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        $this->updateProductCount();
    }

    public function setSortBy($sortby)
    {
        $this->sortBy = $sortby;
        $this->updateProductCount();
    }

    public function handleCloseQuickView()
    {
        $this->selectedProductId = null;
    }

    public function addPreviewProduct($id)
    {
        $this->selectedProductId = $id;
    }

    private function updateProductCount()
    {
        if ($this->sortBy == 'featured') {
            $this->product_count = Product::where('status', 1)->where('is_featured', 1)->where('parent_id', null)->count();
        } elseif ($this->sortBy == 'new') {
            $this->product_count = Product::where('status', 1)->where('parent_id', null)->count();
        }
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->expandedCategories)) {
            $this->expandedCategories = array_diff($this->expandedCategories, [$categoryId]);
        } else {
            $this->expandedCategories[] = $categoryId;
        }
    }
    public function categoryWiseProduct($id, $type = null)
    {
        $Id = intval($id);
        if ($this->selectedCategory === $Id) {
            $this->selectedCategory = null;
        } else {
            $this->selectedCategory = $Id;
        }

        if (($type == 'change' && !empty($this->getCategoryId)) || !empty($this->getBrandId)) {
            $this->dispatch('removeQueryParam', key: 'category_id');
            $this->dispatch('removeQueryParam', key: 'brand_id');
        }
        $this->finalBrands = [];
        $this->selectedBrands = [];
        $this->selectedProductAttribute = null;
    }

    public function paginationChange($value)
    {
        $this->paginationValue = !empty($value) ? intval($value) : 25;
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

    public function render()
    {
        if ($this->selectedCategory != null) {
            //for brand  selection
            $product_category_assign_product_ids = ProductCategoryAssign::where('category_id', $this->selectedCategory)->pluck('product_id')->toArray();
            $get_brand_ids = ProductBrand::whereIn('product_id', $product_category_assign_product_ids)->distinct('brand_id')->pluck('brand_id')->toArray();
            $brands = Brand::whereIn('id', $get_brand_ids)->where('status', 1)->get();

            //for attribute selection
            $get_attributes_ids = ProductAttributeAssign::whereIn('product_id', $product_category_assign_product_ids)->distinct('product_set_id')->pluck('product_set_id')->toArray();
            $productAttributes = ProductAttribute::whereIn('id', $get_attributes_ids)->where('status', 1)->get();
        } else {
            $brands = Brand::where('status', 1)->get();
            $productAttributes = ProductAttribute::where('status', 1)->get();
        }
        $productCategorys = ProductCategory::where('parent_id', null)->get();

        $products = Product::where('active_inactive_status', 1)
            ->where('parent_id', null)
            ->when($this->selectedCategory, function ($query) {
                $query->whereHas('categoryAssigns', function ($q) {
                    $q->where('category_id', $this->selectedCategory);
                });
            })
            ->when($this->sortBy === 'featured', function ($query) {
                $query->where('is_featured', 1);
            })
            ->when($this->sortBy === 'new', function ($query) {
                $query->orderBy('price', 'asc');
            })
            ->when(!empty($this->finalBrands), function ($query) {
                $query->whereHas('brands', function ($q) {
                    $q->whereIn('brand_id', $this->finalBrands);
                });
            })
            ->when(!empty($this->selectedProductAttribute), function ($query) {
                $query->whereHas('attributeAssigns', function ($q) {
                    $q->where('product_set_id', $this->selectedProductAttribute);
                });
            })
            ->when(!empty($this->search), function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%");
                });
            })
            ->when(isset($this->minPrice, $this->maxPrice), function ($query) {
                $query->whereBetween('price', [$this->minPrice, $this->maxPrice]);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->paginationValue);
        return view('livewire.user.shop-component', compact('products', 'brands', 'productCategorys', 'productAttributes'))->layout('layouts.user.app');
    }
}
