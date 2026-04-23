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
    $orderAwb = OrderAWB::with('getOrder')->where('awb_number', $awb_number)->first();
    if (!$orderAwb || !$orderAwb->getOrder) {
        return;
    }

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
            $shipment = $data['order_detail'] ?? $data;

            // 3. Map the Status
            $statusInput = strtolower($shipment['status'] ?? '');
            $new_status = match ($statusInput) {
                'delivered' => 3,
                'rto', 'in_transit_return' => 8,
                'rto_d' => 5,
                'ofd', 'assigned_for_delivery' => 7,
                'lost' => 6,
                'cancelled_by_customer' => 9,
                default => 2,
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
            saveCommandLog($order->id, 'Shadowfax Tracking', ['awb' => $awb_number], $data, 'Success');
        } else {
            // Log Error if API response is not successful
            saveCommandLog($order->id, 'Shadowfax Tracking', ['awb' => $awb_number], $response->json(), 'Error');
        }
    } catch (\Exception $e) {
        // Log System Exceptions
        Log::error("Shadowfax Tracking Exception for $awb_number: " . $e->getMessage());
    }
}
