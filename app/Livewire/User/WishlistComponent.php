<?php

namespace App\Livewire\User;

use App\Traits\HasToastNotification;
use Livewire\Component;
use Cart;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ProductCategoryAssign;

class WishlistComponent extends Component
{
    use HasToastNotification;
    public $quantity = 1;

    public $confirmMessage = '';
    public $confirmAction = '';

    public function askRemove($rowId)
    {
        $this->confirmMessage = 'Are you sure you want to remove this item from your wishlist?';
        $this->confirmAction = "removeWishlist('$rowId')";

        $this->dispatch('open-whislit-remove-item-modal');
    }

    public function addToCart($rowId)
    {
        $mainProduct = Cart::instance('wishlist')->get($rowId);
        $product = $mainProduct->model;
        $existing_qauntity = 0;
        $cart = Cart::instance('cart')->search(function ($cartItem, $rowId) use (&$existing_qauntity, $product) {
            if ($cartItem->id === $product->id) {
                $existing_qauntity = $cartItem->qty;
                return true;
            }
        });
        if($existing_qauntity == 0){
            $addToCart = finalAddToCart($product, $this->quantity);
        }else{
            $addToCart = finalAddToCart($product, $this->quantity + $existing_qauntity, 'update-quantity');
        }
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
        $item['quantity'] = $this->quantity;

        $items[] = $item;
        $this->dispatch('add-to-cart', $items);
        if ($addToCart == false) {
            $this->toastWarning('Already Exist In Your Cart!');
        } else {
            Cart::instance('wishlist')->remove($rowId);
            if (Auth::check()) {
                Cart::instance('wishlist')->store(Auth::user()->mobile);
            }
            $this->toastSuccess('Product Successfully Added In Cart!');
        }
    }

    public function removeWishlist($rowId)
    {
        $removeWishlist = finalRemoveWishlist($rowId);
        if ($removeWishlist == true) {
            $this->toastError('Product Successfully Remove In Your Wishlist!');
            $this->dispatch('close-whislit-remove-item-modal');
        }
    }
    public function render()
    {
        return view('livewire.user.wishlist-component')->layout('layouts.user.app');
    }
}
