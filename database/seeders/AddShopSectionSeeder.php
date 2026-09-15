<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;
use App\Models\PageSection;

class AddShopSectionSeeder extends Seeder
{
    public function run(): void
    {
        $beranda = Page::where('slug', 'beranda')->first();
        if (!$beranda) {
            $this->command->error('Halaman Beranda tidak ditemukan!');
            return;
        }

        // Check if shop section already exists
        $existing = PageSection::where('page_id', $beranda->id)
            ->where('type', 'shop')
            ->first();

        if ($existing) {
            $this->command->info('Section Shop sudah ada di Beranda (ID: ' . $existing->id . ')');
            return;
        }

        // Get the current max order
        $maxOrder = PageSection::where('page_id', $beranda->id)->max('order') ?? 0;

        // Insert shop section before FAQ (order 7, FAQ is 8)
        // Bump FAQ order up
        PageSection::where('page_id', $beranda->id)
            ->where('order', '>=', 7)
            ->increment('order');

        PageSection::create([
            'page_id' => $beranda->id,
            'section_name' => 'Katalog Produk',
            'type' => 'shop',
            'title' => 'Koleksi <span class="theme-gradient">Produk & Layanan</span>',
            'subtitle' => 'PRODUK KAMI',
            'content' => null,
            'button_text' => 'Lihat Semua Produk',
            'button_url' => '/shop',
            'order' => 7,
            'is_active' => true,
        ]);

        $this->command->info('✓ Section Katalog Produk berhasil ditambahkan ke Beranda.');
    }
}
