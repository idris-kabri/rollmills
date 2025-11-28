<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Support\Facades\Auth;

class OrderComponent extends Component
{
    public function render()
    {
        $user_orders = Order::where('logged_in_user_id', Auth::user()->id)
            ->where('status', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();
        $productCategorys = ProductCategory::where('parent_id', null)->get();
        $previously_order = Order::where('logged_in_user_id', Auth::user()->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->get();
        $product_ids = $previously_order->flatMap->getOrderItems
            ->pluck('item_id')
            ->unique()
            ->toArray();
        $previously_order_items = Product::whereIn('id', $product_ids)->take(8)->get();
        $banner = Banner::where('status', 1)->where('banner_type', 'order_page_banner')->first();
        return view('livewire.user.order-component', compact('user_orders', 'productCategorys', 'previously_order_items', 'banner'))->layout('layouts.user.app');
    }
}
