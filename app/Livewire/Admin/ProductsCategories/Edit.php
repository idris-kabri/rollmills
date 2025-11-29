<?php

namespace App\Livewire\Admin\ProductsCategories;

use App\Models\ProductCategory;
use App\Models\ProductCategoryRelation;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads, HasToastNotification;

    public $id;
    public $name = "";
    public $description = "";
    public $status = "";
    public $image;
    public $icon;
    public $is_featured;
    public $seo_title = "";
    public $seo_keyword = "";
    public $seo_description = "";
    public $defaultImage = "";
    public $defaultIcon = "";
    public $parent_categories = [];
    public $parent_category_id = '';
    public $slug;

    public function mount($id)
    {
        $this->id = $id;
        $Product_category = ProductCategory::find($id);
        $this->name = $Product_category->name;
        $this->slug = $Product_category->slug;
        $this->description = $Product_category->description;
        $this->status = $Product_category->status;
        $this->defaultImage = $Product_category->image;
        $this->defaultIcon = $Product_category->icon;
        $this->is_featured = $Product_category->is_featured;
        $this->seo_title = $Product_category->seo_title;
        $this->seo_keyword = $Product_category->seo_keyword;
        $this->seo_description = $Product_category->seo_description;
        $this->parent_categories = ProductCategory::where('id', '!=', $id)->get();
        $this->parent_category_id = $Product_category->parent_id;
    }

    public function updatedName($value)
    {
        $this->slug = Str::slug($value, '-');
    }

    // update
    public function update()
    {
        // validate
        $this->validate([
            "name" => "required",
            "description" => "required",
            "status" => "required",
            'image' => 'nullable|max:2048',
            'icon' => 'nullable|max:2048',
            "seo_title" => "required",
            "seo_keyword" => "required",
            "seo_description" => "required",
            'parent_category_id' => 'sometimes|nullable'
        ]);

        try {
            sleep(1);
            // update
            $store_product_category = ProductCategory::find($this->id);

            if ($this->image instanceof \Illuminate\Http\UploadedFile) {
                $current_image = $store_product_category->image;
                if ($current_image != null && $current_image != '') {
                    $image_path = public_path('storage/' . $current_image);
                    Storage::disk('public')->delete($current_image);
                }
                $imagePath = $this->image->store('product_category', 'public');
                $store_product_category->image = $imagePath;
            }
            if ($this->icon instanceof \Illuminate\Http\UploadedFile) {
                $current_icon = $store_product_category->icon;
                if ($current_icon != null && $current_icon != '') {
                    $icon_path = public_path('storage/' . $current_icon);
                    Storage::disk('public')->delete($current_icon);
                }
                $iconPath = $this->icon->store('product_category_icon', 'public');
                $store_product_category->icon = $iconPath;
            }
            $store_product_category->name = $this->name;
            $store_product_category->slug = $this->slug;
            $store_product_category->description = $this->description;
            $store_product_category->status = $this->status;
            $store_product_category->is_featured = $this->is_featured ?? 0;
            $store_product_category->seo_title = $this->seo_title;
            $store_product_category->seo_keyword = $this->seo_keyword;
            $store_product_category->seo_description = $this->seo_description;
            if (isset($this->parent_category_id) && $this->parent_category_id != null && $this->parent_category_id != '' && $this->parent_category_id != $store_product_category->id && $this->parent_category_id != $store_product_category->parent_id) {
                $store_product_category->parent_id = $this->parent_category_id;
            }
            $store_product_category->save();

            $this->toastSuccess('Product Category Updated Successfully!');
            $this->redirectWithDelay('/admin/products-categories/');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
            $this->redirectWithDelay('/admin/products-categories/');
        }
    }

    public function render()
    {
        return view('livewire.admin.products-categories.edit')->layout('layouts.admin.app');
    }
}
