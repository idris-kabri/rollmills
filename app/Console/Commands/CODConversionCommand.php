<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\OrderCommandLogs;
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
                        $discount = 0;
                        foreach ($order->getOrderItems as $item) {
                            // Ensure numeric calculation
                            $discount += ($item->total * 10) / 100;
                        }

                        $finalAmount = ceil($order->total - $discount - $order->cod_charges);

                        $phone = $order->getBillAddress->mobile;

                        sendCODConversionTemplate($phone, $order->getBillAddress->name, number_format($order->total, 2), $finalAmount, $order->id);

                        OrderCommandLogs::create([
                            'order_id' => $order->id,
                            'command_for' => 'COD Conversion Offer Sent',
                            'request_body' => json_encode([
                                'phone' => $phone,
                                'name' => $order->getBillAddress->name,
                                'total' => $order->total,
                                'final_amount' => $finalAmount,
                            ]),
                            'api_response' => json_encode(['message' => 'COD Conversion Offer Sent']),
                            'response' => 'Success',
                        ]);

                        $order->is_conversion_message_sent = 1;
                        $order->save();
                    } catch (\Exception $e) {
                        $discount = 0;
                        foreach ($order->getOrderItems as $item) {
                            // Ensure numeric calculation
                            $discount += ($item->total * 10) / 100;
                        }

                        $finalAmount = ceil($order->total - $discount - $order->cod_charges);

                        $phone = $order->getBillAddress->mobile;
                        OrderCommandLogs::create([
                            'order_id' => $order->id,
                            'command_for' => 'COD Conversion Offer Sent',
                            'request_body' => json_encode([
                                'phone' => $phone,
                                'name' => $order->getBillAddress->name,
                                'total' => $order->total,
                                'final_amount' => $finalAmount,
                            ]),
                            'api_response' => json_encode(['message' => $e->getMessage()]),
                            'response' => 'Error',
                        ]);
                    }
                }
            });
    }
}
