<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderAWB;
use App\Models\MeeshoOrder;
use App\Models\MeeshoDeduction;
use Carbon\Carbon;

class Report extends Component
{
    public $from_date;
    public $to_date;

    public function render()
    {
        // 1. Establish the base query with date filters
        $baseQuery = Order::query();

        if ($this->from_date && $this->to_date) {
            $baseQuery->whereBetween('created_at', [Carbon::parse($this->from_date)->startOfDay(), Carbon::parse($this->to_date)->endOfDay()]);
        }

        $prepaid_order_sum = (clone $baseQuery)
            ->where('is_cod', 0)
            ->whereIn('status', [1, 2, 3])
            ->sum('total');

        $cod_order_sum = (clone $baseQuery)
            ->where('is_cod', 1)
            ->whereIn('status', [1, 2, 3])
            ->sum('total');

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
        $returned_orders_array = $getStats((clone $baseQuery)->whereIn('status', [5, 8]), 'returned_orders');
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
                'remmitted_amount' => (clone $meesho_query)->whereNotNull('remittance_at')->sum('remittance_amount'),
                'going_to_be_remitted_amount' => (clone $meesho_query)->whereNull('remittance_at')->sum('total'),
                'items_count' => (clone $meesho_query)->sum('quantity'),
            ];
        }

        // 5. Meesho Deductions
        $meesho_deduction = MeeshoDeduction::query();
        if ($this->from_date && $this->to_date) {
            $meesho_deduction->whereBetween('date', [$this->from_date, $this->to_date]);
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

        $provider_base_query = OrderAWB::query()->join('orders', 'orders.id', '=', 'order_awb.order_id');

        if ($this->from_date && $this->to_date) {
            $provider_base_query->whereBetween('orders.created_at', [Carbon::parse($this->from_date)->startOfDay(), Carbon::parse($this->to_date)->endOfDay()]);
        }

        $ithink_orders_query = (clone $provider_base_query)->where('order_awb.aggregator', 'Ithink');
        $shadow_fax_orders_query = (clone $provider_base_query)->where('order_awb.aggregator', 'ShadowFax');
        $xpress_bees_orders_query = (clone $provider_base_query)->where('order_awb.aggregator', 'XpressBees');

        // --- iThink Metrics ---
        $shipped_ithink_order_count = (clone $ithink_orders_query)->where('orders.status', 2)->distinct()->count('orders.id');
        $ithink_order_count = (clone $ithink_orders_query)
            ->whereIn('orders.status', [2, 3, 5, 8, 7, 9])
            ->distinct()
            ->count('orders.id');
        $completed_ithink_order_count = (clone $ithink_orders_query)->where('orders.status', 3)->distinct()->count('orders.id');
        $returned_ithink_order_count = (clone $ithink_orders_query)
            ->whereIn('orders.status', [5, 8])
            ->distinct()
            ->count('orders.id');
        $ofd_ithink_order_count = (clone $ithink_orders_query)->where('orders.status', 7)->distinct()->count('orders.id');
        $undelivered_ithink_order_count = (clone $ithink_orders_query)->where('orders.status', 9)->distinct()->count('orders.id');
        $ithink_rto_rate = $ithink_order_count > 0 ? round(($returned_ithink_order_count / $ithink_order_count) * 100, 2) : 0;

        // --- ShadowFax Metrics ---
        $shipped_shadow_fax_order_count = (clone $shadow_fax_orders_query)->where('orders.status', 2)->distinct()->count('orders.id');
        $shadow_fax_order_count = (clone $shadow_fax_orders_query)
            ->whereIn('orders.status', [2, 3, 5, 8, 7, 9])
            ->distinct()
            ->count('orders.id');
        $completed_shadow_fax_order_count = (clone $shadow_fax_orders_query)->where('orders.status', 3)->distinct()->count('orders.id');
        $returned_shadow_fax_order_count = (clone $shadow_fax_orders_query)
            ->whereIn('orders.status', [5, 8])
            ->distinct()
            ->count('orders.id');
        $ofd_shadow_fax_order_count = (clone $shadow_fax_orders_query)->where('orders.status', 7)->distinct()->count('orders.id');
        $undelivered_shadow_fax_order_count = (clone $shadow_fax_orders_query)->where('orders.status', 9)->distinct()->count('orders.id');
        $shadow_fax_rto_rate = $shadow_fax_order_count > 0 ? round(($returned_shadow_fax_order_count / $shadow_fax_order_count) * 100, 2) : 0;

        // --- XpressBees Metrics ---
        $shipped_xpress_bees_order_count = (clone $xpress_bees_orders_query)->where('orders.status', 2)->distinct()->count('orders.id');
        $xpress_bees_order_count = (clone $xpress_bees_orders_query)
            ->whereIn('orders.status', [2, 3, 5, 8, 7, 9])
            ->distinct()
            ->count('orders.id');
        $completed_xpress_bees_order_count = (clone $xpress_bees_orders_query)->where('orders.status', 3)->distinct()->count('orders.id');
        $returned_xpress_bees_order_count = (clone $xpress_bees_orders_query)
            ->whereIn('orders.status', [5, 8])
            ->distinct()
            ->count('orders.id');
        $ofd_xpress_bees_order_count = (clone $xpress_bees_orders_query)->where('orders.status', 7)->distinct()->count('orders.id');
        $undelivered_xpress_bees_order_count = (clone $xpress_bees_orders_query)->where('orders.status', 9)->distinct()->count('orders.id');
        $xpress_bees_rto_rate = $xpress_bees_order_count > 0 ? round(($returned_xpress_bees_order_count / $xpress_bees_order_count) * 100, 2) : 0;

        $orders_needs_attention = Order::where('status', 2)
            ->where('shipped_at', '<=', Carbon::now()->subDays(10))
            ->get();

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
            'prepaid_order_sum' => $prepaid_order_sum,
            'cod_order_sum' => $cod_order_sum,
            'shipped_ithink_order_count' => $shipped_ithink_order_count,
            'ithink_order_count' => $ithink_order_count,
            'completed_ithink_order_count' => $completed_ithink_order_count,
            'returned_ithink_order_count' => $returned_ithink_order_count,
            'ofd_ithink_order_count' => $ofd_ithink_order_count,
            'undelivered_ithink_order_count' => $undelivered_ithink_order_count,
            'ithink_rto_rate' => $ithink_rto_rate,
            'shipped_shadow_fax_order_count' => $shipped_shadow_fax_order_count,
            'shadow_fax_order_count' => $shadow_fax_order_count,
            'completed_shadow_fax_order_count' => $completed_shadow_fax_order_count,
            'returned_shadow_fax_order_count' => $returned_shadow_fax_order_count,
            'ofd_shadow_fax_order_count' => $ofd_shadow_fax_order_count,
            'undelivered_shadow_fax_order_count' => $undelivered_shadow_fax_order_count,
            'shadow_fax_rto_rate' => $shadow_fax_rto_rate,
            'shipped_xpress_bees_order_count' => $shipped_xpress_bees_order_count,
            'xpress_bees_order_count' => $xpress_bees_order_count,
            'completed_xpress_bees_order_count' => $completed_xpress_bees_order_count,
            'returned_xpress_bees_order_count' => $returned_xpress_bees_order_count,
            'ofd_xpress_bees_order_count' => $ofd_xpress_bees_order_count,
            'undelivered_xpress_bees_order_count' => $undelivered_xpress_bees_order_count,
            'xpress_bees_rto_rate' => $xpress_bees_rto_rate,
            'orders_needs_attention' => $orders_needs_attention,
        ])->layout('layouts.admin.app');
    }
}
