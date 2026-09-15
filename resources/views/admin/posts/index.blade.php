@extends('layouts.vertical', ['title' => 'Daftar Artikel'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
        <div>
            <h4 class="page-title mb-1">Manajemen Artikel</h4>
            <p class="text-muted mb-0">Kelola konten berita dan artikel publikasi Anda.</p>
        </div>
        <div class="d-flex gap-2 align-items-center">
            <form action="{{ route('admin.posts.index') }}" method="GET" class="m-0 d-flex gap-2">
                <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control" placeholder="Cari artikel..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-secondary border-0"><iconify-icon icon="solar:magnifer-linear"></iconify-icon></button>
                </div>
                <select name="status" class="form-select form-select-sm shadow-sm" style="min-width:140px; cursor: pointer;" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>✅ Telah Rilis</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>📝 Masih Draft</option>
                </select>
            </form>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary shadow-sm text-nowrap">
                <iconify-icon icon="solar:pen-new-square-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tulis Baru
            </a>
        </div>
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
                                <th>Gambar</th>
                                <th>Judul Artikel</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal Publikasi</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>{{ method_exists($posts, 'firstItem') ? ($posts->firstItem() + $loop->index) : $loop->iteration }}</td>
                                    <td>
                                        @if($post->image_url)
                                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="avatar-md rounded object-fit-cover shadow-sm" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.classList.remove('d-none');">
                                            <div class="avatar-md bg-light rounded d-flex align-items-center justify-content-center border d-none" title="Gambar Tidak Ditemukan">
                                                <iconify-icon icon="solar:gallery-broken" class="fs-24 text-muted"></iconify-icon>
                                            </div>
                                        @else
                                            <div class="avatar-md bg-light rounded d-flex align-items-center justify-content-center border" title="Tanpa Gambar">
                                                <iconify-icon icon="solar:gallery-broken" class="fs-24 text-muted"></iconify-icon>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-semibold text-truncate" style="max-width:350px;">
                                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-dark">{{ $post->title }}</a>
                                        </h5>
                                        <p class="mb-0 text-muted fs-12 mt-1">Oleh: {{ $post->user->name ?? 'Admin' }}</p>
                                    </td>
                                    <td>
                                        @if($post->category)
                                            <span class="badge bg-primary-subtle text-primary">{{ $post->category->name }}</span>
                                        @else
                                            <span class="text-muted fs-13">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->published_at)
                                            <span class="badge bg-success-subtle text-success border border-success px-2 py-1"><iconify-icon icon="solar:check-circle-bold-duotone" class="me-1"></iconify-icon> Publik</span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1"><iconify-icon icon="solar:pen-bold-duotone" class="me-1"></iconify-icon> Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $post->published_at ? $post->published_at->translatedFormat('d F Y') : '-' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ $post->published_at ? route('article.show', $post->slug) : route('admin.posts.preview', $post->id) }}" target="_blank" class="btn btn-sm btn-soft-secondary" data-bs-toggle="tooltip" title="{{ $post->published_at ? 'Lihat Artikel' : 'Preview Draft' }}">
                                            <iconify-icon icon="solar:eye-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Artikel">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.posts.duplicate', $post->id) }}" method="POST" class="d-inline-block">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip" title="Duplikat Artikel">
                                                <iconify-icon icon="solar:copy-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Artikel">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:document-text-broken" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Data Kosong</h5>
                                        <p class="text-muted">Belum ada artikel yang diunggah. Silakan klik "Tulis Baru" untuk memulai.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($posts->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $posts->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
