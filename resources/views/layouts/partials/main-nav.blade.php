<div class="main-nav">
    <!-- Sidebar Logo -->
    <div class="logo-box">
        @php
            $headerLogoDark = \App\Models\Setting::getByKey('header_logo_dark');
            $headerLogo = \App\Models\Setting::getByKey('header_logo');
            $logoToUse = $headerLogoDark ?: $headerLogo;
            $logoUrl = $logoToUse ? asset('storage/' . $logoToUse) : asset('images/logo-dark.png');
            $logoSmUrl = $logoToUse ? asset('storage/' . $logoToUse) : asset('images/logo-sm.png');
        @endphp
        <a href="{{ route('admin.dashboard') }}" class="logo-dark">
            <img src="{{ $logoSmUrl }}" class="logo-sm" alt="logo sm">
            <img src="{{ $logoUrl }}" class="logo-lg" alt="logo dark">
        </a>

        <a href="{{ route('admin.dashboard') }}" class="logo-light">
            <img src="{{ $logoSmUrl }}" class="logo-sm" alt="logo sm">
            <img src="{{ $logoUrl }}" class="logo-lg" alt="logo light">
        </a>
    </div>

    <!-- Menu Toggle Button (sm-hover) -->
    <button type="button" class="button-sm-hover" aria-label="Show Full Sidebar">
        <iconify-icon icon="solar:double-alt-arrow-right-bold-duotone" class="button-sm-hover-icon"></iconify-icon>
    </button>

    <div class="scrollbar" data-simplebar>
        <ul class="navbar-nav" id="navbar-nav">

            <li class="menu-title">Main Menu</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:widget-5-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Dashboard </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:panorama-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Banner / Slider </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow {{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.page-sections.*') ? '' : 'collapsed' }}" href="#sidebarLandingPage" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.page-sections.*') ? 'true' : 'false' }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:layers-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Kelola Landing Page </span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.pages.*') || request()->routeIs('admin.page-sections.*') ? 'show' : '' }}" id="sidebarLandingPage">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->routeIs('admin.page-sections.*') ? 'active' : '' }}" href="{{ route('admin.page-sections.index') }}">Kelola Section</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->routeIs('admin.pages.*') && !request()->routeIs('admin.page-sections.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">Daftar Halaman</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.categories.*') ? '' : 'collapsed' }}" href="#sidebarArtikel" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.categories.*') ? 'true' : 'false' }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Artikel & Berita </span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.posts.*') || request()->routeIs('admin.categories.*') ? 'show' : '' }}" id="sidebarArtikel">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">Semua Artikel</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">Kategori</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}" href="{{ route('admin.submissions.index') }}">
                                <div class="d-flex align-items-center justify-content-between">
                                    <span>Review Kiriman</span>
                                    @php $pendingReq = \App\Models\ArticleSubmission::where('status','pending')->count(); @endphp
                                    @if($pendingReq > 0)
                                    <span class="badge bg-danger rounded-pill px-2 py-1 fs-12">{{ $pendingReq }}</span>
                                    @endif
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link menu-arrow {{ request()->routeIs('admin.galleries.*') || request()->routeIs('admin.gallery-albums.*') ? '' : 'collapsed' }}" href="#sidebarGaleri" data-bs-toggle="collapse" role="button" aria-expanded="{{ request()->routeIs('admin.galleries.*') || request()->routeIs('admin.gallery-albums.*') ? 'true' : 'false' }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:gallery-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Manajemen Galeri </span>
                </a>
                <div class="collapse {{ request()->routeIs('admin.galleries.*') || request()->routeIs('admin.gallery-albums.*') ? 'show' : '' }}" id="sidebarGaleri">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->routeIs('admin.gallery-albums.*') ? 'active' : '' }}" href="{{ route('admin.gallery-albums.index') }}">Album Galeri</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">Foto & Media</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-round-like-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Testimoni </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:chat-round-dots-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> FAQ </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.activities.*') ? 'active' : '' }}" href="{{ route('admin.activities.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:calendar-star-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Kegiatan </span>
                </a>
            </li>

            @if(auth()->user() && auth()->user()->isSuperAdmin())
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}" href="{{ route('admin.programs.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:folder-with-files-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Program Pesantren </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:cart-large-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Manajemen Toko </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.downloads.*') ? 'active' : '' }}" href="{{ route('admin.downloads.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:cloud-download-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Download Center </span>
                </a>
            </li>

            <li class="menu-title mt-2">Sistem & Komunikasi</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:inbox-in-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Pesan Masuk 
                        @php
                            $unreadContacts = \App\Models\Contact::where('is_read', false)->count();
                        @endphp
                        @if($unreadContacts > 0)
                            <span class="badge bg-danger rounded-pill ms-1">{{ $unreadContacts }}</span>
                        @endif
                    </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:users-group-rounded-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Manajemen Pengguna </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" href="{{ route('admin.menus.builder') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:hamburger-menu-linear"></iconify-icon>
                    </span>
                    <span class="nav-text"> Manajemen Menu </span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:settings-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> Pengaturan Situs </span>
                </a>
            </li>

            <li class="menu-title mt-2">Template Referensi</li>

            <li class="nav-item">
                <a class="nav-link menu-arrow" href="#sidebarDemo" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarDemo">
                    <span class="nav-icon">
                        <iconify-icon icon="solar:layers-bold-duotone"></iconify-icon>
                    </span>
                    <span class="nav-text"> UI Components </span>
                </a>
                <div class="collapse" id="sidebarDemo">
                    <ul class="nav sub-navbar-nav">
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('third', ['components', 'ui', 'buttons']) }}">Buttons</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('third', ['components', 'forms', 'basic']) }}">Forms</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('third', ['components', 'tables', 'basic']) }}">Tables</a>
                        </li>
                        <li class="sub-nav-item">
                            <a class="sub-nav-link" href="{{ route('third', ['components', 'icons', 'solar']) }}">Icons</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

        </ul>
    </div>
</div>
