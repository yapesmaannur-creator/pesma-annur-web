@php
    $footerLogoUrl = isset($settings['footer_logo']) && $settings['footer_logo']
        ? asset('storage/' . $settings['footer_logo'])
        : (isset($settings['header_logo']) && $settings['header_logo']
            ? asset('storage/' . $settings['header_logo'])
            : null);

    // Footer menu from database
    $footerMenu = \App\Models\Menu::with(['items' => function($q) {
        $q->whereNull('parent_id')->orderBy('order')->with(['children' => function($q2) {
            $q2->orderBy('order');
        }]);
    }])->where('location', 'footer')->where('is_active', true)->first();
@endphp

<!-- ========== Landing Page Footer Start ========== -->
<footer class="landing-footer">
    <div class="landing-footer-top">
        <div class="container">
            <div class="row g-4 g-lg-5">

                {{-- Column 1: Brand / Description / Social --}}
                <div class="col-lg-4 col-md-6">
                    <div class="landing-footer-widget">
                        @if($footerLogoUrl)
                            <a href="{{ url('/') }}" class="landing-footer-logo d-inline-block mb-3">
                                <img src="{{ $footerLogoUrl }}" alt="{{ $settings['site_name'] ?? 'Logo' }}" style="max-height: 48px;">
                            </a>
                        @else
                            <a href="{{ url('/') }}" class="landing-footer-brand d-inline-block mb-3">
                                <h4 class="fw-bold text-white mb-0">{{ $settings['site_name'] ?? 'Annur' }}</h4>
                            </a>
                        @endif

                        <p class="landing-footer-desc text-white-50 mb-3">
                            {{ $settings['footer_description'] ?? ($settings['site_description'] ?? 'Lembaga pendidikan Islam terpadu yang berkomitmen mencetak generasi Qurani yang berakhlak mulia.') }}
                        </p>

                        {{-- Social Icons --}}
                        <div class="landing-footer-social d-flex gap-2 flex-wrap">
                            @if(isset($settings['social_facebook']) && $settings['social_facebook'])
                            <a href="{{ $settings['social_facebook'] }}" target="_blank" rel="noopener" class="landing-footer-social-link" title="Facebook">
                                <iconify-icon icon="mdi:facebook" width="20"></iconify-icon>
                            </a>
                            @endif
                            @if(isset($settings['social_instagram']) && $settings['social_instagram'])
                            <a href="{{ $settings['social_instagram'] }}" target="_blank" rel="noopener" class="landing-footer-social-link" title="Instagram">
                                <iconify-icon icon="mdi:instagram" width="20"></iconify-icon>
                            </a>
                            @endif
                            @if(isset($settings['social_tiktok']) && $settings['social_tiktok'])
                            <a href="{{ $settings['social_tiktok'] }}" target="_blank" rel="noopener" class="landing-footer-social-link" title="TikTok">
                                <iconify-icon icon="bi:tiktok" width="18"></iconify-icon>
                            </a>
                            @endif
                            @if(isset($settings['social_twitter']) && $settings['social_twitter'])
                            <a href="{{ $settings['social_twitter'] }}" target="_blank" rel="noopener" class="landing-footer-social-link" title="Twitter/X">
                                <iconify-icon icon="mdi:twitter" width="20"></iconify-icon>
                            </a>
                            @endif
                            @if(isset($settings['social_youtube']) && $settings['social_youtube'])
                            <a href="{{ $settings['social_youtube'] }}" target="_blank" rel="noopener" class="landing-footer-social-link" title="YouTube">
                                <iconify-icon icon="mdi:youtube" width="20"></iconify-icon>
                            </a>
                            @endif
                            @if(isset($settings['social_linkedin']) && $settings['social_linkedin'])
                            <a href="{{ $settings['social_linkedin'] }}" target="_blank" rel="noopener" class="landing-footer-social-link" title="LinkedIn">
                                <iconify-icon icon="mdi:linkedin" width="20"></iconify-icon>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Column 2: Quick Links (from Menu DB or fallback) --}}
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="landing-footer-widget">
                        <h6 class="landing-footer-title">{{ $settings['footer_col2_title'] ?? 'Tautan Cepat' }}</h6>
                        <ul class="landing-footer-links list-unstyled mb-0">
                            @if($footerMenu && $footerMenu->items->isNotEmpty())
                                @foreach($footerMenu->items->take(6) as $item)
                                    <li><a href="{{ url($item->url) }}" target="{{ $item->target ?? '_self' }}">{{ $item->title }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ url('/') }}">Beranda</a></li>
                                <li><a href="{{ url('/tentang') }}">Tentang Kami</a></li>
                                <li><a href="{{ url('/program') }}">Program</a></li>
                                <li><a href="{{ url('/artikel') }}">Artikel</a></li>
                                <li><a href="{{ url('/galeri') }}">Galeri</a></li>
                                <li><a href="{{ url('/kegiatan') }}">Kegiatan</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Column 3: Layanan / Halaman --}}
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="landing-footer-widget">
                        <h6 class="landing-footer-title">{{ $settings['footer_col3_title'] ?? 'Halaman' }}</h6>
                        <ul class="landing-footer-links list-unstyled mb-0">
                            <li><a href="{{ url('/kontak') }}">Kontak Kami</a></li>
                            <li><a href="{{ url('/shop') }}">Toko Online</a></li>
                            <li><a href="{{ url('/faq') }}">FAQ</a></li>
                            @if(Route::has('login'))
                            <li><a href="{{ route('login') }}">Login</a></li>
                            @endif
                        </ul>
                    </div>
                </div>

                {{-- Column 4: Contact Info --}}
                <div class="col-lg-4 col-md-6">
                    <div class="landing-footer-widget">
                        <h6 class="landing-footer-title">{{ $settings['footer_col4_title'] ?? 'Hubungi Kami' }}</h6>
                        <ul class="landing-footer-contact list-unstyled mb-0">
                            @if(isset($settings['contact_address']) && $settings['contact_address'])
                            <li class="d-flex gap-2 mb-3">
                                <iconify-icon icon="solar:map-point-bold-duotone" class="text-primary fs-20 mt-1 flex-shrink-0"></iconify-icon>
                                <span class="text-white-50">{{ $settings['contact_address'] }}</span>
                            </li>
                            @endif
                            @if(isset($settings['contact_phone']) && $settings['contact_phone'])
                            <li class="d-flex gap-2 mb-3">
                                <iconify-icon icon="solar:phone-bold-duotone" class="text-primary fs-20 mt-1 flex-shrink-0"></iconify-icon>
                                <a href="tel:{{ $settings['contact_phone'] }}" class="text-white-50 text-decoration-none landing-footer-contact-link">{{ $settings['contact_phone'] }}</a>
                            </li>
                            @endif
                            @if(isset($settings['contact_email']) && $settings['contact_email'])
                            <li class="d-flex gap-2 mb-3">
                                <iconify-icon icon="solar:letter-bold-duotone" class="text-primary fs-20 mt-1 flex-shrink-0"></iconify-icon>
                                <a href="mailto:{{ $settings['contact_email'] }}" class="text-white-50 text-decoration-none landing-footer-contact-link">{{ $settings['contact_email'] }}</a>
                            </li>
                            @endif
                        </ul>

                        {{-- Google Maps Embed (optional) --}}
                        @if(isset($settings['google_maps_embed']) && $settings['google_maps_embed'])
                        <div class="landing-footer-map mt-2 rounded overflow-hidden" style="height: 120px;">
                            {!! $settings['google_maps_embed'] !!}
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Footer Bottom / Copyright --}}
    <div class="landing-footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-white-50 small">
                        {{ $settings['footer_copyright'] ?? ('© ' . date('Y') . ' ' . ($settings['site_name'] ?? 'Annur') . '. Hak cipta dilindungi.') }}
                        @if(isset($settings['credit_text']) && $settings['credit_text'])
                            &middot; Dibuat oleh <a href="{{ $settings['credit_link'] ?? '#' }}" class="text-white text-decoration-none fw-medium" target="_blank" rel="noopener">{{ $settings['credit_text'] }}</a>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <a href="{{ url('/') }}" class="text-white-50 text-decoration-none small me-3 landing-footer-bottom-link">Beranda</a>
                    <a href="{{ url('/kontak') }}" class="text-white-50 text-decoration-none small me-3 landing-footer-bottom-link">Kontak</a>
                    <a href="{{ url('/faq') }}" class="text-white-50 text-decoration-none small landing-footer-bottom-link">FAQ</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ========== Landing Page Footer End ========== -->
