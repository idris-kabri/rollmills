<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class SyncIthinkRemittanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-ithink-remittance-command';

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
        $order = Order::first();
        if (!$order) {
            $this->error('No orders found.');
            return;
        }

        $startDate = Carbon::parse($order->created_at);
        $today = Carbon::now();
        $days = $startDate->diffInDays($today);

        for ($i = 0; $i <= $days; $i++) {
            $date = $startDate->copy()->addDays($i)->format('Y-m-d');
            IthinkRemittanceSync($date);
        }
    }
}
