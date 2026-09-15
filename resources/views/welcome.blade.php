@extends('layouts.app')

@section('meta_title', 'Beranda')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="row mb-5 justify-content-center">
        <div class="col-xl-10 text-center py-5">
            <h1 class="display-4 fw-bold text-dark mb-3">{{ $settings['site_name'] ?? 'Larkon Edu' }}</h1>
            <p class="lead text-muted mb-4">Membangun generasi cerdas dan berakhlak mulia melalui program unggulan kami.</p>
            <div class="d-flex justify-content-center gap-2">
                <a href="#program-section" class="btn btn-primary px-4 py-2 rounded-pill">Lihat Program</a>
                <a href="{{ route('shop.index') ?? '/shop' }}" class="btn btn-outline-primary px-4 py-2 rounded-pill">E-Commerce</a>
            </div>
        </div>
    </div>

    <!-- Active Programs API Section -->
    <div class="row mb-4" id="program-section">
        <div class="col-12 text-center mb-4">
            <h2 class="fw-bold">Program Pendidikan</h2>
            <p class="text-muted">Pilih kategori program yang sesuai dengan Anda.</p>
        </div>
        
        <div class="col-12 mb-4 d-flex justify-content-center gap-2 filter-wrapper">
            <button class="btn btn-primary rounded-pill btn-filter shadow-sm" data-kategori="">Semua</button>
            <button class="btn btn-outline-secondary rounded-pill btn-filter shadow-sm" data-kategori="unggulan">Unggulan</button>
            <button class="btn btn-outline-secondary rounded-pill btn-filter shadow-sm" data-kategori="reguler">Reguler</button>
        </div>
    </div>

    <div class="row" id="program-container">
        <!-- Rendered by API -->
    </div>
    
    <template id="program-card-template">
        <div class="col-xxl-4 col-lg-4 col-md-6 mb-4 card-item program-card">
            <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <img src="" alt="" class="card-img-top program-img" style="height:220px; object-fit:cover;">
                <div class="card-body">
                    <h5 class="card-title fw-bold program-title mb-2"></h5>
                    <p class="card-text text-muted program-desc fs-14 mb-3"></p>
                    <a href="" class="btn btn-light w-100 text-primary fw-medium program-link">
                        Lihat Selengkapnya <iconify-icon icon="solar:arrow-right-bold-duotone" class="align-middle"></iconify-icon>
                    </a>
                </div>
            </div>
        </div>
    </template>

    <!-- Seksi CTA Filantropi & Donasi -->
    <x-frontend.donationCta />
</div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('program-container');
            const template = document.getElementById('program-card-template');
            const filterBtns = document.querySelectorAll('.btn-filter');

            const fetchPrograms = async (kategori = '') => {
                container.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-2 text-muted">Memuat data program...</p></div>';
                
                try {
                    const response = await fetch(`/api/programs?kategori=${kategori}`, window.fetchOptions || {});
                    const json = await response.json();
                    
                    container.innerHTML = '';

                    if(json.data.length === 0) {
                        container.innerHTML = '<div class="col-12 text-center py-5"><iconify-icon icon="solar:box-minimalistic-bold-duotone" class="fs-48 text-muted mb-2"></iconify-icon><h5 class="text-muted">Belum ada program di kategori ini.</h5></div>';
                        return;
                    }

                    json.data.forEach(program => {
                        const clone = template.content.cloneNode(true);
                        
                        clone.querySelector('.program-img').src = `/storage/${program.image_path}`;
                        clone.querySelector('.program-img').alt = program.name;
                        clone.querySelector('.program-title').textContent = program.name;
                        clone.querySelector('.program-desc').textContent = program.description?.substring(0, 100) + '...';
                        clone.querySelector('.program-link').href = `/program/${program.slug}`;
                        
                        container.appendChild(clone);
                    });
                } catch (error) {
                    container.innerHTML = '<div class="col-12 text-center py-5"><iconify-icon icon="solar:danger-triangle-bold-duotone" class="fs-48 text-danger mb-2"></iconify-icon><h5 class="text-danger">Gagal memuat data dari server.</h5></div>';
                }
            };

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Update Active Button styling
                    filterBtns.forEach(b => {
                        b.classList.remove('btn-primary');
                        b.classList.add('btn-outline-secondary');
                    });
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-primary');
                    
                    fetchPrograms(this.getAttribute('data-kategori'));
                });
            });

            fetchPrograms();
        });
    </script>
@endpush
