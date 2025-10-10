<?php

namespace App\Livewire\Admin\UserQuotation;

use App\Models\Quotation;
use App\Traits\HasToastNotification;
use Livewire\Component;

class View extends Component
{ 
    use HasToastNotification;
    public $quotation; 
    public $status; 

    public function mount($id){ 
        $this->quotation = Quotation::find($id);
    } 

    public function quotationStatusChange(){ 
        try{ 
            $this->quotation->status = $this->status; 
            $this->quotation->save(); 
            $this->toastSuccess('Quotation Status Change Successfully!');  
            $url = '/admin/user-quotation/view/' . $this->quotation->id;
            $this->redirectWithDelay($url);
        }catch(\Exception $e){ 
            $this->toastError($e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.admin.user-quotation.view')->layout('layouts.admin.app');
    }
}
