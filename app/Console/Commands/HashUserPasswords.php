<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HashUserPasswords extends Command
{
    protected $signature = 'users:hash-passwords';
    protected $description = 'Hash all user passwords with Bcrypt if not already hashed';

    public function handle()
    {
        $batchSize = 50;
        $count = 0;

        User::chunk($batchSize, function ($users) use (&$count) {
            foreach ($users as $user) {
                // Check if password is already hashed (starts with $2y$ for Bcrypt)
                if (!str_starts_with($user->password, '$2y$')) {
                    $user->password = Hash::make($user->password);
                    $user->save();
                    $count++;
                }
            }
        });

        $this->info("Hashed passwords for {$count} users.");
        return 0;
    }
}
