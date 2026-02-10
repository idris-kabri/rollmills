<?php

namespace App\Console\Commands;

use App\Models\AbendedCartMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Exception;

class SendMessageCommand extends Command
{
    protected $signature = 'app:send-message-command';
    protected $description = 'Send sequential abandoned cart messages (Hour Based)';

    public function handle()
    {
        Log::info('Abandoned Cart Drip Command Started.');

        // 1. SCHEDULE (IN HOURS)
        $schedule = [
            1 => 4, // 4 Hours
            2 => 72, // 3 Days
            3 => 168, // 7 Days
            4 => 360, // 15 Days
            5 => 576, // 24 Days
            6 => 720, // 30 Days
        ];

        // 2. FETCH CARTS
        $startWindow = now()->subDays(35);
        $endWindow = now()->subHours(4);

        try {
            DB::table('shoppingcart')
                ->where('instance', 'cart')
                ->whereBetween('created_at', [$startWindow, $endWindow])
                ->orderBy('created_at', 'desc')
                ->chunk(50, function ($shoppingCarts) use ($schedule) {
                    foreach ($shoppingCarts as $cart) {
                        try {
                            $user = User::where('mobile', $cart->identifier)->first();
                            $order = Order::where('is_logged_in_user', $user->id)
                                ->whereNotIn('status', [0, 4])
                                ->first();
                            if ($order) {
                                continue;
                            }
                            $cartDate = Carbon::parse($cart->created_at);
                            $phone = preg_replace('/[^0-9]/', '', $cart->identifier);

                            if (strlen($phone) < 10) {
                                continue;
                            }

                            // 3. DETERMINE STEP
                            $messagesSentCount = AbendedCartMessage::where('mobile_number', $cart->identifier)->where('created_at', '>=', $cartDate)->count();

                            $nextStep = $messagesSentCount + 1;

                            if ($nextStep > 6) {
                                continue;
                            }

                            // 4. FIX: CALCULATE POSITIVE AGE
                            // Swapped order: $cartDate->diff(now).
                            // Used floatDiffInHours to handle "4 hours 15 mins" correctly as "4.25"
                            $hoursPassed = $cartDate->floatDiffInHours(now());
                            $requiredHours = $schedule[$nextStep];

                            // Check: if 4.26 hours passed, and we need 4.
                            // 4.26 < 4 is FALSE. So we proceed to send.
                            Log::error("Hours Passed: {$hoursPassed}, Required: {$requiredHours}");
                            if ($hoursPassed < $requiredHours) {
                                // Log::info("Skipping {$cart->identifier}: Requires {$requiredHours}h, passed {$hoursPassed}h");
                                continue;
                            }

                            // 5. SEND MESSAGE
                            $formattedPhone = $phone;
                            $templateName = 'abandoned_cart_1';

                            $response = sendNormalTemplateWawi($templateName, 'en_US', $formattedPhone);

                            if ($response) {
                                $store = new AbendedCartMessage();
                                $store->mobile_number = $cart->identifier;
                                $store->send_at = now();
                                $store->save();

                                Log::info("Step {$nextStep} Sent to {$formattedPhone}. (Age: {$hoursPassed} hours)");
                            }
                        } catch (Exception $e) {
                            Log::error("Row Error {$cart->identifier}: " . $e->getMessage());
                        }
                    }
                });
        } catch (Exception $e) {
            Log::error('Command Error: ' . $e->getMessage());
        }

        Log::info('Command Finished.');
    }
}
