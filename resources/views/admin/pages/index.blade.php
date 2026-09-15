@extends('layouts.vertical', ['title' => 'Daftar Halaman'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Halaman</h4>
            <p class="text-muted mb-0">Kelola halaman statis dan dinamis website.</p>
        </div>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:document-add-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tambah Halaman
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
                                <th>Judul Halaman</th>
                                <th>URL Slug</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pages as $page)
                                <tr>
                                    <td>{{ $loop->iteration + $pages->firstItem() - 1 }}</td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-semibold text-dark">{{ $page->title }}</h5>
                                    </td>
                                    <td>
                                        <span class="text-muted fs-13">/{{ $page->slug }}</span>
                                    </td>
                                    <td>
                                        @if($page->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.pages.builder', $page->slug) }}" class="btn btn-sm btn-soft-success" data-bs-toggle="tooltip" title="Atur Konten/Section Halaman">
                                            <iconify-icon icon="solar:layers-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Meta Data Halaman">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.pages.duplicate', $page->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip" title="Duplikat Halaman">
                                                <iconify-icon icon="solar:copy-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus halaman ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Halaman">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:document-error-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Halaman Kosong</h5>
                                        <p class="text-muted">Belum ada halaman yang didaftarkan. Silakan klik "Tambah Halaman".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($pages->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $pages->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
