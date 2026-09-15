<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @php
        $siteSettings = \App\Models\Setting::pluck('value', 'key');
        $currentUrl = url()->current();
        $pageTitle = ($siteSettings['site_name'] ?? 'Pesantren Mahasiswa An-Nur');
    @endphp
    <title>{{ $pageTitle }} | @yield('meta_title', 'Beranda')</title>
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', $siteSettings['site_description'] ?? '')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $currentUrl }}">

    <!-- PWA Manifest & Theme Color -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#071526">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Pesma An-Nur">
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register("{{ asset('sw.js') }}").then(function(reg) {
                    console.log('PWA ServiceWorker registered');
                }).catch(function(err) {
                    console.log('PWA ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>

    <!-- Per-page meta tags (citation, OG overrides) -->
    @stack('meta')

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }} | @yield('meta_title', 'Beranda')">
    <meta property="og:description" content="@yield('meta_description', $siteSettings['site_description'] ?? '')">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'Pesma An-Nur' }}">
    @php
        $ogImageUrl = null;
        if (trim($__env->yieldContent('meta_image'))) {
            $ogImageUrl = trim($__env->yieldContent('meta_image'));
        } elseif (isset($siteSettings['og_default_image']) && $siteSettings['og_default_image']) {
            $ogImageUrl = asset('storage/' . $siteSettings['og_default_image']);
        } elseif (isset($siteSettings['header_logo']) && $siteSettings['header_logo']) {
            $ogImageUrl = asset('storage/' . $siteSettings['header_logo']);
        }

        if ($ogImageUrl) {
            // Ensure HTTPS protocol for WhatsApp Scraper compatibility
            if (str_starts_with($ogImageUrl, 'http://')) {
                $ogImageUrl = 'https://' . substr($ogImageUrl, 7);
            }
        }
    @endphp

    @if($ogImageUrl)
    <meta property="og:image" content="{{ $ogImageUrl }}">
    <meta property="og:image:secure_url" content="{{ $ogImageUrl }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:image" content="{{ $ogImageUrl }}">
    @endif
    <meta property="og:locale" content="id_ID">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }} | @yield('meta_title', 'Beranda')">
    <meta name="twitter:description" content="@yield('meta_description', $siteSettings['site_description'] ?? '')">

    <!-- JSON-LD Schema Markup for Google Rich Snippets -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@graph": [
            {
                "@type": "EducationalOrganization",
                "@id": "{{ url('/') }}#organization",
                "name": "{{ $siteSettings['site_name'] ?? 'Pesantren Mahasiswa An-Nur' }}",
                "alternateName": "Pesma An-Nur Surabaya",
                "url": "{{ url('/') }}",
                "logo": "{{ isset($siteSettings['header_logo']) && $siteSettings['header_logo'] ? asset('storage/' . $siteSettings['header_logo']) : asset('frontend/assets/images/logo/logo.png') }}",
                "description": "{{ $siteSettings['site_description'] ?? 'Rumah Keilmuan & Akhlak Mahasiswa Pesantren Mahasiswa An-Nur Surabaya' }}",
                "telephone": "{{ $siteSettings['contact_phone'] ?? '' }}",
                "email": "{{ $siteSettings['contact_email'] ?? '' }}",
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "{{ $siteSettings['contact_address'] ?? $siteSettings['address'] ?? 'Surabaya, Jawa Timur' }}",
                    "addressLocality": "Surabaya",
                    "addressRegion": "Jawa Timur",
                    "addressCountry": "ID"
                }
            },
            {
                "@type": "FAQPage",
                "mainEntity": [
                    {
                        "@type": "Question",
                        "name": "Apa itu Pesantren Mahasiswa An-Nur?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Pesantren Mahasiswa An-Nur Surabaya adalah hunian integratif yang mendampingi langkah mahasiswa meraih prestasi akademis kampus dan kedalaman karakter keislaman."
                        }
                    },
                    {
                        "@type": "Question",
                        "name": "Bagaimana cara mendaftar santri baru Pesma An-Nur?",
                        "acceptedAnswer": {
                            "@type": "Answer",
                            "text": "Pendaftaran santri baru dilakukan secara online melalui portal e-Maktab PSB di https://e-maktab.pesma-annur.net/psb."
                        }
                    }
                ]
            }
        ]
    }
    </script>

    <!-- Favicon -->
    @php
        $favicon = \App\Models\Setting::getByKey('favicon');
        $faviconUrl = $favicon ? asset('storage/' . $favicon) : asset('frontend/assets/images/favicon.png');
    @endphp
    <link rel="shortcut icon" href="{{ $faviconUrl }}">
    <link rel="icon" href="{{ $faviconUrl }}" type="image/x-icon">

    <!-- CSS  -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendor/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/euclid-circulara.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/magnigy-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/jodit.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/styles.css') }}">
    
    <!-- Google Fonts Connection -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Iconify Icon Component -->
    <script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>
    
    @stack('styles')

    <!-- Google Analytics -->
    @if(isset($siteSettings['google_analytics_id']) && $siteSettings['google_analytics_id'])
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $siteSettings['google_analytics_id'] }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $siteSettings["google_analytics_id"] }}');
    </script>
    @endif
</head>

