<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentSuccessController extends Controller
{
    public function paymentSuccess(Request $request)
    {
        try {
            session()->forget('coupon_discount_amount');
            session()->forget('coupon_discount_id');
            session()->forget('coupon_code');

            if ($request->type == 'order_payment') {
                $id = $request->id;
                returnUrl($request->transaction_id, $request->payment_id, $request->title, $request->customer_name, $request->customer_email);
                return redirect('/order-completed?id=' . $id)
                    ->with('success', 'Your order placed successfully!');
            } elseif ($request->title) {
                returnUrl($request->transaction_id, $request->payment_id, $request->title, $request->customer_name, $request->customer_email);
                return redirect('/')->with('success', 'Your gift card purchase was successful, and the details have been sent to ' . $request->customer_name . ' email address.');
            } else {
                returnUrl($request->transaction_id, $request->payment_id);
                return redirect('/');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
