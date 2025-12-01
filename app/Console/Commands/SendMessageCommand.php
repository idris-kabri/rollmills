<?php

namespace App\Console\Commands;

use App\Models\AbendedCartMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        $shoppingCarts = DB::table('shoppingcart')->where('instance', 'cart')->where('created_at', '<=', now()->subHours(24))->get();
        foreach ($shoppingCarts as $cart) {

            if (!$cart->created_at) {
                continue;
            }

            $check_condtion = AbendedCartMessage::where('mobile_number', $cart->identifier)->orderBy("id","desc")->first();
            if($check_condtion && now()->diffInDays($check_condtion->send_at) <= 3){
                continue;
            }

            $store = new AbendedCartMessage;
            $store->mobile_number = $cart->identifier;
            $store->send_at = now();
            $store->save();
        }
    }
}