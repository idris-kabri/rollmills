<?php
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderAWB;
use Illuminate\Support\Facades\Log;

function synIthinkOrderDetail($awb_number, $order)
{
    $response = Http::post('https://my.ithinklogistics.com/api_v3/order/get_details.json', [
        'data' => [
            'awb_number_list' => $awb_number,
            'order_no' => '',
            'start_date' => Carbon::parse($order->created_at)->format('Y-m-d'),
            'end_date' => Carbon::parse($order->created_at)->addDays(60)->format('Y-m-d'),
            'access_token' => config('app.ithink_access_token'),
            'secret_key' => config('app.secret_key'),
        ],
    ]);

    if ($response->successful()) {
        $result = $response->json();

        // Check if success and if the specific AWB data actually exists in the response
        if (isset($result['status']) && $result['status'] === 'success' && isset($result['data'][$awb_number])) {
            $apiData = $result['data'][$awb_number];

            $order_data = Order::find($order->id);
            $order_awb = OrderAWB::where('order_id', $order->id)->where('awb_number', $awb_number)->first();

            // Only update if the models were actually found
            if ($order_data && $order_awb) {
                $order_awb->charges_taken = (float) ($apiData['unbilled_total_charges'] ?? 0);
                $order_awb->save();

                $order_data->total_delievery_charges = (float) ($apiData['unbilled_total_charges'] ?? 0);
                $order_data->save();
            }
        }
    }

    return true; // Consider returning false if the API failed, depending on your app's needs
}

function synIthinkTracking($awb_number, $order)
{
    $response = Http::post('https://api.ithinklogistics.com/api_v3/order/track.json', [
        'data' => [
            'awb_number_list' => $awb_number,
            'access_token' => config('app.ithink_access_token'),
            'secret_key' => config('app.secret_key'),
        ],
    ]);

    if ($response->successful()) {
        $result = $response->json();

        if (isset($result['status']) && $result['status'] === 'success' && isset($result['data'][$awb_number])) {
            $apiData = $result['data'][$awb_number];
            $status = $apiData['current_status'] ?? '';

            $internalStatus = match ($status) {
                'In Transit', 'Manifested', 'Picked Up', 'Reached At Destination' => 2, // Shipped
                'Delivered' => 3, // Complete
                'Cancelled', 'REV Cancelled', 'REV Closed' => 4, // Cancelled
                'RTO Delivered', 'REV Delivered' => 5, // Return Complete
                'Damaged', 'Lost', 'Shortage', 'RTO Shortage' => 6, // Lost
                'Out For Delivery' => 7, // OFD
                'RTO Pending', 'RTO Processing', 'RTO In Transit', 'Reached At Origin', 'RTO Out For Delivery', 'RTO Undelivered', 'REV Manifest', 'REV Out for Pick Up', 'REV Picked Up', 'REV In Transit', 'REV Out For Delivery' => 8, // Return Initiated
                'Not Picked', 'Undelivered', 'Out of Delivery Area', 'Delayed', 'Misrouted' => 9, // Undelivered
                default => 2, // Fallback
            };

            $order_data = Order::find($order->id);

            if ($order_data) {
                $order_data->status = $internalStatus;

                // Rename array to avoid overwriting the $apiData
                $trackingDataToSave = [];

                // Safely check if scan_details exists and is an array
                if (isset($apiData['scan_details']) && is_array($apiData['scan_details'])) {
                    foreach ($apiData['scan_details'] as $scan_detail) {
                        if (!empty($scan_detail['status'])) {
                            $trackingDataToSave[] = [
                                'status' => $scan_detail['status'],
                                'date_time' => Carbon::parse($scan_detail['status_date_time'])->format('Y-m-d H:i:s'),
                                'location' => $scan_detail['status_location'] ?? '',
                                'remark' => $scan_detail['status_remark'] ?? '',
                                'reason' => $scan_detail['status_reason'] ?? '',
                            ];
                        }
                    }

                    if (!empty($trackingDataToSave)) {
                        $order_data->tracking_updates = json_encode($trackingDataToSave);
                    }
                }

                $order_data->save();
            }
        }
    }

    return true;
}

function IthinkRemittanceSync($date)
{
    $response = Http::post('https://my.ithinklogistics.com/api_v3/remittance/get_details.json', [
        'data' => [
            'remittance_date' => $date,
            'access_token' => config('app.ithink_access_token'),
            'secret_key' => config('app.secret_key'),
        ],
    ]);

    if ($response->successful()) {
        $data = $response->json();
        if ($data['status'] == 'success' && $data['status_code'] == 200) {
            $awbs = $data['data'];
            if (count($awbs) > 0) {
                foreach ($awbs as $awb) {
                    $order_awb = OrderAWB::where('awb_number', $awb['airway_bill_no'])->first();
                    if ($order_awb) {
                        $order = Order::where('id', $order_awb->getOrder->id)->first();
                        $order->remittance_at = $date;
                        $order->save();
                    }
                }
            }
        }
    }
}

function xpressBeesLogin()
{
    $email = config('app.xpressbees_email');
    $password = config('app.xpressbees_password');
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post('https://shipment.xpressbees.com/api/users/login', [
        'email' => $email,
        'password' => $password,
    ]);

    if ($response->successful()) {
        $data = $response->json();
        if ($data['status'] == true) {
            return $data['data'];
        }
    }

    return false;
}

function xpressBeesTracking($token, $awb_number)
{
    $order_awb = OrderAWB::where('awb_number', $awb_number)->first();
    $order = Order::where('id', $order_awb->getOrder->id)->first();
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Authorization' => 'Bearer ' . $token,
    ])->get('https://shipment.xpressbees.com/api/shipments2/track/' . $awb_number);

    if ($response->successful()) {
        $data = $response->json();
        if ($data['status'] == true) {
            $status = $data['data']['status'];
            $internalStatus = match ($status) {
                'in transit' => 2,
                'delivered' => 3,
                'rto' => 5,
                'out for delivery' => 7,
                default => 2,
            };
            $order->status = $internalStatus;
            $histories = $data['data']['history'];
            if (!empty($histories)) {
                $trackingDataToSave = [];
                foreach ($histories as $history) {
                    $trackingDataToSave[] = [
                        'status' => $history['status_code'],
                        'date_time' => Carbon::parse($history['event_time'])->format('Y-m-d H:i:s'),
                        'location' => $history['location'] ?? '',
                        'remark' => $history['message'] ?? '',
                    ];
                }
                if (!empty($trackingDataToSave)) {
                    $order->tracking_updates = json_encode($trackingDataToSave);
                }
            }
            $order->save();
        }
    }
}
