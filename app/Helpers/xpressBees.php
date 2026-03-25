<?php
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

function xpressBeesLogin()
{
    $response = Http::post('https://shipment.xpressbees.com/api/users/login', [
        'email' => config('app.xpressbees_email'),
        'password' => config('app.xpressbees_password'),
    ]);

    // Handle the response
    if ($response->successful()) {
        $data = $response->json();
        if ($data['status'] == true) {
            return [
                'status' => true,
                'message' => 'Login successful',
                'data' => $data['data'],
            ];
        } else {
            return [
                'status' => false,
                'message' => $data['message'],
            ];
        }
    } else {
        return [
            'status' => false,
            'message' => 'Login failed',
        ];
    }
}

function serviceabilityCheck($token, $order)
{
    $address = json_decode($order->ship_different_address_details, true);
    $weight = 0;
    foreach ($order->getOrderItems as $key => $value) {
        $weight += $value->getProduct->weight * $value->quantity;
    }
    $response = Http::withToken($token)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post('https://shipment.xpressbees.com/api/courier/serviceability', [
            'origin' => '314025',
            'destination' => $address['zipcode'],
            'payment_type' => $order->is_cod == 1 ? 'cod' : 'prepaid',
            'order_amount' => "$order->total",
            'weight' => "$weight",
            'length' => '10',
            'breadth' => '10',
            'height' => '10',
        ]);

    if ($response->successful()) {
        $result = $response->json();

        if ($result['status'] === true) {
            return [
                'status' => true,
                'message' => 'Serviceability check successful',
                'data' => $result['data'],
            ];
        } else {
            return [
                'status' => false,
                'message' => $result['data'],
            ];
        }
    } else {
        return [
            'status' => false,
            'message' => 'Serviceability check failed',
        ];
    }
}

function createXpressBeesShipment($token, $order, $courier_id)
{
    $url = 'https://shipment.xpressbees.com/api/shipments2';

    $weight = 0;
    $product_array = [];
    $total_item_price = 0; // Track the sum of the item prices

    foreach ($order->getOrderItems as $key => $value) {
        $itemWeight = $value->getProduct->weight > 0 ? $value->getProduct->weight : 500;
        $weight += $itemWeight * $value->quantity;

        // Safely get the price
        $item_price = $value->sale_default_price > 0 ? $value->sale_default_price : $value->regular_price;
        $total_item_price += $item_price * $value->quantity;

        $product_array[] = [
            'name' => $value->getProduct->name,
            'qty' => "$value->quantity",
            'sku' => "sku$value->id",
            'price' => "$item_price",
        ];
    }

    // THE BULLETPROOF MATH FIX:
    // Reverse-engineer the discount so XpressBees' calculation matches your $order->total exactly.
    $xpressbees_discount = $total_item_price - $order->total;

    // Failsafe: If shipping makes the total greater than the items, we can't send a negative discount.
    // We cap discount at 0 and add the difference to the first item's price so XpressBees doesn't reject it.
    if ($xpressbees_discount < 0) {
        $difference = abs($xpressbees_discount);
        if (count($product_array) > 0) {
            $product_array[0]['price'] = (string) ($product_array[0]['price'] + $difference);
        }
        $xpressbees_discount = 0;
    }

    $address = json_decode($order->ship_different_address_details, true);

    $actual_shipping = $order->is_cod == 1 ? $order->shipping_charges - $order->cod_charges : $order->shipping_charges;

    $payload = [
        'order_number' => "$order->id",
        'unique_order_number' => 'yes',
        'shipping_charges' => $actual_shipping > 0 ? $actual_shipping : 0,
        'discount' => floor($xpressbees_discount),
        'cod_charges' => $order->is_cod == 1 ? $order->cod_charges : 0,
        'payment_type' => $order->is_cod == 1 ? 'cod' : 'prepaid',
        'order_amount' => "$order->total",
        'package_weight' => $weight,
        'package_length' => 10,
        'package_breadth' => 10,
        'package_height' => 10,
        'request_auto_pickup' => 'yes',
        'consignee' => [
            'name' => $address['name'],
            'address' => $address['address_line_1'],
            'address_2' => $address['address_line_2'] ?? '',
            'city' => $address['city'],
            'state' => $address['state'],
            'pincode' => $address['zipcode'],
            'phone' => $address['mobile'],
        ],
        'pickup' => [
            'warehouse_name' => 'Roll mills',
            'name' => 'Roll mills',
            'address' => 'OPP. GOPI RESTAURANT ABOVE MUFADDAL PRINTING',
            'address_2' => '',
            'city' => 'SAGWARA',
            'state' => 'Rajasthan',
            'pincode' => '314025',
            'phone' => '8764766553',
        ],
        'order_items' => $product_array,
        'courier_id' => "$courier_id",
        'collectable_amount' => $order->is_cod == 1 ? "$order->total" : '0',
    ];

    try {
        $response = Http::withToken($token)->acceptJson()->post($url, $payload);
        $responseData = $response->json();

        Log::info('XpressBees Payload: ' . json_encode($payload));
        Log::info('XpressBees Response: ' . json_encode($responseData));

        if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
            $shipmentData = $responseData['data'] ?? $responseData;

            return [
                'status' => true,
                'message' => 'Shipment created successfully!',
                'awb' => $shipmentData['awb_number'] ?? '',
                'courier_name' => $shipmentData['courier_name'] ?? '',
            ];
        } else {
            $errorMessage = $responseData['message'] ?? 'An unknown error occurred.';
            Log::error('XpressBees Failed: ' . $errorMessage);

            return [
                'status' => false,
                'message' => $errorMessage,
            ];
        }
    } catch (\Exception $e) {
        Log::error('XpressBees Exception: ' . $e->getMessage());
        return [
            'status' => false,
            'message' => 'Request failed: ' . $e->getMessage(),
        ];
    }
}
