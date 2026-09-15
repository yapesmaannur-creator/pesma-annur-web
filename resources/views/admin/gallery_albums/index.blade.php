@extends('layouts.vertical', ['title' => 'Daftar Album Galeri'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Album Galeri</h4>
            <p class="text-muted mb-0">Kelola kategori/album galeri kegiatan dan fasilitas pesantren.</p>
        </div>
        <a href="{{ route('admin.gallery-albums.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:gallery-add-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tambah Album
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
                                <th>Cover Album</th>
                                <th>Informasi Album</th>
                                <th>Tot. Foto</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($albums as $album)
                                <tr>
                                    <td>{{ $loop->iteration + $albums->firstItem() - 1 }}</td>
                                    <td>
                                        @if($album->cover_image)
                                            <img src="{{ asset('storage/' . $album->cover_image) }}" alt="{{ $album->title }}" class="avatar-sm rounded object-fit-cover shadow-sm">
                                        @else
                                            <div class="avatar-sm bg-light rounded d-flex align-items-center justify-content-center border" title="Tanpa Cover">
                                                <iconify-icon icon="solar:gallery-broken" class="fs-20 text-muted"></iconify-icon>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-semibold text-dark">{{ $album->title }}</h5>
                                        <p class="mb-0 text-muted fs-12 mt-1">{{ Str::limit($album->description, 40) }}</p>
                                    </td>
                                    <td><span class="badge bg-primary-subtle text-primary">{{ $album->galleries_count ?? 0 }} Item</span></td>
                                    <td>
                                        @if($album->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.gallery-albums.edit', $album->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Album">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.gallery-albums.destroy', $album->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus album in akan menghapus semua foto di dalamnya. Lanjutkan?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Album">
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
                                        <h5 class="fw-semibold text-dark">Album Kosong</h5>
                                        <p class="text-muted">Belum ada album galeri. Silakan klik "Tambah Album".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($albums->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $albums->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
