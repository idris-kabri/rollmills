<?php

namespace App\Console\Commands;

use App\Models\AbendedCartMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-message-command';

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
        try {
            $shoppingCarts = DB::table('shoppingcart')
                ->where('instance', 'cart')
                ->where('created_at', '<=', now()->subHours(4))
                ->get();
            foreach ($shoppingCarts as $cart) {

                $check_condtion = AbendedCartMessage::where('mobile_number', $cart->identifier)->orderBy('id', 'desc')->first();
                if ($check_condtion && now()->diffInDays($check_condtion->created_at) <= 3) {
                    continue;
                }
                try {
                    $token = config('app.whatsapp_api_token');
                    $phoneNumberId = config('app.whatsapp_phone_number_id');
                    $apiVersion = config('app.whatsapp_api_version');

                    $phone = preg_replace('/[^0-9]/', '', $cart->identifier);
                    $formattedPhone = strlen($phone) == 10 ? '91' . $phone : $phone;

                    $url = "https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages";

                    $payload = [
                        'messaging_product' => 'whatsapp',
                        'to' => $formattedPhone,
                        'type' => 'template',
                        'template' => [
                            'name' => 'abandoned_cart_1',
                            'language' => ['code' => 'en_US'],
                        ],
                    ];

                    $response = Http::withToken($token)->post($url, $payload);

                    if ($response->successful()) {
                        $store = new AbendedCartMessage();
                        $store->mobile_number = $cart->identifier;
                        $store->send_at = now();
                        $store->save();
                        Log::info('Abandoned cart message sent', [
                            'mobile' => $cart->identifier,
                        ]);
                    } else {
                        Log::warning('Failed sending WhatsApp message', [
                            'body' => $response->body(),
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error('WhatsApp exception: ' . $e->getMessage());
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
