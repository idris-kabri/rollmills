<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Traits\HasToastNotification;
use Cart;

class CartComponent extends Component
{
    use HasToastNotification;
    public $quantities = [];

    public function mount()
    {
        foreach (Cart::instance('cart')->content() as $item) {
            $this->quantities[$item->rowId] = $item->qty;
        }
    }

    public function incrementQuantity($rowId)
    {
        if ($rowId) {
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($rowId) {
                    return $cartItem->rowId === $rowId;
                })
                ->first();

            if ($cart_check) {
                $item = Cart::instance('cart')->get($rowId);
                $product = $item->model;
                $qty = $item->qty + 1;
                $this->quantities[$rowId] = $qty;
                finalAddToCart($product, $qty, 'update-quantity');
                // $this->offerCheckEligibility();
                // if ($this->pincode != null) {
                //     $this->pincodeCheckFunction();
                // }
                // if (session('coupon_discount_id')) {
                //     $this->applyCoupon();
                // }
            }
        }
    }

    public function updateQuantity($rowId)
    {
        if ($rowId) {
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($rowId) {
                    return $cartItem->rowId === $rowId;
                })
                ->first();
            if ($cart_check) {
                $item = Cart::instance('cart')->get($rowId);
                $product = $item->model;
                $qty = $this->quantities[$rowId];
                finalAddToCart($product, $qty, 'update-quantity');
                // $this->offerCheckEligibility();
                // if ($this->pincode != null) {
                //     $this->pincodeCheckFunction();
                // }
                // if (session('coupon_discount_id')) {
                //     $this->applyCoupon();
                // }
            }
        }
    }

    public function decrementQuantity($rowId)
    {
        if ($rowId) {
            $cart_check = Cart::instance('cart')
                ->search(function ($cartItem) use ($rowId) {
                    return $cartItem->rowId === $rowId;
                })
                ->first();

            if ($cart_check) {
                $item = Cart::instance('cart')->get($rowId);
                $product = $item->model;
                $qty = $item->qty - 1;
                $this->quantities[$rowId] = $qty;
                finalAddToCart($product, $qty, 'update-quantity');
                // $this->offerCheckEligibility();
                // if ($this->pincode != null) {
                //     $this->pincodeCheckFunction();
                // }
                // if (session('coupon_discount_id')) {
                //     $this->applyCoupon();
                // }
            }
        }
    }

    public function removeFromCart($rowId)
    {
        $removeCart = finalRemoveFromCart($rowId);
        if ($removeCart) {
            $this->toastError('Product Remove Successfully From Your Cart!');
        }
        // $this->offerCheckEligibility();
        // $this->pincodeCheckFunction();
    }
    public function render()
    {
        return view('livewire.user.cart-component')->layout('layouts.user.app');
    }
}
