<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Pesma An-Nur', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+62 812 3456 7890', 'type' => 'text'],
            ['key' => 'logo_header', 'value' => 'logos/logo-header.png', 'type' => 'image'],
            ['key' => 'logo_footer', 'value' => 'logos/logo-footer.png', 'type' => 'image'],
            ['key' => 'address', 'value' => 'Jl. Pesantren No.1, Kota Santri', 'type' => 'text'],
        ];

        Setting::insert($settings);
    }
}
