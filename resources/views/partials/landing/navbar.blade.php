<header class="topbar landing-navbar shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Brand Logo -->
        <div class="d-flex align-items-center">
            <a class="navbar-brand me-4" href="{{ url('/') }}">
                <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0 text-primary">
                    {{ $settings['site_name'] ?? 'Larkon' }}
                </h4>
            </a>
            
            <!-- Left Menu Links -->
            <ul class="nav d-none d-md-flex align-items-center m-0 gap-2">
                @php
                    $headerMenu = \App\Models\Menu::with(['items' => function($q) {
                        $q->whereNull('parent_id')->orderBy('order')->with(['children' => function($q2) {
                            $q2->orderBy('order');
                        }]);
                    }])->where('location', 'header')->where('is_active', true)->first();
                @endphp

                @if($headerMenu && $headerMenu->items->isNotEmpty())
                    @foreach($headerMenu->items as $item)
                        @if($item->children->isNotEmpty())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle fs-15 fw-medium text-dark px-3 py-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $item->title }}
                                </a>
                                <ul class="dropdown-menu shadow-sm border-0 mt-2">
                                    @foreach($item->children as $child)
                                        <li><a class="dropdown-item py-2" href="{{ url($child->url) }}" target="{{ $child->target }}">{{ $child->title }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link fs-15 fw-medium text-dark px-3 py-2" href="{{ url($item->url) }}" target="{{ $item->target }}">{{ $item->title }}</a>
                            </li>
                        @endif
                    @endforeach
                @else
                    <!-- Fallback Menu -->
                    <li class="nav-item"><a class="nav-link fs-15 fw-medium text-dark px-3 mt-1" href="{{ url('/') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link fs-15 fw-medium text-dark px-3 mt-1" href="{{ url('/articles') }}">Artikel</a></li>
                @endif
            </ul>
        </div>

        <!-- Right Side UI Actions -->
        <div class="d-flex align-items-center gap-1">
            <!-- Theme Color (Light/Dark Switcher from Template) -->
            <div class="topbar-item">
                <button type="button" class="topbar-button" id="light-dark-mode">
                    <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                </button>
            </div>

            <!-- Auth Handling Panel -->
            @guest
                <div class="topbar-item ms-2">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm me-1 rounded-pill px-3">
                        <iconify-icon icon="solar:login-2-bold-duotone" class="fs-18 align-middle me-1"></iconify-icon> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">Register</a>
                </div>
            @endguest

            @auth
                <!-- User Profile Dropdown Using Template Structure -->
                <div class="dropdown topbar-item">
                    <a type="button" class="topbar-button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if(Auth::user()->avatar)
                                <img class="rounded-circle" width="32" height="32" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
                            @else
                                <div class="avatar-sm me-2">
                                    <span class="avatar-title bg-soft-primary text-primary fs-20 rounded-circle">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow">
                        <h6 class="dropdown-header">Halo, {{ Auth::user()->name }}!</h6>
                        
                        @if(Auth::user()->role === 'admin')
                            <a class="dropdown-item" href="{{ route('filament.admin.pages.dashboard') ?? '/admin' }}">
                                <i class="bx bx-cog text-muted fs-18 align-middle me-1"></i>
                                <span class="align-middle">Dashboard Admin</span>
                            </a>
                        @else
                            <a class="dropdown-item" href="{{ route('profile.edit') ?? '/profile' }}">
                                <i class="bx bx-user-circle text-muted fs-18 align-middle me-1"></i>
                                <span class="align-middle">Profil Saya</span>
                            </a>
                        @endif
                        
                        <div class="dropdown-divider my-1"></div>
                        
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                <i class="bx bx-log-out fs-18 align-middle me-1"></i>
                                <span class="align-middle">Batalkan Sesi (Logout)</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>
