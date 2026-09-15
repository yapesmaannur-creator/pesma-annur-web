@php
    $settings = \App\Models\Setting::all()->pluck('value', 'key');
    $footerLogoUrl = isset($settings['footer_logo']) && $settings['footer_logo'] ? asset('storage/' . $settings['footer_logo']) : asset('frontend/assets/images/logo/logo.png');
    $footerLogoDarkUrl = isset($settings['footer_logo_dark']) && $settings['footer_logo_dark'] ? asset('storage/' . $settings['footer_logo_dark']) : asset('frontend/assets/images/dark/logo/logo-light.png');
    $footerMenu1 = \App\Models\Menu::with(['items' => function($q) {
        $q->whereNull('parent_id')->orderBy('order');
    }])->where('location', 'footer')->where('is_active', true)->first();
    $footerMenu2 = \App\Models\Menu::with(['items' => function($q) {
        $q->whereNull('parent_id')->orderBy('order');
    }])->where('location', 'footer-2')->where('is_active', true)->first();
@endphp
<style>
    .annur-footer {
        background: #071526 !important;
        color: rgba(255, 255, 255, 0.85) !important;
        border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
        padding-top: 65px;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }
    .annur-footer .ft-title {
        color: #ffffff !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        margin-bottom: 20px !important;
        line-height: 1.3 !important;
    }
    .annur-footer .ft-title::after {
        content: '';
        display: block;
        width: 30px;
        height: 2px;
        background: var(--gold-primary, #C9A227);
        margin-top: 8px;
        border-radius: 2px;
    }
    .annur-footer .description {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 14px !important;
        line-height: 1.65 !important;
    }
    .annur-footer .ft-link {
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .annur-footer .ft-link li {
        margin-bottom: 10px !important;
        font-size: 14px !important;
        line-height: 1.6 !important;
    }
    .annur-footer .ft-link li a {
        color: rgba(255, 255, 255, 0.85) !important;
        font-size: 14px !important;
        text-decoration: none !important;
        transition: color 0.2s ease, padding-left 0.2s ease;
    }
    .annur-footer .ft-link li a:hover {
        color: var(--gold-secondary, #E8C766) !important;
        padding-left: 4px;
    }
    .annur-footer a {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .annur-footer a:hover {
        color: var(--gold-secondary, #E8C766) !important;
    }
    .annur-footer .social-icon li a {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #ffffff !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
        border-radius: 50% !important;
        width: 38px !important;
        height: 38px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s ease !important;
    }
    .annur-footer .social-icon li a:hover {
        background: var(--gold-primary, #C9A227) !important;
        color: #071526 !important;
        border-color: var(--gold-primary, #C9A227) !important;
    }
    .annur-footer-copyright {
        background: #040A14 !important;
        border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
        padding: 18px 0 !important;
        font-size: 13.5px !important;
        color: rgba(255, 255, 255, 0.6) !important;
    }
    .contact-label {
        color: #E8C766 !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        display: inline-block;
        min-width: 70px;
    }
    .contact-value {
        color: rgba(255, 255, 255, 0.85) !important;
        font-size: 14px !important;
    }
</style>

<footer class="rbt-footer annur-footer overflow-hidden">
    <div class="footer-top pb--60">
        <div class="container">
            <div class="row g-5">
                {{-- Column 1 - Brand & Identity --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <div class="logo logo-dark mb-3">
                            <a href="/">
                                <img src="{{ $footerLogoUrl }}" alt="{{ $settings['site_name'] ?? 'Pesma An-Nur' }}" style="max-height: 48px;">
                            </a>
                        </div>
                        <div class="logo d-none logo-light mb-3">
                            <a href="/">
                                <img src="{{ $footerLogoDarkUrl }}" alt="{{ $settings['site_name'] ?? 'Pesma An-Nur' }}" style="max-height: 48px;">
                            </a>
                        </div>

                        <p class="description mb-4">{{ $settings['footer_description'] ?? ($settings['site_description'] ?? 'Pusat Pendidikan Islami dan Karakter Mahasiswa.') }}</p>

                        <ul class="social-icon social-default justify-content-start gap-2 mb-4" style="list-style: none; padding: 0;">
                            @if(isset($settings['social_facebook']) && $settings['social_facebook'])
                            <li><a href="{{ $settings['social_facebook'] }}"><iconify-icon icon="ri:facebook-fill" style="font-size: 18px; vertical-align: middle;"></iconify-icon></a></li>
                            @endif
                            @if(isset($settings['social_twitter']) && $settings['social_twitter'])
                            <li><a href="{{ $settings['social_twitter'] }}"><iconify-icon icon="ri:twitter-x-fill" style="font-size: 18px; vertical-align: middle;"></iconify-icon></a></li>
                            @endif
                            @if(isset($settings['social_instagram']) && $settings['social_instagram'])
                            <li><a href="{{ $settings['social_instagram'] }}"><iconify-icon icon="ri:instagram-fill" style="font-size: 18px; vertical-align: middle;"></iconify-icon></a></li>
                            @endif
                            @if(isset($settings['social_tiktok']) && $settings['social_tiktok'])
                            <li><a href="{{ $settings['social_tiktok'] }}"><iconify-icon icon="ri:tiktok-fill" style="font-size: 18px; vertical-align: middle;"></iconify-icon></a></li>
                            @endif
                            @if(isset($settings['social_linkedin']) && $settings['social_linkedin'])
                            <li><a href="{{ $settings['social_linkedin'] }}"><iconify-icon icon="ri:linkedin-fill" style="font-size: 18px; vertical-align: middle;"></iconify-icon></a></li>
                            @endif
                            @if(isset($settings['social_youtube']) && $settings['social_youtube'])
                            <li><a href="{{ $settings['social_youtube'] }}"><iconify-icon icon="ri:youtube-fill" style="font-size: 18px; vertical-align: middle;"></iconify-icon></a></li>
                            @endif
                        </ul>

                        <div class="contact-btn">
                            <a class="btn-gold" href="{{ url('/kontak') }}" style="min-height: 42px; font-size: 13.5px; padding: 0 20px; color: #071526 !important;">
                                Hubungi Kami
                                <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Column 2 - Tautan Cepat --}}
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <h5 class="ft-title">{{ $settings['footer_col2_title'] ?? 'Tautan Cepat' }}</h5>
                        <ul class="ft-link">
                            @if($footerMenu1 && $footerMenu1->items->isNotEmpty())
                                @foreach($footerMenu1->items->take(6) as $item)
                                    <li><a href="{{ url($item->url) }}" target="{{ $item->target ?? '_self' }}">{{ $item->title }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ url('/') }}">Beranda</a></li>
                                <li><a href="{{ url('/tentang') }}">Tentang Kami</a></li>
                                <li><a href="{{ url('/program') }}">Program</a></li>
                                <li><a href="{{ url('/galeri') }}">Galeri</a></li>
                                <li><a href="{{ url('/artikel') }}">Artikel</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Column 3 - Halaman --}}
                <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <h5 class="ft-title">{{ $settings['footer_col3_title'] ?? 'Halaman' }}</h5>
                        <ul class="ft-link">
                            @if($footerMenu2 && $footerMenu2->items->isNotEmpty())
                                @foreach($footerMenu2->items->take(6) as $item)
                                    <li><a href="{{ url($item->url) }}" target="{{ $item->target ?? '_self' }}">{{ $item->title }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ url('/kontak') }}">Kontak Kami</a></li>
                                <li><a href="{{ url('/shop') }}">Toko Online</a></li>
                                <li><a href="{{ url('/faq') }}">FAQ</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Column 4 - Hubungi Kami & Newsletter --}}
                <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="footer-widget">
                        <h5 class="ft-title">{{ $settings['footer_col4_title'] ?? 'Hubungi Kami' }}</h5>
                        <ul class="ft-link mb-4">
                            @if(isset($settings['contact_phone']) && $settings['contact_phone'])
                            <li><span class="contact-label">Telepon:</span> <a href="tel:{{ $settings['contact_phone'] }}" class="contact-value">{{ $settings['contact_phone'] }}</a></li>
                            @endif
                            @if(isset($settings['contact_email']) && $settings['contact_email'])
                            <li><span class="contact-label">Email:</span> <a href="mailto:{{ $settings['contact_email'] }}" class="contact-value">{{ $settings['contact_email'] }}</a></li>
                            @endif
                            @if(isset($settings['contact_address']) && $settings['contact_address'])
                            <li><span class="contact-label">Alamat:</span> <span class="contact-value">{{ $settings['contact_address'] }}</span></li>
                            @endif
                        </ul>

                        <div class="pt-2">
                            <h5 class="ft-title" style="margin-bottom: 12px !important;">Newsletter</h5>
                            <p class="description mb-3">{{ $settings['newsletter_description'] ?? 'Dapatkan info terbaru langsung ke email Anda.' }}</p>

                            <form action="{{ url('/newsletter/subscribe') }}" method="POST">
                                @csrf
                                <div style="position: relative; width: 100%; max-width: 360px;">
                                    <input name="email" type="email" placeholder="Email Anda..." required style="background: rgba(255, 255, 255, 0.08) !important; border: 1px solid rgba(255, 255, 255, 0.2) !important; color: #ffffff !important; border-radius: 50px !important; padding: 12px 115px 12px 20px !important; font-size: 14px !important; width: 100% !important; outline: none !important; height: 46px !important; font-family: 'Plus Jakarta Sans', sans-serif !important;">
                                    <button type="submit" class="btn-gold" style="position: absolute !important; right: 3px !important; top: 3px !important; bottom: 3px !important; height: 40px !important; min-height: unset !important; padding: 0 20px !important; font-size: 13.5px !important; border-radius: 50px !important; border: none !important; margin: 0 !important; cursor: pointer; color: #071526 !important; font-weight: 700 !important;">
                                        Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Copyright Area  -->
    <div class="annur-footer-copyright">
        <div class="container text-center">
            <p class="m-0" style="font-size: 13.5px !important; color: rgba(255, 255, 255, 0.6) !important;">
                {{ $settings['footer_copyright'] ?? '© ' . date('Y') . ' Pesantren Mahasiswa An-Nur. All Rights Reserved.' }}
            </p>
        </div>
    </div>
    <!-- End Copyright Area  -->
</footer>
{!! $settings['custom_script'] ?? '' !!}

<!-- Mobile App-Feel Bottom Navigation -->
<x-frontend.mobile_bottom_nav />
