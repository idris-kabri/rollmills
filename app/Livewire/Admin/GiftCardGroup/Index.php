<?php

namespace App\Livewire\Admin\GiftCardGroup;

use App\Models\GiftCardGroup;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{ 
    use HasToastNotification,WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $id;
    public $price;
    public $showCustomer;
    public $status;
    public $search;
    public $isCustom;

    public function giftCardGroupCreate(){ 
        $this->validate([
            'price' => 'required|integer|unique:gift_card_groups,price',
        ]); 

        try{  
            DB::beginTransaction();
            $gift_card_group = new GiftCardGroup(); 
            $gift_card_group->price = $this->price; 
            if($this->showCustomer == true){ 
                $gift_card_group->show_customer = 1; 
            }
            if($this->status == true){ 
                $gift_card_group->status = 1; 
            }
            $gift_card_group->save(); 
            $this->toastSuccess('Gift Card Group Create Successfully!'); 
            $this->dispatch('model-close'); 
            DB::commit();
        }catch(\Exception $e){ 
            DB::rollBack(); 
            $this->toastError($e->getMessage());
        }
    } 

    public function giftCardGroupEdit($id){  
        $gift_card_group = GiftCardGroup::findOrFail($id);
        $this->id = $gift_card_group->id;
        $this->price = $gift_card_group->price;
        $this->showCustomer = $gift_card_group->show_customer == 1 ? true : false;
        $this->status = $gift_card_group->status == 1 ? true : false;
        $this->isCustom = $gift_card_group->is_custom == 1 ? true : false;
    }

    public function giftCardGroupUpdate(){ 
        $this->validate([
            'price' => 'required|integer|unique:gift_card_groups,price,'. $this->id,
        ]); 

        try{  
            DB::beginTransaction();
            $gift_card_group = GiftCardGroup::findOrFail($this->id); 
            $gift_card_group->price = $this->price; 
            $gift_card_group->show_customer = $this->showCustomer ? 1 : 0; 
            $gift_card_group->status = $this->status ? 1 : 0; 
            $gift_card_group->is_custom = $this->isCustom ? 1 : 0; 
            $gift_card_group->save(); 
            $this->toastSuccess('Gift Card Group Updated Successfully!'); 
            $this->dispatch('model-close');
            DB::commit();
        }catch(\Exception $e){ 
            DB::rollBack(); 
            $this->toastError($e->getMessage());
        }
    }
    public function resetField(){ 
        $this->price = null;
        $this->showCustomer = null;
        $this->status = null; 
        $this->resetValidation(); 
        $this->resetErrorBag();
    }
    public function render()
    { 
        $giftCardGroups = GiftCardGroup::where(function ($query) {
            $query->where('price', 'LIKE', "%{$this->search}%");
        })->paginate(10);

        return view('livewire.admin.gift-card-group.index',compact('giftCardGroups'))->layout('layouts.admin.app');
    }
}
