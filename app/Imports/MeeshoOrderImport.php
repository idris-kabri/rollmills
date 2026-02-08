<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\MeeshoOrder;
use App\Models\Order;

class MeeshoOrderImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                $meesho_order = MeeshoOrder::where('sub_order_no', $row['order_number'])->first();
                if ($meesho_order) {
                    $meesho_order->status = $row['status'];
                    if ($row['payment_date'] != null) {
                        $meesho_order->remittance_at = $row['payment_date'];
                        $meesho_order->gst = $row['gst'];
                        $meesho_order->transaction_id = $row['transaction_id'];
                        $meesho_order->remittance_amount = $row['amount'];
                        $meesho_order->save();
                    }
                } else {
                    $meesho_order = new MeeshoOrder();
                    $meesho_order->sub_order_no = $row['order_number'];
                    $meesho_order->status = $row['status'];
                    $meesho_order->order_date = $row['order_date'];
                    $meesho_order->customer_state = $row['state'];
                    $meesho_order->product_name = $row['product_name'];
                    $meesho_order->gst = 18;
                    $meesho_order->sku = $row['sku'];
                    $meesho_order->quantity = $row['quantity'];
                    $meesho_order->price_per_piece = $row['price'];
                    $meesho_order->total = $row['price'] * $row['quantity'];
                    $meesho_order->packet_qr = $row['packet_id'];
                    $meesho_order->remittance_at = $row['payment_date'];
                    $meesho_order->transaction_id = $row['transaction_id'];
                    $meesho_order->remittance_amount = $row['amount'];
                    $meesho_order->save();
                }
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }
}
