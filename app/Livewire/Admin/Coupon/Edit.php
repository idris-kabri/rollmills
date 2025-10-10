<?php

namespace App\Livewire\Admin\Coupon;

use App\Models\Coupon;
use App\Models\ProductCategory;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads, HasToastNotification;
    public $id;
    public $title;
    public $coupon_code;
    public $minimum_order_value;
    public $discount_type = 'Percentage';
    public $discount_value;
    public $maximum_discount_amount;
    public $usage_limit;
    public $total_usage;
    public $expiry_date;
    public $category = [];
    public $image;
    public $defaultImage;

    public function mount($id)
    {
        $this->id = $id;
        $coupon = Coupon::find($id);
        $this->title = $coupon->title;
        $this->coupon_code = $coupon->coupon_code;
        $this->minimum_order_value = $coupon->minimum_order_value;
        $this->discount_type = $coupon->discount_type;
        $this->discount_value = $coupon->discount_value;
        $this->maximum_discount_amount = $coupon->maximum_discount_amount;
        $this->usage_limit = $coupon->usage_limit;
        $this->total_usage = $coupon->total_usage;
        $this->expiry_date = $coupon->expiry_date;
        $this->category = explode(',', $coupon->category);
        $this->defaultImage = $coupon->image;
    }

    public function update()
    {
        $validator = Validator::make($this->all(), [
            'title' => 'required|string|max:255',
            'coupon_code' => 'required|unique:coupons,coupon_code,' . $this->id . ',id',
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
            return;
        }

        try { 
            sleep(1);
            $coupon = Coupon::findOrFail($this->id);

            if ($this->image instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $this->image->store('coupon_images', 'public');
                $coupon->image = $imagePath;
            } else {
                $coupon->image = $this->defaultImage;
            }

            $coupon->title = $this->title;
            $coupon->coupon_code = $this->coupon_code;
            $coupon->minimum_order_value = $this->minimum_order_value;
            $coupon->discount_type = $this->discount_type;
            $coupon->discount_value = $this->discount_value;
            $coupon->maximum_discount_amount = $this->maximum_discount_amount;
            $coupon->usage_limit = $this->usage_limit;
            $coupon->total_usage = $this->total_usage;
            $coupon->expiry_date = $this->expiry_date;
            $coupon->category = implode(',', $this->category);

            $coupon->save();

            $this->toastSuccess('Coupon Edited Successfully!');
            return redirect()->route("admin.coupon.index");
        } catch (\Exception $e) {
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            report($e);
            $this->toastError('Something went wrong. Please try again.');
        }
    }


    public function render()
    {
        $categories = ProductCategory::where("parent_id", "!=", null)->get();
        return view('livewire.admin.coupon.edit', compact("categories"))->layout('layouts.admin.app');
    }
}
