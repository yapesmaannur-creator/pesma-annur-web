@extends('layouts.vertical', ['title' => 'Unggah Foto Galeri'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Unggah Foto Galeri</h4>
            <p class="text-muted mb-0">Tambahkan satu atau beberapa foto sekaligus ke dalam album.</p>
        </div>
        <a href="{{ route('admin.galleries.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show mb-3">
    <strong>Gagal!</strong> Periksa kesalahan berikut:
    <ul class="mb-0 mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="gallery_album_id" class="form-label fw-medium">Pilih Album <span class="text-danger">*</span></label>
                        <select name="gallery_album_id" id="gallery_album_id" class="form-select" required>
                            <option value="">-- Pilih Album --</option>
                            @foreach($albums as $album)
                                <option value="{{ $album->id }}" {{ old('gallery_album_id') == $album->id ? 'selected' : '' }}>{{ $album->title }}</option>
                            @endforeach
                        </select>
                        @error('gallery_album_id') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Keterangan Foto</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Opsional: Keterangan singkat foto atau kegiatan" value="{{ old('title') }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4 mt-3">
                        <label class="form-label fw-medium d-block">Pilih Foto <span class="text-danger">*</span></label>
                        <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple required>
                        <p class="text-muted mt-1 fs-12">
                            <iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle me-1"></iconify-icon>
                            Bisa pilih beberapa foto sekaligus (tahan Ctrl/Cmd lalu klik). Format: JPG, PNG, WEBP (Max: 3MB per foto).
                        </p>
                        @error('images') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        @error('images.*') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror

                        {{-- Preview area --}}
                        <div id="imagePreviewArea" class="row g-2 mt-2"></div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Tampilkan di Publik</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:camera-upload-bold-duotone" class="align-middle me-1"></iconify-icon> Unggah Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.getElementById('images').addEventListener('change', function(e) {
        var previewArea = document.getElementById('imagePreviewArea');
        previewArea.innerHTML = '';
        var files = e.target.files;
        
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(ev) {
                var col = document.createElement('div');
                col.className = 'col-4 col-md-3';
                col.innerHTML = '<img src="' + ev.target.result + '" class="img-fluid rounded shadow-sm" style="height: 100px; width: 100%; object-fit: cover;">';
                previewArea.appendChild(col);
            }
            reader.readAsDataURL(files[i]);
        }
    });
</script>
@endsection
