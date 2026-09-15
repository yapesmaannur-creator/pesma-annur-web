@extends('frontend.layouts.app')

@section('meta_title', 'Galeri Foto')
@section('meta_description', 'Galeri foto kegiatan dan aktivitas Pesantren Mahasiswa An-Nur')

@push('styles')
<style>
    .annur-gallery-card {
        border-radius: var(--radius-md);
        overflow: hidden;
        background: var(--card-bg);
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border-color);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        text-decoration: none !important;
    }
    .annur-gallery-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.45);
    }
    .annur-gallery-img-wrapper {
        height: 240px;
        overflow: hidden;
        position: relative;
    }
    .annur-gallery-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top center;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .annur-gallery-card:hover .annur-gallery-img-wrapper img {
        transform: scale(1.06);
    }
    .annur-gallery-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        background: linear-gradient(135deg, #071526 0%, #102A4C 100%);
        color: #E8C766;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        border: 1px solid rgba(201, 162, 39, 0.35);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .annur-gallery-content {
        padding: 22px 20px;
        background: var(--card-bg);
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        justify-content: space-between;
    }
    .annur-gallery-title {
        font-size: 17.5px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 8px;
        line-height: 1.35;
    }
    .annur-gallery-desc {
        color: var(--text-muted);
        font-size: 13.5px;
        margin: 0;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 50px 0 45px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <ul style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; margin-bottom: 12px; font-size: 13px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; color: rgba(255,255,255,0.5); vertical-align: middle;"></iconify-icon></li>
            <li style="color: #E8C766; font-weight: 600;">Galeri</li>
        </ul>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.18); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 10px; letter-spacing: 0.04em;">
                    DOKUMENTASI DOKUMENTAL
                </span>
                <h1 style="color: #FFFFFF !important; font-size: clamp(24px, 3.2vw, 36px); font-weight: 800; line-height: 1.25; margin: 0; letter-spacing: -0.02em;">
                    Galeri Foto & Momen Kegiatan
                </h1>
            </div>

            <div style="background: rgba(255,255,255,0.08); padding: 8px 18px; border-radius: 50px; border: 1px solid rgba(201,162,39,0.3); color: #FFFFFF; font-size: 13.5px; font-weight: 700;">
                <iconify-icon icon="solar:gallery-wide-bold-duotone" style="font-size: 18px; color: #E8C766; vertical-align: middle; margin-right: 6px;"></iconify-icon>
                {{ $albums->count() }} Album
            </div>
        </div>
    </div>
</div>

{{-- Album Grid --}}
<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <div class="row g-4">
            @forelse($albums as $album)
            <div class="col-lg-4 col-md-6 col-12">
                <a href="{{ url('/galeri/' . $album->slug) }}" class="annur-gallery-card">
                    @php
                        $coverUrl = $album->cover_image 
                            ? asset('storage/' . $album->cover_image) 
                            : ($album->galleries->first() 
                                ? asset('storage/' . $album->galleries->first()->image) 
                                : asset('frontend/assets/images/gallery/gallery-01.jpg'));
                    @endphp
                    
                    <div class="annur-gallery-img-wrapper">
                        <div class="annur-gallery-badge">
                            <iconify-icon icon="solar:gallery-bold-duotone" style="vertical-align: middle;"></iconify-icon> {{ $album->galleries_count }} Foto
                        </div>
                        <img src="{{ $coverUrl }}" alt="{{ $album->title }}">
                    </div>

                    <div class="annur-gallery-content">
                        <div>
                            <h3 class="annur-gallery-title">{{ $album->title }}</h3>
                            @if($album->description)
                                <p class="annur-gallery-desc">{{ Str::limit($album->description, 70) }}</p>
                            @endif
                        </div>
                        <div class="pt-3 mt-2 border-top d-flex align-items-center justify-content-between" style="border-color: var(--border-color) !important;">
                            <span style="font-size: 12.5px; font-weight: 700; color: var(--gold-primary);">Lihat Album</span>
                            <iconify-icon icon="solar:alt-arrow-right-linear" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon>
                        </div>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 text-center" style="background: var(--card-bg); border: 2px dashed var(--border-color); border-radius: var(--radius-lg);">
                    <iconify-icon icon="solar:camera-bold-duotone" style="font-size: 54px; color: var(--gold-primary); margin-bottom: 12px;"></iconify-icon>
                    <h4 style="font-weight: 800; color: var(--text-main); margin-bottom: 8px;">Belum Ada Album Foto</h4>
                    <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Koleksi dokumentasi foto kegiatan akan ditampilkan di halaman ini.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection