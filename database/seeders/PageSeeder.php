<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            ['title' => 'Beranda', 'slug' => 'beranda'],
            ['title' => 'Tentang', 'slug' => 'tentang'],
            ['title' => 'Program', 'slug' => 'program'],
            ['title' => 'Kegiatan', 'slug' => 'kegiatan'],
            ['title' => 'Galeri', 'slug' => 'galeri'],
            ['title' => 'Artikel', 'slug' => 'artikel'],
            ['title' => 'FAQ', 'slug' => 'faq'],
            ['title' => 'Kontak', 'slug' => 'kontak'],
        ];

        foreach ($pages as $page) {
            \App\Models\Page::firstOrCreate(
                ['slug' => $page['slug']],
                ['title' => $page['title'], 'is_active' => true]
            );
        }
    }
}
