<?php

namespace App\Livewire\Admin\Banner;

use App\Models\Banner;
use App\Traits\HasToastNotification;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination,HasToastNotification;

    public $search = '';

    public function delete($id){
        $delete = Banner::find($id);
        $delete->delete(); 
        $this->toastError('Banner Deleted Successfully!');
    }
    public function render()
    {
        $banners = Banner::where(function($query){
            if($this->search != '' && $this->search != null){
                $query->where("heading","like","%{$this->search}%")
                ->orWhere("sub_heading","like","%{$this->search}%")
                ->orWhere("button_text","like","%{$this->search}%")
                ->orWhere("start_time","like","%{$this->search}%")
                ->orWhere("end_time","like","%{$this->search}%");
            }
        })->orderBy("id","desc")->paginate(10);

        return view('livewire.admin.banner.index',compact("banners"))->layout('layouts.admin.app');
    }
}
