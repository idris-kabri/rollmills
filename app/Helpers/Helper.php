<?php

use App\Mail\GiftCardPurchaseMail;
use App\Models\GiftCardGroup;
use App\Models\GiftCardItem;
use App\Models\Order;
use App\Models\ProductCategoryAssign;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use App\Traits\HasToastNotification;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

function razorPayPayment($amount, $user_id, $refrence_id, $refrence_table, $description)
{
    $secret_key = config('app.razorpay_secret_key');
    $key_id = config('app.razorpay_key_id');

    $api = new Api($key_id, $secret_key);

    $store = new Transaction();
    $store->user_id = $user_id;
    $store->refrence_id = $refrence_id;
    $store->refrence_table = $refrence_table;
    $store->amount = $amount;
    $store->description = $description;

    $orderData = [
        'receipt' => $store->id,
        'amount' => round($amount * 100),
        'currency' => 'INR',
        'payment_capture' => 1,
    ];

    $order = $api->order->create($orderData);

    $store->payment_id = $order->id;
    $store->save();

    return (object) [
        'id' => $order->id,
        'amount' => $order->amount,
        'transaction_id' => $store->id,
        'description' => $store->description,
    ];
}

function returnUrl($transactionId, $razorpayPaymentId, $gift_tile = null, $name = null, $email = null)
{
    try {
        $transaction = Transaction::findOrFail($transactionId);

        if ($transaction) {
            $transaction->payment_id = $razorpayPaymentId;
            $transaction->status = 1;
            $transaction->save();

            if ($transaction->description == 'Top Up Wallet Balance') {
                $user = User::find($transaction->user_id);
                $user->wallet_balance = (float) $user->wallet_balance;
                $user->wallet_balance += (float) $transaction->amount;
                $user->save();
                return true;
            } elseif ($transaction->refrence_table == 'gift_card_groups') {
                $giftCardGroup = GiftCardGroup::findOrFail($transaction->refrence_id);
                $gift_Item = new GiftCardItem();
                $gift_Item->gift_card_group_id = $giftCardGroup->id;
                $gift_Item->title = $gift_tile;
                $gift_Item->customer_name = $name;
                $gift_Item->customer_email = $email;
                $gift_Item->gift_code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);
                $gift_Item->created_by = Auth::user()->id;
                $gift_Item->save();

                $another_found = Transaction::where('refrence_id', $giftCardGroup->id)->where('refrence_table', 'gift_card_groups')->where('id', '!=', $transaction->id)->first();
                if ($another_found) {
                    if (str_contains($another_found->payment_id, 'WALLET-GIFT')) {
                        updateWalletBalance($another_found->user_id, 'deduct', $another_found->amount);
                    }
                    $another_found->status = 1;
                    $another_found->refrence_id = $gift_Item->id;
                    $another_found->refrence_table = 'gift_card_items';
                    $another_found->save();
                }

                $transaction->refrence_id = $gift_Item->id;
                $transaction->refrence_table = 'gift_card_items';
                $transaction->save();

                $code = $gift_Item->gift_code;
                $created_by = "You've received a special gift card From " . Auth::user()->name;
                $receiver_by = "You've Send a special gift card To " . $name;

                Mail::to($email)->send(new GiftCardPurchaseMail($gift_tile, $name, $code, $gift_Item, $created_by, null));
                Mail::to(Auth::user()->email)->send(new GiftCardPurchaseMail($gift_tile, Auth::user()->name, $code, $gift_Item, null, $receiver_by));
            } elseif ($transaction->refrence_table == 'orders') {
                $another_found = Transaction::where('refrence_id', $transaction->refrence_id)->where('refrence_table', 'orders')->where('id', '!=', $transaction->id)->first();
                if ($another_found) {
                    if (str_contains($another_found->payment_id, 'WALLET-ORDER')) {
                        updateWalletBalance($another_found->user_id, 'deduct', $another_found->amount);
                    }
                }
                $user_order = Order::find($transaction->refrence_id);
                $user_order->status = 1;
                $user_order->save();

                if ($user_order->gift_card_item_id != null) {
                    $gift_Item = GiftCardItem::where('id', $user_order->gift_card_item_id)->first();
                    $gift_Item->user_id = $transaction->user_id;
                    $gift_Item->used_at = now();
                    $gift_Item->save();
                }

                if ($user_order->gift_card_discount != null && $user_order->gift_card_discount > 0) {
                    $store = new Transaction();
                    $store->user_id = $transaction->user_id;
                    $store->refrence_id = $gift_Item->id;
                    $store->payment_id = $transaction->payment_id;
                    $store->refrence_table = 'gift_card_items';
                    $store->amount = $user_order->gift_card_discount;
                    $store->description = 'Gift Card Item In Place Order';
                    $store->status = 1;
                    $store->save();
                }
                placeShipment($transaction->refrence_id);

                // Cart::instance('cart')->clear();
                Cart::instance('cart')->destroy();
                if (Auth::check()) {
                    Cart::instance('cart')->store(Auth::user()->mobile);
                }
            }
        }
    } catch (\Exception $e) {
        dd($e);
    }
}

