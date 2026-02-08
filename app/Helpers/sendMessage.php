<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\User;

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
    // --- 1. PREPARATION (Format Data) ---

    // Format Phone
    $cleanPhone = preg_replace('/\D/', '', $user->mobile);
    if (str_starts_with($cleanPhone, '91')) {
        $cleanPhone = substr($cleanPhone, 2);
    } elseif (str_starts_with($cleanPhone, '0')) {
        $cleanPhone = substr($cleanPhone, 1);
    }
    $formattedPhone = '+91' . $cleanPhone;

    // Format Name
    $nameParts = explode(' ', $user->name ?? '', 2);
    $firstName = $nameParts[0];
    $lastName = $nameParts[1] ?? $nameParts[0];

    if (empty($firstName)) {
        $firstName = fake()->firstName();
        $lastName = fake()->lastName();
    }

    // Prepare Payload
    $payload = [
        'firstname' => $firstName,
        'lastname' => $lastName,
        'phone' => $formattedPhone,
        'type' => 'customer',
    ];

    // API Config
    $baseUrl = config('app.wawi_url');
    $headers = ['Authorization' => 'Bearer ' . config('app.wawi_token')];

    // --- 2. CONTROL FLOW ---

    // CASE A: User ALREADY has a Wawi ID -> UPDATE
    if (!empty($user->wawi_contact_id)) {
        $url = $baseUrl . '/contacts/' . $user->wawi_contact_id;
        $response = Http::withHeaders($headers)->put($url, $payload);

        if ($response->successful()) {
            return $response->json();
        } else {
            Log::error('Wawi Update Failed', [
                'user_id' => $user->id,
                'wawi_id' => $user->wawi_contact_id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }
    }
    // CASE B: User DOES NOT have a Wawi ID -> CREATE
    else {
        $url = $baseUrl . '/contacts';
        $response = Http::withHeaders($headers)->post($url, $payload);

        if ($response->successful()) {
            $responseData = $response->json();

            // Save the new ID to database
            $wawiId = $responseData['data']['id'] ?? null;
            if ($wawiId) {
                $user->wawi_contact_id = $wawiId;
                $user->save();
            }

            return $responseData;
        } else {
            // Handle Create Failure (e.g., Duplicate Number on Wawi side but no local ID)
            Log::warning('Wawi Create Failed', [
                'user_id' => $user->id,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }
    }
}

function sendNormalTemplateWawi($template_name, $language_code, $phone_number)
{
    $url = config('app.wawi_url') . '/messages/template';
    $token = config('app.wawi_token');

    $response = Http::withToken($token)->post($url, [
        'template_name' => $template_name,
        'template_language' => $language_code,
        'phone_number' => '+91' . $phone_number,
    ]);

    // Handle the response
    if ($response->successful()) {
        return $response->json();
    } else {
        return $response->status();
    }
}

function sendParameterTemplateWawi($template_name, $language_code, $phone_number, $parameters)
{
    $url = config('app.wawi_url') . '/messages/template';
    $token = config('app.wawi_token');
    $data = [
        'template_name' => $template_name,
        'template_language' => $language_code,
        'phone_number' => '+91' . $phone_number,
    ];

    foreach ($parameters as $key => $value) {
        $data['field_' . $key + 1] = $value;
    }

    $response = Http::withToken($token)->post($url, [
        'template_name' => $template_name,
        'template_language' => $language_code,
        'phone_number' => '+91' . $phone_number,
    ]);

    // Handle the response
    if ($response->successful()) {
        return $response->json();
    } else {
        return $response->status();
    }
}
