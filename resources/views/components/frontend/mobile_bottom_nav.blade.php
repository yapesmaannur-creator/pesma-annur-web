@php
    $currentRoute = request()->path();
    $isHome = request()->is('/');
    $isShop = request()->is('shop*') || request()->is('produk*');
    $isArtikel = request()->is('artikel*') || request()->is('berita*');
    $isKirim = request()->is('kirim-tulisan*');
    $emaktabUrl = \App\Models\Setting::getByKey('emaktab_url') ?: 'https://e-maktab.pesma-annur.net';
@endphp

<style>
    .annur-mobile-bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        background: rgba(7, 21, 38, 0.96);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
        border-top: 1px solid rgba(201, 162, 39, 0.35);
        box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.45);
        padding: 8px 12px 10px;
        display: none;
    }

    @media (max-width: 991px) {
        .annur-mobile-bottom-nav {
            display: flex;
            align-items: center;
            justify-content: space-around;
        }
        body {
            padding-bottom: 70px !important;
        }
    }

    .annur-mobile-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-decoration: none !important;
        color: rgba(255, 255, 255, 0.75) !important;
        font-size: 10.5px;
        font-weight: 600;
        transition: all 0.25s ease;
        position: relative;
        flex: 1;
        text-align: center;
    }

    .annur-mobile-nav-item iconify-icon {
        font-size: 22px;
        margin-bottom: 3px;
        transition: transform 0.25s ease, color 0.25s ease;
    }

    .annur-mobile-nav-item:hover,
    .annur-mobile-nav-item.active {
        color: #E8C766 !important;
        font-weight: 800;
    }

    .annur-mobile-nav-item.active iconify-icon {
        color: #E8C766 !important;
        transform: translateY(-2px) scale(1.15);
    }

    .annur-mobile-nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -6px;
        width: 16px;
        height: 3px;
        background: #E8C766;
        border-radius: 50px;
        box-shadow: 0 0 8px #E8C766;
    }
</style>

<div class="annur-mobile-bottom-nav">
    <a href="{{ url('/') }}" class="annur-mobile-nav-item {{ $isHome ? 'active' : '' }}">
        <iconify-icon icon="solar:home-smile-bold-duotone"></iconify-icon>
        <span>Beranda</span>
    </a>

    <a href="{{ url('/shop') }}" class="annur-mobile-nav-item {{ $isShop ? 'active' : '' }}">
        <iconify-icon icon="solar:bag-bold-duotone"></iconify-icon>
        <span>Shop</span>
    </a>

    <a href="{{ url('/artikel') }}" class="annur-mobile-nav-item {{ $isArtikel ? 'active' : '' }}">
        <iconify-icon icon="solar:document-text-bold-duotone"></iconify-icon>
        <span>Artikel</span>
    </a>

    <a href="{{ $emaktabUrl }}" target="_blank" rel="noopener noreferrer" class="annur-mobile-nav-item">
        <iconify-icon icon="solar:laptop-minimalistic-bold-duotone" style="color: #E8C766;"></iconify-icon>
        <span style="color: #E8C766; font-weight: 700;">e-Maktab</span>
    </a>

    <a href="{{ url('/kirim-tulisan') }}" class="annur-mobile-nav-item {{ $isKirim ? 'active' : '' }}">
        <iconify-icon icon="solar:pen-new-square-bold-duotone"></iconify-icon>
        <span style="white-space: nowrap;">Kirim Karya</span>
    </a>
</div>
