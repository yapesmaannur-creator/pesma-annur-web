@php
    $banners = \App\Models\Banner::where('is_active', true)->orderBy('order')->get();

    // Helper text sanitizer to purge old placeholders
    $sanitizeHeroText = function($text, $fallback) {
        if (empty($text)) return $fallback;
        $clean = strip_tags($text, '<strong><span><br><i><b>');
        if (stripos($clean, 'PESANTREN MAHASISWA AN-NUR SURABAYA') !== false || stripos($clean, 'Tinggal, Belajar') !== false || stripos($clean, 'ruang tinggal dan pembinaan') !== false || stripos($clean, 'Learn Quran') !== false || stripos($clean, 'Amet minim') !== false) {
            return $fallback;
        }
        return str_replace('http://localhost/', asset('/'), $clean);
    };
@endphp

<!-- Redesigned Authentic Executive Pesantren Mahasiswa Hero -->
<style>
    .annur-hero {
      position: relative;
      overflow: hidden;
      min-height: 82vh;
      display: flex;
      align-items: center;
      background:
        radial-gradient(circle at top right, rgba(201, 162, 39, 0.14), transparent 40%),
        linear-gradient(135deg, #071526 0%, #0B1F3A 48%, #102A4C 100%);
      color: #ffffff;
      padding: 85px 20px;
    }

    .annur-hero__bg {
      position: absolute;
      inset: 0;
      background-image:
        url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23C9A227' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h40v40H40V0zM0 40h40v40H0V40z'/%3E%3Ccircle cx='40' cy='40' r='20' stroke='%23C9A227' stroke-opacity='0.07' stroke-width='1.5' fill='none'/%3E%3Cpath d='M40 0L80 40 40 80 0 40z' stroke='%23C9A227' stroke-opacity='0.05' stroke-width='1' fill='none'/%3E%3C/g%3E%3C/svg%3E"),
        linear-gradient(rgba(255, 255, 255, 0.015) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.015) 1px, transparent 1px);
      background-size: 80px 80px, 50px 50px, 50px 50px;
      mask-image: linear-gradient(to bottom, black, transparent 95%);
      pointer-events: none;
    }

    .annur-hero__container {
      position: relative;
      z-index: 2;
      width: min(1180px, 100%);
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1.15fr 0.85fr;
      gap: 60px;
      align-items: center;
    }

    .annur-hero__content {
      max-width: 680px;
      text-align: left;
    }

    .annur-hero__badge {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      padding: 7px 18px;
      margin-bottom: 22px;
      border: 1px solid rgba(201, 162, 39, 0.35);
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.06);
      color: #E8C766;
      font-size: 12.5px;
      font-weight: 800;
      letter-spacing: 0.6px;
      text-transform: uppercase;
      backdrop-filter: blur(8px);
    }

    .annur-hero__badge span {
      width: 8px;
      height: 8px;
      border-radius: 999px;
      background: #E8C766;
      box-shadow: 0 0 0 5px rgba(201, 162, 39, 0.2);
    }

    .annur-hero h1 {
      margin: 0;
      max-width: 720px;
      font-size: clamp(30px, 3.8vw, 42px);
      line-height: 1.25;
      letter-spacing: -1px;
      font-weight: 800;
      color: #ffffff;
    }

    .annur-hero h1 span, .annur-hero h1 strong {
      display: inline-block;
      background: linear-gradient(135deg, #F5E199 0%, #C9A227 100%);
      -webkit-background-clip: text;
      background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .annur-hero p {
      max-width: 610px;
      margin: 18px 0 0;
      color: rgba(255, 255, 255, 0.85);
      font-size: 16px;
      line-height: 1.65;
    }

    .annur-hero__actions {
      display: flex;
      flex-wrap: wrap;
      gap: 14px;
      margin-top: 30px;
    }

    .annur-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      min-height: 50px;
      padding: 0 32px;
      border-radius: 999px;
      text-decoration: none;
      font-size: 15px;
      font-weight: 800;
      transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
      cursor: pointer;
    }

    .annur-btn:hover {
      transform: translateY(-2px);
      color: inherit;
    }

    .annur-btn--primary {
      background: linear-gradient(135deg, #C9A227 0%, #E8C766 100%);
      color: #071526 !important;
      box-shadow: 0 8px 24px rgba(201, 162, 39, 0.38);
      border: 1px solid #C9A227;
    }

    .annur-btn--primary:hover {
      background: linear-gradient(135deg, #E8C766 0%, #F5E199 100%);
      box-shadow: 0 12px 30px rgba(201, 162, 39, 0.55);
    }

    .annur-hero__stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-top: 40px;
      border-top: 1px solid rgba(255, 255, 255, 0.12);
      padding-top: 24px;
      max-width: 640px;
    }

    .annur-hero__stats div {
      display: flex;
      flex-direction: column;
    }

    .annur-hero__stats strong {
      display: block;
      color: #E8C766;
      font-size: 16.5px;
      font-weight: 800;
      line-height: 1.3;
    }

    .annur-hero__stats span {
      display: block;
      margin-top: 4px;
      color: rgba(255, 255, 255, 0.7);
      font-size: 12.5px;
      line-height: 1.4;
    }

    .annur-hero__visual {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    @keyframes spinOrbit {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    @keyframes spinReverse {
      from { transform: rotate(360deg); }
      to { transform: rotate(0deg); }
    }

    /* Carousel integration for slider */
    .annur-hero .carousel {
      width: 100%;
    }

    .annur-hero .carousel-item {
      width: 100%;
      transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
    }

    .annur-hero .carousel-item.has-bg-image {
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
    }

    .annur-hero .carousel-item.has-bg-image::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(7, 21, 38, 0.88) 0%, rgba(11, 31, 58, 0.8) 48%, rgba(16, 42, 76, 0.88) 100%);
      z-index: 1;
    }

    .annur-hero .carousel-item.has-bg-image .annur-hero__container {
      position: relative;
      z-index: 2;
    }

    /* Static banner styling if background image exists */
    .annur-hero.has-bg-image {
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }

    .annur-hero.has-bg-image::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(7, 21, 38, 0.88) 0%, rgba(11, 31, 58, 0.8) 48%, rgba(16, 42, 76, 0.88) 100%);
      z-index: 1;
    }

    .annur-hero.has-bg-image .annur-hero__bg {
      z-index: 2;
    }

    .annur-hero.has-bg-image .annur-hero__container {
      position: relative;
      z-index: 3;
    }

    /* Carousel Controls styling */
    .annur-hero .carousel-indicators {
      z-index: 5;
      margin-bottom: 24px;
    }

    .annur-hero .carousel-indicators [data-bs-target] {
      width: 10px;
      height: 10px;
      border-radius: 50%;
      border: none;
      background-color: rgba(255, 255, 255, 0.3);
      transition: all 0.4s;
    }

    .annur-hero .carousel-indicators .active {
      width: 30px;
      border-radius: 6px;
      background-color: #E8C766;
    }

    .annur-hero .carousel-control-prev,
    .annur-hero .carousel-control-next {
      width: 48px;
      height: 48px;
      top: 50%;
      transform: translateY(-50%);
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(6px);
      opacity: 0;
      transition: all 0.3s ease;
      z-index: 10;
    }

    .annur-hero:hover .carousel-control-prev,
    .annur-hero:hover .carousel-control-next {
      opacity: 1;
    }

    .annur-hero .carousel-control-prev:hover,
    .annur-hero .carousel-control-next:hover {
      background: rgba(201, 162, 39, 0.25);
      border-color: #E8C766;
    }

    .annur-hero .carousel-control-prev { left: 24px; }
    .annur-hero .carousel-control-next { right: 24px; }

    @media (max-width: 991px) {
      .annur-hero {
        min-height: auto;
        padding: 70px 20px 54px;
      }

      .annur-hero__container {
        grid-template-columns: 1fr;
        gap: 32px;
      }

      .annur-hero__content {
        max-width: 100%;
        text-align: center;
      }

      .annur-hero__actions {
        justify-content: center;
      }

      .annur-hero__stats {
        max-width: 480px;
        margin: 32px auto 0;
        text-align: left;
      }

      .annur-hero__visual {
        display: none;
      }

      .annur-hero .carousel-control-prev,
      .annur-hero .carousel-control-next {
        display: none;
      }
    }

    @media (max-width: 576px) {
      .annur-hero {
        padding-top: 48px;
        padding-bottom: 36px;
      }

      .annur-hero__badge {
        font-size: 11px;
        letter-spacing: 0.3px;
        padding: 6px 14px;
        margin-bottom: 16px;
        max-width: 100%;
        text-align: center;
      }

      .annur-hero h1 {
        font-size: 24px;
        line-height: 1.3;
      }

      .annur-hero p {
        font-size: 13.5px;
        margin-top: 12px;
      }

      .annur-hero__actions {
        flex-direction: column;
        margin-top: 22px;
      }

      .annur-btn {
        width: 100%;
      }

      .annur-hero__stats {
        grid-template-columns: 1fr;
        gap: 10px;
        margin-top: 24px;
        padding-top: 18px;
        text-align: left;
      }

      .annur-hero__stats div {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(201, 162, 39, 0.22);
        border-radius: 12px;
        padding: 10px 14px;
      }

      .annur-hero__stats strong {
        font-size: 14.5px;
      }

      .annur-hero__stats span {
        font-size: 11.5px;
      }
    }
