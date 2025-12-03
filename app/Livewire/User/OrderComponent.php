<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Banner;
use App\Models\OrderItems;
use App\Models\OrderReturnRequest;
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
        $previously_order_items = collect();
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

            $this->dispatch('open-review-modal');
        }
    }

    public function submitReview()
    {
        $this->validate([
            'rating' => 'required|integer|min:1|max:5',
            'remarks' => 'required|string|max:5000',
            'review_images.*' => 'nullable|image|max:2048',
            'target_product_ids' => 'required|array|min:1'
        ]);

        $user = Auth::user();

        $imageString = null;
        if ($this->review_images) {
            $imagePaths = [];
            foreach ($this->review_images as $image) {
                // Fix: Ensure storage folder exists or uses correct disk
                $imagePaths[] = $image->store('reviews', 'public');
            }
            $imageString = implode(',', $imagePaths);
        }

        foreach ($this->target_product_ids as $productId) {
            // Optional: Check if review already exists to prevent duplicates
            $exists = ProductReview::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->exists();

            if (!$exists) {
                $review = new ProductReview();
                $review->product_id = $productId;
                $review->user_id    = $user->id;
                $review->name       = $user->name;
                $review->email      = $user->email;
                $review->ratings    = $this->rating;
                $review->remarks    = $this->remarks;
                $review->image      = $imageString;
                $review->status     = 1; // Assuming 1 is active/approved, adjust as needed
                $review->save();
            }
        }

        $this->reset(['rating', 'remarks', 'review_images', 'target_product_ids']);
        $this->dispatch('close-review-modal');

        // Assuming you have a standard flash message component
        session()->flash('message', 'Reviews submitted for all products in this order!');
    }
}
