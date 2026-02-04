<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderItems;

class SyncGSTCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-g-s-t-command';

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
        $order_items = OrderItems::all();
        foreach ($order_items as $item) {
            if ($gst > 0) {
                $item->gst = $gst;
                $total = (float) $item->total;
                $gst_amount = $total - ($total * 100) / (100 + $gst);
                $item->update([
                    'gst' => $gst,
                    'gst_amount' => round($gstAmount, 2), // Round to 2 decimal places
                ]);
            }
        }
    }
}