</style>

@if($banners->count() > 0)
    <!-- Start Banner Area - Slider -->
    <div class="annur-hero">
        <div class="annur-hero__bg"></div>
        <div id="annurHeroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">

            @if($banners->count() > 1)
            <div class="carousel-indicators">
                @foreach($banners as $i => $banner)
                    <button type="button" data-bs-target="#annurHeroCarousel"
                        data-bs-slide-to="{{ $i }}"
                        class="{{ $i === 0 ? 'active' : '' }}"
                        aria-label="Slide {{ $i + 1 }}"></button>
                @endforeach
            </div>
            @endif

            <div class="carousel-inner">
                @foreach($banners as $i => $banner)
                @php
                    $hasLink       = $banner->link;
                    $imageOnlyLink = $hasLink && ($banner->link_type ?? 'button') === 'image';

                    // Robust image existence check
                    $bannerImage   = $banner->image;
                    $imageExists   = !empty($bannerImage) && \Illuminate\Support\Facades\Storage::disk('public')->exists($bannerImage);
                    $imageUrl      = $imageExists 
                        ? asset('storage/' . $bannerImage) 
                        : null;

                    $subtitle = $sanitizeHeroText($banner->subtitle, 'TEMPAT TERBAIK BERTUMBUH & BERPRESTASI');
                    $title = $sanitizeHeroText($banner->title, 'Pesantren Mahasiswa An-Nur: <span>Rumah Keilmuan & Akhlak</span> Mahasiswa');
                @endphp
                <div class="carousel-item {{ $i === 0 ? 'active' : '' }} {{ $imageExists ? 'has-bg-image' : '' }}"
                     @if($imageExists) style="background-image: url('{{ $imageUrl }}');" @endif>

                    @if($imageOnlyLink)
                        <a href="{{ $banner->link }}" target="_blank"
                           style="position:absolute;inset:0;z-index:4;display:block;"
                           aria-label="Banner link"></a>
                    @endif

                    <div class="annur-hero__container">
                        <!-- Left Column -->
                        <div class="annur-hero__content">
                            <div class="annur-hero__badge">
                                <span></span>
                                {!! $subtitle !!}
                            </div>
                            
                            <h1>
                                {!! nl2br($title) !!}
                            </h1>
                            
                            <p>
                                Mendampingi langkah mahasiswa meraih prestasi akademis kampus dan kedalaman karakter keislaman.
                            </p>

                            <!-- Clean Primary Button Only -->
                            <div class="annur-hero__actions">
                                @php
                                    $heroCtaUrl = ($hasLink && !empty($banner->link) && $banner->link !== '#' && $banner->link !== '#daftar')
                                        ? $banner->link 
                                        : 'https://e-maktab.pesma-annur.net/psb';
                                @endphp
                                <a href="{{ $heroCtaUrl }}" target="_blank" rel="noopener noreferrer" class="annur-btn annur-btn--primary">
                                    {{ $banner->button_text ?? 'Daftar Santri Baru' }}
                                    <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                                </a>
                            </div>

                            <!-- 3 CORE VALUE PILLARS -->
                            <div class="annur-hero__stats">
                                <div>
                                    <strong><iconify-icon icon="solar:rocket-bold-duotone" style="color: #E8C766; margin-right: 4px; vertical-align: middle;"></iconify-icon> Inovatif</strong>
                                    <span>Pengembangan potensi & keilmuan modern</span>
                                </div>
                                <div>
                                    <strong><iconify-icon icon="solar:users-group-two-rounded-bold-duotone" style="color: #E8C766; margin-right: 4px; vertical-align: middle;"></iconify-icon> Kolaboratif</strong>
                                    <span>Sinergi mahasantri & akademisi</span>
                                </div>
                                <div>
                                    <strong><iconify-icon icon="solar:lightbulb-bolt-bold-duotone" style="color: #E8C766; margin-right: 4px; vertical-align: middle;"></iconify-icon> Produktif</strong>
                                    <span>Karya riset, literasi & kepemimpinan</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Column (Pure Sleek Abstract 3D Geometric Crystal Artwork - 0 Text) -->
                        <div class="annur-hero__visual">
                            @if($imageExists && !empty($imageUrl))
                                <!-- Custom Banner Image Frame (When custom photo uploaded in Admin Panel) -->
                                <div style="position: relative; width: 100%; max-width: 440px;">
                                    <div style="position: absolute; inset: -15px; background: radial-gradient(circle, rgba(201, 162, 39, 0.25) 0%, rgba(7, 21, 38, 0) 70%); border-radius: 24px; filter: blur(25px); z-index: 1;"></div>
                                    
                                    <div style="position: relative; z-index: 2; border-radius: 20px; padding: 12px; background: rgba(255, 255, 255, 0.06); backdrop-filter: blur(12px); border: 1.5px solid rgba(201, 162, 39, 0.35); box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);">
                                        <div style="border-radius: 14px; overflow: hidden; height: 380px; position: relative;">
                                            <img src="{{ $imageUrl }}" alt="Banner" style="width: 100%; height: 100%; object-fit: cover; object-position: top center;">
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Pure Sleek Abstract 3D Geometric Crystal Artwork (No text, pure attractive visual) -->
                                <div style="position: relative; width: 100%; max-width: 440px; height: 420px; display: flex; align-items: center; justify-content: center;">
                                    <!-- Radiant Outer Ambient Light Glow -->
                                    <div style="position: absolute; width: 95%; height: 95%; border-radius: 50%; background: radial-gradient(circle, rgba(201, 162, 39, 0.28) 0%, rgba(7, 21, 38, 0) 70%); filter: blur(40px); z-index: 1;"></div>

                                    <!-- Outer Rotating Dotted Orbital Ring -->
                                    <svg style="position: absolute; inset: 0; width: 100%; height: 100%; z-index: 2; animation: spinOrbit 35s linear infinite;" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="200" cy="200" r="175" stroke="#E8C766" stroke-width="1.5" stroke-dasharray="6 12" stroke-opacity="0.4" />
                                        <circle cx="200" cy="25" r="5" fill="#E8C766" />
                                        <circle cx="375" cy="200" r="4" fill="#C9A227" />
                                        <circle cx="200" cy="375" r="5" fill="#E8C766" />
                                        <circle cx="25" cy="200" r="4" fill="#C9A227" />
                                    </svg>

                                    <!-- Inner Geometric Islamic 8-Point Star Mesh Lattice -->
                                    <svg style="position: absolute; inset: 0; width: 100%; height: 100%; z-index: 3; animation: spinReverse 50s linear infinite;" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="200" cy="200" r="130" stroke="url(#goldGradFinal2)" stroke-width="1.5" stroke-opacity="0.6" />
                                        <circle cx="200" cy="200" r="90" stroke="#E8C766" stroke-width="1" stroke-opacity="0.35" />
                                        
                                        <rect x="110" y="110" width="180" height="180" stroke="url(#goldGradFinal2)" stroke-width="1.8" stroke-opacity="0.75" transform="rotate(0 200 200)" />
                                        <rect x="110" y="110" width="180" height="180" stroke="url(#goldGradFinal2)" stroke-width="1.8" stroke-opacity="0.75" transform="rotate(45 200 200)" />
                                        <rect x="130" y="130" width="140" height="140" stroke="#E8C766" stroke-width="1.2" stroke-opacity="0.4" transform="rotate(22.5 200 200)" />
                                        <rect x="130" y="130" width="140" height="140" stroke="#E8C766" stroke-width="1.2" stroke-opacity="0.4" transform="rotate(67.5 200 200)" />

                                        <defs>
                                            <linearGradient id="goldGradFinal2" x1="0%" y1="0%" x2="100%" y2="100%">
                                                <stop offset="0%" stop-color="#C9A227" />
                                                <stop offset="50%" stop-color="#F5E199" />
                                                <stop offset="100%" stop-color="#C9A227" />
                                            </linearGradient>
                                        </defs>
                                    </svg>

                                    <!-- Central Glowing Crystal Prism Core -->
                                    <div style="position: relative; z-index: 4; background: linear-gradient(135deg, rgba(16, 42, 76, 0.7) 0%, rgba(7, 21, 38, 0.85) 100%); backdrop-filter: blur(20px); width: 140px; height: 140px; border-radius: 30px; transform: rotate(45deg); border: 2px solid rgba(232, 199, 102, 0.6); box-shadow: 0 0 40px rgba(201, 162, 39, 0.35), inset 0 0 20px rgba(232, 199, 102, 0.2); display: flex; align-items: center; justify-content: center;">
                                        <div style="width: 70px; height: 70px; border-radius: 16px; border: 1.5px solid rgba(245, 225, 153, 0.8); background: radial-gradient(circle, rgba(201, 162, 39, 0.4) 0%, transparent 80%); box-shadow: 0 0 20px rgba(201, 162, 39, 0.5);"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#annurHeroCarousel" data-bs-slide="prev">
                <iconify-icon icon="solar:alt-arrow-left-linear" style="font-size: 22px; color: #fff; vertical-align: middle;"></iconify-icon>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#annurHeroCarousel" data-bs-slide="next">
                <iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 22px; color: #fff; vertical-align: middle;"></iconify-icon>
            </button>
            @endif
        </div>
    </div>
    <!-- End Banner Area -->

