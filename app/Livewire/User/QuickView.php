<?php

namespace App\Livewire\User;

use App\Models\Product;
use App\Models\ProductAttributeAssign;
use App\Models\ProductCategoryAssign;
use App\Models\ProductReview;
use App\Traits\HasToastNotification;
use Carbon\Carbon;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class QuickView extends Component
{
    use HasToastNotification;

    public $mainProduct;
    public $mainProduct_reviews_percentage;
    public $mainProduct_reviews_count;
    public $quantity = 1;
    public $productId;
    public $main_image; 
    public $groupedAttributes = [];
    public $selectedAttribute = [];

    protected $listeners = [
        'openQuickView' => 'loadProduct'
    ];

    public function changeMainImage($image)
    {
        $this->main_image = $image;
    }

    public function loadProduct($data)
    {
        $this->productId = $data['productId'];
        $product = Product::find($this->productId); 
        $this->mainProduct = $product;

        $subProduct = Product::where('parent_id', $this->productId)->pluck('attribute_id')->toArray();
        $flatIds = [];
        foreach ($subProduct as $item) {
            $flatIds = array_merge($flatIds, explode(',', $item));
        }
        $flatIds = array_map('intval', $flatIds);
        $productAttributeAssign = ProductAttributeAssign::whereIn('id', $flatIds)->get();

        foreach ($productAttributeAssign as $assign) {
            $setIds = $assign->product_set_id;
            $attributeName = $assign->productAttribute->name;

            $assignItems = $assign->productAttribute->getAttibuteItems;

            // dd($assign,$attributeName,$assignItems);
            if (!isset($this->groupedAttributes[$setIds])) {
                $this->groupedAttributes[$setIds] = [
                    'name' => $attributeName,
                    'items' => [],
                ];

                $this->selectedAttribute[$setIds] = null;
            }
            if (!in_array($assign->title, $this->groupedAttributes[$setIds]['items'])) {
                $this->groupedAttributes[$setIds]['items'][] = $assign->title;
            }
            if ($assign->is_default == 1) {
                $this->handleAttributeClick($setIds, $assign->title);
            }
        }

        //review 
        $new_product_reviews = ProductReview::where('status', 1)
            ->where('product_id', $this->mainProduct->id)
            ->get();

        $this->mainProduct_reviews_count = $new_product_reviews->count();
        $product_reviews_avg =
            $this->mainProduct_reviews_count > 0
            ? round($new_product_reviews->avg('ratings'), 1)
            : 0;
        $this->mainProduct_reviews_percentage = ($product_reviews_avg / 5) * 100;
    }

    public function handleAttributeClick($key, $item)
    {
        $this->selectedAttribute[$key] = $item;
        $filtered = array_filter($this->selectedAttribute);
        $attributeName = implode(',', $filtered);
        $product = Product::where('parent_id', $this->productId)->where('attributes_name', $attributeName)->first();
        if ($product) {
            $this->mainProduct = $product;
            $productId = $this->mainProduct->id;
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($productId) {
                    return $cartItem->id === $productId;
                })
                ->first();
            if ($cart_check) {
                $this->quantity = $cart_check->qty;
            } else {
                $this->quantity = 1;
            }
        }
        $this->jsonCreation();
    }

    public function jsonCreation()
    {
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($this->mainProduct->sale_from_date);
        $sale_to_date = Carbon::parse($this->mainProduct->sale_to_date);

        if ($this->mainProduct->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $this->mainProduct->sale_price;
        } else {
            $sale_price = $this->mainProduct->sale_default_price;
        }
        $price = $this->mainProduct->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $this->mainProduct->price > $sale_price ? round($this->mainProduct->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $this->mainProduct->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $this->mainProduct->id,
            'item_name' => $this->mainProduct->name,
            'affiliation' => '',
            'coupon' => '',
            'discount' => (float) $discount,
            'index' => 0,
            'item_brand' => 'Roll Mills',
        ];

        foreach ($category_assign as $key => $category) {
            if ($key == 0) {
                $item['item_category'] = $category->category->name;
            } else {
                $item['item_category' . $key + 1] = $category->category->name;
            }
        }

        $item['item_list_id'] = '';
        $item['item_list_name'] = '';
        if ($this->mainProduct->attributes_name != null) {
            $attributes = explode(',', $this->mainProduct->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = 1;

        $items[] = $item;
        $this->dispatch('item-view', $items);
    }
    
    public function incrementQuantity()
    {
        $this->quantity++; 
    } 

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        $existing_qauntity = 0;
        $cart = Cart::instance('cart')->search(function ($cartItem, $rowId) use (&$existing_qauntity) {
            if ($cartItem->id === $this->mainProduct->id) {
                $existing_qauntity = $cartItem->qty;
                return true;
            }
        });
        $addToCart = finalAddToCart($this->mainProduct, $existing_quantity + $this->quantity, 'update-quantity');
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($this->mainProduct->sale_from_date);
        $sale_to_date = Carbon::parse($this->mainProduct->sale_to_date);

        if ($this->mainProduct->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $this->mainProduct->sale_price;
        } else {
            $sale_price = $this->mainProduct->sale_default_price;
        }
        $price = $this->mainProduct->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $this->mainProduct->price > $sale_price ? round($this->mainProduct->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $this->mainProduct->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $this->mainProduct->id,
            'item_name' => $this->mainProduct->name,
            'affiliation' => '',
            'coupon' => '',
            'discount' => (float) $discount,
            'index' => 0,
            'item_brand' => 'Roll Mills',
        ];

        foreach ($category_assign as $key => $category) {
            if ($key == 0) {
                $item['item_category'] = $category->category->name;
            } else {
                $item['item_category' . $key + 1] = $category->category->name;
            }
        }

        $item['item_list_id'] = '';
        $item['item_list_name'] = '';
        if ($this->mainProduct->attributes_name != null) {
            $attributes = explode(',', $this->mainProduct->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = $this->quantity;

        $items[] = $item;
        $this->dispatch('add-to-cart', $items);
        if ($addToCart) {
            $this->toastSuccess('Successfully Added In Your Cart!');
        } else {
            $this->toastSuccess('Product Quntity Change Successfully!');
        }
    }

    public function render()
    {
        return view('livewire.user.quick-view');
    }
}
