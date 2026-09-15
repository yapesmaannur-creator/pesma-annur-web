@extends('layouts.vertical', ['title' => 'Tambah Album Galeri'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah Album Galeri</h4>
            <p class="text-muted mb-0">Buat album baru untuk mengelompokkan dokumentasi foto.</p>
        </div>
        <a href="{{ route('admin.gallery-albums.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.gallery-albums.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Album <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Kegiatan Ramadhan 1445 H" required value="{{ old('title') }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-medium">Deskripsi Singkat</label>
                        <textarea name="description" id="description" rows="3" class="form-control" placeholder="Penjelasan mengenai album ini...">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium d-block">Cover Album (Opsional)</label>
                        <input type="file" name="cover_image" class="form-control" accept="image/*">
                        <p class="text-muted mt-1 fs-12">Rasio gambar yang disarankan: 4:3 (JPG, PNG, WEBP)</p>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Aktif Tanggal Ini</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Album
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
