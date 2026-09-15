@extends('layouts.vertical', ['title' => 'Daftar Foto & Media Galeri'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Isi Galeri</h4>
            <p class="text-muted mb-0">Kelola foto dan media di dalam masing-masing album.</p>
        </div>
        <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:camera-upload-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Unggah Foto Baru
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
                                <th>#</th>
                                <th>Album Induk</th>
                                <th>Foto / Media</th>
                                <th>Keterangan (Judul)</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($galleries as $gallery)
                                <tr>
                                    <td>{{ method_exists($galleries, 'firstItem') ? ($galleries->firstItem() + $loop->index) : $loop->iteration }}</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary py-1 px-2"><iconify-icon icon="solar:folder-with-files-bold-duotone" class="me-1"></iconify-icon> {{ $gallery->album->title ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <div class="avatar-lg">
                                            <img src="{{ asset('storage/' . $gallery->image) }}" class="rounded img-fluid object-fit-cover shadow-sm w-100 h-100" alt="{{ $gallery->title }}">
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-medium text-dark">{{ $gallery->title ?: '(Tanpa Judul)' }}</h5>
                                    </td>
                                    <td>
                                        @if($gallery->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Foto">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus foto ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Foto">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:gallery-broken" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Galeri Kosong</h5>
                                        <p class="text-muted">Belum ada foto yang diunggah. Silakan klik "Unggah Foto Baru".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($galleries->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $galleries->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
