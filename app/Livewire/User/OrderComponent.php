<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Banner;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class OrderComponent extends Component
{
    use WithFileUploads;

    public $rating = 0;
    public $remarks = '';
    public $review_images = [];

    public $target_product_ids = [];

    public function render()
    {
        $user_orders = Order::where('logged_in_user_id', Auth::user()->id)
            ->where('status', '!=', 0)
            ->orderBy('id', 'desc')
            ->get();
        $productCategorys = ProductCategory::where('parent_id', null)->get();
        $previously_order_items = collect(); // Placeholder for render
        $banner = Banner::where('status', 1)->where('banner_type', 'order_page_banner')->first();

        return view('livewire.user.order-component', compact('user_orders', 'productCategorys', 'previously_order_items', 'banner'))->layout('layouts.user.app');
    }

    public function openReviewModalForOrder($order_id)
    {
        
        $this->reset(['rating', 'remarks', 'review_images', 'target_product_ids']);

        $order = Order::with('getOrderItems')->find($order_id);

        if ($order) {
            $this->target_product_ids = $order->getOrderItems
                ->pluck('item_id')
                ->unique()
                ->toArray();

                dd($this->target_product_ids);

            $this->dispatch('open-review-modal');
        }
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'remarks' => 'required|string|max:5000',
            'review_images.*' => 'nullable|image|max:2048',
            'target_product_ids' => 'required|array|min:1' // Ensure we have products to review
        ]);

        $user = Auth::user();

        $imageString = null;
        if ($this->review_images) {
            $imagePaths = [];
            foreach ($this->review_images as $image) {
                $imagePaths[] = $image->store('reviews', 'public');
            }
            $imageString = implode(',', $imagePaths);
        }

        foreach ($this->target_product_ids as $productId) {

            $review = new ProductReview();
            $review->product_id = $productId; // Specific Product ID
            $review->user_id    = $user->id;
            $review->name       = $user->name;
            $review->email      = $user->email;
            $review->ratings    = $this->rating; // Same rating for all
            $review->remarks    = $this->remarks; // Same remark for all
            $review->image      = $imageString;   // Same images for all
            $review->status     = 1;
            $review->save();
        }

        $this->reset(['rating', 'remarks', 'review_images', 'target_product_ids']);
        $this->dispatch('close-review-modal');

        session()->flash('message', 'Reviews submitted for all products in this order!');
    }
}
