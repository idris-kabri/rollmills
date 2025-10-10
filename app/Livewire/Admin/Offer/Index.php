<?php

namespace App\Livewire\Admin\Offer;

use App\Models\Offer;
use App\Models\OfferAppliesConfig;
use App\Models\OfferTriggerConfig;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, HasToastNotification;

    public $search = '';
    public function delete($id)
    {
        $delete = Offer::find($id);
        $delete->delete();

        $trigger = OfferTriggerConfig::where("offer_id",$id);
        $trigger->delete();
        $applies = OfferAppliesConfig::where("offer_id",$id);
        $applies->delete();
        $this->toastError('Offer Deleted Successfully!');
    }
    public function render()
    {
        $offers = Offer::where(function ($query) {
            if ($this->search != '' && $this->search != null) {
                $query->where("start_rage", "like", "%{$this->search}%")
                    ->orWhere("end_rage", "like", "%{$this->search}%")
                    ->orWhere("minimum_order_value", "like", "%{$this->search}%")
                    ->orWhere("discount_type", "like", "%{$this->search}%")
                    ->orWhere("discount_value", "like", "%{$this->search}%")
                    ->orWhere("maximum_discount_amount", "like", "%{$this->search}%")
                    ->orWhere("usage_limit", "like", "%{$this->search}%")
                    ->orWhere("total_usage", "like", "%{$this->search}%")
                    ->orWhere("expiry_date", "like", "%{$this->search}%");
            }
        })->orderBy("id", "desc")->paginate(10);
        return view('livewire.admin.offer.index',compact("offers"))->layout('layouts.admin.app');
    }
}
