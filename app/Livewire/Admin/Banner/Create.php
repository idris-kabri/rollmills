<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use App\Traits\HasToastNotification;
use Exception;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads, HasToastNotification;
    public $heading;
    public $sub_heading;
    public $button_text;
    public $status = 1;
    public $image;
    public $link;
    public $is_default = 1;
    public $start_time;
    public $end_time;
    public $banner_type;
    public $audience = [];

    public function store()
    {

        $validator = Validator::make($this->all(), [
            "heading" => "sometimes",
            "sub_heading" => "sometimes",
            "button_text" => "sometimes",
            "status" => "required|boolean",
            "image" => "required|image",
            "link" => "sometimes",
            "is_default" => "required",
            "start_time" => "sometimes|nullable|date",
            "end_time" => "sometimes|nullable|date",
            "banner_type" => "required"
        ]);

        if ($validator->fails()) {
            $this->dispatch('validation-errors', [
                'errors' => $validator->errors()
            ]);
        } else {
            try {
                $store_banner = new Banner;
                $store_banner->heading = $this->heading;
                $store_banner->sub_heading = $this->sub_heading;
                $store_banner->button_text = $this->button_text;
                $store_banner->status = $this->status;
                if ($this->image) {
                    $path = $this->image->store("banner", "public");
                    $store_banner->image = $path;
                }
                $store_banner->link = $this->link;
                $store_banner->is_default = $this->is_default ?? 0;
                $store_banner->start_time = $this->start_time;
                $store_banner->end_time = $this->end_time;
                $store_banner->banner_type = $this->banner_type;
                $store_banner->audience = json_encode($this->audience);
                $store_banner->save();

                $this->toastSuccess('Banner Created Successfully!');
                $this->redirectWithDelay('/admin/banner/');
            } catch (\Exception $e) {
                $this->toastError($e->getMessage());
                $this->redirectWithDelay('/admin/banner/');
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.banner.create')->layout('layouts.admin.app');
    }
}
