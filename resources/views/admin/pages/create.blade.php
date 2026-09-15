@extends('layouts.vertical', ['title' => 'Tambah Halaman'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah Halaman</h4>
            <p class="text-muted mb-0">Buat halaman statis baru untuk website.</p>
        </div>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.pages.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Halaman <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Tentang Kami" required value="{{ old('title') }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-medium">Konten Halaman</label>
                        <textarea name="content" id="content" rows="10" class="form-control" placeholder="Isi halaman Anda di sini...">{{ old('content') }}</textarea>
                        @error('content') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="meta_title" class="form-label fw-medium">Meta Title (SEO)</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Judul untuk mesin pencari" value="{{ old('meta_title') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="meta_description" class="form-label fw-medium">Meta Description (SEO)</label>
                            <input type="text" name="meta_description" id="meta_description" class="form-control" placeholder="Deskripsi singkat..." value="{{ old('meta_description') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="created_at" class="form-label fw-medium">Tanggal Dibuat/Publikasi (Opsional)</label>
                            <input type="datetime-local" name="created_at" id="created_at" class="form-control" value="{{ old('created_at', now()->format('Y-m-d\TH:i')) }}">
                            @error('created_at') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Publikasikan Halaman</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Halaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
