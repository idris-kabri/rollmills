<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderAWB;
use Carbon\Carbon;

class XpressBeesOrderDataImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $user = User::where('mobile', $row['phone_number'])->first();

            if (!$user) {
                continue;
            }

            $order = Order::where('logged_in_user_id', $user->id)
                ->whereNotIn('status', [0, 4])
                ->first();

            if (!$order) {
                continue;
            }

            // if (isset($row['remittance_paid']) && $row['remittance_paid'] !== 'No') {
            //     try {
            //         $order->remittance_at = Carbon::parse($row['remittance_date']);
            //     } catch (\Exception $e) {
            //         // Handle or log bad date format
            //     }
            // }

            // $order->total_delievery_charges += $row['charges'] ?? 0;

            if (($row['tracking_status'] ?? '') == 'delivered') {
                $order->status = 3;
            }

            $order->save();

            // 2. Logic for AWB Charges
            // $unbilled = $row['charges'] ?? 0;

            // // 3. Create First AWB
            // OrderAWB::create([
            //     'order_id' => $order->id,
            //     'aggregator' => 'XpressBees',
            //     'provider' => $row['courier'],
            //     'awb_number' => $row['awb_number'],
            //     'charges_taken' => $unbilled,
            //     'remarks' => 'Forward Shipping Charges',
            // ]);
        }
    }
}
