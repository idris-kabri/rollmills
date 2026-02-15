<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Added import
use App\Models\MeeshoOrder;
use Carbon\Carbon;

class MeeshoPaymentImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Get all order numbers from the sheet to avoid N+1 queries
        $orderNumbers = $rows->pluck('order_number')->toArray();
        $meeshoOrders = MeeshoOrder::whereIn('sub_order_no', $orderNumbers)->get()->keyBy('sub_order_no');

        foreach ($rows as $row) {
            $meesho_order = $meeshoOrders->get($row['order_number']);

            if ($meesho_order) {
                // Ensure the amount is treated as a float
                $amount = (float) $row['amount'];

                $meesho_order->remittance_at = $row['payment_date'];
                $meesho_order->transaction_id = $row['transaction_id'];

                // Simply add the amount. If it's negative, it will naturally subtract.
                $meesho_order->remittance_amount += $amount;

                $meesho_order->save();
            }
        }
    }
}
