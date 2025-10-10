<?php

namespace App\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads,HasToastNotification;

    public $name;
    public $description = '';
    public $status = 1;
    public $image;
    public $is_featured = false;
    public $seo_title;
    public $seo_meta;
    public $seo_description;
    public $link;

    public function render()
    {
        return view('livewire.admin.brand.create')->layout('layouts.admin.app');
    }

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required',
            'image' => 'required|image|max:2048',
            'seo_title' => 'required|string|max:255',
            'seo_meta' => 'required|string',
            'seo_description' => 'required|string', 
            'link' => 'required',
        ]);

        try { 
            sleep(1);
            DB::beginTransaction();
            $imagePath = null;
            if ($this->image) {
                $imagePath = $this->image->store('brands', 'public');
            }

            $brand = new Brand();
            $brand->name = $this->name;
            $brand->description = $this->description;
            $brand->status = $this->status;
            $brand->image = $imagePath;
            if ($this->is_featured != null) {
                $brand->is_featured = $this->is_featured;
            }
            $brand->seo_title = $this->seo_title;
            $brand->seo_meta = $this->seo_meta;
            $brand->seo_description = $this->seo_description;
            $brand->link = $this->link;
            $brand->save();
            DB::commit();

            $this->toastSuccess('Brand Created Successfully!'); 
            $this->redirectWithDelay('/admin/brand');
        } catch (\Exception $e) {
            DB::rollBack(); 
            $this->toastError($e->getMessage()); 
            $this->redirectWithDelay('/admin/brand');
        }
    }
}
