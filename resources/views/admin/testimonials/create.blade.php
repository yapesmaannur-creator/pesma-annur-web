@extends('layouts.vertical', ['title' => 'Tambah Testimoni'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah Testimoni</h4>
            <p class="text-muted mb-0">Masukkan ulasan baru dari alumni atau tokoh masyarakat.</p>
        </div>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-medium">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Budi Santoso" required value="{{ old('name') }}">
                            @error('name') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label fw-medium">Jabatan / Profil</label>
                            <input type="text" name="position" id="position" class="form-control" placeholder="Contoh: Alumni 2020 / Wali Santri" value="{{ old('position') }}">
                            @error('position') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label fw-medium">Pesan / Ulasan <span class="text-danger">*</span></label>
                        <textarea name="message" id="message" rows="4" class="form-control" placeholder="Tulis testimoni Anda..." required>{{ old('message') }}</textarea>
                        @error('message') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium d-block">Foto Profil (Opsional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <p class="text-muted mt-1 fs-12">Rasio gambar yang disarankan: 1:1 (Persegi, max 2MB).</p>
                        @error('image') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Tampilkan Testimoni</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Testimoni
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
