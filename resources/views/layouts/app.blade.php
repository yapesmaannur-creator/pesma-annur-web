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
        /* Prevent horizontal overflow/scroll on all devices */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
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

        /* Global button styling for a more modern, pill-shaped look */
        .btn, 
        .rbt-btn,
        button[type="submit"],
        .rbt-marquee-btn,
        .carousel-control-prev,
        .carousel-control-next {
            border-radius: 50px !important;
        }
        .rbt-banner-area .banner-btn {
            border-radius: 50px !important;
        }

        /* Quill Editor Alignment Compatibility */
        .ql-align-center { text-align: center !important; }
        .ql-align-right { text-align: right !important; }
        .ql-align-justify { text-align: justify !important; }

        /* Fix dark mode tab menu on mobile */
        body.active-dark-mode .nav-tabs {
            border-color: var(--color-border, #2b2b36);
        }
        body.active-dark-mode .nav-tabs .nav-link {
            color: #b1b4ba;
        }
        body.active-dark-mode .nav-tabs .nav-link:hover,
        body.active-dark-mode .nav-tabs .nav-link:focus {
            border-color: var(--color-border, #2b2b36) var(--color-border, #2b2b36) transparent;
        }
        body.active-dark-mode .nav-tabs .nav-link.active {
            color: var(--color-white);
            background-color: var(--color-dark);
            border-color: var(--color-border, #2b2b36) var(--color-border, #2b2b36) var(--color-dark);
        }
        body.active-dark-mode .tab-content {
            background-color: var(--color-dark) !important;
            padding: 15px;
            border-radius: 0 0 6px 6px;
        }

        @media (max-width: 767px) {
            body.active-dark-mode .nav-tabs {
                background-color: var(--color-dark);
                border: 1px solid var(--color-border, #2b2b36);
                border-radius: 6px;
                padding: 10px;
                display: flex;
                flex-wrap: wrap;
                flex-direction: column;
            }
            body.active-dark-mode .nav-tabs .nav-item {
                margin-bottom: 5px;
                width: 100%;
            }
            body.active-dark-mode .nav-tabs .nav-link {
                border: none;
                border-radius: 4px;
                background-color: transparent;
                text-align: center;
                display: block;
                width: 100%;
            }
            body.active-dark-mode .nav-tabs .nav-link.active {
                background-color: var(--color-primary);
                color: var(--color-white);
            }
        }

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
        body.active-dark-mode .popup-mobile-menu .inner-top .content .rbt-btn-close .close-button {
            background-color: var(--color-darker, #161621) !important;
            color: var(--color-white, #ffffff) !important;
        }
        body.active-dark-mode .popup-mobile-menu .mobile-search-wrapper {
            border: 1px solid var(--color-border, #2b2b36) !important;
            background-color: var(--color-darker, #161621) !important;
            box-shadow: none !important;
        }
        body.active-dark-mode .popup-mobile-menu .mobile-search-wrapper input {
            background-color: transparent !important;
            color: var(--color-white, #ffffff) !important;
        }
        body.active-dark-mode .popup-mobile-menu .inner-top .description {
            color: var(--color-body, #b9b9c9) !important;
        }
        body.active-dark-mode .popup-mobile-menu .inner-top .logo-dark {
            display: none !important;
        }
        body.active-dark-mode .popup-mobile-menu .inner-top .logo-light {
            display: block !important;
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

    <!-- Search Overlay Styles & Script -->
    <style>
        .rbt-search-dropdown {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(8px);
        }
        .rbt-search-dropdown.d-none { display: none !important; }
        .rbt-search-dropdown .search-form {
            width: 90%;
            max-width: 700px;
        }
        .rbt-search-dropdown .search-field {
            display: flex;
            border-bottom: 3px solid #fff;
            padding-bottom: 10px;
        }
        .rbt-search-dropdown .search-input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: #fff;
            font-size: 28px;
            font-weight: 300;
            padding: 10px 0;
        }
        .rbt-search-dropdown .search-input::placeholder { color: rgba(255,255,255,0.5); }
        .rbt-search-dropdown .search-submit {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
            padding: 10px 15px;
        }
        .rbt-search-dropdown .search-overlay-close {
            position: absolute;
            top: 30px;
            right: 40px;
            color: #fff;
            font-size: 30px;
            cursor: pointer;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }
        .rbt-search-dropdown .search-overlay-close:hover { background: rgba(255,255,255,0.1); }
    </style>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var trigger = document.getElementById('search-trigger');
        var dropdown = document.getElementById('search-dropdown');
        var closeBtn = document.getElementById('search-close');
        var searchInput = document.getElementById('global-search-input');
        if (trigger && dropdown) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.classList.remove('d-none');
                if (searchInput) searchInput.focus();
            });
            closeBtn.addEventListener('click', function() {
                dropdown.classList.add('d-none');
            });
            dropdown.addEventListener('click', function(e) {
                if (e.target === dropdown) dropdown.classList.add('d-none');
            });
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') dropdown.classList.add('d-none');
            });
        }

        // Custom Theme Toggle Logic
        var themeToggle = document.getElementById('custom-theme-toggle');
        var themeIcon = document.getElementById('header-theme-icon');
        
        function updateThemeIcon() {
            if(!themeIcon) return;
            if(document.body.classList.contains('active-dark-mode')) {
                themeIcon.classList.remove('feather-moon');
                themeIcon.classList.add('feather-sun');
            } else {
                themeIcon.classList.remove('feather-sun');
                themeIcon.classList.add('feather-moon');
            }
        }
        
        if (themeToggle) {
            themeToggle.addEventListener('click', function(e) {
                e.preventDefault();
                if(document.body.classList.contains('active-dark-mode')) {
                    // Currently dark, switch to light
                    var lightBtn = document.querySelector('#my_switcher .setColor.light');
                    if(lightBtn) lightBtn.click();
                } else {
                    // Currently light, switch to dark
                    var darkBtn = document.querySelector('#my_switcher .setColor.dark');
                    if(darkBtn) darkBtn.click();
                }
                setTimeout(updateThemeIcon, 50);
            });
            // Initial check after external template scripts have potentially set body class
            setTimeout(updateThemeIcon, 300);
        }
    });
    </script>
    
    <!-- Mobile App-Feel Bottom Navigation -->
    <x-frontend.mobile_bottom_nav />

</body>

</html>
