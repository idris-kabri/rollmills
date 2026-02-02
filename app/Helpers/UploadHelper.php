<?php

use App\Models\Product;
use App\Models\Setting;
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
