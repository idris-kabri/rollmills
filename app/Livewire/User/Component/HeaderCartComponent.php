<?php

namespace App\Livewire\User\Component;

use Livewire\Component;
use App\Traits\HasToastNotification;
use Cart;
use App\Models\Product;
use App\Models\ProductCategoryAssign;
use Carbon\Carbon;

class HeaderCartComponent extends Component
{
    use HasToastNotification;
    public function removeFromCart($rowId)
    {
        try {
            $item = Cart::instance('cart')->get($rowId);
        } catch (\Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException $e) {
            return; // rowId not found — safely exit
        }

        $qty = Cart::instance('cart')->get($rowId)->qty;
        $productId = Cart::instance('cart')->get($rowId)->model->id;
        $removeCart = finalRemoveFromCart($rowId);
        $product = Product::find($productId);
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
        $item['quantity'] = (float)$qty;

        $items[] = $item;
        $this->dispatch('remove-from-cart', $items);
        if ($removeCart) {
            // $this->toastError('Product Remove Successfully From Your Cart!');
        }
    }

    public function render()
    {
        return view('livewire.user.component.header-cart-component');
    }
}
