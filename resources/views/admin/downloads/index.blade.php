@extends('layouts.vertical', ['title' => 'Download Center'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Download Center</h4>
            <p class="text-muted mb-0">Kelola file yang bisa diunduh oleh publik.</p>
        </div>
        <a href="{{ route('admin.downloads.create') }}" class="btn btn-primary">
            <iconify-icon icon="solar:upload-bold-duotone" class="align-middle me-1"></iconify-icon> Upload File Baru
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-centered mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:40px;">#</th>
                        <th>File</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Download</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($downloads as $download)
                    <tr>
                        <td>{{ $download->order }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="{{ $download->file_icon }} me-2 text-primary" style="font-size:20px;"></i>
                                <div>
                                    <h6 class="mb-0 fs-14">{{ $download->title }}</h6>
                                    <small class="text-muted">{{ $download->file_name }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-soft-primary text-primary">{{ \App\Models\Download::categories()[$download->category] ?? $download->category }}</span></td>
                        <td>{{ $download->file_size_human }}</td>
                        <td><span class="badge bg-secondary">{{ $download->download_count }}x</span></td>
                        <td>
                            @if($download->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Nonaktif</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.downloads.edit', $download) }}" class="btn btn-sm btn-soft-primary">
                                <iconify-icon icon="solar:pen-bold-duotone"></iconify-icon>
                            </a>
                            <form action="{{ route('admin.downloads.destroy', $download) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus file ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-soft-danger">
                                    <iconify-icon icon="solar:trash-bin-trash-bold-duotone"></iconify-icon>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Belum ada file yang diupload.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($downloads->hasPages())
<div class="mt-3">{{ $downloads->links('pagination::bootstrap-5') }}</div>
@endif
@endsection
