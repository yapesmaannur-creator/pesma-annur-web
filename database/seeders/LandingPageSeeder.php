<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $page = Page::where('slug', 'beranda')->first();

        if (!$page) {
            $page = Page::create([
                'title' => 'Beranda',
                'slug' => 'beranda',
                'meta_title' => 'Home - Pesantren Mahasiswa An-Nur',
                'meta_description' => 'Website resmi Pesantren Mahasiswa An-Nur.',
                'is_active' => true,
            ]);
        }

        // Cleanup existing sections for this page to prevent duplicates when re-seeding
        $page->sections()->delete();

        // 1. Hero Section
        $hero = $page->sections()->create([
            'section_name' => 'Hero Banner',
            'type' => 'hero',
            'order' => 1,
            'is_active' => true,
            'title' => 'Guided By The Quran <img src="'.asset('frontend/assets/images/shape/i-text-book.png').'" alt="Banner Text"> And Sunnah',
            'subtitle' => '<img src="'.asset('frontend/assets/images/shape/i-graduation.png').'" alt="Banner Icon"> Learn Quran For Peace',
            'content' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. <span class="bold">Velit officia consequat.</span>',
        ]);

        $hero->items()->create([
            'title' => 'Daftar Sekarang',
            'url' => '#',
            'order' => 1
        ]);
        $hero->items()->create([
            'title' => 'Login Santri',
            'url' => '#',
            'icon' => 'outline',
            'order' => 2
        ]);

        // 2. Features Section
        $features = $page->sections()->create([
            'section_name' => 'Keunggulan Kami',
            'type' => 'features',
            'order' => 2,
            'is_active' => true,
            'title' => 'Kenapa Memilih Kami',
            'subtitle' => 'Fasilitas & Keunggulan',
        ]);

        $featuresItems = [
            ['title' => 'Asrama Representatif & Kondusif', 'description' => 'Fasilitas hunian modern yang tenang dan nyaman, dirancang khusus untuk mendukung iklim akademik dan fokus perkuliahan mahasantri.', 'icon' => 'feather-home'],
            ['title' => 'Integrasi Keilmuan Kampus & Pesantren', 'description' => 'Memadukan tradisi keilmuan klasik (turats) dengan dinamika intelektual dunia kampus untuk mencetak sarjana yang tafaqquh fiddin.', 'icon' => 'feather-book-open'],
            ['title' => 'Asatidz & Akademisi Mumpuni', 'description' => 'Dibimbing langsung oleh tenaga pengajar, cendekiawan, dan pakar yang memiliki otoritas keilmuan mendalam di bidang keislaman.', 'icon' => 'feather-users'],
            ['title' => 'Tradisi Riset & Literasi', 'description' => 'Menghidupkan budaya diskusi, kajian pemikiran Islam, serta penguasaan bahasa Arab sebagai fondasi kecendekiawanan.', 'icon' => 'feather-edit-3'],
            ['title' => 'Sistem Layanan Digital Terpadu', 'description' => 'Kemudahan akses informasi akademik, administrasi keuangan, hingga portal mahasantri yang transparan dan dapat diakses secara online.', 'icon' => 'feather-monitor'],
            ['title' => 'Kepemimpinan & Kemandirian', 'description' => 'Program pembinaan karakter dan soft-skill yang adaptif untuk mempersiapkan profesional muslim yang tangguh di masa depan.', 'icon' => 'feather-award'],
        ];

        foreach ($featuresItems as $index => $item) {
            $features->items()->create([
                'title' => $item['title'],
                'description' => $item['description'],
                'icon' => $item['icon'],
                'order' => $index + 1,
            ]);
        }

        // 3. About Section
        $about = $page->sections()->create([
            'section_name' => 'Tentang Kami',
            'type' => 'about',
            'order' => 3,
            'is_active' => true,
            'title' => 'Mengenal <span class="theme-gradient">Pesantren An-Nur</span> Lebih Dekat',
            'subtitle' => 'TENTANG KAMI',
            'content' => 'Pesantren Mahasiswa An-Nur berkomitmen mencetak generasi yang tidak hanya unggul dalam akademik, tetapi juga memiliki kedalaman spiritual dan akhlak yang mulia.',
        ]);

        $aboutList = ['Kelas Fleksibel', 'Pembelajaran Online/Offline', 'Biaya Terjangkau', 'Pendaftaran Mudah'];
        foreach ($aboutList as $index => $item) {
            $about->items()->create([
                'title' => $item,
                'icon' => $index % 2 == 0 ? 'feather-check' : 'feather-star',
                'order' => $index + 1,
            ]);
        }

        // 4. Programs Section
        $programs = $page->sections()->create([
            'section_name' => 'Program Unggulan',
            'type' => 'programs',
            'order' => 4,
            'is_active' => true,
            'title' => 'Program Pembinaan Kami',
            'subtitle' => 'PROGRAM PEMBINAAN',
        ]);

        $programs->items()->create([
            'title' => 'Lihat Semua Program',
            'url' => '/program',
            'order' => 1
        ]);

        $defaultPrograms = [
            [
                'title' => 'Kajian Turats & Kontemporer',
                'description' => 'Bimbingan rutin kajian kitab klasik (turats), isu-isu Islam kontemporer, fiqih, aqidah, dan pemikiran keislaman modern.',
                'icon' => 'solar:book-2-bold-duotone',
            ],
            [
                'title' => 'Mentoring & Tarbiyah',
                'description' => 'Pendampingan personal spiritual, pembentukan karakter mahasantri (character building), dan pembinaan akhlak.',
                'icon' => 'solar:users-group-two-rounded-bold-duotone',
            ],
            [
                'title' => 'Intensif Bahasa Asing (Inggris & Arab)',
                'description' => 'Program akselerasi penguasaan bahasa Inggris (TOEFL/IELTS/Speaking) dan bahasa Arab akademik & komunikasi.',
                'icon' => 'solar:letter-bold-duotone',
            ],
            [
                'title' => 'Prestasi & Pengembangan Diri',
                'description' => 'Bimbingan prestasi akademik, pengembangan minat bakat, dan optimasi potensi diri mahasantri secara seimbang.',
                'icon' => 'solar:medal-star-bold-duotone',
            ],
            [
                'title' => 'Leadership & Soft-Skills',
                'description' => 'Pelatihan kepemimpinan, public speaking, keorganisasian, manajemen waktu, dan kesiapan karir mahasantri.',
                'icon' => 'solar:target-bold-duotone',
            ],
            [
                'title' => 'Sosial & Pengabdian Masyarakat',
                'description' => 'Program sosial, bakti masyarakat, tanggap bencana, dan aksi kepedulian terhadap sesama berbasis kemahasiswaan.',
                'icon' => 'solar:hand-stars-bold-duotone',
            ],
        ];

        foreach ($defaultPrograms as $pData) {
            \App\Models\Program::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($pData['title'])],
                [
                    'title' => $pData['title'],
                    'description' => $pData['description'],
                    'icon' => $pData['icon'],
                    'is_active' => true,
                ]
            );
        }

        // 5. Testimonial Section
        $testimonial = $page->sections()->create([
            'section_name' => 'Testimoni Santri',
            'type' => 'testimonial',
            'order' => 5,
            'is_active' => true,
            'title' => 'Apa Kata <span class="theme-gradient">Mereka?</span>',
            'subtitle' => 'TESTIMONIAL',
        ]);

        // 6. Articles Section
        $articles = $page->sections()->create([
            'section_name' => 'Berita & Artikel',
            'type' => 'articles',
            'order' => 6,
            'is_active' => true,
            'title' => 'Kabar Terbaru Dari <span class="theme-gradient">Pesantren</span>',
            'subtitle' => 'BERITA & ARTIKEL',
        ]);

        // 7. Team Section
        $team = $page->sections()->create([
            'section_name' => 'Pendidik & Staff',
            'type' => 'team',
            'order' => 7,
            'is_active' => true,
            'title' => 'Pengajar & Spesialis Kami',
            'subtitle' => 'TIM KAMI',
        ]);

        $teamItems = [
            ['title' => 'Ustadz Ahmad', 'description' => 'Kepala Kepesantrenan'],
            ['title' => 'Budi Santoso', 'description' => 'Kepala Asrama'],
            ['title' => 'Siti Aminah', 'description' => 'Koordinator Kegiatan'],
            ['title' => 'Wahyu Hidayat', 'description' => 'Pengajar Bahasa Arab'],
        ];

        foreach ($teamItems as $index => $item) {
            $team->items()->create([
                'title' => $item['title'],
                'description' => $item['description'],
                'order' => $index + 1,
            ]);
        }

        // 8. FAQ Section
        $faq = $page->sections()->create([
            'section_name' => 'FAQ',
            'type' => 'faq',
            'order' => 8,
            'is_active' => true,
            'title' => 'Pertanyaan Seputar <span class="theme-gradient">Pendaftaran</span>',
            'subtitle' => 'FAQ',
        ]);
        // Halaman Tentang
        $pageTentang = Page::firstOrCreate(['slug' => 'tentang'], [
            'title' => 'Tentang', 'meta_title' => 'Tentang Kami - Pesantren Mahasiswa An-Nur', 'is_active' => true
        ]);
        $pageTentang->sections()->delete();
        $pageTentang->sections()->create(['section_name' => 'Breadcrumb', 'type' => 'breadcrumb', 'order' => 1, 'is_active' => true]);
        $aboutTentang = $pageTentang->sections()->create(['section_name' => 'Tentang Kami', 'type' => 'about', 'order' => 2, 'is_active' => true, 'title' => 'Profil Singkat', 'subtitle' => 'TENTANG KAMI']);
        foreach (['Berbasis Pesantren Modern', 'Pendidikan Karakter', 'Kurikulum Terpadu'] as $index => $item) {
            $aboutTentang->items()->create(['title' => $item, 'icon' => 'feather-check', 'order' => $index + 1]);
        }
        $teamTentang = $pageTentang->sections()->create(['section_name' => 'Pengurus', 'type' => 'team', 'order' => 3, 'is_active' => true, 'title' => 'Jajaran Pengurus', 'subtitle' => 'TIM KAMI']);
        foreach ([['title' => 'Pengasuh', 'description' => 'Dr. KH.'], ['title' => 'Ketua Yayasan', 'description' => 'H. ']] as $index => $item) {
            $teamTentang->items()->create(['title' => $item['title'], 'description' => $item['description'], 'order' => $index + 1]);
        }

        // Halaman Program
        $pageProgram = Page::firstOrCreate(['slug' => 'program'], [
            'title' => 'Program', 'meta_title' => 'Program - Pesantren Mahasiswa An-Nur', 'is_active' => true
        ]);
        $pageProgram->sections()->delete();
        $pageProgram->sections()->create(['section_name' => 'Breadcrumb', 'type' => 'breadcrumb', 'order' => 1, 'is_active' => true]);
        $pageProgram->sections()->create(['section_name' => 'Daftar Program', 'type' => 'programs', 'order' => 2, 'is_active' => true, 'title' => 'Program Pilihan', 'subtitle' => 'PROGRAM KAMI']);

        // Halaman Kegiatan
        $pageKegiatan = Page::firstOrCreate(['slug' => 'kegiatan'], [
            'title' => 'Kegiatan', 'meta_title' => 'Kegiatan - Pesantren Mahasiswa An-Nur', 'is_active' => true
        ]);
        $pageKegiatan->sections()->delete();
        $pageKegiatan->sections()->create(['section_name' => 'Breadcrumb', 'type' => 'breadcrumb', 'order' => 1, 'is_active' => true]);
        $pageKegiatan->sections()->create(['section_name' => 'Daftar Kegiatan', 'type' => 'activities', 'order' => 2, 'is_active' => true, 'title' => 'Agenda Pesantren', 'subtitle' => 'KEGIATAN']);

        // Halaman Galeri
        $pageGaleri = Page::firstOrCreate(['slug' => 'galeri'], [
            'title' => 'Galeri', 'meta_title' => 'Galeri - Pesantren Mahasiswa An-Nur', 'is_active' => true
        ]);
        $pageGaleri->sections()->delete();
        $pageGaleri->sections()->create(['section_name' => 'Breadcrumb', 'type' => 'breadcrumb', 'order' => 1, 'is_active' => true]);
        $pageGaleri->sections()->create(['section_name' => 'Album Galeri', 'type' => 'gallery', 'order' => 2, 'is_active' => true, 'title' => 'Dokumentasi', 'subtitle' => 'GALERI']);

        // Halaman Artikel
        $pageArtikel = Page::firstOrCreate(['slug' => 'artikel'], [
            'title' => 'Artikel', 'meta_title' => 'Artikel - Pesantren Mahasiswa An-Nur', 'is_active' => true
        ]);
        $pageArtikel->sections()->delete();
        $pageArtikel->sections()->create(['section_name' => 'Breadcrumb', 'type' => 'breadcrumb', 'order' => 1, 'is_active' => true]);
        $pageArtikel->sections()->create(['section_name' => 'Daftar Artikel', 'type' => 'articles', 'order' => 2, 'is_active' => true, 'title' => 'Tulisan Terbaru', 'subtitle' => 'ARTIKEL']);

        // Halaman FAQ
        $pageFaq = Page::firstOrCreate(['slug' => 'faq'], [
            'title' => 'FAQ', 'meta_title' => 'FAQ - Pesantren Mahasiswa An-Nur', 'is_active' => true
        ]);
        $pageFaq->sections()->delete();
        $pageFaq->sections()->create(['section_name' => 'Breadcrumb', 'type' => 'breadcrumb', 'order' => 1, 'is_active' => true]);
        $pageFaq->sections()->create(['section_name' => 'Daftar Pertanyaan', 'type' => 'faq', 'order' => 2, 'is_active' => true, 'title' => 'Pertanyaan Umum', 'subtitle' => 'FAQ']);

        // Halaman Kontak
        $pageKontak = Page::firstOrCreate(['slug' => 'kontak'], [
            'title' => 'Kontak', 'meta_title' => 'Kontak - Pesantren Mahasiswa An-Nur', 'is_active' => true
        ]);
        $pageKontak->sections()->delete();
        $pageKontak->sections()->create(['section_name' => 'Breadcrumb', 'type' => 'breadcrumb', 'order' => 1, 'is_active' => true]);
        $pageKontak->sections()->create(['section_name' => 'Form Kontak', 'type' => 'contact', 'order' => 2, 'is_active' => true, 'title' => 'Kirim Pesan', 'subtitle' => 'KONTAK KAMI']);
    }
}
