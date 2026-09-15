@extends('frontend.layouts.app')


@section('meta_title', 'Hasil Pencarian: ' . $query)

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 50px 0 45px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <ul style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; margin-bottom: 12px; font-size: 13px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li style="color: #E8C766; font-weight: 600;">Hasil Pencarian</li>
        </ul>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.18); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 10px; letter-spacing: 0.04em;">
                    PENCARIAN GLOBAL
                </span>
                <h1 style="color: #FFFFFF !important; font-size: clamp(24px, 3.2vw, 36px); font-weight: 800; line-height: 1.25; margin: 0; letter-spacing: -0.02em;">
                    @if(!empty($query))
                        Hasil Pencarian: "{{ $query }}"
                    @else
                        Pencarian Konten
                    @endif
                </h1>
            </div>

            @if(!empty($query))
            <div style="background: rgba(255,255,255,0.08); padding: 8px 18px; border-radius: 50px; border: 1px solid rgba(201,162,39,0.3); color: #FFFFFF; font-size: 13.5px; font-weight: 700;">
                <iconify-icon icon="solar:magnifier-bold-duotone" style="font-size: 18px; color: #E8C766; vertical-align: middle; margin-right: 6px;"></iconify-icon>
                {{ $totalResults }} Ditemukan
            </div>
            @endif
        </div>
    </div>
</div>

<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <!-- Search Input Bar -->
        <div class="row mb-5 justify-content-center">
            <div class="col-lg-8">
                <form action="{{ url('/cari') }}" method="GET">
                    <div class="d-flex p-2" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: 50px; box-shadow: var(--card-shadow);">
                        <input type="text" name="q" value="{{ $query }}" placeholder="Cari artikel, program, produk, FAQ..." class="form-control border-0 shadow-none px-4" style="background: transparent; color: var(--text-main); font-size: 15px;">
                        <button type="submit" class="btn-gold" style="min-height: 44px; padding: 0 26px; color: #071526 !important; font-weight: 700; flex-shrink: 0;">
                            <i class="feather-search me-1"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(!empty($query))
            @if($totalResults > 0)
            <div class="row g-4">
                @foreach($results as $result)
                <div class="col-lg-6 col-12">
                    <div class="annur-article-hover-card p-4 h-100" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); transition: all 0.35s ease;">
                        <div class="d-flex align-items-start gap-3">
                            @if(isset($result->image) && $result->image)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $result->image) }}" alt="{{ $result->title }}" style="width: 85px; height: 85px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--border-color);">
                            </div>
                            @endif
                            <div class="flex-grow-1">
                                <span style="font-size: 11.5px; font-weight: 700; color: var(--gold-primary); background: rgba(201, 162, 39, 0.12); border: 1px solid rgba(201, 162, 39, 0.3); padding: 3px 10px; border-radius: 50px; display: inline-block; margin-bottom: 8px;">
                                    {{ strtoupper($result->type) }}
                                </span>
                                <h4 style="font-size: 16.5px; font-weight: 800; line-height: 1.35; margin-bottom: 6px;">
                                    <a href="{{ $result->url }}" style="color: var(--text-main); text-decoration: none;">
                                        {!! preg_replace('/(' . preg_quote($query, '/') . ')/i', '<mark style="background: rgba(232, 199, 102, 0.4); padding: 0 4px; border-radius: 4px;">$1</mark>', e($result->title)) !!}
                                    </a>
                                </h4>
                                @if(isset($result->excerpt) && $result->excerpt)
                                <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($result->excerpt), 130) }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="row">
                <div class="col-12 text-center py-5">
                    <div class="p-5 text-center" style="background: var(--card-bg); border: 2px dashed var(--border-color); border-radius: var(--radius-lg);">
                        <iconify-icon icon="solar:magnifier-bug-bold-duotone" style="font-size: 56px; color: var(--gold-primary); margin-bottom: 12px;"></iconify-icon>
                        <h4 style="font-weight: 800; color: var(--text-main); margin-bottom: 8px;">Tidak Ada Hasil Ditemukan</h4>
                        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">Coba kata kunci lain atau periksa ejaan Anda.</p>
                        <a href="/" class="btn-gold" style="min-height: 42px; padding: 0 24px; color: #071526 !important; font-weight: 700;">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection
