<?php
namespace App\Livewire\Admin\ProductAttributes;

use App\Models\ProductAttribute;
use App\Models\ProductAttributesItem;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination , HasToastNotification;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        return view('livewire.admin.product-attributes.index', [
            "product_attributes" => ProductAttribute::paginate(10)
        ])->layout('layouts.admin.app');
    }

    public function deleteProductAttributes($id){
        ProductAttributesItem::where('product_attribute_id', $id)->delete();
        ProductAttribute::where('id', $id)->delete(); 

        $this->toastError('Product Attribute Deleted Successfully!');
    }
}