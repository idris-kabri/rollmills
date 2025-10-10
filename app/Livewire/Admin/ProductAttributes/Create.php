<?php

namespace App\Livewire\Admin\ProductAttributes;

use App\Models\ProductAttribute;
use App\Models\ProductAttributesItem;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    use HasToastNotification;
    
    public $name;
    public $attributes_lists = [];
    public $status = 1;
    
    public function addNewAttributes(){
        $this->attributes_lists[] = [
            'is_default' => 0,
            'name' => ''
        ];
    }
    
    public function render()
    {
        return view('livewire.admin.product-attributes.create')->layout('layouts.admin.app');
    }

    public function removeArray($key){
        unset($this->attributes_lists[$key]);
    }

    public function store(){
        $this->validate([
            'name' => 'required|unique:product_attributes,name',
            'status' => 'required',
            'attributes_lists' => 'required|array',
            'attributes_lists.*.name' => 'required',
            'attributes_lists.*.is_default' => 'sometimes|nullable'
        ]);

        try { 
            sleep(1);
            DB::beginTransaction();
            $product_attribute = new ProductAttribute();
            $product_attribute->name = $this->name;
            $product_attribute->status = $this->status;
            $product_attribute->save();

            foreach($this->attributes_lists as $attribute_list){
                $find = ProductAttributesItem::where('product_attribute_id', $product_attribute->id)->where('name', $attribute_list['name'])->count();

                if($find > 0){
                    session()->flash('error', 'Attribute Item with name: ' . $attribute_list['name'] . ' already exists');
                    break;
                }

                $product_attributes_items = new ProductAttributesItem();
                $product_attributes_items->product_attribute_id = $product_attribute->id;
                $product_attributes_items->is_default = $attribute_list['is_default'] ? (int) $attribute_list['is_default'] : 0;
                $product_attributes_items->name = $attribute_list['name'];
                $product_attributes_items->save();
            }

            DB::commit();

            $this->toastSuccess('Attribute Created Successfully!');
            $this->redirectWithDelay('/admin/product-attributes/');

        } catch (\Exception $e) {
            DB::rollBack(); 
            $this->toastError($e->getMessage()); 
            $this->redirectWithDelay('/admin/product-attributes/create');
        }
    }

}
