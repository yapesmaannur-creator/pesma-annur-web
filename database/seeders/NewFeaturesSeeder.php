<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\Page;

class NewFeaturesSeeder extends Seeder
{
    public function run(): void
    {
        // ===== Settings for New Features =====
        $settings = [
            // CTA Header Button
            ['key' => 'cta_header_url', 'value' => 'https://e-maktab.pesma-annur.net/psb', 'type' => 'text'],
            ['key' => 'cta_header_text', 'value' => 'Daftar Sekarang', 'type' => 'text'],
            // WhatsApp Floating Button
            ['key' => 'whatsapp_number', 'value' => '6281234567890', 'type' => 'text'],
            ['key' => 'whatsapp_message', 'value' => 'Assalamu\'alaikum, saya ingin bertanya tentang Pesma An-Nur', 'type' => 'text'],
            // Google Analytics
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'text'],
            // Default OG Image
            ['key' => 'og_default_image', 'value' => '', 'type' => 'image'],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'type' => $setting['type']]
            );
        }

        // ===== Counter Section on Beranda =====
        $page = Page::where('slug', 'beranda')->first();
        if ($page) {
            // Check if counter section already exists
            $existingCounter = $page->sections()->where('type', 'counter')->first();
            if (!$existingCounter) {
                $counter = $page->sections()->create([
                    'section_name' => 'Statistik Pesantren',
                    'type' => 'counter',
                    'order' => 3, // After features
                    'is_active' => true,
                    'title' => 'Pesantren Dalam <span class="theme-gradient">Angka</span>',
                    'subtitle' => 'STATISTIK KAMI',
                ]);

                $counterItems = [
                    ['title' => 'Santri Aktif', 'description' => '250+', 'icon' => 'feather-users', 'order' => 1],
                    ['title' => 'Alumni', 'description' => '1000+', 'icon' => 'feather-award', 'order' => 2],
                    ['title' => 'Tahun Berdiri', 'description' => '15+', 'icon' => 'feather-calendar', 'order' => 3],
                    ['title' => 'Pengajar', 'description' => '20+', 'icon' => 'feather-book-open', 'order' => 4],
                ];

                foreach ($counterItems as $item) {
                    $counter->items()->create($item);
                }
            }
        }
    }
}
