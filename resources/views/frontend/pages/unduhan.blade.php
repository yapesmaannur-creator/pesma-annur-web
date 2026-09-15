@extends('frontend.layouts.app')


@section('meta_title', 'Pusat Unduhan Dokumen')
@section('meta_description', 'Download brosur, formulir, panduan, dan dokumen resmi dari Pesantren Mahasiswa An-Nur.')

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 50px 0 45px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <ul style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; margin-bottom: 12px; font-size: 13px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li style="color: #E8C766; font-weight: 600;">Pusat Unduhan</li>
        </ul>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.18); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 10px; letter-spacing: 0.04em;">
                    ARSIP & DOKUMEN RESMI
                </span>
                <h1 style="color: #FFFFFF !important; font-size: clamp(24px, 3.2vw, 36px); font-weight: 800; line-height: 1.25; margin: 0; letter-spacing: -0.02em;">
                    Pusat Unduhan & Formulir
                </h1>
            </div>

            <div style="background: rgba(255,255,255,0.08); padding: 8px 18px; border-radius: 50px; border: 1px solid rgba(201,162,39,0.3); color: #FFFFFF; font-size: 13.5px; font-weight: 700;">
                <iconify-icon icon="solar:document-add-bold-duotone" style="font-size: 18px; color: #E8C766; vertical-align: middle; margin-right: 6px;"></iconify-icon>
                Dokumen Resmi
            </div>
        </div>
    </div>
</div>

<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        @if($downloads->isEmpty())
        <div class="text-center py-5">
            <div class="p-5 text-center" style="background: var(--card-bg); border: 2px dashed var(--border-color); border-radius: var(--radius-lg);">
                <iconify-icon icon="solar:folder-with-files-bold-duotone" style="font-size: 54px; color: var(--gold-primary); margin-bottom: 12px;"></iconify-icon>
                <h4 style="font-weight: 800; color: var(--text-main); margin-bottom: 8px;">Belum Ada Berkas</h4>
                <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">Berkas dan dokumen resmi akan diunggah di sini.</p>
                <a href="/" class="btn-gold" style="min-height: 42px; padding: 0 24px; color: #071526 !important; font-weight: 700;">Kembali ke Beranda</a>
            </div>
        </div>
        @else
            @foreach($downloads as $categoryKey => $items)
            <div class="mb-5">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom" style="border-color: var(--border-color) !important;">
                    <iconify-icon icon="solar:folder-bold-duotone" style="font-size: 24px; color: var(--gold-primary);"></iconify-icon>
                    <h3 style="font-size: 20px; font-weight: 800; color: var(--text-main); margin: 0;">
                        {{ $categories[$categoryKey] ?? ucfirst($categoryKey) }}
                    </h3>
                </div>

                <div class="row g-4">
                    @foreach($items as $download)
                    <div class="col-lg-6 col-12">
                        <div class="annur-article-hover-card p-4 h-100" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); transition: all 0.35s ease;">
                            <div class="d-flex align-items-start gap-3">
                                <div class="flex-shrink-0">
                                    <div style="width: 52px; height: 52px; border-radius: 14px; background: linear-gradient(135deg, #071526 0%, #102A4C 100%); border: 1px solid rgba(201, 162, 39, 0.35); display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 16px rgba(7,21,38,0.18);">
                                        <iconify-icon icon="solar:file-bold-duotone" style="font-size: 26px; color: #E8C766;"></iconify-icon>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h4 style="font-size: 16.5px; font-weight: 800; line-height: 1.35; margin-bottom: 6px; color: var(--text-main);">
                                        {{ $download->title }}
                                    </h4>
                                    @if($download->description)
                                    <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6; margin-bottom: 12px;">
                                        {{ $download->description }}
                                    </p>
                                    @endif
                                    
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 pt-2 border-top" style="border-color: var(--border-color) !important;">
                                        <div class="d-flex align-items-center gap-3" style="font-size: 12.5px; color: var(--text-muted); font-weight: 600;">
                                            <span><i class="feather-hard-drive me-1" style="color: var(--gold-primary);"></i> {{ $download->file_size_human }}</span>
                                            <span style="padding: 2px 8px; background: rgba(201, 162, 39, 0.12); color: var(--gold-primary); border-radius: 4px; font-weight: 700;">{{ strtoupper($download->file_type) }}</span>
                                        </div>

                                        <a href="{{ route('unduhan.download', $download->id) }}" class="btn-gold" style="min-height: 36px; padding: 0 18px; font-size: 13px; color: #071526 !important; font-weight: 700;">
                                            <i class="feather-download me-1"></i> Unduh Berkas
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
