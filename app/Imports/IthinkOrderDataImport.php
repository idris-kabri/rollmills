<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Order;
use App\Models\OrderAWB;
use Carbon\Carbon;

class IthinkOrderDataImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Find the order - ensure 'sub_order_number' matches your CSV column header
            $order = Order::find($row['sub_order_number']);

            if (!$order) {
                continue; // Skip if order not found to avoid errors
            }

            // 1. Update Order Details
            if (isset($row['cod_remittance_date']) && $row['cod_remittance_date'] !== 'N/A') {
                try {
                    $order->remittance_at = Carbon::parse($row['cod_remittance_date']);
                } catch (\Exception $e) {
                    // Handle or log bad date format
                }
            }

            $order->total_delievery_charges = $row['unbilled_charges'] ?? 0;

            if (($row['order_status'] ?? '') == 'Delivered') {
                $order->status = 3;
            }

            $order->save();

            // 2. Logic for AWB Charges
            $unbilled = $row['unbilled_charges'] ?? 0;
            $hasRto = !empty($row['rto_awb']) && $row['rto_awb'] !== null;

            $delivery_charge = $hasRto ? $unbilled / 2 : $unbilled;

            // 3. Create First AWB
            OrderAWB::create([
                'order_id' => $order->id,
                'aggregator' => 'Ithink',
                'provider' => $row['courier_company'],
                'awb_number' => $row['awb_no'],
                'charges_taken' => $delivery_charge,
                'remarks' => 'Forward Shipping Charges',
            ]);

            // 4. Create Second AWB if RTO exists
            if ($hasRto) {
                OrderAWB::create([
                    'order_id' => $order->id,
                    'aggregator' => 'Ithink',
                    'provider' => $row['courier_company'],
                    'awb_number' => $row['rto_awb'],
                    'charges_taken' => $delivery_charge,
                    'remarks' => 'Reverse Shipping Charges',
                ]);
            }
        }
    }
}
