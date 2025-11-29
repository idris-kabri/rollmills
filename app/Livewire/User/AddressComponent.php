<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasToastNotification;

class AddressComponent extends Component
{
    use HasToastNotification;
    public $addresses;
    public $show_addres = false;

    public function mount(){
        $this->addresses = Address::where('user_id', Auth::user()->id)->get();
    }

    public function add_address(){
        if($this->show_addres){
            $this->show_addres = false;
        }else{
            $this->show_addres = true;
        }
    }

    public function deleteAddress($id){
        $address = Address::find($id);
        $address->delete();
        $this->toastSuccess('Address Deleted Successfully');
        $this->addresses = Address::where('user_id', Auth::user()->id)->get();
    } 
    
    public function render()
    {
        return view('livewire.user.address-component')->layout('layouts.user.app');
    }
}
