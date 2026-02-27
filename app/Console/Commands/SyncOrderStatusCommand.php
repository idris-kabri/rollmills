<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderAWB;

class SyncOrderStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-order-status-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::whereNotIn('status', [0])
            ->pluck('id')
            ->toArray();
        $order_awbs = OrderAWB::whereIn('order_id', $orders)->get();
        foreach ($order_awbs as $order_awb) {
            if ($order_awb->getOrder->status == 4) {
                continue;
            }

            if ($order_awb->aggregator == 'Ithink') {
                synIthinkOrderDetail($order_awb->awb_number, $order_awb->getOrder);
                synIthinkTracking($order_awb->awb_number, $order_awb->getOrder);
            }
        }
    }
}
