@php($title = 'Tambah FAQ Baru')
@extends('layouts.vertical')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah FAQ</h4>
            <p class="text-muted mb-0">Buat pertanyaan dan jawaban baru untuk halaman FAQ.</p>
        </div>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.faqs.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="question" class="form-label fw-medium">Pertanyaan <span class="text-danger">*</span></label>
                        <input type="text" name="question" id="question" class="form-control" placeholder="Contoh: Bagaimana cara mendaftar?" required value="{{ old('question') }}">
                        @error('question') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="answer" class="form-label fw-medium">Jawaban <span class="text-danger">*</span></label>
                        <textarea name="answer" id="answer" rows="5" class="form-control" placeholder="Tuliskan jawaban yang detail..." required>{{ old('answer') }}</textarea>
                        @error('answer') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="order" class="form-label fw-medium">Urutan Tampil (No)</label>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}">
                            <p class="text-muted mt-1 fs-12">Semakin kecil angkanya, semakin di atas tampilannya.</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Aktif Tanggal Ini</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan FAQ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
