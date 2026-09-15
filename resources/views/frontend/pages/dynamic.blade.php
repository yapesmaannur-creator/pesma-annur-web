@extends('frontend.layouts.app')

@section('content')
    @if($page->sections->isEmpty())
        <div class="container py-5 my-5 text-center">
            <h3>Halaman ini belum memiliki konten HTML/Section.</h3>
            <p class="text-muted">Silahkan login ke Admin Panel dan tambahkan section untuk halaman ini.</p>
        </div>
    @endif

    @foreach($page->sections as $section)
        {{-- Skip team section - not representative --}}
        @if($section->type === 'team')
            @continue
        @endif
        @if(!empty($section->type) && view()->exists('frontend.sections.' . $section->type))
            @include('frontend.sections.' . $section->type, ['section' => $section])
        @else
            <!-- Partial for section type '{{ $section->type }}' not found. -->
            @if(config('app.debug'))
                <div class="container py-3">
                    <div class="alert alert-warning text-center">
                        Template Section <code>frontend.sections.{{ $section->type }}</code> belum dibuat oleh developer.
                    </div>
                </div>
            @endif
        @endif
    @endforeach

    @if(isset($page) && $page->slug === 'beranda')

        {{-- ===== JURNAL ILMIAH SECTION ===== --}}
        <style>
            .annur-jrnl-section {
                background: linear-gradient(135deg, #071526 0%, #0B1F3A 60%, #102A4C 100%);
                padding: 64px 0;
                position: relative;
                overflow: hidden;
            }
            .annur-jrnl-section::before {
                content: '';
                position: absolute;
                inset: 0;
                background-image: radial-gradient(circle at 24px 24px, rgba(255,255,255,0.04) 2px, transparent 2px);
                background-size: 48px 48px;
                pointer-events: none;
            }
            .annur-jrnl-header-eyebrow {
                display: inline-block;
                padding: 4px 18px;
                background: rgba(232,199,102,0.12);
                color: #E8C766;
                border: 1px solid rgba(232,199,102,0.35);
                border-radius: 50px;
                font-size: 11.5px;
                font-weight: 800;
                letter-spacing: 0.1em;
                margin-bottom: 14px;
            }
            .annur-jrnl-card {
                background: rgba(255,255,255,0.04);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 20px;
                padding: 28px;
                display: flex;
                align-items: stretch;
                gap: 24px;
                transition: all 0.35s ease;
                position: relative;
                z-index: 1;
            }
            .annur-jrnl-card:hover {
                background: rgba(255,255,255,0.07);
                border-color: rgba(232,199,102,0.35);
                transform: translateY(-4px);
                box-shadow: 0 16px 40px rgba(0,0,0,0.4);
            }
            .annur-jrnl-cover {
                width: 110px;
                min-width: 110px;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 8px 24px rgba(0,0,0,0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                background: rgba(0,0,0,0.3);
            }
            .annur-jrnl-cover img {
                width: 110px;
                height: 155px;
                object-fit: cover;
                display: block;
            }
            .annur-jrnl-cover-icon {
                width: 110px;
                min-width: 110px;
                height: 155px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: linear-gradient(135deg, #1a4d2e, #2d6a4f);
                border-radius: 12px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.5);
            }
            .annur-jrnl-info {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .annur-jrnl-tag {
                display: inline-block;
                padding: 2px 10px;
                background: rgba(232,199,102,0.12);
                color: #E8C766;
                border: 1px solid rgba(232,199,102,0.3);
                border-radius: 50px;
                font-size: 10.5px;
                font-weight: 700;
                letter-spacing: 0.06em;
                margin-bottom: 8px;
            }
            .annur-jrnl-name {
                font-size: 15.5px;
                font-weight: 800;
                color: #fff;
                line-height: 1.4;
                margin-bottom: 8px;
                letter-spacing: -0.01em;
            }
            .annur-jrnl-desc {
                font-size: 12.5px;
                color: rgba(255,255,255,0.62);
                line-height: 1.6;
                margin-bottom: 16px;
                flex-grow: 1;
            }
            .annur-jrnl-btns { display: flex; gap: 8px; flex-wrap: wrap; }
            .annur-jrnl-btn-primary {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 8px 18px; background: #E8C766; color: #071526 !important;
                font-size: 12.5px; font-weight: 700; border-radius: 50px;
                text-decoration: none; transition: all 0.25s ease;
            }
            .annur-jrnl-btn-primary:hover { background: #f0d47c; transform: translateY(-2px); box-shadow: 0 6px 16px rgba(232,199,102,0.35); }
            .annur-jrnl-btn-secondary {
                display: inline-flex; align-items: center; gap: 6px;
                padding: 8px 18px; background: rgba(255,255,255,0.08);
                color: rgba(255,255,255,0.85) !important; font-size: 12.5px; font-weight: 600;
                border-radius: 50px; border: 1px solid rgba(255,255,255,0.15);
                text-decoration: none; transition: all 0.25s ease;
            }
            .annur-jrnl-btn-secondary:hover { background: rgba(255,255,255,0.14); border-color: rgba(255,255,255,0.3); }
            @media (max-width: 576px) {
                .annur-jrnl-card { flex-direction: column; align-items: center; text-align: center; }
                .annur-jrnl-btns { justify-content: center; }
            }
        </style>

        <div class="annur-jrnl-section">
            <div class="container" style="position:relative; z-index:1;">
                <div class="text-center mb-5">
                    <span class="annur-jrnl-header-eyebrow">PUBLIKASI ILMIAH</span>
                    <h2 style="font-size:32px; font-weight:800; color:#fff; letter-spacing:-0.02em; margin:0;">
                        Jurnal <span style="color:#E8C766;">Ilmiah An-Nur</span>
                    </h2>
                    <p style="color:rgba(255,255,255,0.6); font-size:15px; margin:10px auto 0; max-width:560px; line-height:1.65;">
                        Publikasi peer-reviewed bertaraf internasional oleh Yayasan Pesantren Mahasiswa An-Nur Surabaya.
                    </p>
                </div>

                <div class="row g-4 justify-content-center">
                    {{-- AIJIT --}}
                    <div class="col-lg-10 col-12">
                        <div class="annur-jrnl-card">
                            <div class="annur-jrnl-cover">
                                <img src="https://journal.pesma-annur.net/public/journals/1/journalThumbnail_en.gif" alt="AIJIT Cover">
                            </div>
                            <div class="annur-jrnl-info">
                                <div>
                                    <span class="annur-jrnl-tag">Islamic Thought · Social Sciences · Humanities</span>
                                    <div class="annur-jrnl-name">An-Nur International Journal of Islamic Thought (AIJIT)</div>
                                    <p class="annur-jrnl-desc">Jurnal peer-reviewed open-access bertaraf internasional yang memuat riset di bidang Ilmu Sosial & Humaniora berbasis Islam — sejarah, filsafat, politik, linguistik, pendidikan, etika, gender, dan tasawuf. Terbit dua kali setahun dalam Bahasa Inggris dan Arab.</p>
                                </div>
                                <div class="annur-jrnl-btns">
                                    <a href="https://journal.pesma-annur.net/index.php/aijit" target="_blank" class="annur-jrnl-btn-primary">
                                        <iconify-icon icon="solar:book-2-bold-duotone" style="font-size:15px;"></iconify-icon> Lihat Jurnal
                                    </a>
                                    <a href="https://journal.pesma-annur.net/index.php/aijit/issue/current" target="_blank" class="annur-jrnl-btn-secondary">
                                        <iconify-icon icon="solar:layers-bold-duotone" style="font-size:15px;"></iconify-icon> Edisi Terkini
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- AIJQH --}}
                    <div class="col-lg-10 col-12">
                        <div class="annur-jrnl-card">
                            <div class="annur-jrnl-cover">
                                <img src="https://journal.pesma-annur.net/public/journals/2/journalThumbnail_en.gif" alt="AIJQH Cover">
                            </div>
                            <div class="annur-jrnl-info">
                                <div>
                                    <span class="annur-jrnl-tag">Quran & Hadith · E-ISSN: 3030-9352</span>
                                    <div class="annur-jrnl-name">An-Nur International Journal of The Quran & Hadith (AIJQH)</div>
                                    <p class="annur-jrnl-desc">Jurnal ilmiah yang didedikasikan untuk riset orisinal di bidang Studi Al-Quran dan Hadits. Memuat artikel Bahasa Inggris & Arab untuk menjembatani tradisi keilmuan Islam dan Barat. Terbit dua kali setahun sejak 2023.</p>
                                </div>
                                <div class="annur-jrnl-btns">
                                    <a href="https://journal.pesma-annur.net/index.php/aijqh" target="_blank" class="annur-jrnl-btn-primary">
                                        <iconify-icon icon="solar:book-2-bold-duotone" style="font-size:15px;"></iconify-icon> Lihat Jurnal
                                    </a>
                                    <a href="https://journal.pesma-annur.net/index.php/aijqh/issue/current" target="_blank" class="annur-jrnl-btn-secondary">
                                        <iconify-icon icon="solar:layers-bold-duotone" style="font-size:15px;"></iconify-icon> Edisi Terkini
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- EduLinguist --}}
                    <div class="col-lg-10 col-12">
                        <div class="annur-jrnl-card">
                            <div class="annur-jrnl-cover-icon">
                                <iconify-icon icon="solar:book-bookmark-bold-duotone" style="font-size:52px; color:#a8edbe;"></iconify-icon>
                                <p style="margin-top:8px; font-size:10px; font-weight:800; color:#fff; text-align:center; letter-spacing:0.04em; line-height:1.3;">EduLinguist</p>
                            </div>
                            <div class="annur-jrnl-info">
                                <div>
                                    <span class="annur-jrnl-tag">Education · Linguistics · 2x/tahun</span>
                                    <div class="annur-jrnl-name">EduLinguist: Journal of Education and Linguistics</div>
                                    <p class="annur-jrnl-desc">Jurnal peer-reviewed yang memuat riset orisinal di bidang Pendidikan dan Linguistik — pendidikan agama, manajemen pendidikan, linguistik teoritis & terapan. Terbit dua kali setahun (April & September) dalam Bahasa Indonesia dan Inggris.</p>
                                </div>
                                <div class="annur-jrnl-btns">
                                    <a href="https://journal.pesma-annur.net/index.php/Edulinguist" target="_blank" class="annur-jrnl-btn-primary">
                                        <iconify-icon icon="solar:book-2-bold-duotone" style="font-size:15px;"></iconify-icon> Lihat Jurnal
                                    </a>
                                    <a href="https://journal.pesma-annur.net/index.php/Edulinguist/issue/current" target="_blank" class="annur-jrnl-btn-secondary">
                                        <iconify-icon icon="solar:layers-bold-duotone" style="font-size:15px;"></iconify-icon> Edisi Terkini
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="https://journal.pesma-annur.net" target="_blank" style="color:#E8C766; font-size:13.5px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:6px; opacity:0.85; transition:opacity 0.2s ease;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                        <iconify-icon icon="solar:arrow-right-up-linear" style="font-size:15px;"></iconify-icon>
                        Kunjungi Portal Jurnal An-Nur
                    </a>
                </div>
            </div>
        </div>
        {{-- ===== END JURNAL SECTION ===== --}}

        {{-- ===== PRODUK TERBARU SECTION ===== --}}
        <div class="section py-5" style="background: var(--ivory-bg);">
            <div class="container py-3">
                <div class="row mb-4 text-center">
                    <div class="col-12">
                        <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">PRODUK & PUBLIKASI</span>
                        <h2 class="section-title mt-2" style="font-size: 32px; font-weight: 800; letter-spacing: -0.02em;">
                            Koleksi <span class="theme-gradient">Produk & Buku</span>
                        </h2>
                        <p style="color: var(--text-muted); font-size: 15px; max-width: 580px; margin: 0 auto;">
                            Temukan buku, merchandise, dan produk edukasi unggulan dari Pesantren Mahasiswa An-Nur.
                        </p>
                    </div>
                </div>

                @php
                    $berandaProducts = [];
                    if (class_exists('\App\Models\Product')) {
                        $berandaProducts = \App\Models\Product::where('is_active', true)->orderBy('id', 'desc')->limit(4)->get();
                    }
                @endphp

                <div class="row g-4 justify-content-center">
                    @forelse($berandaProducts as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="annur-shop-card rbt-default-card style-three rbt-hover h-100 d-flex flex-column">
                            <div class="inner d-flex flex-column flex-grow-1">
                                <div class="annur-shop-thumb mb-3">
                                    <a href="{{ route('shop.show', $product->slug) }}" class="w-100 h-100 d-block">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:rgba(201,162,39,0.06);">
                                                <iconify-icon icon="solar:book-bold-duotone" style="font-size:60px;color:var(--gold-primary);opacity:0.4;"></iconify-icon>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="content pt--0 pb--10 flex-grow-1">
                                    <h4 class="title" style="font-family: var(--font-body); font-size: 15px; font-weight: 700; line-height: 1.4; margin-bottom: 8px;">
                                        <a href="{{ route('shop.show', $product->slug) }}" style="color: var(--text-main); text-decoration: none;">{{ $product->name }}</a>
                                    </h4>
                                    @php
                                        $authorName = null;
                                        if (!empty($product->authors) && is_array($product->authors)) {
                                            $authorName = implode(', ', array_slice($product->authors, 0, 2));
                                        } elseif (!empty($product->author_name)) {
                                            $authorName = $product->author_name;
                                        }
                                    @endphp
                                    @if($authorName)
                                    <span class="d-block" style="font-size: 13px; color: var(--text-muted);">
                                        <iconify-icon icon="solar:user-bold-duotone" class="me-1" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon> {{ $authorName }}
                                    </span>
                                    @endif
                                </div>
                                <div class="content mt-auto pt-3 border-top" style="border-color: var(--border-color) !important;">
                                    <div class="rbt-price justify-content-center mb-3">
                                        @if($product->discount_price > 0 && $product->discount_price < $product->price)
                                            <span class="current-price theme-gradient" style="font-size: 17px; font-weight: 800;">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                            <span class="off-price text-muted ms-2" style="font-size: 13px; text-decoration: line-through;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @else
                                            <span class="current-price theme-gradient" style="font-size: 17px; font-weight: 800;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        @endif
                                    </div>
                                    <div class="addto-cart-btn text-center">
                                        <a class="btn-gold w-100" style="min-height: 40px; font-size: 13px; padding: 0 16px;" href="{{ route('shop.show', $product->slug) }}">
                                            Lihat Detail
                                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-4">
                        <p class="text-muted">Belum ada produk yang tersedia.</p>
                    </div>
                    @endforelse
                </div>

                <div class="row mt--40 text-center">
                    <div class="col-lg-12">
                        <a class="btn-outline-navy" href="{{ url('/shop') }}">
                            Lihat Semua Produk
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        {{-- ===== END PRODUK SECTION ===== --}}

        <!-- YouTube Video Section -->
        <style>
            .yt-card {
                border-radius: 10px;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                background: var(--rbt-white, #fff);
                border: 1px solid rgba(0,0,0,0.08);
            }
            .yt-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 12px 28px rgba(0,0,0,0.12);
            }
            .yt-card-img {
                position: relative;
                overflow: hidden;
                background: #000;
                aspect-ratio: 16/9;
            }
            .yt-card-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                opacity: 0.92;
                transition: opacity 0.3s ease, transform 0.4s ease;
            }
            .yt-card:hover .yt-card-img img {
                opacity: 1;
                transform: scale(1.04);
            }
            .yt-play-btn {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: #ff0000;
                border-radius: 12px;
                width: 56px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 12px rgba(255,0,0,0.35);
                transition: transform 0.3s ease;
            }
            .yt-card:hover .yt-play-btn {
                transform: translate(-50%, -50%) scale(1.12);
            }
            .yt-play-btn i { color: #fff; font-size: 18px; margin-left: 3px; }
            .yt-overlay {
                position: absolute;
                bottom: 0; left: 0; right: 0;
                background: linear-gradient(transparent, rgba(0,0,0,0.75));
                padding: 18px 14px 10px;
            }
            .yt-overlay-badge {
                color: #fff;
                font-weight: 500;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                font-size: 13px;
                background: rgba(0,0,0,0.55);
                padding: 4px 10px;
                border-radius: 20px;
            }
            .yt-card-body { padding: 16px; }
            .yt-card-title {
                font-size: 15px;
                font-weight: 600;
                line-height: 1.5;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                text-overflow: ellipsis;
                margin: 0;
            }
            .yt-card-title a { color: var(--rbt-heading-color, #2d3436); text-decoration: none; }
            .yt-card-title a:hover { color: var(--rbt-primary-color, #2f57ef); }
            @media (min-width: 576px) and (max-width: 991px) {
                .yt-grid .col-yt { flex: 0 0 50%; max-width: 50%; }
            }
            @media (max-width: 575px) {
                .yt-grid .col-yt { flex: 0 0 100%; max-width: 100%; }
            }
        </style>

        <div class="rbt-video-area rbt-section-gapBottom mt--50">
            <div class="container">
                <div class="row mb--30">
                    <div class="col-12">
                        <div class="section-title text-start">
                            <h3 class="title">VIDEO</h3>
                            <hr style="border-top: 2px solid #eaeaea; margin-top: 15px;">
                        </div>
                    </div>
                </div>

                @if(isset($youtubeVideos) && count($youtubeVideos) > 0)
                <div class="row g-4 yt-grid">
                    @foreach($youtubeVideos as $video)
                    <div class="col-lg-4 col-md-6 col-12 col-yt">
                        <div class="yt-card shadow-sm">
                            <div class="yt-card-img">
                                <a href="{{ $video['link'] }}" target="_blank" title="{{ $video['title'] }}">
                                    <img src="{{ $video['thumbnail'] }}" alt="{{ $video['title'] }}" loading="lazy">
                                    <div class="yt-play-btn">
                                        <i class="feather-play"></i>
                                    </div>
                                    <div class="yt-overlay">
                                        <span class="yt-overlay-badge">
                                            <i class="feather-youtube" style="color: #ff0000;"></i> Tonton di YouTube
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="yt-card-body">
                                <h5 class="yt-card-title">
                                    <a href="{{ $video['link'] }}" target="_blank">{{ $video['title'] }}</a>
                                </h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-light text-center py-4 border-dashed border-secondary mb-0">
                            <i class="feather-youtube mb-2 d-block" style="font-size: 30px; color: #ccc;"></i>
                            <p class="mb-0 text-muted">Video terbaru sedang tidak dapat dimuat saat ini. Silahkan cek langsung di channel <a href="https://youtube.com/@@pesmaan-nur5975" target="_blank" class="fw-semibold">YouTube Kami <i class="feather-external-link"></i></a>.</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    @endif
@endsection
