<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HashAdminPasswords extends Command
{
    protected $signature = 'admin:hash-passwords';

    protected $description = 'Hash all unhashed admin passwords in the database';

    public function handle()
    {
        $admins = DB::table('admins')->get();

        foreach ($admins as $admin) {
            try {
                $this->info("Processing admin ID {$admin->id}"); // Removed password from log
                // Force hash all passwords regardless of length
                $hashed = Hash::make($admin->password);
                DB::table('admins')->where('id', $admin->id)->update(['password' => $hashed]);
                $this->info("Hashed password for admin ID {$admin->id}");
            } catch (\Exception $e) {
                $this->error("Error hashing password for admin ID {$admin->id}: " . $e->getMessage());
            }
        }

        $this->info('Admin password hashing complete.');
    }
}
