<?php

namespace App\Livewire\User\Component;

use Livewire\Component;
use App\Traits\HasToastNotification;
use App\Models\Product;
use App\Models\ProductAttributeAssign;
use App\Models\ProductCategoryAssign;
use Carbon\Carbon;
use Cart;

class ProductCard extends Component
{
    use HasToastNotification;
    public $product = [];
    public $parameter = '';
    public $get_sold = false;
    public $selected_product = null;
    public $selectedProductId;
    protected $listeners = [];


    public function mount($product, $parameter = null, $get_sold = false)
    {
        $this->product = $product;
        if ($parameter != null && $parameter != '') {
            $this->parameter = $parameter;
        }
        $this->get_sold = $get_sold;
    }

    public function updatedSelectedProduct($id)
    {
        $this->selected_product = $id;
        session()->put('selected_product', $id);
        dd('Hye');
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


    public function previewProduct($id)
    {
        $this->dispatch('previewProductEvent', id: $id);
    }

    public function addToCart($id)
    {
        // $product = Product::find($id);
        $defaultProduct = $this->getDefaultVariation($id);

        $existing_qauntity = 0;
        $cart = Cart::instance('cart')->search(function ($cartItem, $rowId) use (&$existing_qauntity, $defaultProduct) {
            if ($cartItem->id === $defaultProduct->id) {
                $existing_qauntity = $cartItem->qty;
                return true;
            }
        });

        $addToCart = finalAddToCart($defaultProduct, 1 + $existing_qauntity);
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($defaultProduct->sale_from_date);
        $sale_to_date = Carbon::parse($defaultProduct->sale_to_date);

        if ($defaultProduct->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $defaultProduct->sale_price;
        } else {
            $sale_price = $defaultProduct->sale_default_price;
        }
        $price = $defaultProduct->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $defaultProduct->price > $sale_price ? round($defaultProduct->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $defaultProduct->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $defaultProduct->id,
            'item_name' => $defaultProduct->name,
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
        if ($defaultProduct->attributes_name != null) {
            $attributes = explode(',', $defaultProduct->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = 1;

        $items[] = $item;
        $this->dispatch('add-to-cart', $items);
        if ($addToCart == false) {
            $this->toastWarning('Already Exist In Your Cart!');
        } else {
            $this->toastSuccess('Successfully Added In Your Cart!');
        }
    }

    public function addToWhishlist($id)
    {
        $product = Product::find($id);

        $addToWhishlist = finalAddToWhishlist($product);
        $sale_price = 0;
        $currentDate = Carbon::now();
        $sale_from_date = Carbon::parse($product->sale_from_date);
        $sale_to_date = Carbon::parse($product->sale_to_date);

        if ($product->sale_price > 0 && $currentDate->between($sale_from_date, $sale_to_date)) {
            $sale_price = $product->sale_price;
        } else {
            $sale_price = $product->sale_default_price;
        }
        $price = $product->price;
        $discount = 0;
        if ($sale_price > 0) {
            $price = $sale_price;
            $discount = $product->price > $sale_price ? round($product->price - $sale_price) : 0;
        }
        $category_assign = ProductCategoryAssign::where('product_id', $product->id)->orderBy('category_id', 'asc')->get();

        $items = [];
        $item = [
            'item_id' => $product->id,
            'item_name' => $product->name,
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
        if ($product->attributes_name != null) {
            $attributes = explode(',', $product->attributes_name);
            foreach ($attributes as $key => $attribute) {
                $item['item_variant'] = $attribute;
            }
        }
        $item['location_id'] = '';
        $item['price'] = (float) $price;
        $item['quantity'] = 1;

        $items[] = $item;
        $this->dispatch('add-to-wishlist', $items);
        if ($addToWhishlist == true) {
            $this->toastSuccess('Successfully Added In Your Whishlist!');
        } else {
            $this->toastWarning('Already Exist In Your Wishlist!');
        }
    }

    public function render()
    {
        return view('livewire.user.component.product-card');
    }
}
