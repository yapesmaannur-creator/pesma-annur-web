@extends('layouts.vertical', ['title' => 'Daftar Banner'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Banner</h4>
            <p class="text-muted mb-0">Kelola banner slider yang tampil di halaman beranda.</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:gallery-add-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tambah Banner
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm badge-soft-success mb-4">
    <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-18 align-middle me-1"></iconify-icon> {{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 80px;">Urutan</th>
                                <th>Gambar Banner</th>
                                <th>Informasi Teks</th>
                                <th>Tautan</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($banners as $banner)
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark shadow-sm px-2 py-1 fs-14">{{ $banner->order }}</span>
                                    </td>
                                    <td>
                                        <img src="{{ asset('storage/' . $banner->image) }}" class="rounded shadow-sm object-fit-cover" style="height: 60px; max-width: 150px;" alt="Banner">
                                    </td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-medium text-dark">{{ $banner->title ?: '(Tanpa Judul)' }}</h5>
                                        <p class="mb-0 text-muted fs-12 mt-1">{{ Str::limit($banner->subtitle, 40) }}</p>
                                    </td>
                                    <td>
                                        @if($banner->link)
                                            <a href="{{ $banner->link }}" target="_blank" class="text-primary fs-13"><iconify-icon icon="solar:link-circle-line-duotone" class="align-middle fs-16"></iconify-icon> Kunjungi</a>
                                        @else
                                            <span class="text-muted fs-12">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($banner->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Banner">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus banner ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Banner">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:gallery-remove-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Data Kosong</h5>
                                        <p class="text-muted">Manajemen Banner masih kosong. Silakan tambah banner baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($banners->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $banners->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
