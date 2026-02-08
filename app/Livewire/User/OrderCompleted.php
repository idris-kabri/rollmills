<?php

namespace App\Livewire\User;

use App\Traits\HasToastNotification;
use App\Models\Order;
use App\Models\ProductCategoryAssign;
use Livewire\Component;
use Carbon\Carbon;

class OrderCompleted extends Component
{
    use HasToastNotification;

    public $id;
    public $items_checkout_event_array = [];

    public function mount()
    {
        $this->id = request()->id;
        $user_order = Order::find($this->id);

        foreach ($user_order->getOrderItems as $key => $order_item) {
            $product = $order_item->getProduct;
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
            $item['quantity'] = $order_item->quantity;

            $this->items_checkout_event_array[] = $item;
        }

        $final_order_array = [
            'transaction_id' => $user_order->id,
            'value' => (float) $user_order->total,
            'tax' => 0.0,
            'shipping' => (float) $user_order->shipping_charges,
            'currency' => 'INR',
            'coupon' => $coupon->code ?? null,
            'customer_type' => 'new',
            'items' => $this->items_checkout_event_array,
        ];

        $this->dispatch('purchase', $final_order_array);
        if (session()->has('success')) {
            $parameters = [$user_order->getBillAddress->name, $user_order->id];
            sendParameterTemplateWawi('order_success_new2', 'en_us', $user_order->getBillAddress->mobile, $parameters);
            $this->toastSuccess('Your order placed successfully!');
        }

        session()->forget('success');
    }

    public function render()
    {
        return view('livewire.user.order-completed')->layout('layouts.user.app');
    }
}
