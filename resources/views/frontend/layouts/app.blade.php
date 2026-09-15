<!DOCTYPE html>
<html lang="en">

<x-frontend.head/>

<body class="<?php echo (isset($bodyClass) ?  $bodyClass   : 'rbt-header-sticky')?>">


    <?php 
        if (!isset($switcher)) {
            ?>
            <style>
                /* Hide the default template floating switcher gear */
                .my_switcher { display: none !important; }
            </style>
            <div class="d-none">
                <x-frontend.switcher/>
            </div>
            <?php
        }
    ?>

    <?php 

        if (!isset($header)) {
            ?>
            <x-frontend.header/>
            <x-frontend.mobileMenu/>
            <?php
        }
    ?>

    <style>
        /* ========================================================
           UNIFIED PROFESSIONAL TYPOGRAPHY SYSTEM (Plus Jakarta Sans)
           ======================================================== */
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        :root {
          --font-primary: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
          --font-heading: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
          --font-body: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
          --color-primary: #0B1F3A !important;
          --color-secondary: #C9A227 !important;
        }

        body.active-dark-mode {
          --color-primary: #070F1E !important;
          --color-secondary: #E8C766 !important;
        }

        /* GLOBAL FONT STANDARDIZATION — 100% UNIFIED */
        *, html, body, h1, h2, h3, h4, h5, h6, p, span, a, button, input, textarea, select, label, li,
        .title, .subtitle, .section-title, .description, .section-desc, .eyebrow,
        .btn, .rbt-btn, .mainmenu, .content, .card-title, .rbt-card-title {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }

        /* FORCE CENTER TITLE ALIGNMENT IN CENTER CONTAINERS */
        .text-center .section-title,
        .center .section-title,
        .section-title.text-center,
        .text-center h1, .text-center h2, .text-center h3,
        .center h1, .center h2, .center h3 {
            text-align: center !important;
            margin-left: auto !important;
            margin-right: auto !important;
            display: block !important;
            width: 100% !important;
        }

        /* CRITICAL FIX: PREVENT GIANT SVG ARROWS & HARMONIZE PAGINATION */
        nav svg,
        .pagination svg,
        ul.pagination svg,
        ul.rbt-pagination svg,
        svg.w-5.h-5,
        svg.w-6.h-6,
        nav[role="navigation"] svg {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            display: inline-block !important;
            vertical-align: middle !important;
            flex-shrink: 0 !important;
        }

        .pagination, ul.rbt-pagination, ul.pagination {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            list-style: none !important;
            padding: 0 !important;
            margin: 35px 0 0 !important;
        }

        .pagination .page-item, .pagination li {
            display: inline-flex !important;
        }

        .pagination .page-link, .pagination a, .pagination span {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 40px !important;
            height: 40px !important;
            padding: 0 14px !important;
            border-radius: 10px !important;
            background: var(--card-bg, #ffffff) !important;
            color: var(--text-main, #0F172A) !important;
            border: 1px solid var(--border-color, #E2E8F0) !important;
            font-weight: 700 !important;
            font-size: 14px !important;
            text-decoration: none !important;
            transition: all 0.25s ease !important;
        }

        .pagination .page-item.active .page-link,
        .pagination li.active a,
        .pagination li.active span {
            background: linear-gradient(135deg, #C9A227 0%, #E8C766 100%) !important;
            color: #071526 !important;
            border-color: #C9A227 !important;
            box-shadow: 0 4px 14px rgba(201, 162, 39, 0.35) !important;
        }

        /* Prevent horizontal overflow/scroll on all devices */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        /* PROFESSIONAL HARMONIC TYPOGRAPHY SCALE SYSTEM */
        h1, .h1 {
            font-size: clamp(30px, 3.6vw, 42px) !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
            line-height: 1.25 !important;
        }
        h2, .h2, .section-title h2, .section-title .title, .section-title {
            font-size: clamp(24px, 2.8vw, 32px) !important;
            font-weight: 800 !important;
            letter-spacing: -0.02em !important;
            line-height: 1.3 !important;
        }
        h3, .h3, .card-title, .rbt-card-title, .annur-why-title {
            font-size: clamp(17px, 2vw, 19px) !important;
            font-weight: 800 !important;
            letter-spacing: -0.015em !important;
            line-height: 1.35 !important;
        }
        h4, .h4 {
            font-size: clamp(15.5px, 1.8vw, 17px) !important;
            font-weight: 700 !important;
            line-height: 1.4 !important;
        }
        h5, .h5 {
            font-size: 15px !important;
            font-weight: 700 !important;
            line-height: 1.4 !important;
        }
        p, .description, .section-desc, .annur-why-desc-centered, .annur-program-desc-centered {
            font-size: 14.5px !important;
            font-weight: 400 !important;
            line-height: 1.65 !important;
        }
        .eyebrow, .subtitle {
            font-size: 12px !important;
            font-weight: 700 !important;
            letter-spacing: 0.05em !important;
            text-transform: uppercase !important;
        }

        /* ULTRA-REFINED MOBILE UX & BEAUTIFICATION SYSTEM */
        @media (max-width: 768px) {
            /* General Section & Layout Gaps */
            .section, .py-5, .rbt-section-gap {
                padding-top: 2.2rem !important;
                padding-bottom: 2.2rem !important;
            }
            .container {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }
            .row.g-4, .row.g-5 {
                --bs-gutter-y: 1.25rem !important;
                --bs-gutter-x: 1.25rem !important;
            }

            /* Responsive Headings */
            h1, .h1 {
                font-size: clamp(21px, 5.8vw, 25px) !important;
                line-height: 1.28 !important;
                letter-spacing: -0.015em !important;
            }
            h2, .h2, .section-title h2, .section-title .title, .section-title {
                font-size: clamp(19px, 5vw, 22px) !important;
                line-height: 1.3 !important;
                letter-spacing: -0.015em !important;
                margin-bottom: 14px !important;
            }
            h3, .h3, .card-title, .rbt-card-title, .annur-why-title {
                font-size: 15.5px !important;
                line-height: 1.35 !important;
                margin-top: 10px !important;
                margin-bottom: 8px !important;
            }
            h4, .h4, h5, .h5 {
                font-size: 14.5px !important;
                line-height: 1.38 !important;
            }
            p, .description, .section-desc, .annur-why-desc-centered, .annur-program-desc-centered, .news-article-content p {
                font-size: 13.5px !important;
                line-height: 1.6 !important;
            }
            .eyebrow, .subtitle {
                font-size: 11px !important;
                padding: 4px 14px !important;
                letter-spacing: 0.04em !important;
                margin-bottom: 8px !important;
            }

            /* Mobile Card Touch Paddings */
            .annur-why-card-centered,
            .annur-program-card-centered,
            .annur-feature-card,
            .annur-faq-card,
            .about-card-wrapper {
                padding: 22px 18px !important;
                border-radius: 14px !important;
            }

            /* Mobile Icon Badges */
            .annur-why-icon-badge,
            .annur-program-icon-badge {
                width: 48px !important;
                height: 48px !important;
                min-width: 48px !important;
                border-radius: 12px !important;
            }
            .annur-why-icon-badge iconify-icon,
            .annur-program-icon-badge iconify-icon {
                font-size: 24px !important;
            }

            /* Mobile Header Navbar Heights & Buttons */
            .rbt-header-wrapper {
                min-height: 60px !important;
            }
            .rbt-header-wrapper .logo img {
                max-height: 32px !important;
                width: auto !important;
            }
            .hamberger-button.rbt-round-btn,
            .access-icon .rbt-round-btn {
                width: 38px !important;
                height: 38px !important;
                border-radius: 50% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                background: rgba(201, 162, 39, 0.12) !important;
                border: 1px solid rgba(201, 162, 39, 0.3) !important;
                color: #E8C766 !important;
            }
        }

        /* HIGH-CONTRAST READABILITY FOR DAFTAR SEKARANG & GOLD BUTTONS */
        .btn-gold,
        a.btn-gold,
        button.btn-gold {
            background: linear-gradient(135deg, #C9A227 0%, #E8C766 100%) !important;
            color: #071526 !important;
            font-weight: 800 !important;
            font-size: 14px !important;
            letter-spacing: 0.02em !important;
            border-radius: 50px !important;
            padding: 10px 24px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            border: 1px solid #C9A227 !important;
            box-shadow: 0 4px 16px rgba(201, 162, 39, 0.4) !important;
            text-decoration: none !important;
            transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
        }
        .btn-gold *,
        a.btn-gold *,
        button.btn-gold * {
            color: #071526 !important;
            font-weight: 800 !important;
        }
        .btn-gold:hover,
        a.btn-gold:hover,
        button.btn-gold:hover {
            background: linear-gradient(135deg, #E8C766 0%, #F5E199 100%) !important;
            color: #071526 !important;
            box-shadow: 0 8px 24px rgba(201, 162, 39, 0.55) !important;
            transform: translateY(-2px) !important;
        }

        /* FIX STICKY HEADER MENU TEXT VISIBILITY */
        .rbt-header-wrapper.header-sticky.rbt-sticky {
            background: rgba(11, 31, 58, 0.96) !important;
            backdrop-filter: blur(14px) !important;
            -webkit-backdrop-filter: blur(14px) !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .rbt-header-wrapper.rbt-sticky .mainmenu-nav .mainmenu > li > a {
            color: #FFFFFF !important;
            font-weight: 600 !important;
        }
        .rbt-header-wrapper.rbt-sticky .mainmenu-nav .mainmenu > li > a:hover {
            color: #E8C766 !important;
        }
        body.active-dark-mode .rbt-header-wrapper.header-sticky {
            background: rgba(7, 15, 30, 0.97) !important;
        }

        /* PURPLE / BLUE COLOR ELIMINATION OVERRIDES */
        .theme-gradient,
        .bg-gradient-1 {
            background: linear-gradient(135deg, #C9A227, #E8C766) !important;
            -webkit-background-clip: text !important;
            background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
        }

        .btn-gradient,
        .rbt-btn.btn-gradient,
        a.btn-gradient,
        button.btn-gradient,
        .rbt-button.btn-gradient {
            background: linear-gradient(135deg, #E8C766, #C9A227) !important;
            color: #0B1F3A !important;
            border: 1px solid #E8C766 !important;
            box-shadow: 0 10px 24px rgba(201, 162, 39, 0.22) !important;
            border-radius: 50px !important;
            font-weight: 700 !important;
        }
        .btn-gradient:hover,
        .rbt-btn.btn-gradient:hover {
            background: linear-gradient(135deg, #f6e6a8, #C9A227) !important;
            color: #0B1F3A !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 16px 32px rgba(201, 162, 39, 0.38) !important;
        }

        .bg-primary-opacity,
        .bg-secondary-opacity {
            background: rgba(201, 162, 39, 0.12) !important;
            color: #C9A227 !important;
            border: 1px solid rgba(201, 162, 39, 0.25) !important;
        }

        .current-price,
        .rbt-price .current-price,
        .price .current-price {
            color: #C9A227 !important;
            font-weight: 800 !important;
        }

        /* FIX PURPLE ICON BACKGROUNDS IN JOURNAL / CUSTOM SECTIONS */
        [style*="#f0edff"],
        [style*="background: #f0edff"],
        [style*="background-color: #f0edff"],
        .bg-purple-opacity {
            background: rgba(201, 162, 39, 0.12) !important;
            color: #C9A227 !important;
            border-radius: 14px !important;
        }
        [style*="#7a5cf0"],
        [style*="color: #7a5cf0"],
        .color-purple {
            color: #C9A227 !important;
        }

        /* OVERRIDE TEMPLATE PURPLE BORDER GRADIENT BUTTONS */
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
            box-shadow: none !important;
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
        .btn-border-gradient i,
        .rbt-btn.btn-border-gradient i {
            color: #E8C766 !important;
        }
        .btn-border-gradient:hover i,
        .rbt-btn.btn-border-gradient:hover i {
            color: #071526 !important;
        }

        /* FIX YELLOW/PURPLE JOURNAL BUTTONS */
        a[style*="background: #f8b81f"],
        a[style*="background:#f8b81f"],
        button[style*="background: #f8b81f"],
        a[class*="btn-yellow"],
        .btn-warning {
            background: linear-gradient(135deg, #E8C766, #C9A227) !important;
            color: #0B1F3A !important;
            border-radius: 50px !important;
            font-weight: 700 !important;
            border: 1px solid #E8C766 !important;
            padding: 12px 28px !important;
            box-shadow: 0 10px 24px rgba(201, 162, 39, 0.25) !important;
        }

        /* ELIMINATE TEMPLATE NEGATIVE MARGIN OVERLAPS ON PROFILE PAGES */
        .rbt-tutor-information {
            position: relative !important;
            bottom: auto !important;
            padding: 0 !important;
        }

        /* EXECUTIVE NAVY & GOLD UTILITY CLASSES */
        .annur-card-hover {
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), border-color 0.35s ease !important;
        }
        .annur-card-hover:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.28), 0 0 20px rgba(201, 162, 39, 0.15) !important;
            border-color: rgba(201, 162, 39, 0.4) !important;
        }
        .annur-badge-gold {
            background: rgba(201, 162, 39, 0.12) !important;
            color: #E8C766 !important;
            border: 1px solid rgba(201, 162, 39, 0.35) !important;
            border-radius: 50px !important;
            font-weight: 700 !important;
            font-size: 11.5px !important;
            letter-spacing: 0.04em !important;
            padding: 4px 14px !important;
            display: inline-flex !important;
            align-items: center !important;
        }

        /* EXECUTIVE NAVY & GOLD PAGINATION STYLING */
        .pagination {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px !important;
            padding: 0 !important;
            margin: 0 !important;
            list-style: none !important;
        }
        .pagination .page-item .page-link {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-width: 42px !important;
            height: 42px !important;
            padding: 0 14px !important;
            border-radius: 10px !important;
            background: var(--card-bg, #FFFFFF) !important;
            color: var(--text-main, #071526) !important;
            border: 1px solid var(--border-color, rgba(0, 0, 0, 0.12)) !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
            transition: all 0.25s ease !important;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04) !important;
        }
        .pagination .page-item.active .page-link {
            background: #071526 !important;
            color: #E8C766 !important;
            border-color: #071526 !important;
            box-shadow: 0 4px 14px rgba(7, 21, 38, 0.3) !important;
        }
        .pagination .page-item:not(.active):not(.disabled) .page-link:hover {
            background: #E8C766 !important;
            color: #071526 !important;
            border-color: #E8C766 !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(201, 162, 39, 0.3) !important;
        }
        .pagination .page-item.disabled .page-link {
            opacity: 0.4 !important;
            cursor: not-allowed !important;
            background: var(--card-bg, #FFFFFF) !important;
            color: var(--text-muted, #6c757d) !important;
        }
        .annur-glass-card {
            background: var(--card-bg) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid var(--border-color) !important;
            border-radius: var(--radius-md) !important;
            box-shadow: var(--card-shadow) !important;
        }
        .rbt-tutor-information {
            width: 100% !important;
        }
        .rbt-dashboard-area.mt--50,
        .rbt-dashboard-area {
            margin-top: 0 !important;
        }

        /* CARD TYPOGRAPHY FIXES */
        .feature-card h3,
        .feature-card h4,
        .program-card h3,
        .program-card h4,
        .rbt-card-title,
        .rbt-default-card .title,
        .program-card .title {
            font-weight: 700 !important;
            font-size: 16px !important;
            color: #0F172A !important;
            line-height: 1.4 !important;
            letter-spacing: -0.01em !important;
        }
        body.active-dark-mode .feature-card h3,
        body.active-dark-mode .program-card h3,
        body.active-dark-mode .rbt-card-title,
        body.active-dark-mode .rbt-default-card .title {
            color: #F8FAFC !important;
        }

        /* FLOATING ACTION BUTTONS FIX */
        .rbt-whatsapp-float,
        .whatsapp-float,
        a[href*="wa.me"] {
            bottom: 25px;
            right: 25px;
            z-index: 9998 !important;
        }

        @media (max-width: 991px) {
            .rbt-whatsapp-float,
            .whatsapp-float,
            a[href*="wa.me"] {
                bottom: 78px !important;
                right: 16px !important;
            }
        }

        .rbt-top-to-bottom,
        #top-to-bottom,
        .rbt-top-to-bottom.active {
            bottom: 95px !important;
            right: 25px !important;
            z-index: 99998 !important;
        }

        /* Pagination responsive fix */
        @media (max-width: 767px) {
            .rbt-pagination {
                flex-wrap: wrap !important;
                justify-content: center !important;
                gap: 6px !important;
                margin: 0 !important;
            }
            .rbt-pagination li {
                margin: 3px !important;
            }
            .rbt-pagination li a {
                width: 38px !important;
                height: 38px !important;
                font-size: 13px !important;
            }
        }

        /* Quill Editor Alignment Compatibility */
        .ql-align-center { text-align: center !important; }
        .ql-align-right { text-align: right !important; }
        .ql-align-justify { text-align: justify !important; }

        /* Fix dark mode mobile menu */
        body.active-dark-mode .popup-mobile-menu .inner-wrapper {
            background-color: var(--color-dark, #1a1a2e) !important;
        }
        body.active-dark-mode .popup-mobile-menu .mainmenu li a {
            color: var(--color-white, #ffffff) !important;
        }
        body.active-dark-mode .popup-mobile-menu .mainmenu li {
            border-bottom-color: var(--color-border, #2b2b36) !important;
        }
    </style>

    @yield('content')

    <?php 

        if (isset($topToBottom) && $topToBottom === 'true') {
            ?>
            <x-frontend.topToBottom />
            <?php
        }
    ?>

    <?php 

        if (!isset($footer) || $footer !== 'false') {
            ?>
            <x-frontend.footer />
            <?php
        }
    ?>
    

    <x-frontend.whatsapp-float/>

    <x-frontend.script/>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Custom Theme Toggle Logic
        var themeToggle = document.getElementById('custom-theme-toggle');
        var themeIcon = document.getElementById('header-theme-icon');
        
        function updateThemeIcon() {
            if(!themeIcon) return;
            if(document.body.classList.contains('active-dark-mode')) {
                themeIcon.setAttribute('icon', 'solar:sun-linear');
            } else {
                themeIcon.setAttribute('icon', 'solar:moon-linear');
            }
        }
        
        if (themeToggle) {
            themeToggle.addEventListener('click', function(e) {
                e.preventDefault();
                if(document.body.classList.contains('active-dark-mode')) {
                    var lightBtn = document.querySelector('#my_switcher .setColor.light');
                    if(lightBtn) lightBtn.click();
                } else {
                    var darkBtn = document.querySelector('#my_switcher .setColor.dark');
                    if(darkBtn) darkBtn.click();
                }
                setTimeout(updateThemeIcon, 50);
            });
            setTimeout(updateThemeIcon, 300);
        }
    });
    </script>
    
    <!-- Mobile App-Feel Bottom Navigation -->
    <x-frontend.mobile_bottom_nav />

</body>

</html>
