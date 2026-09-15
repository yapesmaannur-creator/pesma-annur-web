@extends('frontend.layouts.app')

@php
/** @var \Illuminate\Pagination\LengthAwarePaginator $products */
@endphp

@section('meta_title', 'Toko Buku & Produk Pesma')
@section('meta_description', 'Katalog buku, kitab, dan produk resmi Pesantren Mahasiswa An-Nur Surabaya')

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 50px 0 45px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <ul style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; margin-bottom: 12px; font-size: 13px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; color: rgba(255,255,255,0.5); vertical-align: middle;"></iconify-icon></li>
            <li style="color: #E8C766; font-weight: 600;">Toko Buku</li>
        </ul>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.18); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 10px; letter-spacing: 0.04em;">
                    E-MAKTAB & LITERASI
                </span>
                <h1 style="color: #FFFFFF !important; font-size: clamp(24px, 3.2vw, 36px); font-weight: 800; line-height: 1.25; margin: 0; letter-spacing: -0.02em;">
                    Toko Buku & Literatur Santri
                </h1>
            </div>

            <div style="background: rgba(255,255,255,0.08); padding: 8px 18px; border-radius: 50px; border: 1px solid rgba(201,162,39,0.3); color: #FFFFFF; font-size: 13.5px; font-weight: 700;">
                <iconify-icon icon="solar:shop-bold-duotone" style="font-size: 18px; color: #E8C766; vertical-align: middle; margin-right: 6px;"></iconify-icon>
                {{ $products->total() }} Produk
            </div>
        </div>
    </div>
</div>

<!-- SORTING & PRODUCT GRID -->
<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <!-- Filter Header -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4 pb-3 border-bottom" style="border-color: var(--border-color) !important;">
            <span style="font-size: 13.5px; font-weight: 600; color: var(--text-muted);">
                Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() }} produk
            </span>

            <form action="{{ route('shop.index') }}" method="GET" id="sort-form" class="d-flex align-items-center gap-2">
                <span style="font-size: 13px; font-weight: 700; color: var(--text-main);">Urutkan:</span>
                <select name="sort" onchange="document.getElementById('sort-form').submit()" style="background: var(--card-bg); color: var(--text-main); border: 1px solid var(--border-color); padding: 6px 14px; border-radius: 8px; font-size: 13px; font-weight: 600;">
                    <option value="latest" {{ $sort == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="popular" {{ $sort == 'popular' ? 'selected' : '' }}>Terlama</option>
                    <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>Harga: Rendah ke Tinggi</option>
                    <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>Harga: Tinggi ke Rendah</option>
                </select>
            </form>
        </div>

        <!-- Product Grid -->
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="annur-article-hover-card p-3 h-100 d-flex flex-column" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); transition: all 0.35s ease;">
                    <div style="width: 100%; height: 210px; border-radius: var(--radius-sm); overflow: hidden; background: rgba(0,0,0,0.02); display: flex; align-items: center; justify-content: center;" class="mb-3">
                        <a href="{{ route('shop.show', $product->slug) }}" class="w-100 h-100 d-flex align-items-center justify-content-center">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            @else
                                <img src="{{ asset('frontend/assets/images/product/1.jpg') }}" alt="{{ $product->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                            @endif
                        </a>
                    </div>

                    <div class="flex-grow-1">
                        <h4 style="font-size: 15.5px; font-weight: 800; line-height: 1.35; margin-bottom: 6px;">
                            <a href="{{ route('shop.show', $product->slug) }}" style="color: var(--text-main); text-decoration: none;">{{ $product->name }}</a>
                        </h4>
                        @if($product->author_name)
                        <span class="d-block" style="font-size: 13px; color: var(--text-muted); font-weight: 500;">
                            <iconify-icon icon="solar:user-bold-duotone" class="me-1" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon> {{ $product->author_name }}
                        </span>
                        @endif
                    </div>

                    <div class="pt-3 mt-3 border-top" style="border-color: var(--border-color) !important;">
                        <div class="mb-3 text-center">
                            @if($product->discount_price > 0 && $product->discount_price < $product->price)
                                <span style="font-size: 17px; font-weight: 800; color: var(--gold-primary);">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                <span style="font-size: 12.5px; color: var(--text-muted); text-decoration: line-through;" class="ms-2">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @else
                                <span style="font-size: 17px; font-weight: 800; color: var(--gold-primary);">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        <a href="{{ route('shop.show', $product->slug) }}" class="btn-gold w-100" style="min-height: 38px; padding: 0 16px; font-size: 13px; color: #071526 !important; font-weight: 700;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="p-5 text-center" style="background: var(--card-bg); border: 2px dashed var(--border-color); border-radius: var(--radius-lg);">
                    <iconify-icon icon="solar:bag-bold-duotone" style="font-size: 54px; color: var(--gold-primary); margin-bottom: 12px;"></iconify-icon>
                    <h4 style="font-weight: 800; color: var(--text-main); margin-bottom: 8px;">Belum Ada Produk</h4>
                    <p style="color: var(--text-muted); font-size: 14px; margin: 0;">Produk dan buku literasi akan ditampilkan di sini.</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
