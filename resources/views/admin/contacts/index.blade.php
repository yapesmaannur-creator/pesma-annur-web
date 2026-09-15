@php($title = 'Daftar Pesan Masuk')
@extends('layouts.vertical')
@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Pesan Masuk</h4>
            <p class="text-muted mb-0">Kelola dan baca pesan yang dikirim oleh pengunjung website.</p>
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
                                <th style="width: 50px;">#</th>
                                <th>Pengirim</th>
                                <th>Subjek & Pesan Singkat</th>
                                <th>Waktu Kirim</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($contacts as $contact)
                                <tr class="{{ !$contact->is_read ? 'bg-primary-subtle' : '' }}">
                                    <td>
                                        @if(!$contact->is_read)
                                            <span class="text-primary"><iconify-icon icon="solar:letter-unread-bold-duotone" class="fs-20"></iconify-icon></span>
                                        @else
                                            <span class="text-muted"><iconify-icon icon="solar:letter-opened-linear" class="fs-20"></iconify-icon></span>
                                        @endif
                                    </td>
                                    <td>
                                        <h5 class="m-0 fs-14 fw-semibold {{ !$contact->is_read ? 'text-primary' : 'text-dark' }}">{{ $contact->name }}</h5>
                                        <span class="fs-12 text-muted">{{ $contact->email }}</span>
                                    </td>
                                    <td>
                                        <p class="mb-0 fs-14 {{ !$contact->is_read ? 'fw-medium text-dark' : 'text-muted' }}">{{ $contact->subject ?? '(Tanpa Subjek)' }}</p>
                                        <span class="fs-12 text-muted truncate-2-lines" style="max-width: 300px;">{{ Str::limit($contact->message, 50) }}</span>
                                    </td>
                                    <td>
                                        <span class="fs-13 text-muted">{{ $contact->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td>
                                        @if(!$contact->is_read)
                                            <span class="badge bg-danger-subtle text-danger px-2 py-1">Baru</span>
                                        @else
                                            <span class="badge bg-light text-dark px-2 py-1">Terbaca</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-soft-info" data-bs-toggle="tooltip" title="Baca Pesan">
                                            <iconify-icon icon="solar:eye-bold-duotone" class="fs-18"></iconify-icon>
                                        </a>
                                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-soft-danger" data-bs-toggle="tooltip" title="Hapus Pesan">
                                                <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="fs-18"></iconify-icon>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="avatar-lg bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                                            <iconify-icon icon="solar:inbox-line-duotone" class="fs-32 text-muted"></iconify-icon>
                                        </div>
                                        <h5 class="fw-semibold text-dark">Tidak Ada Pesan Masuk</h5>
                                        <p class="text-muted">Kotak masuk keluhan atau pesan pengunjung masih kosong.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($contacts->hasPages())
                <div class="card-footer bg-white border-top">
                    {{ $contacts->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
