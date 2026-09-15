@extends('layouts.vertical', ['title' => 'Daftar Program'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Program</h4>
            <p class="text-muted mb-0">Kelola dan tampilkan program unggulan pesantren.</p>
        </div>
        <a href="{{ route('admin.programs.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:folder-with-files-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tambah Program
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
                                <th>Ikon / Gambar</th>
                                <th>Nama Program</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($programs as $program)
                                <tr>
                                    <td>{{ method_exists($programs, 'firstItem') ? ($programs->firstItem() + $loop->index) : $loop->iteration }}</td>
                                    <td>
                                        @if($program->image)
                                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" class="avatar-sm rounded object-fit-cover shadow-sm">
                                        @elseif($program->icon)
                                            <div class="avatar-sm bg-primary-subtle text-primary rounded d-flex align-items-center justify-content-center border" title="Ikon Tema: {{ $program->icon }}">
                                                <i class="{{ $program->icon }} fs-24"></i>
                                            </div>
                                        @else
                                            <div class="avatar-sm bg-light rounded d-flex align-items-center justify-content-center border" title="Tanpa Gambar / Ikon Otomatis">
                                                <iconify-icon icon="solar:gallery-broken" class="fs-20 text-muted"></iconify-icon>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-semibold text-dark">{{ $program->title }}</h5>
                                        <p class="mb-0 text-muted fs-12 mt-1 text-truncate" style="max-width:350px;">{{ Str::limit($program->description, 50) }}</p>
                                    </td>
                                    <td>
                                        @if($program->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.programs.edit', $program->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Program">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Program">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:folder-error-bold-duotone" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Program Kosong</h5>
                                        <p class="text-muted">Belum ada program yang didaftarkan. Silakan klik "Tambah Program".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($programs->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $programs->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
