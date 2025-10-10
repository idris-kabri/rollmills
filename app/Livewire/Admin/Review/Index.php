<?php

namespace App\Livewire\Admin\Review;

use App\Models\ProductReview;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HasToastNotification;
    public $review_id;
    public $search;
    protected $paginationTheme = 'bootstrap';

    public function reviewIdSet($id)
    {
        $this->review_id = $id;
    }
    public function resetField()
    {
        $this->review_id = null;
    }
    public function reviewChangeStatus()
    {
        $review = ProductReview::find($this->review_id);
        $review->status = $review->status == 1 ? 0 : 1;
        $review->save();
        $this->toastSuccess('Review Status Change SuccessFully!');
        $this->resetField();
        $this->dispatch('review-change-status-model-close');
    }
    public function render()
    {
        $search = $this->search; 
        $reviews = ProductReview::with('getProducts')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('remarks', 'like', "%{$search}%")
                    ->orWhereHas('getProducts', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('livewire.admin.review.index', compact('reviews'))->layout('layouts.admin.app');
    }
}
