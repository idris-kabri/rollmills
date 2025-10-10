<?php

namespace App\Livewire\Admin\Offer;

use App\Models\Brand;
use App\Models\Offer;
use App\Models\OfferAppliesConfig;
use App\Models\OfferTriggerConfig;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Create extends Component
{
    use HasToastNotification;
    public $start_rage, $end_rage, $audience = "", $discount_type = "", $discount_value;

    public $trigger_list = [];
    public $applies_list = [];


    public $trigger_edit_index = '';
    public $tigger_refrence_id = "";
    public $trigger_type = "";
    public $trigger_brands = [];
    public $trigger_products = [];
    public $trigger_categories = [];
    public $trigger_value_label = "";
    public $trigger_min_qty = "";
    public $trigger_min_amount = "";

    public $applies_edit_index = '';
    public $applies = "";
    public $applies_refrence_id  = "";
    public $applies_brands = [];
    public $applies_products = [];
    public $applies_categories = [];
    public $applies_value_label = "";
    public $applies_min_qnty = "";
    public $applies_min_amount = ""; 
    public $item_returnable = 1;

    public function mount()
    {
        $this->trigger_products = Product::all();
        $this->trigger_brands = Brand::all();
        $this->trigger_categories = ProductCategory::all();

        //applies 
        $this->applies_categories = ProductCategory::all();
        $this->applies_brands = Brand::all();
        $this->applies_products = Product::all();
    }
    public function changeTriggerType($index)
    {
        if ($index == '') {
            $this->dynamicTriggerOption();
        }
    }


    public function dynamicTriggerOption()
    {
        if ($this->trigger_type == 1) {
            $this->trigger_value_label = "Product";
            // $this->trigger_products = Product::all();
        } elseif ($this->trigger_type == 2) {
            $this->trigger_value_label = "Brand";
            // $this->trigger_brands = Brand::all();
        } elseif ($this->trigger_type == 3) {
            $this->trigger_value_label = "Category";
            // $this->trigger_categories = ProductCategory::all();
        }
        return true;
    }




    public function changeApplies($index)
    {
        if ($index == '') {
            $this->dynamicAppliesTo();
        }
    }


    public function dynamicAppliesTo()
    {
        if ($this->applies == 1) {
            $this->applies_value_label = "Product";
            // $this->applies_products = Product::all();
        } elseif ($this->applies == 2) {
            $this->applies_value_label = "Brand";
            // $this->applies_brands = Brand::all();
        } elseif ($this->applies == 3) {
            $this->applies_value_label = "Category";
            // $this->applies_categories = ProductCategory::all();
        }
        return true;
    }

    public function addTriggerType()
    {
        $validator = Validator::make($this->all(), [
            'tigger_refrence_id' => "required",
            'trigger_type' => "required",
        ]);
        if ($validator->fails()) {
            $this->dispatch('validation-errors', [
                'errors' => $validator->errors()
            ]);
        } else {
            $reference = explode('developer', $this->tigger_refrence_id);
            $name = $reference[1];
            $id = $reference[0];
            if ($this->trigger_edit_index == '') {
                $this->trigger_list[] = [
                    "refrence_id" => $id,
                    "name" => $name,
                    "trigger_type" => $this->trigger_type,
                    "min_qty" => $this->trigger_min_qty != '' ? $this->trigger_min_qty : 0,
                    "min_amount" => $this->trigger_min_amount != '' ? $this->trigger_min_amount : 0,
                ];
            } else {
                $this->trigger_list[$this->trigger_edit_index] = [
                    "refrence_id" => $id,
                    "name" => $name,
                    "trigger_type" => $this->trigger_type,
                    "min_qty" => $this->trigger_min_qty != '' ? $this->trigger_min_qty : 0,
                    "min_amount" => $this->trigger_min_amount != '' ? $this->trigger_min_amount : 0,
                ];
            }
            $this->reset(["tigger_refrence_id", "trigger_type", "trigger_min_qty", "trigger_min_amount"]);
        }
    }


    public function editTrigger($index)
    {
        $this->trigger_edit_index = $index;
        $this->trigger_type = $this->trigger_list[$index]["trigger_type"];
        if ($this->dynamicTriggerOption()) {
            $this->tigger_refrence_id = $this->trigger_list[$index]["refrence_id"] . 'developer' . $this->trigger_list[$index]["name"];
        }
        $this->trigger_min_qty = $this->trigger_list[$index]["min_qty"];
        $this->trigger_min_amount = $this->trigger_list[$index]["min_amount"];
    }


    public function triggerDelete($index)
    {
        unset($this->trigger_list[$index]);
    }

    public function addAppliesTo()
    {
        $validator = Validator::make($this->all(), [
            'applies_refrence_id' => "sometimes",
            'applies' => "required",
        ]);
        if ($validator->fails()) {
            $this->dispatch('validation-errors', [
                'errors' => $validator->errors()
            ]);
        } else {
            $reference = $this->applies == "4" ? [] : explode('developer', $this->applies_refrence_id);
            $name = null;
            $id = null;
            if (count($reference) > 0) {
                $name = $reference[1];
                $id = $reference[0];
            }
            if ($this->applies_edit_index == '') {
                $this->applies_list[] = [
                    "refrence_id" => $id,
                    "name" => $name,
                    "applies" => $this->applies,
                    "min_qnty" => ($this->applies_min_qnty != '' && $this->applies != "4") ? $this->applies_min_qnty : 0,
                    "min_amount" => ($this->applies_min_amount != '' && $this->applies != "4") ? $this->applies_min_amount : 0,
                ];
            } else {
                $this->applies_list[$this->applies_edit_index] = [
                    "refrence_id" => $id,
                    "name" => $name,
                    "applies" => $this->applies,
                    "min_qnty" => ($this->applies_min_qnty != '' && $this->applies != "4") ? $this->applies_min_qnty : 0,
                    "min_amount" => ($this->applies_min_amount != '' && $this->applies != "4") ? $this->applies_min_amount : 0,
                ];
            }
            $this->reset(["applies_refrence_id", "applies", "applies_min_qnty", "applies_min_amount"]);
        }
    }


    public function editApplies($index)
    {
        $this->applies_edit_index = $index;
        $this->applies = $this->applies_list[$index]["applies"];
        if ($this->dynamicAppliesTo()) {
            $this->applies_refrence_id = $this->applies_list[$index]["refrence_id"] . 'developer' . $this->applies_list[$index]["name"];
        }
        $this->applies_min_qnty = $this->applies_list[$index]["min_qnty"];
        $this->applies_min_amount = $this->applies_list[$index]["min_amount"];
    }


    public function appliesDelete($index)
    {
        unset($this->applies_list[$index]);
    }


    public function submit()
    {
        $validator = Validator::make($this->all(), [
            'start_rage' => "required",
            'end_rage' => "required",
            'audience' => "required",
            'discount_type' => "required",
            'discount_value' => "required",
        ]);
        if ($validator->fails()) {
            $this->dispatch('validation-errors', [
                'errors' => $validator->errors()
            ]);
        } else { 
            sleep(1); 
            $offer = new Offer();
            $offer->start_rage = $this->start_rage;
            $offer->end_rage = $this->end_rage;
            $offer->audience = $this->audience;
            $offer->discount_type = $this->discount_type;
            $offer->discount_value = $this->discount_value; 
            if($this->item_returnable == false){ 
                $offer->item_returnable = 0;
            }else{ 
                $offer->item_returnable = 1;
            }
            $offer->save();
            foreach ($this->trigger_list as $triggers) {
                $offer_trigger_config = new OfferTriggerConfig;
                $offer_trigger_config->offer_id = $offer->id;
                $offer_trigger_config->trigger_type = $triggers["trigger_type"];
                $offer_trigger_config->refrence_id = $triggers["refrence_id"];
                $offer_trigger_config->min_qnty = $triggers["min_qty"];
                $offer_trigger_config->min_amount = $triggers["min_amount"];
                $offer_trigger_config->save();
            }

            foreach ($this->applies_list as $applies) {
                $offer_applies_config = new OfferAppliesConfig();
                $offer_applies_config->offer_id = $offer->id;
                $offer_applies_config->applies = $applies["applies"];
                $offer_applies_config->refrence_id = $applies["refrence_id"];
                $offer_applies_config->min_qnty = $applies["min_qnty"];
                $offer_applies_config->min_amount = $applies["min_amount"];
                $offer_applies_config->save();
            }
            $this->toastSuccess("Offer Created Successfully...");
            return redirect()->route("admin.offer.index");
        }
    }

    public function render()
    {
        return view('livewire.admin.offer.create')->layout('layouts.admin.app');
    }
}
