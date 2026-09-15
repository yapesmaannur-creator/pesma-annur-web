<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        if (!Menu::where('location', 'header')->exists()) {
            $m = Menu::create(['name' => 'Menu Utama', 'location' => 'header']);
            $m->items()->createMany([
                ['title' => 'Beranda', 'url' => '/', 'order' => 0],
                ['title' => 'Artikel', 'url' => '/artikel', 'order' => 1],
                ['title' => 'Produk', 'url' => '/shop', 'order' => 2],
                ['title' => 'Kontak', 'url' => '/kontak', 'order' => 3]
            ]);
        }
    }
}
