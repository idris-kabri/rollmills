<?php

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderAWB;
use App\Models\OrderCommandLogs;
use Illuminate\Support\Facades\Log;

/**
 * Sync Detailed Order Information from iThink Logistics
 */
function synIthinkOrderDetail($awb_number, $order)
{
    $requestData = [
        'awb_number_list' => $awb_number,
        'order_no' => '',
        'start_date' => Carbon::parse($order->created_at)->format('Y-m-d'),
        'end_date' => Carbon::parse($order->created_at)->addDays(60)->format('Y-m-d'),
        'access_token' => config('app.ithink_access_token'),
        'secret_key' => config('app.secret_key'),
    ];

    try {
        $response = Http::timeout(20)
            ->retry(2, 100)
            ->post('https://my.ithinklogistics.com/api_v3/order/get_details.json', [
                'data' => $requestData,
            ]);

        if ($response->successful()) {
            $result = $response->json();

            if (isset($result['status']) && $result['status'] === 'success' && isset($result['data'][$awb_number])) {
                $apiData = $result['data'][$awb_number];

                // Update Order and AWB
                $unbilledCharges = (float) ($apiData['unbilled_total_charges'] ?? 0);

                OrderAWB::where('order_id', $order->id)
                    ->where('awb_number', $awb_number)
                    ->update(['charges_taken' => $unbilledCharges]);

                $order->update(['total_delievery_charges' => $unbilledCharges]);

                saveCommandLog($order->id, 'Sync Ithink Order Detail', $requestData, $apiData, 'Success');
            } else {
                saveCommandLog($order->id, 'Sync Ithink Order Detail', $requestData, $result, 'Error');
            }
        }
    } catch (\Exception $e) {
        Log::error('iThink Detail Sync Exception: ' . $e->getMessage());
    }

    return true;
}

/**
 * Sync Tracking Status from iThink Logistics
 */
function synIthinkTracking($awb_number, $order)
{
    $requestData = [
        'awb_number_list' => $awb_number,
        'access_token' => config('app.ithink_access_token'),
        'secret_key' => config('app.secret_key'),
    ];

    try {
        $response = Http::timeout(20)
            ->retry(2, 100)
            ->post('https://api.ithinklogistics.com/api_v3/order/track.json', [
                'data' => $requestData,
            ]);

        if ($response->successful()) {
            $result = $response->json();

            if (isset($result['status']) && $result['status'] === 'success' && isset($result['data'][$awb_number])) {
                $apiData = $result['data'][$awb_number];

                $order->status = match ($apiData['current_status'] ?? '') {
                    'In Transit', 'Manifested', 'Picked Up', 'Reached At Destination' => 2,
                    'Delivered' => 3,
                    'Cancelled', 'REV Cancelled', 'REV Closed' => 4,
                    'RTO Delivered', 'REV Delivered' => 5,
                    'Damaged', 'Lost', 'Shortage', 'RTO Shortage' => 6,
                    'Out For Delivery' => 7,
                    'RTO Pending', 'RTO Processing', 'RTO In Transit', 'Reached At Origin', 'RTO Out For Delivery', 'RTO Undelivered', 'REV Manifest', 'REV Out for Pick Up', 'REV Picked Up', 'REV In Transit', 'REV Out For Delivery' => 8,
                    'Not Picked', 'Undelivered', 'Out of Delivery Area', 'Delayed', 'Misrouted' => 9,
                    default => 2,
                };

                // Process Scan Details
                if (isset($apiData['scan_details']) && is_array($apiData['scan_details'])) {
                    $trackingUpdates = collect($apiData['scan_details'])
                        ->filter(fn($scan) => !empty($scan['status']))
                        ->map(
                            fn($scan) => [
                                'status' => $scan['status'],
                                'date_time' => Carbon::parse($scan['status_date_time'])->format('Y-m-d H:i:s'),
                                'location' => $scan['status_location'] ?? '',
                                'remark' => $scan['status_remark'] ?? '',
                                'reason' => $scan['status_reason'] ?? '',
                            ],
                        )
                        ->toArray();

                    $order->tracking_updates = json_encode($trackingUpdates);
                }

                $order->save();
                saveCommandLog($order->id, 'Sync Ithink Tracking', $requestData, $apiData, 'Success');
            } else {
                saveCommandLog($order->id, 'Sync Ithink Tracking', $requestData, $result, 'Error');
            }
        }
    } catch (\Exception $e) {
        Log::error('iThink Tracking Exception: ' . $e->getMessage());
    }

    return true;
}