@else
    <!-- Fallback Static Banner -->
    @php
        $staticImageExists = $section->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($section->image);
        $staticImageUrl = $staticImageExists
            ? asset('storage/' . $section->image)
            : null;

        $subtitle = $sanitizeHeroText($section->subtitle, 'TEMPAT TERBAIK BERTUMBUH & BERPRESTASI');
        $title = $sanitizeHeroText($section->title, 'Pesantren Mahasiswa An-Nur: <span>Rumah Keilmuan & Akhlak</span> Mahasiswa');
        $content = $sanitizeHeroText($section->content, 'Mendampingi langkah mahasiswa meraih prestasi akademis kampus dan kedalaman karakter keislaman.');
    @endphp
    <div class="annur-hero {{ $staticImageExists ? 'has-bg-image' : '' }}"
         @if($staticImageExists) style="background-image: url('{{ $staticImageUrl }}');" @endif>
         
        <div class="annur-hero__bg"></div>
         
        <div class="annur-hero__container">
            <!-- Left Column -->
            <div class="annur-hero__content">
                <div class="annur-hero__badge">
                    <span></span>
                    {!! $subtitle !!}
                </div>
                
                <h1>
                    {!! nl2br($title) !!}
                </h1>
                
                <p>
                    {!! $content !!}
                </p>

                <div class="annur-hero__actions">
                    @php
                        $staticCtaUrl = ($section->button_url && $section->button_url !== '#' && $section->button_url !== '#daftar')
                            ? $section->button_url 
                            : 'https://e-maktab.pesma-annur.net/psb';
                    @endphp
                    <a href="{{ $staticCtaUrl }}" target="_blank" rel="noopener noreferrer" class="annur-btn annur-btn--primary">
                        {{ $section->button_text ?? 'Daftar Santri Baru' }}
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                    </a>
                </div>

                <div class="annur-hero__stats">
                    <div>
                        <strong><iconify-icon icon="solar:rocket-bold-duotone" style="color: #E8C766; margin-right: 4px; vertical-align: middle;"></iconify-icon> Inovatif</strong>
                        <span>Pengembangan potensi & keilmuan modern</span>
                    </div>
                    <div>
                        <strong><iconify-icon icon="solar:users-group-two-rounded-bold-duotone" style="color: #E8C766; margin-right: 4px; vertical-align: middle;"></iconify-icon> Kolaboratif</strong>
                        <span>Sinergi mahasantri & akademisi</span>
                    </div>
                    <div>
                        <strong><iconify-icon icon="solar:lightbulb-bolt-bold-duotone" style="color: #E8C766; margin-right: 4px; vertical-align: middle;"></iconify-icon> Produktif</strong>
                        <span>Karya riset, literasi & kepemimpinan</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Column (Pure Sleek Abstract 3D Geometric Crystal Artwork - 0 Text) -->
            <div class="annur-hero__visual">
                @if($staticImageExists && !empty($staticImageUrl))
                    <!-- Custom Banner Image Frame -->
                    <div style="position: relative; width: 100%; max-width: 440px;">
                        <div style="position: absolute; inset: -15px; background: radial-gradient(circle, rgba(201, 162, 39, 0.25) 0%, rgba(7, 21, 38, 0) 70%); border-radius: 24px; filter: blur(25px); z-index: 1;"></div>
                        <div style="position: relative; z-index: 2; border-radius: 20px; padding: 12px; background: rgba(255, 255, 255, 0.06); backdrop-filter: blur(12px); border: 1.5px solid rgba(201, 162, 39, 0.35); box-shadow: 0 20px 45px rgba(0, 0, 0, 0.4);">
                            <div style="border-radius: 14px; overflow: hidden; height: 380px; position: relative;">
                                <img src="{{ $staticImageUrl }}" alt="Banner" style="width: 100%; height: 100%; object-fit: cover; object-position: top center;">
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Pure Sleek Abstract 3D Geometric Crystal Artwork (No text, pure attractive visual) -->
                    <div style="position: relative; width: 100%; max-width: 440px; height: 420px; display: flex; align-items: center; justify-content: center;">
                        <div style="position: absolute; width: 95%; height: 95%; border-radius: 50%; background: radial-gradient(circle, rgba(201, 162, 39, 0.28) 0%, rgba(7, 21, 38, 0) 70%); filter: blur(40px); z-index: 1;"></div>

                        <svg style="position: absolute; inset: 0; width: 100%; height: 100%; z-index: 2; animation: spinOrbit 35s linear infinite;" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="200" cy="200" r="175" stroke="#E8C766" stroke-width="1.5" stroke-dasharray="6 12" stroke-opacity="0.4" />
                            <circle cx="200" cy="25" r="5" fill="#E8C766" />
                            <circle cx="375" cy="200" r="4" fill="#C9A227" />
                            <circle cx="200" cy="375" r="5" fill="#E8C766" />
                            <circle cx="25" cy="200" r="4" fill="#C9A227" />
                        </svg>

                        <svg style="position: absolute; inset: 0; width: 100%; height: 100%; z-index: 3; animation: spinReverse 50s linear infinite;" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="200" cy="200" r="130" stroke="url(#goldGradFinal2)" stroke-width="1.5" stroke-opacity="0.6" />
                            <circle cx="200" cy="200" r="90" stroke="#E8C766" stroke-width="1" stroke-opacity="0.35" />
                            
                            <rect x="110" y="110" width="180" height="180" stroke="url(#goldGradFinal2)" stroke-width="1.8" stroke-opacity="0.75" transform="rotate(0 200 200)" />
                            <rect x="110" y="110" width="180" height="180" stroke="url(#goldGradFinal2)" stroke-width="1.8" stroke-opacity="0.75" transform="rotate(45 200 200)" />
                            <rect x="130" y="130" width="140" height="140" stroke="#E8C766" stroke-width="1.2" stroke-opacity="0.4" transform="rotate(22.5 200 200)" />
                            <rect x="130" y="130" width="140" height="140" stroke="#E8C766" stroke-width="1.2" stroke-opacity="0.4" transform="rotate(67.5 200 200)" />

                            <defs>
                                <linearGradient id="goldGradFinal2" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#C9A227" />
                                    <stop offset="50%" stop-color="#F5E199" />
                                    <stop offset="100%" stop-color="#C9A227" />
                                </linearGradient>
                            </defs>
                        </svg>

                        <div style="position: relative; z-index: 4; background: linear-gradient(135deg, rgba(16, 42, 76, 0.7) 0%, rgba(7, 21, 38, 0.85) 100%); backdrop-filter: blur(20px); width: 140px; height: 140px; border-radius: 30px; transform: rotate(45deg); border: 2px solid rgba(232, 199, 102, 0.6); box-shadow: 0 0 40px rgba(201, 162, 39, 0.35), inset 0 0 20px rgba(232, 199, 102, 0.2); display: flex; align-items: center; justify-content: center;">
                            <div style="width: 70px; height: 70px; border-radius: 16px; border: 1.5px solid rgba(245, 225, 153, 0.8); background: radial-gradient(circle, rgba(201, 162, 39, 0.4) 0%, transparent 80%); box-shadow: 0 0 20px rgba(201, 162, 39, 0.5);"></div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif