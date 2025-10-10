<?php

namespace App\Livewire\Admin\ProductsCategories;

use App\Models\ProductCategory;
use App\Models\ProductCategoryRelation;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads, HasToastNotification;

    public $name = "";
    public $description = "";
    public $status = "1";
    public $image;
    public $icon;
    public $is_featured;
    public $seo_title = "";
    public $seo_keyword = "";
    public $seo_description = "";
    public $parent_categories = [];
    public $parent_category_id = '';

    public function mount()
    {
        $this->parent_categories = ProductCategory::all();
    }
    // store
    public function store()
    {
        // validate
        $this->validate([
            "name" => "required",
            "description" => "required",
            "status" => "required",
            "image" => "required",
            "icon" => "required",
            "seo_title" => "required",
            "seo_keyword" => "required",
            "seo_description" => "required",
            'parent_category_id' => 'sometimes|nullable'
        ]);

        try {
            sleep(1);
            DB::beginTransaction();
            // create
            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('product_category', 'public');
            }

            $iconPath = null;
            if ($this->icon) {
                $iconPath = $this->icon->store('product_category_icon', 'public');
            }
            $store_product_category = new ProductCategory;
            $store_product_category->name = $this->name;
            $store_product_category->description = $this->description;
            $store_product_category->status = $this->status;
            $store_product_category->image = $imagePath;
            $store_product_category->icon = $iconPath;
            $store_product_category->is_featured = $this->is_featured ?? 0;
            $store_product_category->seo_title = $this->seo_title;
            $store_product_category->seo_keyword = $this->seo_keyword;
            $store_product_category->seo_description = $this->seo_description;
            if (isset($this->parent_category_id) && $this->parent_category_id != '' && $this->parent_category_id != null) {
                $store_product_category->parent_id = $this->parent_category_id;
            }
            $store_product_category->save();
            DB::commit();

            $this->toastSuccess('Product Category Created Successfully!');
            $this->redirectWithDelay('/admin/products-categories/');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());

            $this->toastError($e->getMessage());
            $this->redirectWithDelay('/admin/products-categories/');
        }
    }

    public function render()
    {
        return view('livewire.admin.products-categories.create')->layout('layouts.admin.app');
    }
}
