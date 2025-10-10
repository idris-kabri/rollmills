<?php

namespace App\Livewire\Admin\Coupon;

use App\Models\Coupon;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HasToastNotification;

    public $search = '';
    public function delete($id)
    {
        $delete = Coupon::find($id);
        $delete->delete();
        $this->toastError('Coupon Deleted Successfully!');
    }
    public function render()
    {
        $Coupons = Coupon::where(function ($query) {
            if ($this->search != '' && $this->search != null) {
                $query->where("title", "like", "%{$this->search}%")
                    ->orWhere("coupon_code", "like", "%{$this->search}%")
                    ->orWhere("minimum_order_value", "like", "%{$this->search}%")
                    ->orWhere("discount_type", "like", "%{$this->search}%")
                    ->orWhere("discount_value", "like", "%{$this->search}%")
                    ->orWhere("maximum_discount_amount", "like", "%{$this->search}%")
                    ->orWhere("usage_limit", "like", "%{$this->search}%")
                    ->orWhere("total_usage", "like", "%{$this->search}%")
                    ->orWhere("expiry_date", "like", "%{$this->search}%");
            }
        })->orderBy("id", "desc")->paginate(10);

        return view('livewire.admin.coupon.index',compact("Coupons"))->layout('layouts.admin.app');
    }
}
