<?php

namespace App\Livewire\Admin\ProductsCategories;

use App\Models\ProductCategory;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{   
    public $search = "";
    use WithPagination,HasToastNotification;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $product_categories = ProductCategory::orderBy("id", "desc")->
            where("name","like","%{$this->search}%")->
            orwhere("description","like","%{$this->search}%")->
            orwhere("seo_title","like","%{$this->search}%")->
            orwhere("seo_description","like","%{$this->search}%")->
            orwhere("seo_keyword","like","%{$this->search}%")
            ->paginate(10);
        return view('livewire.admin.products-categories.index', compact("product_categories"))->layout('layouts.admin.app');
    }

    public function deleteProductCategory($id)
    {
        try {
            DB::beginTransaction();
            $delete_product_category = ProductCategory::find($id);
            $delete_product_category->delete();
            DB::commit(); 
            $this->toastError('Product Category Deleted Successfully!'); 
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage()); 
            $this->toastError($e->getMessage()); 
        }
    }
}
