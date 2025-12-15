<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

function messageSend($mobile, $otp, $template_name)
{
    try {
        $token = config('app.whatsapp_api_token');
        $phoneNumberId = config('app.whatsapp_phone_number_id');
        $apiVersion = config('app.whatsapp_api_version');

        // $url = "https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages";

        // $payload = [
        //     'messaging_product' => 'whatsapp',
        //     'to' => '91' . $mobile,
        //     'type' => 'template',
        //     'template' => [
        //         'name' => $template_name,
        //         'language' => ['code' => 'en'],
        //         'components' => [
        //             [
        //                 'type' => 'body',
        //                 'parameters' => [
        //                     ['type' => 'text', 'text' => (string) $otp]
        //                 ],
        //             ],
        //             [
        //                 'type' => 'button',
        //                 'sub_type' => 'url',
        //                 'index' => '0',
        //                 'parameters' => [
        //                     ['type' => 'text', 'text' => (string) $otp]
        //                 ],
        //             ],
        //         ],
        //     ],
        // ];


        // $response = Http::withToken($token)->post($url, $payload);
        // if ($response->successful()) {
        //     return true;
        // } else {
        //     Log::warning('failed', [
        //         'status' => $response->status(),
        //         'body' => $response->body()
        //     ]);
        //     return false;
        // }
    } catch (\Exception $e) {
        Log::error('WhatsApp exception: ' . $e->getMessage());
        return false;
    }
}
