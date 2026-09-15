@extends('layouts.vertical', ['title' => 'Dashboard Administrasi'])

@section('css')
<style>
    .stat-card {
        transition: transform 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
    .quick-link {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-radius: 8px;
        transition: background 0.2s;
        color: inherit;
        text-decoration: none;
    }
    .quick-link:hover {
        background: var(--bs-tertiary-bg);
        color: #2f57ef;
    }
    .quick-link iconify-icon {
        font-size: 20px;
        margin-right: 10px;
    }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="page-title mb-1">Dashboard Administrasi</h4>
        <p class="text-muted mb-0">Selamat datang kembali! Berikut ringkasan statistik sistem saat ini.</p>
    </div>
</div>

<!-- Stat Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-uppercase fs-13 fw-semibold mb-1">Total Pengguna</p>
                        <h3 class="mb-0 text-dark">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="avatar-md bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:users-group-two-rounded-bold-duotone" class="fs-24 text-primary"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-uppercase fs-13 fw-semibold mb-1">Total Artikel</p>
                        <h3 class="mb-0 text-dark">{{ $stats['total_posts'] }}</h3>
                    </div>
                    <div class="avatar-md bg-info-subtle rounded-circle d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:document-text-bold-duotone" class="fs-24 text-info"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-uppercase fs-13 fw-semibold mb-1">Produk</p>
                        <h3 class="mb-0 text-dark">{{ $stats['total_products'] }}</h3>
                    </div>
                    <div class="avatar-md bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:bag-heart-bold-duotone" class="fs-24 text-warning"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted text-uppercase fs-13 fw-semibold mb-1">Pesan Masuk</p>
                        <h3 class="mb-0 text-dark">{{ $stats['total_contacts'] }}</h3>
                    </div>
                    <div class="avatar-md bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center">
                        <iconify-icon icon="solar:letter-bold-duotone" class="fs-24 text-danger"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row mb-2">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-success-subtle rounded d-flex align-items-center justify-content-center me-3">
                        <iconify-icon icon="solar:bookmark-circle-bold-duotone" class="fs-20 text-success"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-muted fs-13 mb-0">Program Aktif</p>
                        <h5 class="mb-0">{{ $stats['active_programs'] }} / {{ $stats['total_programs'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-secondary-subtle rounded d-flex align-items-center justify-content-center me-3">
                        <iconify-icon icon="solar:gallery-bold-duotone" class="fs-20 text-secondary"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-muted fs-13 mb-0">Foto Galeri</p>
                        <h5 class="mb-0">{{ $stats['total_galleries'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100 stat-card">
            <div class="card-body py-3">
                <div class="d-flex align-items-center">
                    <div class="avatar-sm bg-primary-subtle rounded d-flex align-items-center justify-content-center me-3">
                        <iconify-icon icon="solar:pen-new-round-bold-duotone" class="fs-20 text-primary"></iconify-icon>
                    </div>
                    <div>
                        <p class="text-muted fs-13 mb-0">Submission Artikel</p>
                        <h5 class="mb-0">{{ $stats['total_submissions'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-bottom py-3">
                <h5 class="card-title mb-0 fw-semibold">
                    <iconify-icon icon="solar:chart-2-bold-duotone" class="align-middle me-1 text-primary"></iconify-icon>
                    Statistik Konten (6 Bulan Terakhir)
                </h5>
            </div>
            <div class="card-body">
                <div id="content-chart" style="min-height: 320px;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-bottom py-3">
                <h5 class="card-title mb-0 fw-semibold">
                    <iconify-icon icon="solar:link-round-angle-bold-duotone" class="align-middle me-1 text-primary"></iconify-icon>
                    Pintasan Cepat
                </h5>
            </div>
            <div class="card-body p-2">
                <a href="{{ route('admin.posts.create') }}" class="quick-link">
                    <iconify-icon icon="solar:pen-new-round-bold-duotone" class="text-primary"></iconify-icon>
                    Tulis Artikel Baru
                </a>
                <a href="{{ route('admin.products.create') }}" class="quick-link">
                    <iconify-icon icon="solar:bag-heart-bold-duotone" class="text-warning"></iconify-icon>
                    Tambah Produk
                </a>
                <a href="{{ route('admin.galleries.create') }}" class="quick-link">
                    <iconify-icon icon="solar:gallery-bold-duotone" class="text-success"></iconify-icon>
                    Upload Galeri
                </a>
                <a href="{{ route('admin.page-sections.index') }}" class="quick-link">
                    <iconify-icon icon="solar:layers-bold-duotone" class="text-info"></iconify-icon>
                    Kelola Section Halaman
                </a>
                <a href="{{ route('admin.settings.index') }}" class="quick-link">
                    <iconify-icon icon="solar:settings-bold-duotone" class="text-secondary"></iconify-icon>
                    Pengaturan Situs
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="quick-link">
                    <iconify-icon icon="solar:letter-bold-duotone" class="text-danger"></iconify-icon>
                    Pesan Masuk
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row">
    <!-- Recent Articles -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">Artikel Terbaru</h5>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-soft-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered align-middle mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_posts as $post)
                                <tr>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-normal text-truncate" style="max-width:250px;">
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-dark">{{ $post->title }}</a>
                                        </h5>
                                        <small class="text-muted">{{ $post->published_at ? $post->published_at->format('d M Y') : 'Draft' }}</small>
                                    </td>
                                    <td>{{ $post->user->name ?? 'Admin' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-soft-primary">
                                            <iconify-icon icon="solar:pen-bold-duotone"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada artikel.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 fw-semibold">Pesan Kontak Terbaru</h5>
                <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-soft-danger">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered align-middle mb-0">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th>Pengirim</th>
                                <th>Subjek</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_contacts as $contact)
                                <tr>
                                    <td>
                                        <span class="fw-medium">{{ $contact->name ?? '-' }}</span><br>
                                        <small class="text-muted">{{ $contact->email ?? '' }}</small>
                                    </td>
                                    <td class="text-truncate" style="max-width: 200px;">{{ $contact->subject ?? $contact->message ?? '-' }}</td>
                                    <td><small>{{ $contact->created_at ? $contact->created_at->format('d M Y') : '-' }}</small></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada pesan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var options = {
        series: [{
            name: 'Artikel Baru',
            data: {!! json_encode($chartData['articles']) !!}
        }, {
            name: 'Pesan Masuk',
            data: {!! json_encode($chartData['contacts']) !!}
        }],
        chart: {
            type: 'area',
            height: 320,
            fontFamily: 'inherit',
            toolbar: { show: false },
        },
        colors: ['#2f57ef', '#e74c65'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2.5 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: {!! json_encode($chartData['months']) !!},
            axisBorder: { show: false },
            axisTicks: { show: false },
        },
        yaxis: {
            min: 0,
            forceNiceScale: true,
        },
        grid: {
            borderColor: '#f1f1f1',
            strokeDashArray: 4,
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
        },
        tooltip: {
            y: { formatter: function(val) { return val + ' item'; }}
        }
    };
    var chart = new ApexCharts(document.querySelector("#content-chart"), options);
    chart.render();
});
</script>
@endsection
