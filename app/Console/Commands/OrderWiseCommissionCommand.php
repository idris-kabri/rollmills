<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
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
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $payments = Transaction::all();
        foreach ($payments as $payment) {
            $payment_id = null;
            if (str_contains($payment->payment_id, 'order_')) {
                $payment_id = getPaymentId($payment->payment_id);
            } else {
                $payment_id = $payment->payment_id;
            }
            if ($payment_id) {
                $response = Http::withBasicAuth(config('app.razorpay_key_id'), config('app.razorpay_secret_key'))->get("https://api.razorpay.com/v1/payments/{$payment_id}");

                if ($response->failed()) {
                    continue;
                }

                $payment_response = $response->json();

                if ($payment_response['status'] == 'captured') {
                    $commission_final = $payment_response['fee'] > 0 ? $payment_response['fee'] / 100 : 0;
                    $payment->status = 1;
                    $payment->commission = $commission_final;
                    $payment->save();

                    $order = Order::find((int) $payment->refrence_id);
                    if ($order) {
                        $order->commission = $commission_final;
                        $order->save();
                    }
                }

                $payment->payment_id = $payment_id;
                $payment->save();
            }
        }
    }
}
