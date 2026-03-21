<?php

use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

function getPrice($id)
{
    $product = Product::findOrFail($id);
    $currentDate = Carbon::now();
    if ($product->sale_from_date != null && $product->sale_to_date != null) {
        $isOnSale = $currentDate->between($product->sale_from_date, $product->sale_to_date);
    } else {
        $isOnSale = false;
    }

    if ($product->sale_price != 0 && $isOnSale) {
        return [
            'price' => $product->sale_price,
            'original_price' => $product->price,
            'discount' => $product->price > $product->sale_price ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0,
        ];
    } elseif ($product->sale_default_price != 0) {
        return [
            'price' => $product->sale_default_price,
            'original_price' => $product->price,
            'discount' => $product->price > $product->sale_price ? round((($product->price - $product->sale_default_price) / $product->price) * 100) : 0,
        ];
    } else {
        return [
            'price' => $product->price,
            'original_price' => null,
            'discount' => null,
        ];
    }
}

function checkReview()
{
    $review = false;
    $setting = Setting::where('label', 'Enable Review')->first();

    if ($setting) {
        $review = filter_var($setting->value, FILTER_VALIDATE_BOOLEAN);
    }

    return $review;
}

function getPaymentId($orderId)
{
    $response = Http::withBasicAuth(config('app.razorpay_key_id'), config('app.razorpay_secret_key'))->get("https://api.razorpay.com/v1/orders/{$orderId}/payments");

    if ($response->failed()) {
        return response()->json(
            [
                'success' => false,
                'message' => 'Failed to fetch payments from Razorpay',
            ],
            400,
        );
    }

    $payments = $response->json()['items'] ?? [];

    // Get first captured payment
    $paymentId = null;
    foreach ($payments as $payment) {
        if ($payment['status'] === 'captured') {
            $paymentId = $payment['id'];
            break;
        }
    }

    return $paymentId;
}

function claimCoupon($id)
{
    $order = Order::find($id);

    // Fix: Ensure we return the existing coupon code if it was already generated
    if ($order->is_coupon_avail == 1) {
        $existingCoupon = Coupon::where('order_id', $order->id)->first();
        return $existingCoupon ? $existingCoupon->coupon_code : '';
    }

    $settings = Setting::all();
    $shipping_days = $settings->where('label', 'shipping_days')->first()?->value ?? 7;

    $max_return_replacement_days = 0;
    foreach ($order->getOrderItems as $item) {
        $return_days = $item->item_return_days;
        $replacement_days = $item->item_replacement_days;

        if ($return_days > 0 || $replacement_days > 0) {
            $days = max($return_days, $replacement_days);
            if ($days > $max_return_replacement_days) {
                $max_return_replacement_days = $days;
            }
        }
    }

    $max_return_replacement_days += $shipping_days;

    $order->is_coupon_avail = 1;
    $order->save();

    $user = User::find($order->logged_in_user_id);

    // Safely get first name
    $nameParts = preg_split('/\s+/', trim($user->name ?? 'User'));
    $firstName = $nameParts[0];

    $couponCode = $firstName . rand(10, 200);

    // Fallback if shipped_at is missing
    $shippedDate = $order->shipped_at ? Carbon::parse($order->shipped_at) : now();
    $start_date = $shippedDate->addDays($max_return_replacement_days)->format('Y-m-d');

    $expiryDays = (int) ($settings->where('label', 'coupon_expiry')->first()?->value ?? 30);

    $coupon = new Coupon();
    $coupon->title = 'Coupon for Order #' . $order->id;
    $coupon->coupon_code = $couponCode;

    // Fix: Used null-safe operator (?->) to prevent crashes if a setting doesn't exist
    $coupon->minimum_order_value = $settings->where('label', 'coupon_min_order_value')->first()?->value ?? 0;
    $coupon->discount_type = $settings->where('label', 'coupon_discount_type')->first()?->value ?? 0;
    $coupon->discount_value = $settings->where('label', 'discount_value')->first()?->value ?? 0;
    $coupon->maximum_discount_amount = $settings->where('label', 'coupon_max_discount')->first()?->value ?? 0;

    $coupon->usage_limit = 1;
    $coupon->total_usage = 1;
    $coupon->category = '';
    $coupon->start_date = $start_date;
    $coupon->expiry_date = Carbon::now()->addDays($expiryDays)->format('Y-m-d');
    $coupon->order_id = $order->id;
    $coupon->save();

    return $couponCode;
}
