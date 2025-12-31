<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Address;

class UserAddressDefailFeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-address-defail-feed-command';

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
        $users = User::where('name', null)->get();
        foreach ($users as $user) {
            $address = Address::where('user_id', $user->id)->first();
            if ($address) {
                $user->name = $address->name;
                $user->email = $address->email;
                $user->save();
            }
        }
    }
}
