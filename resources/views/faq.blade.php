@extends('frontend.layouts.app')

@section('meta_title', 'FAQ (Pertanyaan Sering Diajukan) - Pesantren Mahasiswa An-Nur')
@section('meta_description', 'Temukan jawaban lengkap seputar pendaftaran santri baru, program kurikulum, fasilitas, dan informasi Pesantren Mahasiswa An-Nur Surabaya.')

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 55px 0 50px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <!-- Breadcrumb -->
        <ul style="list-style: none; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 0; margin-bottom: 14px; font-size: 13.5px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li style="color: #E8C766; font-weight: 600;">FAQ</li>
        </ul>

        <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.15); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.35); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 12px; letter-spacing: 0.04em;">
            CENTRAL INFORMASI & BANTUAN
        </span>

        <h1 style="color: #FFFFFF !important; font-size: 34px; font-weight: 800; line-height: 1.3; margin-bottom: 10px; letter-spacing: -0.02em;">
            Pertanyaan Sering Diajukan (FAQ)
        </h1>
        <p style="color: rgba(255,255,255,0.85); font-size: 16px; margin: 0; max-width: 680px; line-height: 1.6;">
            Temukan jawaban langsung untuk pertanyaan umum mengenai alur pendaftaran, biaya, program akademik, hingga tata tertib pesantren.
        </p>
    </div>
</div>

<!-- MAIN FAQ WORKSPACE -->
<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <div class="row g-5 align-items-start">
            <!-- LEFT COLUMN: ACCORDIONS -->
            <div class="col-lg-8">
                @php
                    $faqs = [];
                    if (class_exists('\App\Models\Faq')) {
                        $faqs = \App\Models\Faq::where('is_active', true)->orderBy('order', 'asc')->get();
                    }
                @endphp

                <div class="accordion" id="faqAccordionPage">
                    @forelse($faqs as $index => $faq)
                    <div class="card mb-3" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); overflow: hidden; transition: all 0.3s ease;">
                        <h2 class="accordion-header" id="headingPage{{ $faq->id }}">
                            <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePage{{ $faq->id }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapsePage{{ $faq->id }}" style="background: transparent !important; color: var(--text-main) !important; font-size: 16px !important; font-weight: 700 !important; padding: 20px 24px !important; box-shadow: none !important;">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="collapsePage{{ $faq->id }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="headingPage{{ $faq->id }}" data-bs-parent="#faqAccordionPage">
                            <div class="accordion-body" style="font-size: 14.5px !important; color: var(--text-main) !important; line-height: 1.7 !important; padding: 20px 24px !important; border-top: 1px solid var(--border-color);">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="card p-4 text-center" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                        <i class="feather-help-circle mb-2" style="font-size: 32px; color: var(--gold-primary);"></i>
                        <h4 style="font-weight: 700;">Belum Ada FAQ</h4>
                        <p class="text-muted mb-0">Pertanyaan dan jawaban FAQ sedang disiapkan oleh pengurus.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- RIGHT COLUMN: SIDEBAR CONTACT CTA CARD -->
            <div class="col-lg-4">
                <div class="p-4" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 100%); border-radius: var(--radius-lg); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: var(--card-shadow); color: #FFFFFF;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); border: 1px solid rgba(201, 162, 39, 0.3); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 20px;">
                        <i class="feather-message-square"></i>
                    </div>

                    <h4 style="color: #FFFFFF !important; font-size: 20px; font-weight: 800; margin-bottom: 10px;">
                        Punya Pertanyaan Lain?
                    </h4>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
                        Jika pertanyaan Anda belum terdaftar di sini, jangan ragu untuk langsung menghubungi tim pengurus kami.
                    </p>

                    <a href="{{ route('contact') }}" style="background: linear-gradient(135deg, #C9A227 0%, #E8C766 100%) !important; color: #071526 !important; border: none !important; border-radius: 50px !important; padding: 12px 24px !important; font-size: 14px !important; font-weight: 700 !important; cursor: pointer; width: 100%; box-shadow: 0 6px 20px rgba(201, 162, 39, 0.35) !important; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none;">
                        <i class="feather-mail"></i> Hubungi Tim Pengurus
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