function finalAddToCart($product, $quantity, $type = null, $customPrice = null)
{
    $cart = Cart::instance('cart')->search(function ($cartItem, $rowId) use ($product) {
        return $cartItem->id === $product->id;
    });
    if ($cart->isNotEmpty()) {
        if ($type == 'update-quantity') {
            if ($customPrice != null) {
                Cart::instance('cart')->update($cart->first()->rowId, $quantity, $customPrice);
                if (Auth::check()) {
                    Cart::instance('cart')->store(Auth::user()->mobile);
                }
            } else {
                Cart::instance('cart')->update($cart->first()->rowId, $quantity);
                if (Auth::check()) {
                    Cart::instance('cart')->store(Auth::user()->mobile);
                }
            }
            return true;
        } else {
            return false;
        }
    } else {
        $priceInfo = $customPrice ? ['price' => $customPrice] : getPrice($product->id);
        Cart::instance('cart')->add($product->id, $product->name, $quantity, $priceInfo['price'])->associate('App\Models\Product');
        return true;
    }
}
function finalRemoveFromCart($rowId)
{
    Cart::instance('cart')->remove($rowId);
    if (Auth::check()) {
        Cart::instance('cart')->store(Auth::user()->mobile);
    }
    return true;
}

function finalAddToWhishlist($product)
{
    $cart = Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($product) {
        return $cartItem->id === $product->id;
    });
    if ($cart->isNotEmpty()) {
        return false;
    } else {
        $priceInfo = getPrice($product->id);
        Cart::instance('wishlist')->add($product->id, $product->name, 1, $priceInfo['price'])->associate('App\Models\Product');
        return true;
    }
}
function finalRemoveWishlist($rowId)
{
    Cart::instance('wishlist')->remove($rowId);
    if (Auth::check()) {
        Cart::instance('wishlist')->store(Auth::user()->mobile);
    }
    return true;
}

function walletPayment($user, $refrence_id, $refrence_table, $amount, $payment_id, $description, $status = null)
{
    $transaction = new Transaction();
    $transaction->user_id = $user;
    $transaction->refrence_id = $refrence_id;
    $transaction->refrence_table = $refrence_table;
    $transaction->amount = $amount;
    $transaction->payment_id = $payment_id;
    $transaction->description = $description;
    if ($status) {
        $transaction->status = $status;
    }
    $transaction->save();
}

function updateWalletBalance($user_id, $type, $amount)
{
    $user = User::find($user_id);
    $wallet_balance = (float) $user->wallet_balance;
    if ($type == 'add') {
        $user->wallet_balance = $wallet_balance + (float) $amount;
    } else {
        $user->wallet_balance = $wallet_balance - (float) $amount;
    }
    $user->save();
}

function generateShipRocketToken()
{
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post('https://apiv2.shiprocket.in/v1/external/auth/login', [
        'email' => 'alihussain@web-amplifier.com',
        'password' => '3ELyePD@6o0qYam&',
    ]);

    if ($response->successful()) {
        return $response->json()['token'];
    }
}

function getChannelId($token)
{
    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://apiv2.shiprocket.in/v1/external/channels');

        if ($response->successful()) {
            return $response->json()['data'][0]['id'];
        } else {
            Log::error('ChannelId Generation Error on ' . now() . ' : ' . $response->json()['message']);
            return false;
        }
    } catch (\Exception $e) {
        Log::error('ChannelId Generation Error on ' . now() . ' : ' . $e->getMessage());
        return false;
    }
}

