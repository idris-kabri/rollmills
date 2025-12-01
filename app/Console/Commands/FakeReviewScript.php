<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FakeReviewScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fake-review-script';

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
        $user = User::where('is_fake', 1)->inRandomOrder()->get();
    }
}
