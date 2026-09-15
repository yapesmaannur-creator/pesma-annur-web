@extends('frontend.layouts.app')

@section('meta_title', 'Artikel & Wawasan - Pesantren Mahasiswa An-Nur')
@section('meta_description', 'Baca kumpulan artikel keislaman, riset akademik, opini santri, dan berita kegiatan Pesantren Mahasiswa An-Nur Surabaya.')

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 55px 0 50px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <!-- Breadcrumb -->
        <ul style="list-style: none; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 0; margin-bottom: 14px; font-size: 13.5px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; color: rgba(255,255,255,0.5); vertical-align: middle;"></iconify-icon></li>
            <li style="color: #E8C766; font-weight: 600;">Semua Artikel</li>
        </ul>

        <div class="d-flex align-items-center gap-3 flex-wrap mb-2">
            <h1 style="color: #FFFFFF !important; font-size: 34px; font-weight: 800; line-height: 1.3; margin: 0; letter-spacing: -0.02em;">
                @if($activeCategory)
                    Kategori: {{ $activeCategory->name }}
                @else
                    Artikel & Wawasan
                @endif
            </h1>
            <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.18); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 12.5px; font-weight: 700; letter-spacing: 0.03em;">
                {{ $posts->total() }} Artikel Diterbitkan
            </span>
        </div>

        <!-- Category Filters -->
        @if($categories->isNotEmpty())
        <style>
            .annur-cat-filter-btn {
                padding: 7px 18px;
                border-radius: 50px;
                font-size: 13px;
                font-weight: 700;
                text-decoration: none;
                transition: all 0.3s ease;
                background: rgba(255,255,255,0.08);
                color: rgba(255,255,255,0.85);
                border: 1px solid rgba(255,255,255,0.15);
            }
            .annur-cat-filter-btn.active {
                background: #E8C766;
                color: #071526;
                border-color: #E8C766;
                box-shadow: 0 4px 12px rgba(201,162,39,0.3);
            }
        </style>
        <div class="d-flex flex-wrap align-items-center gap-2 mt-4 pt-2">
            <a href="{{ route('article.index') }}" class="annur-cat-filter-btn {{ !$activeCategory ? 'active' : '' }}">
                Semua Artikel
            </a>
            @foreach($categories as $category)
                @php
                    $isActive = $activeCategory && $activeCategory->id === $category->id;
                @endphp
                <a href="{{ route('article.index', ['category' => $category->slug]) }}" class="annur-cat-filter-btn {{ $isActive ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- MAIN ARTICLES GRID -->
<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <div class="row g-4">
            @forelse($posts as $index => $post)
            <div class="col-lg-4 col-md-6 col-12">
                <div style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); overflow: hidden; height: 100%; display: flex; flex-direction: column; transition: all 0.35s ease;" class="annur-article-hover-card">
                    <!-- Image Wrapper -->
                    <div style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden;">
                        @if(isset($post->category) && $post->category)
                            <span style="position: absolute; top: 12px; left: 12px; padding: 4px 12px; background: rgba(7, 21, 38, 0.85); backdrop-filter: blur(8px); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 11.5px; font-weight: 700; z-index: 2; letter-spacing: 0.04em;">
                                {{ $post->category->name }}
                            </span>
                        @endif
                        <a href="{{ route('article.show', $post->slug) }}">
                            <img src="{{ $post->image_url ?? asset('frontend/assets/images/blog/islamic-blog-0' . (($index % 3) + 1) . '.png') }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;" class="annur-card-img" onerror="this.onerror=null; this.src='{{ asset('frontend/assets/images/blog/islamic-blog-0' . (($index % 3) + 1) . '.png') }}';">
                        </a>
                    </div>

                    <!-- Body -->
                    <div style="padding: 24px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                        <div>
                            <div class="d-flex align-items-center gap-3 mb-2" style="font-size: 12.5px; color: var(--text-muted);">
                                <span><iconify-icon icon="solar:calendar-bold-duotone" class="me-1" style="color: var(--gold-primary); font-size: 14px; vertical-align: middle;"></iconify-icon> {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d M Y') : date('d M Y') }}</span>
                                @if(isset($post->user) && $post->user)
                                    <span>
                                        <iconify-icon icon="solar:user-bold-duotone" class="me-1" style="color: var(--gold-primary); font-size: 14px; vertical-align: middle;"></iconify-icon>
                                        <a href="{{ route('article.author', $post->user->id) }}" style="color: inherit; text-decoration: none;">{{ $post->user->name }}</a>
                                    </span>
                                @endif
                            </div>
                            <h3 style="font-size: 17.5px; font-weight: 800; line-height: 1.4; margin-bottom: 10px;">
                                <a href="{{ route('article.show', $post->slug) }}" style="color: var(--text-main); text-decoration: none; transition: color 0.2s ease;">{{ $post->title }}</a>
                            </h3>
                            <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content ?? $post->body_content), 100) }}
                            </p>
                        </div>
                        <div class="pt-3 border-top" style="border-color: var(--border-color) !important;">
                            <a href="{{ route('article.show', $post->slug) }}" class="btn-gold w-100" style="min-height: 40px; padding: 0 18px; font-size: 13px; color: #071526 !important; font-weight: 700;">
                                Baca Selengkapnya
                                <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="font-size: 15px; vertical-align: middle;"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="feather-file-text mb-3" style="font-size: 40px; color: var(--gold-primary); opacity: 0.5;"></i>
                <h4 style="font-weight: 800; color: var(--text-main);">Belum Ada Artikel</h4>
                <p class="text-muted">Artikel baru sedang dalam proses penulisan.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .annur-article-hover-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-shadow-hover) !important;
        border-color: rgba(201, 162, 39, 0.4) !important;
    }
    .annur-article-hover-card:hover .annur-card-img {
        transform: scale(1.05);
    }
</style>
@endsection