function placeShipment($order_id)
{
    try {
        $order = Order::find($order_id);
        $order_items = $order->getOrderItems()->get();
        $billing_address = json_decode($order->billing_address_details, true);
        $shipping_address = json_decode($order->ship_different_address_details, true);
        $weight = 0;
        $height = 0;
        $breadth = 0;
        $length = 0;

        $items_array = [];
        $shipping_charges = [];
        $courier_name = [];
        foreach ($order_items as $order_item) {
            $weight += (max((float) $order_item->getProduct->weight, 0.1) / 1000) * (int) $order_item->quantity;
            $height += max((float) $order_item->getProduct->height, 1) * (int) $order_item->quantity;
            $breadth += max((float) $order_item->getProduct->breadth, 1) * (int) $order_item->quantity;
            $length += max((float) $order_item->getProduct->length, 1) * (int) $order_item->quantity;
            $items_array[$order_item->courier_id][] = [
                'product_name' => $order_item->getProduct->name,
                'product_sku' => $order_item->getProduct->SKU,
                'product_quantity' => $order_item->quantity,
                'product_price' => $order_item->total,
                'product_img_url' => url('storage/' . $order_item->getProduct->featured_image),
            ];
            $shipping_charges[$order_item->courier_id] += (float) $shipping_charges[$order_item->courier_id] + (float) $order_item->overall_rate;
            $courier_name[$order_item->courier_id] = $order_item->courier;
        }

        $exploded_billing_name = explode(' ', $billing_address['name']);
        $billing_last_name = $exploded_billing_name[count($exploded_billing_name) - 1] ?? '';

        $exploded_shipping_name = explode(' ', $shipping_address['name']);
        $shipping_last_name = $exploded_shipping_name[count($exploded_shipping_name) - 1] ?? '';

        $shipments = [];
        foreach ($items_array as $key => $item) {
            $total_amount = 0;
            foreach ($item as $order_item) {
                $total_amount += $order_item['product_price'];
            }
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://my.ithinklogistics.com/api_v3/order/add.json', [
                'data' => [
                    'shipments' => [
                        [
                            'order' => $order_id . '-' . $key,
                            'order_date' => Carbon::parse($order->created_at)->format('Y-m-d'),
                            'total_amount' => (string) $total_amount,
                            'name' => $billing_address['name'],
                            'add' => $billing_address['address_line_1'],
                            'add2' => $billing_address['address_line_2'],
                            'pin' => $billing_address['zipcode'],
                            'city' => $billing_address['city'],
                            'state' => $billing_address['state'],
                            'country' => 'India',
                            'phone' => $billing_address['mobile'],
                            'email' => $billing_address['email'],
                            'is_billing_same_as_shipping' => 'No',
                            'billing_name' => $billing_address['name'],
                            'billing_add' => $billing_address['address_line_1'],
                            'billing_add2' => $billing_address['address_line_2'],
                            'billing_pin' => $billing_address['zipcode'],
                            'billing_city' => $billing_address['city'],
                            'billing_state' => $billing_address['state'],
                            'billing_country' => 'India',
                            'billing_phone' => $billing_address['mobile'],
                            'billing_email' => $billing_address['email'],
                            'shipping_name' => $shipping_address['name'],
                            'shipping_add' => $shipping_address['address_line_1'],
                            'shipping_add2' => $shipping_address['address_line_2'],
                            'shipping_pin' => $shipping_address['zipcode'],
                            'shipping_city' => $shipping_address['city'],
                            'shipping_state' => $shipping_address['state'],
                            'shipping_country' => 'India',
                            'shipping_phone' => $shipping_address['mobile'],
                            'shipping_email' => $shipping_address['email'],
                            'shipping_add' => $shipping_address['address_line_1'],
                            'shipping_add2' => $shipping_address['address_line_2'],
                            'shipping_pin' => $shipping_address['zipcode'],
                            'shipping_city' => $shipping_address['city'],
                            'shipping_state' => $shipping_address['state'],
                            'shipping_country' => 'India',
                            'shipping_email' => $shipping_address['email'],
                            'shipping_phone' => $shipping_address['mobile'],
                            'products' => $item, // Ensure $item is an array of arrays (List), not just a single object
                            'shipment_length' => ceil($length),
                            'shipment_width' => ceil($breadth),
                            'shipment_height' => ceil($height),
                            'weight' => round($weight, 2),
                            'shipping_charges' => $shipping_charges[$key],
                            'payment_mode' => 'Prepaid',
                            'return_address_id' => 93192,
                            'store_id' => 25642,
                            'transaction_charges' => '0',
                            'total_discount' => (float) $order->coupon_discount + (float) $order->offer_discount,
                        ],
                    ],
                    'pickup_address_id' => '931912',
                    'access_token' => config('app.access_token'),
                    'secret_key' => config('app.secret_key'),
                    'logistics' => $courier_name[$key],
                ],
            ]);
            if ($response->successful()) {
                $response->json()['data']['id'];
            } else {
                Log::error('Shipment Creation Error on ' . now() . ' : ' . $response->json()['message']);
                return false;
            }
        }
        return true;
    } catch (\Exception $e) {
        Log::error('Shipment Creation Error on ' . now() . ' : ' . $e->getMessage());
        return false;
    }
}

