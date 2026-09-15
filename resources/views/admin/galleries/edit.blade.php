@extends('layouts.vertical', ['title' => 'Edit Foto Galeri'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit Foto Galeri</h4>
            <p class="text-muted mb-0">Ubah keterangan atau perbarui foto galeri.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="gallery_album_id" class="form-label fw-medium">Pilih Album <span class="text-danger">*</span></label>
                        <select name="gallery_album_id" id="gallery_album_id" class="form-select" required>
                            <option value="">-- Pilih Album --</option>
                            @foreach($albums as $album)
                                <option value="{{ $album->id }}" {{ old('gallery_album_id', $gallery->gallery_album_id) == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                            @endforeach
                        </select>
                        @error('gallery_album_id') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Keterangan Foto</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $gallery->title) }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4 mt-3">
                        <label class="form-label fw-medium d-block">Ganti Foto (Opsional)</label>
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="rounded avatar-xl object-fit-cover shadow-sm">
                        </div>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <p class="text-muted mt-1 fs-12">Format yang didukung: JPG, PNG, WEBP. Biarkan kosong jika tidak diubah.</p>
                        @error('image') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $gallery->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">Tampilkan di Publik</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Perbarui Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
