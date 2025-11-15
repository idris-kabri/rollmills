<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use App\Traits\HasToastNotification;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\json;

class Edit extends Component
{
    use WithFileUploads, HasToastNotification;

    public $id;
    public $heading;
    public $sub_heading;
    public $button_text;
    public $status;
    public $image;
    public $link;
    public $is_default;
    public $start_time;
    public $end_time;
    public $banner_type;
    public $defaultImage = "";
    public $audience = [];

    public function mount($id)
    {
        $this->id = $id;
        $banner = Banner::find($id);
        $this->defaultImage = $banner->image;
        $this->link = $banner->link;
        $this->heading = $banner->heading;
        $this->sub_heading = $banner->sub_heading;
        $this->button_text = $banner->button_text;
        $this->status = $banner->status;
        $this->is_default = $banner->is_default;
        $this->start_time = $banner->start_time;
        $this->end_time = $banner->end_time;
        $this->banner_type = $banner->banner_type;
        $this->audience = json_decode($banner->audience, true);
    }

    public function update()
    {
        $validator = Validator::make($this->all(), [
            "heading" => "sometimes",
            "sub_heading" => "sometimes",
            "button_text" => "sometimes",
            "status" => "required|boolean",
            "image" => "sometimes|nullable|image",
            "link" => "sometimes",
            "is_default" => "required",
            "start_time" => "sometimes|nullable|date",
            "end_time" => "sometimes|nullable|date",
            "banner_type" => "required",
            "audience" => "required|array"
        ]);

        if ($validator->fails()) {
            $this->dispatch('validation-errors', [
                'errors' => $validator->errors()
            ]);
        }

        try {
            $update_banner = Banner::find($this->id);
            if ($this->image instanceof \Illuminate\Http\UploadedFile) {
                $current_image = $update_banner->image;
                if ($current_image != null && $current_image != '') {
                    Storage::disk('public')->delete($current_image);
                }
                $imagePath = $this->image->store('banner', 'public');
                $update_banner->image = $imagePath;
            }
            $update_banner->heading = $this->heading;
            $update_banner->sub_heading = $this->sub_heading;
            $update_banner->button_text = $this->button_text;
            $update_banner->status = $this->status;
            $update_banner->link = $this->link;
            $update_banner->is_default = $this->is_default ?? 0;
            $update_banner->start_time = $this->start_time;
            $update_banner->end_time = $this->end_time;
            $update_banner->banner_type = $this->banner_type;
            $update_banner->audience = json_encode($this->audience);
            $update_banner->save();

            $this->toastSuccess('Banner Updated Successfully!');
            $this->redirectWithDelay('/admin/banner/');
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
            $this->redirectWithDelay('/admin/banner/');
        }
    }
    public function render()
    {
        return view('livewire.admin.banner.edit')->layout('layouts.admin.app');
    }
}
