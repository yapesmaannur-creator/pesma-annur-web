@php($title = 'Detail Pesan Masuk')
@extends('layouts.vertical')
@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Detail Pesan</h4>
            <p class="text-muted mb-0">Membaca detail pesan dari pengunjung.</p>
        </div>
        <div>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary me-2">
                <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali ke Kotak Masuk
            </a>
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="align-middle me-1"></iconify-icon> Hapus Pesan
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-9">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm">
                            <span class="fs-24 fw-bold text-primary">{{ substr($contact->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h4 class="m-0 fs-18 fw-semibold text-dark mb-1">{{ $contact->name }}</h4>
                            <p class="mb-0 text-muted fs-14">
                                <iconify-icon icon="solar:letter-bold-duotone" class="me-1 align-middle"></iconify-icon>
                                <a href="mailto:{{ $contact->email }}" class="text-primary text-decoration-none">{{ $contact->email }}</a>
                            </p>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="text-muted fs-13 d-block"><iconify-icon icon="solar:calendar-date-bold-duotone" class="me-1"></iconify-icon> {{ $contact->created_at->translatedFormat('l, d F Y') }}</span>
                        <span class="text-muted fs-13 d-block mt-1"><iconify-icon icon="solar:clock-circle-bold-duotone" class="me-1"></iconify-icon> {{ $contact->created_at->format('H:i') }} WIB</span>
                    </div>
                </div>

                <div class="message-content">
                    <h5 class="fs-16 fw-semibold text-dark mb-3">Subjek: {{ $contact->subject ?? '(Tanpa Subjek)' }}</h5>
                    <div class="bg-light rounded p-4 border" style="min-height: 200px; white-space: pre-wrap;">{{ $contact->message }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 fs-15">Tindakan Cepat</h5>
            </div>
            <div class="card-body">
                <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary w-100 mb-2">
                    <iconify-icon icon="solar:forward-bold-duotone" class="align-middle me-1"></iconify-icon> Balas via Email
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
