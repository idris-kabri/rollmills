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
