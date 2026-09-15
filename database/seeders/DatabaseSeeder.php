<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Program;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Panggil Pengaturan Global Dasar
        $this->call(SettingSeeder::class);

        // 2. Buat Akun Sistem Inti
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@pesma.net',
            'role' => 'admin',
        ]);

        // 3. Eksekusi Dummy Data Lanjutan
        // Program::factory(4)->create();
        // Post::factory(10)->create();
    }
}
