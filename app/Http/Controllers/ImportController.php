<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\IthinkOrderDataImport;
use App\Imports\XpressBeesOrderDataImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use App\Models\Order;

class ImportController extends Controller
{
    public function ithink()
    {
        Excel::import(new IthinkOrderDataImport(), public_path('Ithink_import_sheet.csv'));
        return response()->json(['success' => true]);
    }

    public function xpreesBees()
    {
        Excel::import(new XpressBeesOrderDataImport(), public_path('xprees_bees_import_report.csv'));
        return response()->json(['success' => true]);
    }

    public function paymentSettlement()
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
        return response()->json(['success' => true]);
    }
}
