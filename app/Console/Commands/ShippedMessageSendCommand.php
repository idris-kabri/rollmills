<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class ShippedMessageSendCommand extends Command
{
    protected $signature = 'app:shipped-message-send-command';
    protected $description = 'Sends notifications for orders shipped yesterday';

    public function handle()
    {
        // Define yesterday's boundaries clearly
        $start = Carbon::yesterday()->startOfDay();
        $end = Carbon::now()->endOfDay();

        // Eager load relationships to prevent 100s of database queries
        $orders = Order::with(['getBillAddress', 'getOrderItems.getProduct'])
            ->whereBetween('shipped_at', [$start, $end])
            ->get();

        foreach ($orders as $order) {
            // Use collection methods instead of a manual foreach loop for items
            $items = $order->getOrderItems
                ->map(function ($item) {
                    return ($item->getProduct->name ?? 'Unknown Product') . ' x ' . $item->quantity;
                })
                ->implode(', ');

            // Check if address exists to avoid "Property of non-object" errors
            $address = $order->getBillAddress;
            if (!$address) {
                $this->warn("Skipping Order #{$order->id}: No billing address found.");
                continue;
            }

            $body_para = [$address->name, (string) $order->id, $items];
            $button_para = [(string) $order->id];

            messageSend($address->mobile, 'order_shipped', $body_para, $button_para, 'en');
        }

        $this->info('Shipped messages sent successfully.');
    }
}
