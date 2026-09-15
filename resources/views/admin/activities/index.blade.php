@extends('layouts.vertical', ['title' => 'Daftar Kegiatan'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Manajemen Kegiatan</h4>
            <p class="text-muted mb-0">Kelola daftar acara dan kegiatan pesantren mahasiswa.</p>
        </div>
        <a href="{{ route('admin.activities.create') }}" class="btn btn-primary shadow-sm">
            <iconify-icon icon="solar:calendar-add-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Tambah Kegiatan
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm badge-soft-success mb-4">
    <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-18 align-middle me-1"></iconify-icon> {{ session('success') }}
</div>
@endif

{{-- Filter Tabs --}}
<div class="row mb-3">
    <div class="col-12">
        <ul class="nav nav-pills gap-2">
            <li class="nav-item">
                <a class="nav-link {{ !request('status') || request('status') == 'all' ? 'active' : '' }}" href="{{ route('admin.activities.index', ['status' => 'all']) }}">
                    Semua <span class="badge bg-light text-dark ms-1">{{ $submissions_count['all'] ?? 0 }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'upcoming' ? 'active' : '' }}" href="{{ route('admin.activities.index', ['status' => 'upcoming']) }}">
                    Mendatang <span class="badge bg-primary-subtle text-primary ms-1">{{ $submissions_count['upcoming'] ?? 0 }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'ongoing' ? 'active' : '' }}" href="{{ route('admin.activities.index', ['status' => 'ongoing']) }}">
                    Berlangsung <span class="badge bg-success-subtle text-success ms-1">{{ $submissions_count['ongoing'] ?? 0 }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" href="{{ route('admin.activities.index', ['status' => 'completed']) }}">
                    Selesai <span class="badge bg-secondary-subtle text-secondary ms-1">{{ $submissions_count['completed'] ?? 0 }}</span>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Poster</th>
                                <th>Informasi Kegiatan</th>
                                <th>Jadwal & Lokasi</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($activities as $activity)
                                <tr>
                                    <td>{{ $loop->iteration + $activities->firstItem() - 1 }}</td>
                                    <td>
                                        @if($activity->image)
                                            <img src="{{ asset('storage/' . $activity->image) }}" class="rounded avatar-md object-fit-cover shadow-sm" alt="Poster">
                                        @else
                                            <div class="avatar-md bg-light rounded d-flex align-items-center justify-content-center text-muted border">
                                                <iconify-icon icon="solar:gallery-broken" class="fs-24"></iconify-icon>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-medium text-dark mb-1">{{ $activity->title }}</h5>
                                        <span class="fs-12 text-muted" style="max-width: 200px; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ Str::limit(strip_tags($activity->description), 50) }}</span>
                                        @if($activity->organizer)
                                            <span class="fs-11 text-primary"><iconify-icon icon="solar:users-group-rounded-bold-duotone" class="me-1"></iconify-icon>{{ $activity->organizer }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($activity->date)
                                            <span class="badge bg-primary-subtle text-primary py-1 px-2 fs-13 d-block mb-1"><iconify-icon icon="solar:calendar-date-bold-duotone" class="me-1"></iconify-icon>{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</span>
                                        @endif
                                        @if($activity->location)
                                            <span class="fs-12 text-muted"><iconify-icon icon="solar:map-point-bold-duotone" class="me-1"></iconify-icon>{{ $activity->location }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $activity->status_color }}-subtle text-{{ $activity->status_color }} px-2 py-1 mb-1">{{ $activity->status_label }}</span>
                                        <br>
                                        @if($activity->is_active)
                                            <span class="badge bg-success-subtle text-success px-2 py-1"><iconify-icon icon="solar:eye-bold-duotone" class="me-1"></iconify-icon>Tampil</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1"><iconify-icon icon="solar:eye-closed-bold-duotone" class="me-1"></iconify-icon>Draf</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.activities.show', $activity->id) }}" class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip" title="Lihat Detail">
                                            <iconify-icon icon="solar:eye-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.activities.edit', $activity->id) }}" class="btn btn-sm btn-soft-primary" data-bs-toggle="tooltip" title="Edit">
                                            <iconify-icon icon="solar:pen-2-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:calendar-broken" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Daftar Kosong</h5>
                                        <p class="text-muted">Belum ada kegiatan yang diagendakan. Silakan klik "Tambah Kegiatan".</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($activities->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $activities->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
