<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\PageSection;
use App\Models\SectionItem;
use Illuminate\Database\Seeder;

class TentangPageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure the "Tentang" page exists
        $page = Page::firstOrCreate(
        ['slug' => 'tentang'],
        ['title' => 'Tentang Kami', 'is_active' => true]
        );

        // Update title if page already existed
        $page->update(['title' => 'Tentang Kami']);

        // 2. Clear existing sections on this page (optional — prevents duplicates on re-seed)
        $page->sections()->delete();

        // 3. Add Breadcrumb section
        PageSection::create([
            'page_id' => $page->id,
            'section_name' => 'Breadcrumb Tentang',
            'type' => 'breadcrumb',
            'title' => 'Tentang Kami',
            'order' => 1,
            'is_active' => true,
        ]);

        // 4. Add Sejarah (History) section with timeline items
        $sejarahSection = PageSection::create([
            'page_id' => $page->id,
            'section_name' => 'Sejarah Pesantren Mahasiswa An-Nur',
            'type' => 'sejarah',
            'title' => 'Jejak Langkah <span class="theme-gradient">Pesantren Mahasiswa An-Nur</span>',
            'subtitle' => 'Sejarah Kami',
            'content' => 'Pesantren Mahasiswa An-Nur, atau yang lebih dikenal dengan sebutan Pesma An-Nur, merupakan lembaga pendidikan yang lahir dari visi besar Prof. Dr. KH. Imam Ghazali Said, M.A.',
            'order' => 2,
            'is_active' => true,
        ]);

        // 5. Create Section Items (timeline entries)
        $items = [
            [
                'title' => 'Sejarah Kami',
                'subtitle' => 'Awal Mula',
                'icon' => 'feather-book-open',
                'content' => '<p>Pesantren Mahasiswa An-Nur, atau yang lebih dikenal dengan sebutan Pesma An-Nur, merupakan lembaga pendidikan yang lahir dari visi besar Prof. Dr. KH. Imam Ghazali Said, M.A. Beliau mencita-citakan berdirinya sebuah institusi yang mampu mengintegrasikan sistem pendidikan tradisional khas pesantren dengan keilmuan akademik modern yang ada di sekolah-sekolah formal dan perguruan tinggi.</p><p>Gagasan ini mendapatkan dukungan penuh dari keluarga besar H.M. Noer. Dukungan tersebut diwujudkan secara konkret melalui pemberian sebidang tanah yang berlokasi di Wonocolo Gang Modin, Surabaya, sebagai titik awal pembangunan fisik pesantren.</p>',
                'order' => 1,
            ],
            [
                'title' => 'Legalitas dan Ikrar Wakaf',
                'subtitle' => '21 Agustus 1994',
                'icon' => 'feather-file-text',
                'content' => '<p>Pada mulanya, lahan awal pesantren merupakan hibah dari H.M. Noer kepada istrinya, Nikmah Noer, S.H. Atas usulan rasional dari KH. Imam Ghazali Said dan diperkuat oleh persetujuan mufakat dari seluruh keluarga, tanah tersebut dialihkan statusnya menjadi tanah wakaf yang diperuntukkan bagi Yayasan Pesantren Mahasiswa An-Nur.</p><p>Ikrar wakaf ini diresmikan pada 14 Rabiul Awal 1415 H atau bertepatan dengan 21 Agustus 1994. Prosesi hukum ini mencatatkan tanah hak milik atas nama H.M. Noer dan Nikmah Noer secara resmi menjadi wakaf yayasan. Penyerahan ini disaksikan langsung oleh para tokoh masyarakat Wonocolo serta sivitas akademika setempat. Saat ini, legalitas tanah tersebut telah dilindungi dengan sertifikat wakaf resmi yang dikeluarkan oleh Badan Pertanahan Nasional (BPN) Surabaya.</p>',
                'order' => 2,
            ],
            [
                'title' => 'Fase Pembangunan dan Peresmian Institusi',
                'subtitle' => '21 Agustus 1994',
                'icon' => 'feather-home',
                'content' => '<p>Pembangunan fisik Pesma An-Nur tahap pertama direalisasikan dengan mengandalkan kontribusi pendanaan utama dari H.M. Noer, berdampingan dengan dana swadaya masyarakat yang dikelola secara kolektif oleh panitia pembangunan.</p><p>Kegiatan belajar mengajar (pengajian kitab) secara definitif telah dimulai sejak 1 September 1994. Namun, peresmian institusi secara seremonial baru diselenggarakan satu tahun kemudian, yakni pada 21 Agustus 1995 (24 Rabiul Awal 1416 H). Peresmian ini ditandai dengan penyelenggaraan seminar bertajuk "Pesantren Mahasiswa Sebagai Alternatif Pengembangan Pemikiran Islam di Indonesia" serta penandatanganan prasasti oleh KH. Abdurrahman Wahid, yang saat itu menjabat sebagai Ketua Umum PBNU. Momen peresmian inilah yang kemudian ditetapkan secara resmi sebagai hari lahir (Harlah) Pesma An-Nur.</p>',
                'order' => 3,
            ],
            [
                'title' => 'Ekspansi dan Dinamika Akademik',
                'subtitle' => '1997 - Sekarang',
                'icon' => 'feather-trending-up',
                'content' => '<p>Merespons tingginya animo mahasiswa untuk memadukan studi kampus dan keilmuan pesantren, pengasuh dan yayasan melakukan pembebasan lahan tambahan pada tahun 1997. Lahan baru seluas kurang lebih 1.000 meter persegi di sebelah timur bangunan utama ini difungsikan untuk perluasan pembangunan fisik tahap kedua.</p><p>Pada awal dekade pertumbuhannya (sekitar tahun 1999-2000), Pesma An-Nur telah menjadi tempat bernaung bagi para santri mahasiswa dari berbagai perguruan tinggi di Surabaya, termasuk IAIN (kini UINSA), UNAIR, ITS, UBHARA, AWS, dan UNSURI. Untuk menjaga standar mutu pendidikan klasik, para santri dikelompokkan ke dalam empat jenjang kelas (Mustawa): Awal, Tsani, Tsalits, dan Rabi\', yang ditentukan melalui tes potensi akademik dan kemampuan dasar.</p><p>Seiring dengan kematangan manajerial, kelengkapan sarana fisik, serta menetapnya pengasuh di lokasi pesantren, Pesma An-Nur yang pada awalnya beroperasi khusus untuk santri putra akhirnya berekspansi dengan membuka penerimaan santri putri pada periode 2001-2002. Kebijakan ini merupakan langkah progresif sekaligus respons atas tuntutan masyarakat dan ulama agar pendidikan pesantren tingkat mahasiswa memberikan porsi dan akses yang setara bagi para mahasiswi.</p>',
                'order' => 4,
            ],
        ];

        foreach ($items as $item) {
            SectionItem::create(array_merge($item, [
                'page_section_id' => $sejarahSection->id,
                'is_active' => true,
            ]));
        }
    }
}
