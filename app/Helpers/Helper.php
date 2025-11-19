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

                $token = generateShipRocketToken();
                placeShipment($transaction->refrence_id, $token);

                // Cart::instance('cart')->clear();
                Cart::instance('cart')->destroy();
                if (Auth::check()) {
                    Cart::instance('cart')->store(Auth::user()->email);
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
                    Cart::instance('cart')->store(Auth::user()->email);
                }
            } else {
                Cart::instance('cart')->update($cart->first()->rowId, $quantity);
                if (Auth::check()) {
                    Cart::instance('cart')->store(Auth::user()->email);
                }
            }
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
        Cart::instance('cart')->store(Auth::user()->email);
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
        Cart::instance('wishlist')->store(Auth::user()->email);
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

function placeShipment($order_id, $token)
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
        foreach ($order_items as $order_item) {
            $weight += (max((float) $order_item->getProduct->weight, 0.1) / 1000) * (int) $order_item->quantity;
            $height += max((float) $order_item->getProduct->height, 1) * (int) $order_item->quantity;
            $breadth += max((float) $order_item->getProduct->breadth, 1) * (int) $order_item->quantity;
            $length += max((float) $order_item->getProduct->length, 1) * (int) $order_item->quantity;
            $items_array[$order_item->courier_id][] = [
                'name' => $order_item->getProduct->name,
                'sku' => $order_item->getProduct->SKU,
                'units' => $order_item->quantity,
                'selling_price' => $order_item->total,
                'shipping_cost' => $order_item->overall_rate,
            ];
        }

        $exploded_billing_name = explode(' ', $billing_address['name']);
        $billing_last_name = $exploded_billing_name[count($exploded_billing_name) - 1] ?? '';

        $exploded_shipping_name = explode(' ', $shipping_address['name']);
        $shipping_last_name = $exploded_shipping_name[count($exploded_shipping_name) - 1] ?? '';

        foreach ($items_array as $key => $item) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', [
                'order_id' => $order_id . '-' . $key,
                'order_date' => Carbon::parse($order->created_at)->format('Y-m-d'),
                'pickup_location' => 'Home',
                'comment' => 'Near ICICI Bank Sagwara',
                'reseller_name' => 'Roll Mills Store',
                'company_name' => 'Roll Mills Store',
                'billing_customer_name' => $billing_address['name'],
                'billing_last_name' => $billing_last_name,
                'billing_address' => $billing_address['address_line_1'],
                'billing_address_2' => $billing_address['address_line_2'],
                'billing_city' => $billing_address['city'],
                'billing_pincode' => $billing_address['zipcode'],
                'billing_state' => $billing_address['state'],
                'billing_country' => 'India',
                'billing_email' => $billing_address['email'],
                'billing_phone' => $billing_address['mobile'],
                'shipping_is_billing' => false,
                'shipping_customer_name' => $shipping_address['name'],
                'shipping_last_name' => $shipping_last_name,
                'shipping_address' => $shipping_address['address_line_1'],
                'shipping_address_2' => $shipping_address['address_line_2'],
                'shipping_city' => $shipping_address['city'],
                'shipping_pincode' => $shipping_address['zipcode'],
                'shipping_country' => 'India',
                'shipping_state' => $shipping_address['state'],
                'shipping_email' => $shipping_address['email'],
                'shipping_phone' => $shipping_address['mobile'],
                'order_items' => $item,
                'payment_method' => 'Prepaid',
                'shipping_charges' => (float) $order->shipping_rate + (float) $order->shipping_bear_margin,
                'giftwrap_charges' => '0',
                'courier_company_id' => $key,
                'transaction_charges' => '0',
                'total_discount' => (float) $order->coupon_discount + (float) $order->offer_discount,
                'sub_total' => $order->subtotal,
                'length' => ceil($length),
                'breadth' => ceil($breadth),
                'height' => ceil($height),
                'weight' => round($weight, 2),
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

function calculateRates($products, $token, $pincode)
{
    $latestEtd = null;
    $shippingCharge = 0;
    $shipping_bear_margin = 0;
    $checkout_condition_fail = false;
    foreach ($products as $cart_item) {
        $weightInKg = (float) $cart_item->model->weight / 1000;
        $response = Http::withToken($token)->get('https://apiv2.shiprocket.in/v1/external/courier/serviceability', [
            'pickup_postcode' => '314025',
            'delivery_postcode' => $pincode,
            'cod' => 0,
            'weight' => $weightInKg * $cart_item->qty,
        ]);
        // dd($response->json());
        if ($response->successful()) {
            $shippingData = $response->json();
            if ($shippingData['status'] == 404) {
                $checkout_condition_fail = true;
                break;
            }
            $couriers = $shippingData['data']['available_courier_companies'] ?? [];
            $lowest = collect($couriers)->where('rate', '>', 0)->sortBy('rate')->first();
            if ($lowest) {
                $options = $cart_item->options->all();
                $options['courier_id'] = $lowest['courier_company_id'];
                $options['courier'] = $lowest['courier_name'];
                $options['overall_rate'] = $lowest['rate'];
                $options['rate'] = $lowest['rate'] - ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;
                $options['shipping_margin_bear'] = ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;
                $options['etd'] = $lowest['etd'];
                Cart::instance('cart')->update($cart_item->rowId, [
                    'options' => $options,
                ]);

                $shippingCharge += $lowest['rate'] - ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;
                $shipping_bear_margin += ((float) $cart_item->model->shipping_margin_br ?? 0) * $cart_item->qty;

                foreach ($couriers as $courier) {
                    if (!empty($courier['etd'])) {
                        $etdDate = Carbon::parse($courier['etd']);
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
            return false;
        }
    }
    session()->put('shipping_charge', $shippingCharge);
    session()->put('latest_etd', $latestEtd);
    session()->put('shipping_bear_margin', $shipping_bear_margin);

    return $checkout_condition_fail;
}

function isInCart($id)
{
    return Cart::instance('cart')->content()->where('id', $id)->count() > 0;
}

function isInWishlist($id)
{
    return Cart::instance('wishlist')->content()->where('id', $id)->count() > 0;
}
