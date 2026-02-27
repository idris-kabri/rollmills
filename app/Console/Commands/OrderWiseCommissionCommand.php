<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Order;

class OrderWiseCommissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:order-wise-commission-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Razorpay payments and update order-wise commissions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order_ids = Order::where('is_cod', 0)->where('status', '!=', 0)->where('commission', 0)->pluck('id')->toArray();

        if (empty($order_ids)) {
            $this->info('No orders found requiring commission updates.');
            return;
        }

        $this->info('Starting commission updates...');

        Transaction::whereIn('refrence_id', $order_ids)->chunk(100, function ($payments) {
            foreach ($payments as $payment) {
                $payment_id = str_contains($payment->payment_id, 'order_') ? getPaymentId($payment->payment_id) : $payment->payment_id;

                if (!$payment_id) {
                    continue;
                }

                $response = Http::withBasicAuth(config('app.razorpay_key_id'), config('app.razorpay_secret_key'))->get("https://api.razorpay.com/v1/payments/{$payment_id}");

                if ($response->failed()) {
                    Log::error("Razorpay API failed for Payment ID: {$payment_id}", [
                        'status' => $response->status(),
                        'response' => $response->body(),
                    ]);
                    continue;
                }

                $payment_response = $response->json();

                $payment->payment_id = $payment_id;

                if (isset($payment_response['status']) && $payment_response['status'] === 'captured') {
                    $commission_final = $payment_response['fee'] > 0 ? $payment_response['fee'] / 100 : 0;

                    $payment->status = 1;
                    $payment->commission = $commission_final;

                    $order = Order::find((int) $payment->refrence_id);
                    if ($order) {
                        $order->commission = $commission_final;
                        $order->save();
                    }
                }

                $payment->save();
            }
        });

        $this->info('Commission updates completed successfully.');
    }
}