/**
 * Sync Remittance data for a specific date
 */
function IthinkRemittanceSync($date)
{
    try {
        $response = Http::timeout(30)->post('https://my.ithinklogistics.com/api_v3/remittance/get_details.json', [
            'data' => [
                'remittance_date' => $date,
                'access_token' => config('app.ithink_access_token'),
                'secret_key' => config('app.secret_key'),
            ],
        ]);

        if ($response->successful()) {
            $data = $response->json();
            if (($data['status'] ?? '') == 'success') {
                foreach ($data['data'] ?? [] as $awbData) {
                    $orderAwb = OrderAWB::with('getOrder')->where('awb_number', $awbData['airway_bill_no'])->first();

                    if ($orderAwb && $orderAwb->getOrder) {
                        $order = $orderAwb->getOrder;
                        $order->update(['remittance_at' => $date]);

                        saveCommandLog($order->id, 'Ithink Remittance', ['date' => $date], ['message' => 'Synced'], 'Success');
                    }
                }
            }
        }
    } catch (\Exception $e) {
        Log::error('Remittance Sync Exception: ' . $e->getMessage());
    }
}

/**
 * XpressBees Login with resiliency
 */
function xpressBeesLogin()
{
    try {
        $response = Http::timeout(15)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post('https://shipment.xpressbees.com/api/users/login', [
                'email' => config('app.xpressbees_email'),
                'password' => config('app.xpressbees_password'),
            ]);

        if ($response->successful()) {
            $data = $response->json();
            if ($data['status'] ?? false) {
                return $data['data'];
            }
        }
    } catch (\Exception $e) {
        Log::error('XpressBees Login Exception: ' . $e->getMessage());
    }
    return false;
}

/**
 * XpressBees Tracking with resiliency
 */
function xpressBeesTracking($token, $awb_number)
{
    $orderAwb = OrderAWB::with('getOrder')->where('awb_number', $awb_number)->first();
    if (!$orderAwb || !$orderAwb->getOrder) {
        return;
    }

    $order = $orderAwb->getOrder;

    try {
        $response = Http::timeout(20)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ])
            ->get('https://shipment.xpressbees.com/api/shipments2/track/' . $awb_number);

        if ($response->successful()) {
            $data = $response->json();
            if ($data['status'] ?? false) {
                $shipment = $data['data'];

                $order->status = match (strtolower($shipment['status'] ?? '')) {
                    'in transit' => 2,
                    'delivered' => 3,
                    'rto' => 5,
                    'out for delivery' => 7,
                    default => 2,
                };

                if (!empty($shipment['history'])) {
                    $history = collect($shipment['history'])
                        ->map(
                            fn($h) => [
                                'status' => $h['status_code'],
                                'date_time' => Carbon::parse($h['event_time'])->format('Y-m-d H:i:s'),
                                'location' => $h['location'] ?? '',
                                'remark' => $h['message'] ?? '',
                            ],
                        )
                        ->toArray();

                    $order->tracking_updates = json_encode($history);
                }

                $order->save();
                saveCommandLog($order->id, 'XpressBees Tracking', ['awb' => $awb_number], $data, 'Success');
            } else {
                saveCommandLog($order->id, 'XpressBees Tracking', ['awb' => $awb_number], $data, 'Error');
            }
        }
    } catch (\Exception $e) {
        Log::error("XpressBees Tracking Exception for $awb_number: " . $e->getMessage());
    }
}

/**
 * Global Helper for Logging
 */
function saveCommandLog($orderId, $commandName, $request, $response, $status)
{
    OrderCommandLogs::create([
        'order_id' => $orderId,
        'command_for' => $commandName,
        'request_body' => json_encode($request),
        'api_response' => json_encode($response),
        'response' => $status,
    ]);
}
