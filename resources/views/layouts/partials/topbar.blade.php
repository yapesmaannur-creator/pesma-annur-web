<header class="topbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="d-flex align-items-center">
                <!-- Menu Toggle Button -->
                <div class="topbar-item">
                    <button type="button" class="button-toggle-menu me-2">
                        <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                    </button>
                </div>

                <!-- Menu Toggle Button -->
                <div class="topbar-item">
                    <h4 class="fw-bold topbar-button pe-none text-uppercase mb-0">{{ \App\Models\Setting::getByKey('site_name', 'Larkon') }}</h4>
                </div>
            </div>

            <div class="d-flex align-items-center gap-1">

                <!-- Visit User Site / Frontend -->
                <div class="topbar-item">
                    <a href="{{ url('/') }}" target="_blank" class="topbar-button text-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kunjungi Situs Web">
                        <iconify-icon icon="solar:global-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                    </a>
                </div>

                <!-- Theme Color (Light/Dark) -->
                <div class="topbar-item">
                    <button type="button" class="topbar-button" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Mode Gelap">
                        <iconify-icon icon="solar:moon-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                    </button>
                </div>

                <!-- Notification dummy removed -->

                <!-- Theme Setting -->
                <div class="topbar-item d-none d-md-flex">
                    <button type="button" class="topbar-button" id="theme-settings-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                        <iconify-icon icon="solar:settings-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                    </button>
                </div>

                <!-- Activity -->
                <div class="topbar-item d-none d-md-flex">
                    <button type="button" class="topbar-button" id="theme-activity-btn" data-bs-toggle="offcanvas"
                            data-bs-target="#theme-activity-offcanvas" aria-controls="theme-activity-offcanvas">
                        <iconify-icon icon="solar:clock-circle-bold-duotone" class="fs-24 align-middle"></iconify-icon>
                    </button>
                </div>

                <!-- User -->
                <div class="dropdown topbar-item">
                    <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                              <span class="d-flex align-items-center">
                                    <img class="rounded-circle" width="32" height="32" style="object-fit: cover;" src="{{ Auth::check() && Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/users/avatar-1.jpg') }}" alt="User Avatar">
                              </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Welcome {{ Auth::check() ? Auth::user()->name : 'Admin' }}!</h6>
                        @if(Route::has('profile.edit'))
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <iconify-icon icon="solar:user-circle-bold-duotone" class="text-muted fs-18 align-middle me-1"></iconify-icon><span
                                class="align-middle">Profil</span>
                        </a>
                        @endif

                        <div class="dropdown-divider my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger border-0 bg-transparent w-100 text-start">
                                <iconify-icon icon="solar:logout-2-bold-duotone" class="fs-18 align-middle me-1"></iconify-icon><span
                                    class="align-middle">Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- App Search (Removed because it was just a visual dummy from the original theme) -->
            </div>
        </div>
    </div>
</header>

<!-- Activity Timeline -->
<div>
    <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="theme-activity-offcanvas"
         style="max-width: 450px; width: 100%;">
        <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
            <h5 class="text-white m-0 fw-semibold">Activity Stream (Aktivitas Real-Time)</h5>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0">
            <div data-simplebar class="h-100 p-4">
                <div class="position-relative ms-2">
                    <span class="position-absolute start-0  top-0 border border-dashed h-100"></span>
                    
                    @php $activities = $activityStream ?? []; @endphp
                    @forelse($activities as $activity)
                    <div class="position-relative ps-4 mb-4">
                        <span class="position-absolute start-0 avatar-sm translate-middle-x bg-{{ $activity['color'] }} d-inline-flex align-items-center justify-content-center rounded-circle text-light fs-20">
                            <iconify-icon icon="{{ $activity['icon'] }}"></iconify-icon>
                        </span>
                        <div class="ms-2">
                            <h5 class="mb-1 text-dark fw-semibold fs-15 lh-base">{{ $activity['title'] }}</h5>
                            <p class="mb-0 text-muted">{!! $activity['description'] !!}</p>
                            
                            @if($activity['link'] && $activity['link'] !== '#')
                            <div class="mt-2">
                                <a href="{{ $activity['link'] }}" class="btn btn-sm btn-soft-{{ $activity['color'] }}">Lihat Detail</a>
                            </div>
                            @endif
                            
                            <h6 class="mt-2 text-muted fw-normal fs-13">
                                <iconify-icon icon="solar:clock-circle-linear" class="align-middle me-1"></iconify-icon>
                                {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                            </h6>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <iconify-icon icon="solar:ghost-smile-bold-duotone" class="fs-48 text-muted mb-2"></iconify-icon>
                        <p class="text-muted">Belum ada aktivitas terekam.</p>
                    </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>
