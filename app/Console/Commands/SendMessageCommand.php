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
    protected $description = 'Send sequential abandoned cart messages (4h, 3d, 7d, 15d, 24d, 30d)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Abandoned Cart Drip Command Started.');

        $schedule = [
            1 => 4, // 4 Hours
            2 => 24 * 3, // 3 Days (72 hours)
            3 => 24 * 7, // 7 Days
            4 => 24 * 15, // 15 Days
            5 => 24 * 24, // 24 Days
            6 => 24 * 30, // 30 Days
        ];

        $startWindow = now()->subDays(35);
        $endWindow = now()->subHours(4);

        try {
            DB::table('shoppingcart')
                ->where('instance', 'cart')
                ->whereBetween('created_at', [$startWindow, $endWindow])
                ->orderBy('created_at', 'desc') // Process newest first
                ->chunk(50, function ($shoppingCarts) use ($schedule) {
                    foreach ($shoppingCarts as $cart) {
                        try {
                            $cartDate = Carbon::parse($cart->created_at);
                            $phone = preg_replace('/[^0-9]/', '', $cart->identifier);

                            // Validation: Skip invalid numbers
                            if (strlen($phone) < 10) {
                                continue;
                            }
                            $messagesSentCount = AbendedCartMessage::where('mobile_number', $cart->identifier)->where('created_at', '>=', $cartDate)->count();

                            $nextStep = $messagesSentCount + 1;

                            if ($nextStep > 6) {
                                continue;
                            }

                            $hoursSinceCartCreated = now()->diffInHours($cartDate);
                            $requiredHours = $schedule[$nextStep];

                            if ($hoursSinceCartCreated < $requiredHours) {
                                continue;
                            }

                            $formattedPhone = strlen($phone) == 10 ? '91' . $phone : $phone;
                            $templateName = 'abandoned_cart_1';
                            sendNormalTemplateWawi($templateName, 'en_US', $formattedPhone);

                            $store = new AbendedCartMessage();
                            $store->mobile_number = $cart->identifier;
                            $store->send_at = now();
                            $store->save();

                            Log::info("Step {$nextStep} sent to {$formattedPhone} (Cart Age: {$hoursSinceCartCreated} hours)");
                        } catch (Exception $e) {
                            Log::error("Error processing cart {$cart->identifier}: " . $e->getMessage());
                        }
                    }
                });
        } catch (Exception $e) {
            Log::error('Critical Error in Abandoned Cart Command: ' . $e->getMessage());
        }

        Log::info('Abandoned Cart Drip Command Finished.');
    }
}
