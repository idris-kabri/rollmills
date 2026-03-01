<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderAWB;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $orderCount = Order::count();
        $productCount = Product::count();
        $customerCount = User::where('role', 'User')->count();
        $reviewCount = ProductReview::count();

        $today = Carbon::today();

        $current_date_orders = Order::whereDate('created_at', $today)->where('status', 1)->get();

        $current_register_user = User::where('is_guest_user', 0)->where('is_fake', 0)->where('id', '!=', 1)->get();

        $current_guest_user_register = User::where('is_guest_user', 1)->where('is_fake', 0)->where('id', '!=', 1)->get();

        $order_ids = OrderAWB::distinct()->pluck('order_id')->toArray();

        $not_awbs = Order::whereNotIn('id', $order_ids)
            ->whereNotIn('status', [0, 10, 1])
            ->get();

        return view('livewire.admin.dashboard', compact('orderCount', 'productCount', 'customerCount', 'reviewCount', 'current_date_orders', 'current_register_user', 'current_guest_user_register', 'not_awbs'))->layout('layouts.admin.app');
    }
}
