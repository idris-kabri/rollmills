<?php

use Illuminate\Support\Facades\Http;

function messageSend($mobile,$otp,$template_name)
{
    try {
        $token = 'EAAWBZAOKnVrMBQMBZCU8kWa8fXMZADlKZAE9euLlFQuxkWhA92Q4ZBtmg9CYJAnMmQFgC19Dg81TK8cC7F63KLif27C2C1jx9zYWNIX3FseLhShZCWBgZBGSFTcLRbiKVudbtZBhk4SN8SjX9ZBOSv58V5yitVJ3gzPuZBmiZCmcXUJZBpgCIIja8tpvNm12eGklREFPQQZDZD';
        $phoneNumberId = '882451871618236';
        $apiVersion = 'v20.0';

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
                        'parameters' => [
                            ['type' => 'text', 'text' => (string) $otp]
                        ],
                    ],
                    [
                        'type' => 'button',
                        'sub_type' => 'url',
                        'index' => '0',
                        'parameters' => [
                            ['type' => 'text', 'text' => (string) $otp]
                        ],
                    ],
                ],
            ],
        ];


        $response = Http::withToken($token)->post($url, $payload);
        if ($response->successful()) {
            return true;
        } else {
            \Log::warning('failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return false;
        }
    } catch (\Exception $e) {
        \Log::error('WhatsApp exception: ' . $e->getMessage());
        return false;
    }
} 
