<div class="popup-mobile-menu">
    <style>
        .popup-mobile-menu .inner-wrapper {
            background: linear-gradient(135deg, #071526 0%, #0B1F3A 100%) !important;
            box-shadow: -10px 0 40px rgba(0, 0, 0, 0.4) !important;
            color: #FFFFFF !important;
        }
        .popup-mobile-menu .inner-top .description {
            color: rgba(255, 255, 255, 0.75) !important;
            font-size: 13px !important;
        }
        .popup-mobile-menu .close-button {
            background: rgba(201, 162, 39, 0.15) !important;
            color: #E8C766 !important;
            border: 1px solid rgba(201, 162, 39, 0.35) !important;
        }
        .popup-mobile-menu .close-button:hover {
            background: #C9A227 !important;
            color: #071526 !important;
        }
        .popup-mobile-menu .mainmenu li a {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 700 !important;
            font-size: 15px !important;
            padding: 12px 16px !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
            transition: all 0.2s ease !important;
        }
        .popup-mobile-menu .mainmenu li a:hover,
        .popup-mobile-menu .mainmenu li.active a {
            color: #E8C766 !important;
            padding-left: 22px !important;
        }
        .popup-mobile-menu .mainmenu li .submenu {
            background: rgba(0, 0, 0, 0.2) !important;
            border-left: 2px solid #E8C766 !important;
            padding-left: 10px !important;
            margin-left: 10px !important;
            border-radius: 0 8px 8px 0 !important;
        }
        .popup-mobile-menu .mainmenu li .submenu li a {
            font-size: 13.5px !important;
            border-bottom: none !important;
        }
    </style>
    <div class="inner-wrapper">
        <div class="inner-top">
            <div class="content">
                <div class="logo logo-dark">
                    <a href="/">
                        <img src="{{ \App\Models\Setting::getByKey('header_logo') ? asset('storage/' . \App\Models\Setting::getByKey('header_logo')) : asset('frontend/assets/images/logo/logo.png') }}" alt="Education Logo Images" style="max-height: 40px; width: auto;">
                    </a>
                </div>
                <div class="logo d-none logo-light">
                    <a href="/">
                        <img src="{{ \App\Models\Setting::getByKey('header_logo_dark') ? asset('storage/' . \App\Models\Setting::getByKey('header_logo_dark')) : asset('frontend/assets/images/dark/logo/logo-light.png') }}" alt="Education Logo Images" style="max-height: 40px; width: auto;">
                    </a>
                </div>
                <div class="rbt-btn-close">
                    <button class="close-button rbt-round-btn"><iconify-icon icon="solar:close-circle-bold-duotone" style="font-size: 20px; vertical-align: middle;"></iconify-icon></button>
                </div>
            </div>
            <p class="description">{{ \App\Models\Setting::getByKey('footer_description') ?? 'Pesantren Mahasiswa An-Nur' }}</p>
        </div>

        <nav class="mainmenu-nav">
            <ul class="mainmenu">
                @php
                    $headerMenu = \App\Models\Menu::with(['items' => function($q) {
                        $q->whereNull('parent_id')->orderBy('order');
                    }, 'items.children'])->where('location', 'header')->first();
                @endphp

                @if($headerMenu && $headerMenu->items->count() > 0)
                    @foreach($headerMenu->items as $item)
                        @if($item->children->count() > 0)
                            <li class="has-dropdown has-menu-child-item">
                                <a href="{{ url($item->url ?? '#') }}">{{ $item->title }}
                                    <iconify-icon icon="solar:alt-arrow-down-linear" class="ms-1" style="font-size: 12px; vertical-align: middle;"></iconify-icon>
                                </a>
                                <ul class="submenu">
                                    @foreach($item->children as $child)
                                        @if($child->children->count() > 0)
                                            <li class="has-dropdown"><a href="{{ url($child->url ?? '#') }}">{{ $child->title }}</a>
                                                <ul class="submenu">
                                                    @foreach($child->children as $grandchild)
                                                        <li><a href="{{ url($grandchild->url ?? '#') }}">{{ $grandchild->title }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li><a href="{{ url($child->url ?? '#') }}">{{ $child->title }}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ url($item->url ?? '#') }}">{{ $item->title }}</a>
                            </li>
                        @endif
                    @endforeach
                @else
                    <li><a href="/">Beranda</a></li>
                    <li><a href="/tentang">Tentang</a></li>
                    <li><a href="/program">Program</a></li>
                    <li><a href="/kegiatan">Kegiatan</a></li>
                    <li><a href="/galeri">Galeri</a></li>
                    <li><a href="/artikel">Artikel</a></li>
                    <li><a href="/kirim-tulisan">Kirim Tulisan</a></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/kontak">Kontak</a></li>
                @endif
            </ul>
        </nav>

        <div class="mobile-menu-bottom mt-4">
            <!-- Mobile CTA -->
            @php
                $ctaUrl = \App\Models\Setting::getByKey('cta_header_url') ?: 'https://e-maktab.pesma-annur.net/psb';
                $ctaText = \App\Models\Setting::getByKey('cta_header_text', 'Daftar Sekarang');
            @endphp
            @if($ctaUrl)
            <div class="rbt-btn-wrapper mb--20">
                <a class="btn-gold w-100 justify-content-center text-center"
                   href="{{ $ctaUrl }}" target="_blank" rel="noopener noreferrer" style="min-height: 44px; color: #071526 !important; font-weight: 700;">
                    <span>{{ $ctaText }}</span>
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
