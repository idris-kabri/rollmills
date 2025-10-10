<?php

namespace App\Livewire\Admin\Brand;

use App\Models\Brand;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads,HasToastNotification;
    public $id;
    public $name;
    public $description;
    public $status;
    public $image;
    public $is_featured;
    public $seo_title;
    public $seo_meta;
    public $seo_description;
    public $defaultImage;
    public $link;

    public function mount($id)
    {
        $this->id = $id;
        $brand = Brand::find($id);
        $this->name = $brand->name;
        $this->description = $brand->description;
        $this->status = $brand->status;
        $this->defaultImage = $brand->image;
        $this->is_featured = $brand->is_featured;
        $this->seo_title = $brand->seo_title;
        $this->seo_meta = $brand->seo_meta;
        $this->seo_description = $brand->seo_description;
        $this->link = $brand->link;
    }
    public function render()
    {
        return view('livewire.admin.brand.edit')->layout('layouts.admin.app');
    } 

    public function update(){  
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required',
            'image' => 'nullable|max:2048',
            'seo_title' => 'required|string|max:255',
            'seo_meta' => 'required|string',
            'seo_description' => 'required|string',
            'link' => 'required',
        ]);   
        
        try{    
            sleep(1);
            DB::beginTransaction();
            $brand =  Brand::find($this->id);
            if ($this->image instanceof \Illuminate\Http\UploadedFile) {
                $imagePath = $this->image->store('brands', 'public'); 
                $brand->image = $imagePath; 
            }
            $brand->name = $this->name;
            $brand->description = $this->description;
            $brand->status = $this->status;
            $brand->is_featured = $this->is_featured;
            $brand->seo_title = $this->seo_title;
            $brand->seo_meta = $this->seo_meta;
            $brand->seo_description = $this->seo_description; 
            $brand->link = $this->link; 
            $brand->save();  
            DB::commit(); 

            $this->toastSuccess('Brand Updated Successfully!'); 
            $this->redirectWithDelay('/admin/brand');
        }catch(\Exception $e){ 
            DB::rollBack();  
            $this->toastError($e->getMessage()); 
            $this->redirectWithDelay('/admin/brand');
        }
    } 
}
