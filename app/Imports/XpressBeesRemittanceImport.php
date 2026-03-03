<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Order;
use App\Models\OrderAWB;

class XpressBeesRemittanceImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $awb = $row['awb'];
            $order_awb = OrderAWB::where('awb_number', $awb)->first();
            $date = $row['date'];
            if ($order_awb == null) {
                continue;
            }
            $order = Order::where('id', $order_awb->order_id)->first();
            $order->remittance_at = $date;
            $order->save();
        }
    }
}
