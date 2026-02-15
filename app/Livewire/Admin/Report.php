<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\MeeshoOrder;
use App\Models\MeeshoDeduction;

class Report extends Component
{
    public $from_date;
    public $to_date;

    public function render()
    {
        // 1. Establish the base query with date filters
        $baseQuery = Order::query();

        if ($this->from_date && $this->to_date) {
            $baseQuery->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }

        // 2. Helper function
        $getStats = function ($queryClone, $statusLabel) {
            return [
                $statusLabel => (clone $queryClone)->count(),
                'prepaid_orders' => (clone $queryClone)->where('is_cod', 0)->count(),
                'prepaid_order_revenue' => (clone $queryClone)->where('is_cod', 0)->sum('total'),
                'cod_orders' => (clone $queryClone)->where('is_cod', 1)->count(),
                'cod_order_revenue_remitted' => (clone $queryClone)->where('is_cod', 1)->whereNotNull('remittance_at')->sum('total'),
                'cod_order_revenue_not_remitted' => (clone $queryClone)->where('is_cod', 1)->whereNull('remittance_at')->sum('total'),
                'commission' => (clone $queryClone)->sum('commission'),
                'sc_taken_from_customer' => (clone $queryClone)->sum('shipping_charges'),
                'real_sc' => (clone $queryClone)->sum('total_delievery_charges'),
            ];
        };

        // 3. Generate arrays (Your existing logic is fine here)
        $process_orders_array = $getStats((clone $baseQuery)->where('status', 1), 'processed_orders');
        $shipped_orders_array = $getStats((clone $baseQuery)->where('status', 2), 'shipped_orders');
        $delivered_orders_array = $getStats((clone $baseQuery)->where('status', 3), 'delivered_orders');
        $cancelled_orders_array = $getStats((clone $baseQuery)->where('status', 4), 'cancelled_orders');
        $returned_orders_array = $getStats((clone $baseQuery)->where('status', 5), 'returned_orders');
        $lost_orders_array = $getStats((clone $baseQuery)->where('status', 6), 'lost_orders');

        // --- FIX STARTS HERE ---

        // 4. Meesho Status Loop
        $meesho_orders_array = [];
        $meesho_order_status_array = MeeshoOrder::distinct()->pluck('status')->toArray();

        foreach ($meesho_order_status_array as $meesho_order_status) {
            // FIX: Removed ->query()
            $meesho_query = MeeshoOrder::where('status', $meesho_order_status);

            if ($this->from_date && $this->to_date) {
                $meesho_query->whereBetween('order_date', [$this->from_date, $this->to_date]);
            }

            $meesho_orders_array[$meesho_order_status] = [
                // FIX: Changed $query to $meesho_query
                'count' => (clone $meesho_query)->count(),
                'remmitted_amount' => (clone $meesho_query)->whereNotNull('remittance_at')->sum('total'),
                'going_to_be_remitted_amount' => (clone $meesho_query)->whereNull('remittance_at')->sum('total'),
                'items_count' => (clone $meesho_query)->sum('quantity'),
            ];
        }

        // 5. Meesho Deductions
        $meesho_deduction = MeeshoDeduction::query();
        if ($this->from_date && $this->to_date) {
            $meesho_deduction->whereBetween('created_at', [$this->from_date, $this->to_date]);
        }
        // FIX: Clone here is safer to prevent side effects if you add more logic later
        $meesho_deduction_array = [
            'count' => (clone $meesho_deduction)->count(),
            'amount' => (clone $meesho_deduction)->sum('total_sum'),
        ];

        // 6. Meesho Items Loop
        // PERFORMANCE WARNING: This loop runs 4 queries per product. If you have 50 products, that's 200 queries.
        $meesho_item_array = MeeshoOrder::distinct()->pluck('product_name')->toArray();
        $meesho_items = [];

        if (count($meesho_item_array) > 0) {
            foreach ($meesho_item_array as $meesho_item) {
                // FIX: Removed ->query()
                $meesho_item_query = MeeshoOrder::where('product_name', $meesho_item)->whereIn('status', ['DELIVERED', 'SHIPPED', 'READY_TO_SHIP']);

                if ($this->from_date && $this->to_date) {
                    $meesho_item_query->whereBetween('order_date', [$this->from_date, $this->to_date]);
                }

                $meesho_items[$meesho_item] = [
                    // FIX: Added (clone ...) to ALL lines below to prevent filters from stacking
                    'count' => (clone $meesho_item_query)->count(),
                    'remmitted_amount' => (clone $meesho_item_query)->whereNotNull('remittance_at')->sum('total'),
                    'going_to_be_remitted_amount' => (clone $meesho_item_query)->whereNull('remittance_at')->sum('total'),
                    'items_count' => (clone $meesho_item_query)->sum('quantity'),
                ];
            }
        }

        return view('livewire.admin.report', [
            'process_orders_array' => $process_orders_array,
            'shipped_orders_array' => $shipped_orders_array,
            'delivered_orders_array' => $delivered_orders_array,
            'cancelled_orders_array' => $cancelled_orders_array,
            'returned_orders_array' => $returned_orders_array,
            'lost_orders_array' => $lost_orders_array,
            'meesho_orders_array' => $meesho_orders_array,
            'meesho_deduction_array' => $meesho_deduction_array,
            'meesho_items' => $meesho_items,
        ])->layout('layouts.admin.app');
    }
}
