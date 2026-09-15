<!-- Start Header Area -->
<header class="rbt-header rbt-header-10">
    <div class="rbt-sticky-placeholder"></div>

    <style>
        /* HEADER NAV STYLING & GLASSMORPHISM */
        .rbt-header-wrapper.header-sticky {
            transition: background 0.3s ease, box-shadow 0.3s ease;
        }
        .rbt-header-wrapper.header-sticky.rbt-sticky {
            background: rgba(7, 21, 38, 0.96) !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            box-shadow: 0 10px 32px rgba(0, 0, 0, 0.3) !important;
            border-bottom: 1px solid rgba(201, 162, 39, 0.2) !important;
        }
        body.active-dark-mode .rbt-header-wrapper.header-sticky {
            background: rgba(7, 15, 30, 0.98) !important;
            border-bottom-color: rgba(201, 162, 39, 0.25) !important;
        }
        .mainmenu-nav .mainmenu > li > a {
            font-weight: 700 !important;
            font-size: 14.5px !important;
            color: var(--text-main);
            transition: color 0.25s ease;
            padding: 12px 14px;
        }
        .rbt-header-wrapper.rbt-sticky .mainmenu-nav .mainmenu > li > a,
        body.active-dark-mode .mainmenu-nav .mainmenu > li > a {
            color: #FFFFFF !important;
        }
        .mainmenu-nav .mainmenu > li > a:hover,
        .mainmenu-nav .mainmenu > li.active > a {
            color: #E8C766 !important;
        }

        /* SUBMENU DROPDOWN REDESIGN & HIGH CONTRAST FIX */
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu,
        ul.submenu {
            background: #0B1F3A !important;
            backdrop-filter: blur(16px) !important;
            -webkit-backdrop-filter: blur(16px) !important;
            border: 1px solid rgba(201, 162, 39, 0.35) !important;
            border-radius: 14px !important;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45) !important;
            padding: 10px 8px !important;
            min-width: 220px !important;
        }
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu li,
        ul.submenu li {
            list-style: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu li a,
        ul.submenu li a {
            color: #FFFFFF !important;
            background: transparent !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            padding: 10px 16px !important;
            border-radius: 8px !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            text-decoration: none !important;
        }
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu li a:hover,
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu li a:focus,
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu li a:active,
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu li.active > a,
        .mainmenu-nav .mainmenu > li.has-dropdown .submenu li:hover > a,
        ul.submenu li a:hover,
        ul.submenu li a:focus,
        ul.submenu li a:active,
        ul.submenu li:hover > a {
            background: rgba(201, 162, 39, 0.25) !important;
            color: #F5E199 !important;
            padding-left: 20px !important;
        }

        /* ROUND BUTTONS & ACCESS ICONS */
        .rbt-round-btn {
            background: rgba(11, 31, 58, 0.06);
            border: 1px solid var(--border-color);
            color: var(--navy-primary) !important;
            transition: all 0.25s ease;
        }
        .rbt-sticky .rbt-round-btn,
        body.active-dark-mode .rbt-round-btn {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: #FFFFFF !important;
        }
        .rbt-round-btn:hover {
            background: #C9A227 !important;
            color: #071526 !important;
            border-color: #C9A227 !important;
            transform: scale(1.06);
        }

        /* SEARCH DROPDOWN REDESIGN - EXECUTIVE NAVY & GOLD */
        .rbt-search-dropdown {
            background: rgba(7, 21, 38, 0.98) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border-bottom: 1px solid rgba(201, 162, 39, 0.3) !important;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5) !important;
            padding: 30px 0 20px !important;
        }
        .rbt-search-dropdown input {
            background: rgba(255, 255, 255, 0.07) !important;
            border: 1px solid rgba(201, 162, 39, 0.3) !important;
            color: #FFFFFF !important;
            border-radius: 12px !important;
            font-size: 15px !important;
            padding: 12px 20px !important;
        }
        .rbt-search-dropdown input::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        .rbt-search-dropdown input:focus {
            border-color: #E8C766 !important;
            box-shadow: 0 0 16px rgba(232, 199, 102, 0.3) !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }
        .rbt-search-dropdown .rbt-title-style-2 {
            color: #E8C766 !important;
            font-weight: 700 !important;
            letter-spacing: 0.05em !important;
            text-transform: uppercase !important;
            font-size: 12px !important;
        }
        .rbt-search-dropdown .rbt-separator {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* QUICK SEARCH PILL BUTTONS (ELIMINATE PURPLE/BLUE BORDER) */
        .btn-border-gradient,
        .rbt-btn.btn-border-gradient,
        a.btn-border-gradient {
            background: rgba(201, 162, 39, 0.1) !important;
            border: 1px solid rgba(201, 162, 39, 0.35) !important;
            color: rgba(255, 255, 255, 0.95) !important;
            border-radius: 50px !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            padding: 8px 18px !important;
            transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
            display: inline-flex !important;
            align-items: center !important;
            text-decoration: none !important;
        }
        .btn-border-gradient:hover,
        .rbt-btn.btn-border-gradient:hover,
        a.btn-border-gradient:hover {
            background: #C9A227 !important;
            color: #071526 !important;
            border-color: #C9A227 !important;
            box-shadow: 0 4px 16px rgba(201, 162, 39, 0.4) !important;
            transform: translateY(-2px) !important;
        }
        .btn-border-gradient iconify-icon,
        .rbt-btn.btn-border-gradient iconify-icon {
            color: #E8C766 !important;
            transition: color 0.25s ease !important;
        }
        .btn-border-gradient:hover iconify-icon,
        .rbt-btn.btn-border-gradient:hover iconify-icon {
            color: #071526 !important;
        }
    </style>

    <div class="rbt-header-wrapper header-space-betwween header-sticky">
        <div class="container-fluid">
            <div class="mainbar-row rbt-navigation-center align-items-center">
                <div class="header-left rbt-header-content">
                    <div class="header-info">
                        <div class="logo logo-dark">
                            <a href="/">
                                @php
                                    $headerLogo = \App\Models\Setting::getByKey('header_logo');
                                    $headerLogoDark = \App\Models\Setting::getByKey('header_logo_dark');
                                @endphp
                                <img src="{{ $headerLogo ? asset('storage/' . $headerLogo) : asset('frontend/assets/images/logo/logo.png') }}" alt="Website Logo">
                            </a>
                        </div>

                        <div class="logo d-none logo-light">
                            <a href="/">
                                <img src="{{ $headerLogoDark ? asset('storage/' . $headerLogoDark) : asset('frontend/assets/images/dark/logo/logo-light.png') }}" alt="Website Logo">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rbt-main-navigation d-none d-xl-block">
                    <nav class="mainmenu-nav">
                        <ul class="mainmenu">
                            @php
                                $headerMenu = \App\Models\Menu::with(['items' => function($q) {
                                    $q->whereNull('parent_id')->orderBy('order');
                                }, 'items.children'])->where('location', 'header')->first();
                            @endphp

                            @if($headerMenu?->items && $headerMenu->items->count() > 0)
                                @foreach($headerMenu->items as $item)
                                    @if($item->children->count() > 0)
                                        <li class="has-dropdown has-menu-child-item">
                                            <a href="{{ url($item->url ?? '#') }}">{{ $item->title }}
                                                <iconify-icon icon="solar:alt-arrow-down-linear" class="ms-1" style="font-size: 12px; vertical-align: middle;"></iconify-icon>
                                            </a>
                                            <ul class="submenu">
                                                @foreach($item->children as $child)
                                                    <li><a href="{{ url($child->url ?? '#') }}" target="{{ $child->target ?? '_self' }}">{{ $child->title }}</a></li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ url($item->url ?? '#') }}" target="{{ $item->target ?? '_self' }}">{{ $item->title }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @else
                                <li><a href="/">Beranda</a></li>
                                <li><a href="/tentang">Tentang</a></li>
                                <li><a href="/program">Program</a></li>
                                <li><a href="https://e-maktab.pesma-annur.net/donasi" target="_blank" style="color: #10b981 !important; font-weight: 700;"><iconify-icon icon="solar:heart-bold" class="me-1"></iconify-icon>Donasi</a></li>
                                <li><a href="/kegiatan">Kegiatan</a></li>
                                <li><a href="/galeri">Galeri</a></li>
                                <li><a href="/artikel">Artikel</a></li>
                                <li><a href="/kirim-tulisan">Kirim Tulisan</a></li>
                                <li><a href="/faq">FAQ</a></li>
                                <li><a href="/kontak">Kontak</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>

                <div class="header-right">
                    @php
                        $ctaUrl = \App\Models\Setting::getByKey('cta_header_url') ?: 'https://e-maktab.pesma-annur.net/psb';
                        $ctaText = \App\Models\Setting::getByKey('cta_header_text', 'Daftar Sekarang');
                    @endphp

                    <!-- Quick Access Icons -->
                    <ul class="quick-access d-flex align-items-center gap-2">
                        <!-- Search -->
                        <li class="access-icon">
                            <a class="search-trigger-active rbt-round-btn d-inline-flex align-items-center justify-content-center" href="#" title="Cari" style="width: 40px; height: 40px;">
                                <iconify-icon icon="solar:magnifer-linear" style="font-size: 19px; display: flex; align-items: center; justify-content: center;"></iconify-icon>
                            </a>
                        </li>

                        <!-- Dark/Light Mode Toggle -->
                        <li class="access-icon d-none d-md-flex">
                            <a href="javascript:void(0);" class="rbt-round-btn d-inline-flex align-items-center justify-content-center" id="custom-theme-toggle" title="Mode Layar" style="width: 40px; height: 40px;">
                                <iconify-icon icon="solar:moon-linear" id="header-theme-icon" style="font-size: 19px; display: flex; align-items: center; justify-content: center;"></iconify-icon>
                            </a>
                        </li>

                        @if($ctaUrl)
                        <!-- CTA Button -->
                        <li class="rbt-btn-wrapper d-none d-xl-block ms-1">
                            <a class="btn-gold d-inline-flex align-items-center justify-content-center gap-2" href="{{ $ctaUrl }}" target="_blank" rel="noopener noreferrer" style="min-height: 42px; padding: 0 22px; font-size: 13.5px; color: #071526 !important; font-weight: 700;">
                                {{ $ctaText }}
                                <iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 15px;"></iconify-icon>
                            </a>
                        </li>
                        @endif
                    </ul>

                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar d-block d-xl-none ms-2">
                        <div class="hamberger">
                            <button class="hamberger-button rbt-round-btn">
                                <iconify-icon icon="solar:hamburger-menu-linear" style="font-size: 20px; vertical-align: middle;"></iconify-icon>
                            </button>
                        </div>
                    </div>
                    <!-- End Mobile-Menu-Bar -->
                </div>
            </div>
        </div>

        <!-- Start Search Dropdown -->
        <div class="rbt-search-dropdown">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ url('/cari') }}" method="GET">
                            <input type="text" name="q" placeholder="Cari artikel, program, produk..." autocomplete="off" id="global-search-input">
                            <div class="submit-btn">
                                <button class="btn-gold" type="submit" style="min-height: 44px; padding: 0 22px; color: #071526 !important; font-weight: 700;">Cari</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="rbt-separator-mid">
                    <hr class="rbt-separator m-0">
                </div>

                <div class="row g-4 pt--30 pb--60">
                    <div class="col-lg-12">
                        <div class="section-title">
                            <h6 class="rbt-title-style-2" style="color:var(--text-main);">Telusuri Cepat</h6>
                        </div>
                        <ul class="rbt-information-list mt--10" style="display:flex; flex-wrap:wrap; gap:10px; list-style:none; padding:0;">
                            <li><a href="{{ url('/artikel') }}" class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none"><iconify-icon icon="solar:document-text-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Artikel</a></li>
                            <li><a href="{{ url('/program') }}" class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none"><iconify-icon icon="solar:book-2-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Program</a></li>
                            <li><a href="{{ url('/shop') }}" class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none"><iconify-icon icon="solar:shop-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Toko Buku</a></li>
                            <li><a href="{{ url('/kegiatan') }}" class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none"><iconify-icon icon="solar:calendar-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Kegiatan</a></li>
                            <li><a href="{{ url('/galeri') }}" class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none"><iconify-icon icon="solar:gallery-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Galeri</a></li>
                            <li><a href="{{ url('/kontak') }}" class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none"><iconify-icon icon="solar:mailbox-bold-duotone" class="me-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon> Kontak</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Search Dropdown -->

    </div>
    <a class="rbt-close_side_menu" href="javascript:void(0);"></a>

</header>
