<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Address;
use App\Models\Order;
use App\Models\ProductReview;
use App\Models\Transaction;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination; 
use Cart;

class CustomerDetail extends Component
{
    use WithPagination;
    public $name;
    public $email;
    public $id;
    public $oredr_search;
    public $review_search;
    public function mount($id)
    {
        $this->id = $id;
        $user_detail = User::find($id);
        $this->name = $user_detail->name;
        $this->email = $user_detail->email;
    }
    public function render()
    {
        $transactions = Transaction::where("user_id", $this->id)->orderBy("id", "desc")->get(); 
        $get_address = Address::where('user_id',$this->id)->orderBy('id','desc')->get();  

        //whislist
        Cart::instance('wishlist')->destroy();
        $restore_wishlist =  Cart::instance('wishlist')->restore($this->email);
        $get_whislist = Cart::instance('wishlist')->content();

        //cart
        Cart::instance('cart')->destroy();
        $restore_cart =  Cart::instance('cart')->restore($this->email);
        $get_cart = Cart::instance('cart')->content();

        $orders = Order::where("logged_in_user_id", $this->id)
            ->when($this->oredr_search, function ($query) {
                $query->where(function ($q) {
                    $q->where('subtotal', 'like', '%' . $this->oredr_search . '%')
                        ->orWhere('coupon_discount', 'like', '%' . $this->oredr_search . '%')
                        ->orWhere('offer_discount', 'like', '%' . $this->oredr_search . '%')
                        ->orWhere('gift_card_discount', 'like', '%' . $this->oredr_search . '%')
                        ->orWhere('paid_amount', 'like', '%' . $this->oredr_search . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $reviews = ProductReview::where("user_id", $this->id)
            ->when($this->review_search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->review_search . '%')
                        ->orWhere('email', 'like', '%' . $this->review_search . '%')
                        ->orWhere('remarks', 'like', '%' . $this->review_search . '%')
                        ->orWhereHas('getProducts', function($query){ 
                            $query->where('name','like', '%' . $this->review_search . '%');
                        });
                });
            })
            ->orderBy('id', 'desc')
            ->get();
        return view('livewire.admin.customers.customer-detail', compact("transactions", 'orders','reviews','get_address','get_whislist','get_cart'))->layout('layouts.admin.app');
    }
}
