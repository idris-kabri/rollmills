<?php
use Illuminate\Support\Facades\Http;

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

    foreach ($order->getOrderItems as $key => $value) {
        $weight += $value->getProduct->weight * $value->quantity;
        $product_array[] = [
            'name' => $value->getProduct->name,
            'qty' => "$value->quantity",
            'sku' => "sku$value->id",
            'price' => "$value->sale_default_price",
        ];
    }

    $address = json_decode($order->ship_different_address_details, true);

    $payload = [
        'order_number' => "$order->id",
        'unique_order_number' => 'yes',
        'shipping_charges' => 0,
        'discount' => $order->total_bonus + $order->special_discount + $order->coupon_discount,
        'cod_charges' => $order->is_cod == 1 ? $order->cod_charges : 0,
        'payment_type' => $order->is_cod == 1 ? 'cod' : 'prepaid', // cod, prepaid, or reverse
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

        if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
            $shipmentData = $responseData['data'];

            $awbNumber = $shipmentData['awb_number'];
            $courier_name = $shipmentData['courier_name'];

            return [
                'success' => true,
                'message' => 'Shipment created successfully!',
                'awb' => $awbNumber,
                'courier_name' => $courier_name,
            ];
        } else {
            $errorMessage = $responseData['message'] ?? 'An unknown error occurred while booking the shipment.';

            return [
                'success' => false,
                'message' => $errorMessage,
            ];
        }
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => 'Request failed: ' . $e->getMessage(),
        ];
    }
}
