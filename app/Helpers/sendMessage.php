<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

function messageSend($mobile, $otp, $template_name)
{
    try {
        $token = config('app.whatsapp_api_token');
        $phoneNumberId = config('app.whatsapp_phone_number_id');
        $apiVersion = config('app.whatsapp_api_version');

        $url = "https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages";

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => '91' . $mobile,
            'type' => 'template',
            'template' => [
                'name' => $template_name,
                'language' => ['code' => 'en'],
                'components' => [
                    [
                        'type' => 'body',
                        'parameters' => [['type' => 'text', 'text' => (string) $otp]],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [['type' => 'text', 'text' => (string) $otp]],
                    ],
                ],
            ],
        ];

        $response = Http::withToken($token)->post($url, $payload);
        if ($response->successful()) {
            return true;
        } else {
            Log::warning('failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }
    } catch (\Exception $e) {
        Log::error('WhatsApp exception: ' . $e->getMessage());
        return false;
    }
}

function wawiContact($user)
{
    Log::error($user);
    $cleanPhone = preg_replace('/\D/', '', $user->mobile);

    // 2. Remove leading '91' or '0' if they exist to get the base 10 digits
    if (str_starts_with($cleanPhone, '91')) {
        $cleanPhone = substr($cleanPhone, 2);
    } elseif (str_starts_with($cleanPhone, '0')) {
        $cleanPhone = substr($cleanPhone, 1);
    }

    // 3. Final formatted number
    $formattedPhone = '+91' . $cleanPhone;
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . config('app.wawi_token'),
    ])->post(config('app.wawi_url') . '/contacts', [
        'firstname' => explode(' ', $user->name)[0],
        'lastname' => explode(' ', $user->name)[1] ?? $user->name,
        'phone' => $formattedPhone,
        'type' => 'customer',
    ]);

    // Check if the request was successful
    if ($response->successful()) {
        return $response->json();
    }
}
