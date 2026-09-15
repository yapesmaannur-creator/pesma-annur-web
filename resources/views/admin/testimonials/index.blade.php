@extends('layouts.vertical', ['title' => 'Daftar Testimoni'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Testimoni</h4>
            <p class="text-muted mb-0">Kelola testimoni dari alumni dan santri aktif.</p>
        </div>
        <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:chat-round-like-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tambah Testimoni
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
                                <th>Profil</th>
                                <th>Pesan Testimoni</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $loop->iteration + $testimonials->firstItem() - 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($testimonial->image)
                                                <img src="{{ asset('storage/' . $testimonial->image) }}" class="avatar-sm rounded-circle shadow-sm me-3 object-fit-cover" alt="Foto">
                                            @else
                                                <div class="avatar-sm rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3">
                                                    <span class="text-primary fw-bold">{{ substr($testimonial->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <h5 class="m-0 fs-14 fw-medium text-dark">{{ $testimonial->name }}</h5>
                                                <span class="fs-12 text-muted">{{ $testimonial->position ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-wrap" style="max-width: 300px;">
                                            <p class="mb-0 text-muted fs-13">"{{ $testimonial->message }}"</p>
                                        </div>
                                    </td>
                                    <td>
                                        @if($testimonial->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon> Aktif</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon> Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit Testimoni">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Testimoni">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:chat-round-like-line-duotone" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Belum ada Testimoni</h5>
                                        <p class="text-muted">Testimoni akan ditambahkan di sini. Silakan buat baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($testimonials->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $testimonials->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
