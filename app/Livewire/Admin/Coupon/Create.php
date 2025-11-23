<?php

namespace App\Livewire\Admin\Coupon;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, HasToastNotification;
    public $title;
    public $image;
    public $coupon_code;
    public $minimum_order_value;
    public $discount_type = 'Percentage';
    public $discount_value;
    public $maximum_discount_amount;
    public $usage_limit;
    public $total_usage;
    public $expiry_date;
    public $category = [];
    public $is_global = 0;
    public $description;

    public function mount()
    {
        $this->category = [];
    }


    public function store()
    {
        $validator = Validator::make($this->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image',
            'coupon_code' => 'required|unique:coupons,coupon_code',
            'minimum_order_value' => 'required|numeric|min:0',
            'discount_type' => 'required',
            'discount_value' => 'required|numeric|min:0',
            'maximum_discount_amount' => 'required|numeric|min:0',
            'usage_limit' => 'required|integer|min:1',
            'total_usage' => 'required|integer|min:0',
            'expiry_date' => 'required|date|after:today',
            // 'category' => 'required|array|min:1',
            // 'category.*' => 'exists:product_categories,id',
        ]);

        if ($validator->fails()) {
            $this->dispatch('validation-errors', [
                'errors' => $validator->errors()
            ]);
            // dd($validator->errors());
        } else {
            try { 
                sleep(1);
                // Store image
                $imagePath = $this->image->store('coupon_images', 'public');

                // Create new coupon instance
                $coupon = new Coupon();
                $coupon->title = $this->title;
                $coupon->image = $imagePath;
                $coupon->coupon_code = $this->coupon_code;
                $coupon->minimum_order_value = $this->minimum_order_value;
                $coupon->discount_type = $this->discount_type;
                $coupon->discount_value = $this->discount_value;
                $coupon->maximum_discount_amount = $this->maximum_discount_amount;
                $coupon->usage_limit = $this->usage_limit;
                $coupon->total_usage = $this->total_usage;
                $coupon->expiry_date = $this->expiry_date;
                $coupon->category = implode(',', $this->category);
                $coupon->is_global = $this->is_global;
                $coupon->description = $this->description;
                $coupon->save();

                return redirect()->route("admin.coupon.index");
                $this->toastSuccess('Coupon Created Successfully!');
            } catch (\Exception $e) {
                // Delete the uploaded image if coupon creation fails
                if (isset($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
        }
    }

    public function render()
    {
        $categories = ProductCategory::where("parent_id", "!=", null)->get();
        return view('livewire.admin.coupon.create', compact("categories"))->layout('layouts.admin.app');
    }
}
