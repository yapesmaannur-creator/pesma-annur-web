@extends('layouts.vertical', ['title' => 'Tambah Item Section'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah Item Baru</h4>
            <p class="text-muted mb-0">Untuk section: {{ $pageSection->section_name }}</p>
        </div>
        <a href="{{ route('admin.page-sections.items', $pageSection->id) }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.section-items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <input type="hidden" name="page_section_id" value="{{ $pageSection->id }}">

                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Item</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-medium">Deskripsi / Konten</label>
                        <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="icon" class="form-label fw-medium mb-1">Ikon (Iconify Class)</label>
                            <p class="text-muted fs-12 mb-2">Contoh: <code>solar:star-bold</code></p>
                            <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="url" class="form-label fw-medium mb-1">Tautan / Link URL</label>
                            <p class="text-muted fs-12 mb-2">Opsional: Jika item ini bisa diklik.</p>
                            <input type="text" name="url" id="url" class="form-control" value="{{ old('url') }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium mb-1">Gambar</label>
                            <p class="text-muted fs-12 mb-2">Opsional: Jika bagian ini membutuhkan gambar.</p>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            @error('image') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="order" class="form-label fw-medium mb-1">Urutan Tampil (Order)</label>
                            <p class="text-muted fs-12 mb-2">Angka kecil tampil lebih atas.</p>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Aktif</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
