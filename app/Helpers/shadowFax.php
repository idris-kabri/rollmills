<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\OrderAWB;

function getRate($pincode)
{
    $token = config('app.rate_token');
    $response = Http::withHeaders([
        'Accept' => 'application/json, text/plain, */*',
    ])
        ->withToken($token, 'Token')
        ->post('https://glaurung.shadowfax.in/wallet/rate-card/estimate/bulk/', [
            'requests' => [
                [
                    'pickup_pincode' => '314025',
                    'delivery_pincodes' => ["$pincode"],
                ],
            ],
            'order_type' => 'fwd',
        ]);

    if ($response->successful()) {
        $data = $response->json();
        if ($data['message'] == 'Success') {
            return [
                'status' => 200,
                'rate' => $data['data']['estimates']['314025']["$pincode"]['total_charge'],
            ];
        } else {
            return [
                'status' => 300,
                'message' => $data['message'],
            ];
        }
    } else {
        return [
            'status' => 300,
            'message' => $response->json()['message'] ?? 'API Request Failed',
        ];
    }
}

function shadowFaxTracking($awb_number)
{
    // 1. Fetch the Order using the AWB Number
    $orderAwbs = OrderAWB::with('getOrder')->where('awb_number', $awb_number)->get();
    if (!$orderAwbs || count($orderAwbs) == 0) {
        return;
    }
    foreach ($orderAwbs as $orderAwb) {
        $order = $orderAwb->getOrder;
        $token = config('app.shadowfax_token');

        try {
            // 2. Make the API Call
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $token,
            ])->get("https://dale.shadowfax.in/api/v4/clients/orders/$awb_number/track");

            if ($response->successful()) {
                $data = $response->json();
                // Assume the main shipment object is directly in $data or nested in a 'data' key
                $shipment = $data['order_details'] ?? $data;

                // 3. Map the Status
                $statusInput = strtolower($shipment['status'] ?? '');
                $new_status = match ($statusInput) {
                    'delivered' => 3,
                    'rto', 'in_transit_return', 'rts_d' => 8,
                    'rto_d', 'rto', 'rts' => 5,
                    'ofd', 'assigned_for_delivery' => 7,
                    'lost' => 6,
                    'cancelled_by_customer' => 9,
                    default => $order->status,
                };

                $old_status = $order->status;
                $order->status = $new_status;

                // 4. Track History (Adjust 'track_trail' if Shadowfax uses a different key for tracking history array)
                if (!empty($data['tracking_details'])) {
                    $history = collect($data['tracking_details'])
                        ->map(
                            fn($h) => [
                                'status' => $h['status'] ?? '',
                                'date_time' => isset($h['created']) ? Carbon::parse($h['created'])->format('Y-m-d H:i:s') : '',
                                'location' => $h['location'] ?? '',
                                'remark' => $h['remark'] ?? '',
                                'reason' => $h['remark'] ?? '',
                            ],
                        )
                        ->toArray();

                    $order->tracking_updates = json_encode($history);
                }

                if (!empty($shipment['promised_delivery_date'])) {
                    $order->estimated_delivery_date = $shipment['promised_delivery_date'];
                }

                if ($new_status == 7 && $old_status != $new_status) {
                    sendParameterTemplateWawi('order_out_for_delivery', 'en_us', $order->getBillAddress->mobile, [$order->getBillAddress->name, $order->id]);
                } elseif ($new_status == 3 && $old_status != $new_status) {
                    markOrderAsDelivered($order);
                }

                // 7. Save Order and Log Success
                $order->save();
                saveCommandLog($order->id, 'Shadowfax Tracking', $awb_number, $data, 'Success');
            } else {
                // Log Error if API response is not successful
                saveCommandLog($order->id, 'Shadowfax Tracking', ['awb' => $awb_number], $response->json(), 'Error');
            }
        } catch (\Exception $e) {
            // Log System Exceptions
            Log::error("Shadowfax Tracking Exception for $awb_number: " . $e->getMessage());
        }
    }
}

function createShadowfaxOrder($order, $shippingAmount)
{
    try {
        // Prepare Address
        $shippAddress = json_decode($order->ship_different_address_details);
        $name = $shippAddress->name ?? $order->getBillAddress->name;
        $mobile = $shippAddress->mobile ?? $order->getBillAddress->mobile;
        $pincode = $shippAddress->zipcode ?? $order->getBillAddress->zipcode;
        $city = $shippAddress->city ?? $order->getBillAddress->city;
        $state = $shippAddress->state ?? $order->getBillAddress->state;

        $addressParts = [];
        if (!empty($shippAddress->address_line_1)) {
            $addressParts[] = $shippAddress->address_line_1;
        }
        if (!empty($shippAddress->address_line_2)) {
            $addressParts[] = $shippAddress->address_line_2;
        }
        $fullAddress = implode(', ', $addressParts);
        if (empty($fullAddress)) {
            $fullAddress = $order->getBillAddress->address_line_1 . ' ' . $order->getBillAddress->address_line_2;
        }

        // Prepare Products
        $product_details = [];
        foreach ($order->getOrderItems as $item) {
            $price = $item->sale_default_price > 0 ? $item->sale_default_price : $item->regular_price;
            $product_details[] = [
                'name' => $item->getProduct->name,
                'sku_id' => '128',
                'category' => '',
                'price' => (float) $price,
                'quantity' => (int) $item->quantity,
            ];
        }

        // Add COD as a separate item if applicable
        if ($order->is_cod == 1 && $order->cod_charges > 0) {
            $product_details[] = [
                'name' => 'Cash on delivery Charges',
                'sku_id' => '123',
                'category' => '',
                'price' => (float) $order->cod_charges,
                'quantity' => 1,
            ];
        }

        $shipmentData = [
            'fwd_order' => [
                'client_order_id' => (string) $order->id,
                'payment_mode' => $order->is_cod == 1 ? 'cod' : 'prepaid',

                'pickup_details' => [
                    'name' => 'Roll Mills',
                    'contact' => '8764766553',
                    'address' => '02nd Floor, Above Mufaddal Printing, Opposite Gopi Restaurant',
                    'pincode' => 314025,
                    'city' => 'Sagwara',
                    'state' => 'Rajasthan',
                ],

                'delivery_details' => [
                    'name' => $name,
                    'contact' => $mobile,
                    'address' => $fullAddress,
                    'pincode' => (int) $pincode,
                    'city' => $city,
                    'state' => $state,
                    'alternate_contact' => '',
                ],

                'product_details' => $product_details,
            ],
        ];

        $token = config('app.rate_token') ?? 'd7e33028ee7f76bc5acb78f65e8acafc7cd104e8';

        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $token,
            'Accept' => 'application/json',
        ])->post('https://dale.shadowfax.in/api/portal/v1/orders/', $shipmentData);

        if ($response->successful()) {
            $result = $response->json();
            return [
                'status' => true,
                'awb' => $result['data']['fwd_order']['awb_number'] ?? null,
                'message' => 'Shipment created successfully!',
            ];
        } else {
            dd($response->json());
            return [
                'status' => false,
                'message' => $response->json()['message'] ?? 'Failed to create ShadowFax shipment.',
            ];
        }
    } catch (\Exception $e) {
        return [
            'status' => false,
            'message' => 'Exception: ' . $e->getMessage(),
        ];
    }
}
