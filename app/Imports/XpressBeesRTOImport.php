<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Order;
use App\Models\OrderAWB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class XpressBeesRTOImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $order_awb = OrderAWB::where('awb_number', $row['awb_number'])->first();
            if ($order_awb == null) {
                Log::error('OrderAWB not found for awb_number: ' . $row['awb_number']);
                continue;
            }
            $order = Order::where('id', $order_awb->order_id)->first();
            $previous_charge = $order_awb->charges_taken;
            $order_awb->charges_taken = $row['charges'];
            $order_awb->save();
            $order->total_delievery_charges = $order->total_delievery_charges - $previous_charge + (float) $row['charges'];
            $order->save();
        }
    }
}
