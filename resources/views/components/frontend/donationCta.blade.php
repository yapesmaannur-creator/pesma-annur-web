<!-- Komponen CTA Filantropi & Kebaikan Pesma An-Nur & Unit Binaan -->
<div class="rbt-callto-action-area my-5">
    <div class="container">
        <div class="pesma-cta-banner rounded-4 shadow-lg overflow-hidden position-relative p-4 p-md-5">
            <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <!-- Badge Kategori Terpadu -->
                    <div class="d-inline-flex align-items-center gap-2 mb-3 px-3 py-1 rounded-pill pesma-cta-tag">
                        <iconify-icon icon="solar:heart-bold" class="text-warning"></iconify-icon>
                        <span class="fw-semibold">Program Filantropi & Kebaikan Pesma An-Nur</span>
                    </div>

                    <h2 class="fw-bold text-white mb-3 pesma-cta-title">
                        Mengalirkan Pahala Jariyah untuk Santri Pejuang Al-Qur'an & Dakwah Ummat
                    </h2>

                    <p class="pesma-cta-desc mb-4">
                        Dukung beasiswa pendidikan santri mahasiswa tahfidz Pesma An-Nur, pengembangan sarana dakwah, serta pembinaan adik-adik santri Pesantren Al-Bisri secara transparan dan amanah.
                    </p>

                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <a href="https://e-maktab.pesma-annur.net/donasi" target="_blank" class="rbt-btn btn-warning-custom shadow-lg">
                            <span class="icon-reverse-wrapper">
                                <span class="btn-text">Salurkan Donasi Sekarang</span>
                                <span class="btn-icon"><iconify-icon icon="solar:arrow-right-up-linear" class="fs-5"></iconify-icon></span>
                                <span class="btn-icon"><iconify-icon icon="solar:arrow-right-up-linear" class="fs-5"></iconify-icon></span>
                            </span>
                        </a>
                        <div class="pesma-cta-subtext small">
                            <iconify-icon icon="solar:shield-check-bold" class="text-warning me-1 fs-5 align-middle"></iconify-icon>
                            <span>QRIS, E-Wallet & Transfer Bank • Bebas Biaya Admin</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 text-center d-none d-lg-block">
                    <div class="pesma-cta-glass p-4 rounded-4 text-center">
                        <iconify-icon icon="solar:book-bookmark-minimalistic-bold-duotone" class="display-3 text-warning mb-2"></iconify-icon>
                        <h5 class="fw-bold text-white mb-1">Pesma An-Nur</h5>
                        <p class="small text-white text-opacity-75 mb-3">& Unit Binaan Pesantren Al-Bisri</p>
                        
                        <div class="d-flex justify-content-center gap-3 text-center border-top border-white border-opacity-25 pt-3">
                            <div>
                                <h6 class="fw-bold text-white mb-0">100%</h6>
                                <small class="text-white text-opacity-75" style="font-size: 0.75rem;">Amanah</small>
                            </div>
                            <div class="border-start border-white border-opacity-25 ps-3">
                                <h6 class="fw-bold text-white mb-0">Bebas Fee</h6>
                                <small class="text-white text-opacity-75" style="font-size: 0.75rem;">Nominal Pas</small>
                            </div>
                            <div class="border-start border-white border-opacity-25 ps-3">
                                <h6 class="fw-bold text-white mb-0">Laporan</h6>
                                <small class="text-white text-opacity-75" style="font-size: 0.75rem;">Transparan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Background Decorative Glow -->
            <div class="pesma-cta-glow"></div>
        </div>
    </div>
</div>

<style>
    /* Styling CTA Resisten Terhadap Mode Apapun (Light & Dark Mode) */
    .pesma-cta-banner {
        background: linear-gradient(135deg, #064e3b 0%, #047857 55%, #059669 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
    }
    .pesma-cta-title {
        color: #ffffff !important;
        font-size: clamp(1.5rem, 2.5vw, 2.2rem) !important;
        line-height: 1.35 !important;
    }
    .pesma-cta-desc {
        color: rgba(255, 255, 255, 0.92) !important;
        font-size: 1.05rem !important;
        max-width: 640px !important;
        line-height: 1.65 !important;
    }
    .pesma-cta-tag {
        background: rgba(255, 255, 255, 0.18) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        color: #ffffff !important;
        font-size: 0.85rem !important;
    }
    .pesma-cta-subtext {
        color: rgba(255, 255, 255, 0.85) !important;
    }
    .pesma-cta-glass {
        background: rgba(255, 255, 255, 0.12) !important;
        backdrop-filter: blur(12px) !important;
        -webkit-backdrop-filter: blur(12px) !important;
        border: 1px solid rgba(255, 255, 255, 0.25) !important;
    }
    .btn-warning-custom {
        background-color: #f59e0b !important;
        border-color: #f59e0b !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        padding: 14px 30px !important;
        border-radius: 50px !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-size: 1rem !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
    }
    .btn-warning-custom:hover {
        background-color: #d97706 !important;
        border-color: #d97706 !important;
        color: #000000 !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4) !important;
    }
    .pesma-cta-glow {
        position: absolute;
        width: 320px;
        height: 320px;
        background: radial-gradient(circle, rgba(245, 158, 11, 0.2) 0%, rgba(255,255,255,0) 70%);
        top: -60px;
        right: -40px;
        border-radius: 50%;
        pointer-events: none;
    }

    /* Proteksi Dark Mode Histudy */
    body.active-dark-mode .pesma-cta-banner {
        background: linear-gradient(135deg, #043629 0%, #064e3b 55%, #047857 100%) !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
    }
    body.active-dark-mode .btn-warning-custom {
        background-color: #f59e0b !important;
        color: #0f172a !important;
    }
</style>
