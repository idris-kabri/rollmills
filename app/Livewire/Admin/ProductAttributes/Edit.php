<?php

namespace App\Livewire\Admin\ProductAttributes;

use App\Models\ProductAttribute;
use App\Models\ProductAttributesItem;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Edit extends Component
{
    use HasToastNotification;

    public $id;
    public $product_attribute;
    public $name;
    public $attributes_lists = [];
    public $status;

    public function mount($id)
    {
        $this->id = $id;
        $product_attribute = ProductAttribute::find($id);
        $this->product_attribute = $product_attribute;
        $this->name = $product_attribute->name;
        $this->status = $product_attribute->status;
        foreach ($product_attribute->getAttibuteItems as $item) {
            $this->attributes_lists[] = [
                'id' => $item->id,
                'is_default' => $item->is_default,
                'name' => $item->name
            ];
        }
    }
    public function addNewAttributes()
    {
        $this->attributes_lists[] = [
            'id' => 0,
            'is_default' => 0,
            'name' => ''
        ];
    }

    public function removeArray($key)
    {
        if ($this->attributes_lists[$key]['id'] != 0 && $this->attributes_lists[$key]['id'] != '' && $this->attributes_lists[$key]['id'] != null) {
            ProductAttributesItem::where('id', $this->attributes_lists[$key]['id'])->delete();
        }
        unset($this->attributes_lists[$key]);
    }

    public function render()
    {
        return view('livewire.admin.product-attributes.edit')->layout('layouts.admin.app');
    }

    public function store(){
        $this->validate([
            'name' => 'required|unique:product_attributes,name,' . $this->id,
            'status' => 'required',
            'attributes_lists' => 'required|array',
            'attributes_lists.*.name' => 'required',
            'attributes_lists.*.is_default' => 'sometimes|nullable',
            'attributes_lists.*.id' => 'sometimes|nullable'
        ]);
        
        try {
            sleep(1);
            DB::beginTransaction();
            $product_attribute = ProductAttribute::find($this->id);
            $product_attribute->name = $this->name;
            $product_attribute->status = $this->status;
            $product_attribute->save();
            
            foreach($this->attributes_lists as $attribute_list){
                if($attribute_list['id'] != 0 && $attribute_list['id'] != '' && $attribute_list['id'] != null){
                    $find = ProductAttributesItem::where('product_attribute_id', $this->id)->where('name', $attribute_list['name'])->where('id', '!=', $attribute_list['id'])->count();
                }else{
                    $find = ProductAttributesItem::where('product_attribute_id', $this->id)->where('name', $attribute_list['name'])->count();
                }
                if($find > 0){
                    session()->flash('error', 'Attribute Item with name: ' . $attribute_list['name'] . ' already exists');
                    break;
                }
                
                if ($attribute_list['id'] != 0 && $attribute_list['id'] != '' && $attribute_list['id'] != null) {
                    $product_attributes_items = ProductAttributesItem::find($attribute_list['id']);
                }else{
                    $product_attributes_items = new ProductAttributesItem();
                }
                $product_attributes_items->product_attribute_id = $product_attribute->id;
                $product_attributes_items->is_default = $attribute_list['is_default'] ? (int) $attribute_list['is_default'] : 0;
                $product_attributes_items->name = $attribute_list['name'];
                $product_attributes_items->save();
            }
            DB::commit(); 

            $this->toastSuccess('Attribute Updated Successfully!');
            $this->redirectWithDelay('/admin/product-attributes/');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->toastError($e->getMessage()); 
            $this->redirectWithDelay('/admin/product-attributes/');
        }
    }
}
