@extends('layouts.vertical', ['title' => 'Edit File Download'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit File Download</h4>
            <p class="text-muted mb-0">Perbarui informasi file download.</p>
        </div>
        <a href="{{ route('admin.downloads.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.downloads.update', $download) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul File <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $download->title) }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="form-control">{{ old('description', $download->description) }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="file" class="form-label fw-medium">Ganti File</label>
                            <input type="file" name="file" id="file" class="form-control">
                            <small class="text-muted">Biarkan kosong jika tidak diganti. File saat ini: <strong>{{ $download->file_name }}</strong> ({{ $download->file_size_human }})</small>
                            @error('file') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="form-label fw-medium">Kategori <span class="text-danger">*</span></label>
                            <select name="category" id="category" class="form-select" required>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ old('category', $download->category) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="order" class="form-label fw-medium">Urutan</label>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $download->order) }}">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $download->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="is_active">Aktif</label>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <span class="text-muted fs-13">Diunduh: <strong>{{ $download->download_count }}x</strong></span>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Perbarui File
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
