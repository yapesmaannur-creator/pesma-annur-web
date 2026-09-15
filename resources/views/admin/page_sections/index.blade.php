@extends('layouts.vertical', ['title' => 'Daftar Section Beranda'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Section Beranda & Halaman</h4>
            <p class="text-muted mb-0">Kelola bagian-bagian (section) di dalam halaman.</p>
        </div>
        <a href="{{ route('admin.page-sections.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:layers-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tambah Section
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
                                <th>Section & Judul Landing Page</th>
                                <th>Halaman Induk</th>
                                <th>Urutan</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pageSections as $section)
                                <tr>
                                    <td>{{ $loop->iteration + $pageSections->firstItem() - 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            @if($section->image)
                                                <img src="{{ asset('storage/' . $section->image) }}" class="rounded avatar-sm object-fit-cover border shadow-sm" style="width: 42px; height: 42px;">
                                            @else
                                                <div class="avatar-sm bg-light rounded d-flex align-items-center justify-content-center text-muted border" style="width: 42px; height: 42px;">
                                                    <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-20"></iconify-icon>
                                                </div>
                                            @endif

                                            <div>
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <span class="badge bg-dark-subtle text-dark border px-2 py-1 fw-bold fs-11">{{ strtoupper($section->type) }}</span>
                                                    <span class="fw-bold text-dark fs-14">{{ $section->section_name }}</span>
                                                </div>
                                                @if($section->title)
                                                    <p class="mb-0 text-muted fs-12">{!! strip_tags($section->title) !!}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary px-2 py-1"><iconify-icon icon="solar:document-text-bold-duotone" class="me-1"></iconify-icon> {{ $section->page->title ?? 'Beranda' }}</span>
                                    </td>
                                    <td><span class="badge bg-secondary-subtle text-secondary">{{ $section->order }}</span></td>
                                    <td>
                                        @if($section->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.page-sections.edit', $section->id) }}" class="btn btn-sm btn-soft-primary me-1" data-bs-toggle="tooltip" title="Edit Section & Gambar">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18 align-middle"></iconify-icon> Edit
                                        </a>
                                        <form action="{{ route('admin.page-sections.destroy', $section->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus section ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Section">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:layers-minimalistic-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Section Kosong</h5>
                                        <p class="text-muted">Belum ada section yang didaftarkan. Silakan klik "Tambah Section".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($pageSections->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $pageSections->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
