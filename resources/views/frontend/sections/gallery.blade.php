@php
    $galleries = \App\Models\Gallery::where('is_active', true)->latest()->take(6)->get();
    $items = $section->items->count() > 0 ? $section->items : $galleries;
@endphp

<style>
    .annur-gallery-card {
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        aspect-ratio: 4/3;
        box-shadow: 0 10px 25px rgba(11, 31, 58, 0.08);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: block;
        background: #071526;
    }
    .annur-gallery-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease, opacity 0.3s ease;
        opacity: 0.92;
    }
    .annur-gallery-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(11, 31, 58, 0.16);
    }
    .annur-gallery-card:hover img {
        transform: scale(1.08);
        opacity: 1;
    }
    .annur-gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(7, 21, 38, 0.75) 0%, transparent 60%);
        display: flex;
        align-items: flex-end;
        padding: 20px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .annur-gallery-card:hover .annur-gallery-overlay {
        opacity: 1;
    }
    .annur-gallery-title {
        color: #ffffff;
        font-size: 14.5px;
        font-weight: 700;
        margin: 0;
    }
</style>

<div class="section py-5">
    <div class="container py-3">
        <div class="text-center mb-5">
            <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 18px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                {{ strtoupper($section->subtitle ?? 'MOMEN KEBERSAMAAN') }}
            </span>
            <h2 class="section-title mt-2" style="font-size: 34px; font-weight: 800; letter-spacing: -0.02em; text-align: center;">
                {!! $section->title ?? 'Momen Kebersamaan' !!}
            </h2>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($items as $item)
                @php
                    $imageUrl = isset($item->image) && !empty($item->image) ? asset('storage/' . $item->image) : asset('frontend/assets/images/gallery/gallery-0' . ($loop->iteration % 9 + 1) . '.jpg');
                    $titleText = $item->title ?? 'Dokumentasi Pesma An-Nur';
                @endphp
                <div class="col-lg-4 col-md-6 col-12">
                    <a href="{{ $imageUrl }}" class="annur-gallery-card" data-lightbox="gallery-group" title="{{ $titleText }}">
                        <img src="{{ $imageUrl }}" alt="{{ $titleText }}" loading="lazy">
                        <div class="annur-gallery-overlay">
                            <p class="annur-gallery-title">{{ $titleText }}</p>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">Belum ada foto galeri.</p>
                </div>
            @endforelse
        </div>

        <div class="text-center mt-5">
            <a class="btn-gold" href="{{ route('gallery.index') }}" style="min-height: 46px; font-size: 14px; padding: 0 26px; color: #071526 !important; font-weight: 700; display: inline-flex; align-items: center; border-radius: 999px;">
                Lihat Semua Galeri
                <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-2" style="font-size: 16px;"></iconify-icon>
            </a>
        </div>
    </div>
</div>