function getEstimation($products, $pincode, $payment_method)
{
    $weight = 0;
    $price = 0;
    foreach ($products as $cart_item) {
        $weight += $cart_item->model->weight > 0 ? (float) $cart_item->model->weight * $cart_item->qty : 1;
        $price += $cart_item->price * $cart_item->qty;
    }
    $innerPayload = [
        'from_pincode' => '314025',
        'to_pincode' => $pincode,
        'shipping_weight_kg' => $weight / 1000,
        'order_type' => 'forward',
        'payment_method' => $payment_method,
        'product_mrp' => $price,
        'access_token' => config('app.ithink_access_token'),
        'secret_key' => config('app.secret_key'),
    ];

    $wrappedPayload = [
        'data' => $innerPayload,
    ];

    $response = Http::post('https://my.ithinklogistics.com/api_v3/rate/check.json', $wrappedPayload);
    if ($response->successful()) {
        $shippingData = $response->json();
        if ($shippingData['status'] !== 'success') {
            return "We don't deliver to this pincode";
        }
        $couriers = $shippingData['data'] ?? [];
        $lowest = collect($couriers)->where('rate', '>', 0)->sortBy('rate')->first();
        $rate = $lowest['rate'] ?? 0;
        return $rate;
    } else {
        return "We don't deliver to this pincode";
    }
}

function calculateRates($products, $pincode, $payment_method)
{
    $latestEtd = null;
    $shippingCharge = 0;
    // $shipping_bear_margin = 0;
    $checkout_condition_fail = false;
    foreach ($products as $cart_item) {
        $weightInKg = $cart_item->model->weight > 0 ? (float) $cart_item->model->weight / 1000 : 1;

        $innerPayload = [
            'from_pincode' => '314025',
            'to_pincode' => $pincode,
            'shipping_weight_kg' => $weightInKg,
            'order_type' => 'forward',
            'payment_method' => $payment_method,
            'product_mrp' => $cart_item->model->price * $cart_item->qty,
            'access_token' => config('app.ithink_access_token'),
            'secret_key' => config('app.secret_key'),
        ];

        $wrappedPayload = [
            'data' => $innerPayload,
        ];
        $response = Http::post('https://my.ithinklogistics.com/api_v3/rate/check.json', $wrappedPayload);
        if ($response->successful()) {
            $shippingData = $response->json();
            if ($shippingData['status'] !== 'success') {
                $checkout_condition_fail = true;
                break;
            }
            $couriers = $shippingData['data'] ?? [];
            $lowest = collect($couriers)->where('rate', '>', 0)->sortBy('rate')->first();
            if ($lowest) {
                $options = $cart_item->options->all();
                $options['courier_id'] = $lowest['logistic_id'];
                $options['courier'] = $lowest['logistic_name'];
                $options['overall_rate'] = $lowest['rate'];
                $options['rate'] = $lowest['rate'] - ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;
                $options['shipping_margin_bear'] = ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;
                $options['etd'] = $lowest['delivery_tat'];
                Cart::instance('cart')->update($cart_item->rowId, [
                    'options' => $options,
                ]);

                $shippingCharge += $lowest['rate'] - ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;
                // $shipping_bear_margin += ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;

                foreach ($couriers as $courier) {
                    if (!empty($courier['delivery_tat'])) {
                        $now = Carbon::now();
                        $etdDate = $now->copy()->addDays((int) $courier['delivery_tat']);
                        if (!$latestEtd || $etdDate->gt($latestEtd)) {
                            $latestEtd = Carbon::parse($etdDate)->format('d F Y');
                        }
                    }
                }
            }
        } else {
            logger()->error("Shiprocket API error for item {$cart_item->id}", [
                'response' => $response->body(),
            ]);
            dd('error', $response->body());
            return false;
        }
    }
    // session()->put('shipping_charge', $shippingCharge);
    // session()->put('latest_etd', $latestEtd);
    // session()->put('shipping_bear_margin', $shipping_bear_margin);

    return $shippingCharge;
}

function isInCart($id)
{
    return Cart::instance('cart')->content()->where('id', $id)->count() > 0;
}

function isInWishlist($id)
{
    return Cart::instance('wishlist')->content()->where('id', $id)->count() > 0;
}
