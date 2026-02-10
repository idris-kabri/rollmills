<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CODConversionCommand extends Command
{
    protected $signature = 'app:cod-conversion-command';
    protected $description = 'Send COD to Prepaid conversion offer (10% Off) after 4 hours';

    public function handle()
    {
        Log::info('COD Conversion Command Started.');

        $startWindow = now()->subHours(24);
        $endWindow = now()->subHours(3);

        Order::where('status', 1)
            ->where('is_cod', 1)
            ->where('is_conversion_message_sent', 0)
            ->whereBetween('created_at', [$startWindow, $endWindow])
            ->with(['getOrderItems', 'getBillAddress'])
            ->chunk(50, function ($orders) {
                foreach ($orders as $order) {
                    try {
                        // 3. NULL SAFETY: Check if address exists
                        if (!$order->getBillAddress) {
                            Log::warning("Skipping Order #{$order->id}: No Billing Address found.");
                            continue;
                        }

                        $discount = 0;
                        foreach ($order->getOrderItems as $item) {
                            // Ensure numeric calculation
                            $discount += ($item->total * 10) / 100;
                        }

                        $finalAmount = ceil($order->total - $discount - $order->cod_charges);

                        $parameter = [$order->getBillAddress->name, number_format($order->total, 2), $finalAmount];

                        $phone = $order->getBillAddress->mobile;

                        sendParameterTemplateWawi('cod_conversion', 'en_us', $phone, $parameter);

                        $order->is_conversion_message_sent = 1;
                        $order->save();
                    } catch (\Exception $e) {
                    }
                }
            });
    }
}
