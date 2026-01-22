<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class ContactSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:contact-sync-command';

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
        $users = User::where('role', '!=', 'admin')->get();
        foreach ($users as $user) {
            wawiContact($user);
        }
    }
}
