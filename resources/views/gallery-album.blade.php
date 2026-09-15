@extends('frontend.layouts.app')

@section('meta_title', $album->title . ' - Galeri Foto')
@section('meta_description', $album->description ?? 'Galeri foto ' . $album->title)

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 50px 0 45px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <ul style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; margin-bottom: 12px; font-size: 13px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; color: rgba(255,255,255,0.5); vertical-align: middle;"></iconify-icon></li>
            <li><a href="{{ url('/galeri') }}" style="color: rgba(255,255,255,0.85); text-decoration: none;">Galeri</a></li>
            <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; color: rgba(255,255,255,0.5); vertical-align: middle;"></iconify-icon></li>
            <li style="color: #E8C766; font-weight: 600;">{{ $album->title }}</li>
        </ul>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.18); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 10px; letter-spacing: 0.04em;">
                    ALBUM DOKUMENTASI
                </span>
                <h1 style="color: #FFFFFF !important; font-size: clamp(24px, 3.2vw, 36px); font-weight: 800; line-height: 1.25; margin: 0; letter-spacing: -0.02em;">
                    {{ $album->title }}
                </h1>
                @if($album->description)
                <p style="color: rgba(255,255,255,0.8); font-size: 14.5px; margin-top: 8px; margin-bottom: 0; max-width: 700px;">
                    {{ $album->description }}
                </p>
                @endif
            </div>

            <a href="{{ url('/galeri') }}" class="btn-gold" style="min-height: 40px; padding: 0 20px; font-size: 13px; color: #071526 !important; font-weight: 700;">
                <iconify-icon icon="solar:alt-arrow-left-linear" class="me-2" style="vertical-align: middle;"></iconify-icon> Kembali ke Galeri
            </a>
        </div>
    </div>
</div>

{{-- Lightbox CSS --}}
<style>
    .gallery-lightbox-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(7, 15, 26, 0.95);
        backdrop-filter: blur(12px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }
    .gallery-lightbox-overlay.active { display: flex; }
    .gallery-lightbox-overlay img {
        max-width: 90vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 16px 50px rgba(0,0,0,0.6);
    }
    .lb-close {
        position: absolute; top: 20px; right: 24px;
        color: #E8C766; font-size: 24px; cursor: pointer;
        background: rgba(255,255,255,0.1); width: 44px; height: 44px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        transition: background 0.3s;
        border: 1px solid rgba(201, 162, 39, 0.3);
    }
    .lb-close:hover { background: #C9A227; color: #071526; }
    .lb-nav {
        position: absolute; top: 50%; transform: translateY(-50%);
        color: #E8C766; font-size: 22px; cursor: pointer;
        background: rgba(255,255,255,0.1); width: 48px; height: 48px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        transition: background 0.3s;
        border: 1px solid rgba(201, 162, 39, 0.3);
    }
    .lb-nav:hover { background: #C9A227; color: #071526; }
    .lb-prev { left: 20px; }
    .lb-next { right: 20px; }
    .lb-caption {
        position: absolute; bottom: 24px; left: 50%; transform: translateX(-50%);
        color: #FFFFFF; font-size: 14px; font-weight: 600; text-align: center;
        background: rgba(7, 21, 38, 0.85); padding: 8px 24px; border-radius: 30px;
        border: 1px solid rgba(201, 162, 39, 0.3);
    }
    .lb-counter {
        position: absolute; top: 24px; left: 24px;
        color: #E8C766; font-size: 14px; font-weight: 700;
    }
    .gallery-photo-card {
        border-radius: var(--radius-md); overflow: hidden; cursor: pointer; position: relative;
        border: 1px solid var(--border-color); box-shadow: var(--card-shadow);
        transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.35s ease;
        background: var(--card-bg);
    }
    .gallery-photo-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.45);
    }
    .gallery-photo-card img {
        width: 100%; height: 240px; object-fit: cover; object-position: top center; display: block;
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .gallery-photo-card:hover img { transform: scale(1.06); }
</style>

{{-- Photo Grid --}}
<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <div class="row g-4">
            @forelse($album->galleries as $index => $photo)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="gallery-photo-card" data-index="{{ $index }}" onclick="openLightbox(parseInt(this.dataset.index, 10))">
                    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title ?? $album->title }}">
                    @if($photo->title)
                    <div style="padding: 14px 16px; background: var(--card-bg); border-top: 1px solid var(--border-color);">
                        <h5 style="font-size: 14px; font-weight: 700; color: var(--text-main); margin: 0; line-height: 1.35;">{{ $photo->title }}</h5>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 text-center" style="background: var(--card-bg); border: 2px dashed var(--border-color); border-radius: var(--radius-lg);">
                    <iconify-icon icon="solar:gallery-bold-duotone" style="font-size: 54px; color: var(--gold-primary); margin-bottom: 12px;"></iconify-icon>
                    <h4 style="font-weight: 800; color: var(--text-main); margin-bottom: 8px;">Album Ini Masih Kosong</h4>
                    <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Belum ada foto yang diunggah ke dalam album ini.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Lightbox Overlay Modal --}}
<div class="gallery-lightbox-overlay" id="galleryLightbox">
    <button class="lb-close" onclick="closeLightbox()">&times;</button>
    <button class="lb-nav lb-prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="lb-nav lb-next" onclick="changeSlide(1)">&#10095;</button>
    <div class="lb-counter" id="lbCounter">1 / 1</div>
    <img id="lbImage" src="" alt="Gallery Image">
    <div class="lb-caption" id="lbCaption"></div>
</div>

@php
    $photosJson = json_encode($album->galleries->map(function($p) use ($album) {
        return [
            'src' => asset('storage/' . $p->image),
            'caption' => $p->title ?? $album->title
        ];
    }));
@endphp

<script id="gallery-photos-json" type="application/json">
{!! $photosJson !!}
</script>

<script>
    const photos = JSON.parse(document.getElementById('gallery-photos-json').textContent || '[]');
    let currentIndex = 0;

    function openLightbox(index) {
        if (!photos.length) return;
        currentIndex = index;
        updateLightbox();
        document.getElementById('galleryLightbox').classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        document.getElementById('galleryLightbox').classList.remove('active');
        document.body.style.overflow = '';
    }

    function changeSlide(direction) {
        currentIndex = (currentIndex + direction + photos.length) % photos.length;
        updateLightbox();
    }

    function updateLightbox() {
        if (!photos[currentIndex]) return;
        document.getElementById('lbImage').src = photos[currentIndex].src;
        document.getElementById('lbCaption').textContent = photos[currentIndex].caption;
        document.getElementById('lbCounter').textContent = (currentIndex + 1) + ' / ' + photos.length;
    }

    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('galleryLightbox').classList.contains('active')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') changeSlide(-1);
        if (e.key === 'ArrowRight') changeSlide(1);
    });
</script>
@endsection
