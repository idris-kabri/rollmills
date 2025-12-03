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
    public $address_id = null;
    public $name;
    public $email;
    public $mobile;
    public $state;
    public $city;
    public $zipcode;
    public $address_line_1;
    public $address_line_2;

    public function mount()
    {
        $this->addresses = Address::where('user_id', Auth::user()->id)->get();
    }

    public function add_address()
    {
        $this->name = "";
        $this->email = "";
        $this->mobile = "";
        $this->state = "";
        $this->city = "";
        $this->zipcode = "";
        $this->address_line_1 = "";
        $this->address_line_2 = "";
        $this->address_id = "";
        if ($this->show_addres) {
            $this->show_addres = false;
        } else {
            $this->show_addres = true;
        }
    }

    public function editAddress($id)
    {
        if ($this->address_id == $id) {
            $this->show_addres = false;
            $this->address_id = null;
        } else {
            $address = Address::find($id);
            $this->name = $address->name;
            $this->email = $address->email;
            $this->mobile = $address->mobile;
            $this->state = $address->state;
            $this->city = $address->city;
            $this->zipcode = $address->zipcode;
            $this->address_line_1 = $address->address_line_1;
            $this->address_line_2 = $address->address_line_2;
            $this->address_id = $id;
            $this->show_addres = true;
        }
    }

    public function deleteAddress($id)
    {
        $address = Address::find($id);
        $address->delete();
        $this->toastSuccess('Address Deleted Successfully');
        $this->addresses = Address::where('user_id', Auth::user()->id)->get();
    }

    public function saveAddress()
    {
        if ($this->address_id != null) {
            $address = Address::find($this->address_id);
        } else {
            $address = new Address();
        }
        $address->name = $this->name;
        $address->email = $this->email;
        $address->mobile = $this->mobile;
        $address->address_line_1 = $this->address_line_1;
        $address->address_line_2 = $this->address_line_2 ?? null;
        $address->city = $this->city;
        $address->state = $this->state;
        $address->zipcode = $this->zipcode;
        $address->ip_address = request()->ip();
        $address->is_user_logged_in_user = 1;
        $address->user_id = Auth::id();
        $address->save();
        $this->show_addres = false;
        $this->toastSuccess('Address Saved Successfully');
        $this->addresses = Address::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        return view('livewire.user.address-component')->layout('layouts.user.app');
    }
}
