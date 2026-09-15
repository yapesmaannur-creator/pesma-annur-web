@extends('layouts.vertical', ['title' => 'Detail Kegiatan'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Detail Kegiatan</h4>
            <p class="text-muted mb-0">Preview informasi kegiatan sebelum ditampilkan di website.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="btn btn-primary">
                <iconify-icon icon="solar:pen-2-bold-duotone" class="align-middle me-1"></iconify-icon> Edit
            </a>
            <a href="{{ route('admin.activities.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            @if($activity->image)
            <img src="{{ asset('storage/' . $activity->image) }}" class="card-img-top" style="max-height: 350px; object-fit: cover;" alt="{{ $activity->title }}">
            @endif
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-{{ $activity->status_color }}-subtle text-{{ $activity->status_color }} px-3 py-2 fs-13">{{ $activity->status_label }}</span>
                    @if($activity->is_active)
                        <span class="badge bg-success-subtle text-success px-2 py-2 fs-13">Aktif / Tampil</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger px-2 py-2 fs-13">Draf / Tersembunyi</span>
                    @endif
                </div>
                <h3 class="fw-bold mb-3">{{ $activity->title }}</h3>
                <div class="text-muted" style="font-size: 1.05rem; line-height: 1.8; white-space: pre-wrap;">{{ $activity->description }}</div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">Informasi Pelaksanaan</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-3">
                        <small class="text-muted d-block mb-1"><iconify-icon icon="solar:calendar-date-bold-duotone" class="me-1"></iconify-icon>Tanggal</small>
                        <strong>{{ $activity->date ? $activity->date->translatedFormat('l, d F Y') : 'Belum ditentukan' }}</strong>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block mb-1"><iconify-icon icon="solar:clock-circle-bold-duotone" class="me-1"></iconify-icon>Waktu</small>
                        <strong>
                            @if($activity->time_start)
                                {{ \Carbon\Carbon::parse($activity->time_start)->format('H:i') }}
                                @if($activity->time_end) - {{ \Carbon\Carbon::parse($activity->time_end)->format('H:i') }} @endif
                                WIB
                            @else
                                Belum ditentukan
                            @endif
                        </strong>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block mb-1"><iconify-icon icon="solar:map-point-bold-duotone" class="me-1"></iconify-icon>Lokasi</small>
                        <strong>{{ $activity->location ?? 'Belum ditentukan' }}</strong>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block mb-1"><iconify-icon icon="solar:users-group-rounded-bold-duotone" class="me-1"></iconify-icon>Penyelenggara</small>
                        <strong>{{ $activity->organizer ?? '-' }}</strong>
                    </li>
                    <li class="mb-3">
                        <small class="text-muted d-block mb-1"><iconify-icon icon="solar:phone-calling-bold-duotone" class="me-1"></iconify-icon>Narahubung</small>
                        <strong>{{ $activity->contact_person ?? '-' }}</strong>
                    </li>
                    @if($activity->max_participants)
                    <li class="mb-3">
                        <small class="text-muted d-block mb-1"><iconify-icon icon="solar:user-id-bold-duotone" class="me-1"></iconify-icon>Kuota Peserta</small>
                        <strong>{{ $activity->max_participants }} orang</strong>
                    </li>
                    @endif
                    @if($activity->registration_link)
                    <li class="mb-3">
                        <a href="{{ $activity->registration_link }}" target="_blank" class="btn btn-success w-100">
                            <iconify-icon icon="solar:link-bold-duotone" class="me-1"></iconify-icon> Buka Link Pendaftaran
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-3">
                <small class="text-muted">Slug: <code>{{ $activity->slug }}</code></small><br>
                <small class="text-muted">Dipublikasikan: {{ $activity->created_at->translatedFormat('d M Y, H:i') }}</small>
            </div>
        </div>
    </div>
</div>
@endsection
