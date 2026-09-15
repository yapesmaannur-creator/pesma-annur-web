<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class ResetAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::first();
        if ($admin) {
            $admin->password = bcrypt('password');
            $admin->save();
            $this->command->info('Password reset to "password" for: ' . $admin->email);
        } else {
            $this->command->error('No admin found');
        }
    }
}
