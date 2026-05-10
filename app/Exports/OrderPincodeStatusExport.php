<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderPincodeStatusExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Using Conditional Aggregation to pivot the statuses into columns
        return Order::select(
            // Location Data (Trimmed to remove accidental spaces)
            DB::raw("TRIM(JSON_UNQUOTE(JSON_EXTRACT(orders.ship_different_address_details, '$.zipcode'))) as pincode"),
            DB::raw("TRIM(JSON_UNQUOTE(JSON_EXTRACT(orders.ship_different_address_details, '$.state'))) as state"),
            DB::raw("TRIM(JSON_UNQUOTE(JSON_EXTRACT(orders.ship_different_address_details, '$.city'))) as city"),

            // Shipped (Status 2)
            DB::raw('SUM(CASE WHEN orders.status = 2 THEN 1 ELSE 0 END) as shipped_count'),
            DB::raw('SUM(CASE WHEN orders.status = 2 THEN orders.total ELSE 0 END) as shipped_sum'),
            DB::raw('SUM(CASE WHEN orders.status = 2 THEN order_awb.charges_taken ELSE 0 END) as shipped_shipping_charges'),

            // Completed (Status 3)
            DB::raw('SUM(CASE WHEN orders.status = 3 THEN 1 ELSE 0 END) as completed_count'),
            DB::raw('SUM(CASE WHEN orders.status = 3 THEN orders.total ELSE 0 END) as completed_sum'),
            DB::raw('SUM(CASE WHEN orders.status = 3 THEN order_awb.charges_taken ELSE 0 END) as completed_shipping_charges'),

            // Out for delivery (Status 7)
            DB::raw('SUM(CASE WHEN orders.status = 7 THEN 1 ELSE 0 END) as ofd_count'),
            DB::raw('SUM(CASE WHEN orders.status = 7 THEN orders.total ELSE 0 END) as ofd_sum'),
            DB::raw('SUM(CASE WHEN orders.status = 7 THEN order_awb.charges_taken ELSE 0 END) as ofd_shipping_charges'),

            // Return (Statuses 5 & 8)
            DB::raw('SUM(CASE WHEN orders.status IN (5, 8) THEN 1 ELSE 0 END) as return_count'),
            DB::raw('SUM(CASE WHEN orders.status IN (5, 8) THEN orders.total ELSE 0 END) as return_sum'),
            DB::raw('SUM(CASE WHEN orders.status IN (5, 8) THEN order_awb.charges_taken ELSE 0 END) as return_shipping_charges'),
        )
            ->join('order_awb', 'orders.id', '=', 'order_awb.order_id')
            ->whereNotNull('orders.ship_different_address_details')
            ->groupBy(DB::raw("TRIM(JSON_UNQUOTE(JSON_EXTRACT(orders.ship_different_address_details, '$.zipcode')))"), DB::raw("TRIM(JSON_UNQUOTE(JSON_EXTRACT(orders.ship_different_address_details, '$.state')))"), DB::raw("TRIM(JSON_UNQUOTE(JSON_EXTRACT(orders.ship_different_address_details, '$.city')))"))
            // Note: Removed the "order." prefix here because 'shipped_count' is a custom alias, not a DB column
            ->orderBy('shipped_count', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return ['Pincode', 'State', 'City', 'Shipped order count', 'Shipped order Sum', 'Shipped order shipping charges sum', 'completed order count', 'completed order Sum', 'completed order shipping charges sum', 'Out for delivery order count', 'Out for delivery order Sum', 'Out for delivery order shipping charges sum', 'Return order count', 'Return order Sum', 'Return order shipping charges sum'];
    }

    public function map($row): array
    {
        return [$row->pincode ?? 'N/A', $row->state ?? 'N/A', $row->city ?? 'N/A', $row->shipped_count, $row->shipped_sum ?? 0, $row->shipped_shipping_charges ?? 0, $row->completed_count, $row->completed_sum ?? 0, $row->completed_shipping_charges ?? 0, $row->ofd_count, $row->ofd_sum ?? 0, $row->ofd_shipping_charges ?? 0, $row->return_count, $row->return_sum ?? 0, $row->return_shipping_charges ?? 0];
    }
}
