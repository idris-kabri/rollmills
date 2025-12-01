<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Order;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class OrderDetail extends Component
{
    use WithFileUploads;

    public $id;
    
    // Review Properties
    public $rating = 0;
    public $remarks = '';
    public $review_images = [];
    public $target_product_ids = [];

    public function mount($id){
        $this->id = $id;
    }

    public function render()
    {
        $order = Order::find($this->id);
        return view('livewire.user.order-detail', compact('order'))->layout('layouts.user.app');
    }

    // UPDATED: Now accepts a specific product ID
    public function openReviewModalForProduct($productId)
    {
        $this->reset(['rating', 'remarks', 'review_images', 'target_product_ids']);

        // Set the target to just this single product
        $this->target_product_ids = [$productId];

        $this->dispatch('open-review-modal');
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
                $imagePaths[] = $image->store('reviews', 'public');
            }
            $imageString = implode(',', $imagePaths);
        }

        foreach ($this->target_product_ids as $productId) {
            // Check if user already reviewed this product to avoid duplicates
            $exists = ProductReview::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->exists();

            if(!$exists){
                $review = new ProductReview();
                $review->product_id = $productId;
                $review->user_id    = $user->id;
                $review->name       = $user->name;
                $review->email      = $user->email;
                $review->ratings    = $this->rating;
                $review->remarks    = $this->remarks;
                $review->image      = $imageString;
                $review->status     = 1; 
                $review->save();
            }
        }

        $this->reset(['rating', 'remarks', 'review_images', 'target_product_ids']);
        $this->dispatch('close-review-modal');

        session()->flash('message', 'Review submitted successfully!');
    }
}