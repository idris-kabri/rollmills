<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = ['is_logged_in_user', 'logged_in_user_id', 'subtotal', 'coupon_discount', 'coupon_id', 'offer_discount', 'shipping_charges', 'shipping_bearable', 'total', 'status', 'is_manual_pickup', 'paid_amount', 'remaining_amount', 'is_cod', 'additional_information', 'billing_address_id', 'ship_different_address_id', 'gift_card_item_id', 'gift_card_discount', 'billing_address_details', 'ship_different_address_details', 'shipping_rate', 'shipping_bear_margin', 'etd', 'shipped_at', 'complete_at', 'delivery_charges', 'total_delievery_charges', 'commission', 'remittance_at', 'is_conversion_message_sent'];

    public function getUser()
    {
        return $this->BelongsTo(User::class, 'logged_in_user_id', 'id');
    }

    public function getShipAddress()
    {
        return $this->BelongsTo(Address::class, 'ship_different_address_id', 'id');
    }
    public function getBillAddress()
    {
        return $this->BelongsTo(Address::class, 'billing_address_id', 'id');
    }

    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function getCoupon()
    {
        return $this->BelongsTo(Coupon::class, 'coupon_id', 'id');
    }
}
