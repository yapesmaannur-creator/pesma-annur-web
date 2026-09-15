@extends('layouts.vertical', ['title' => 'Edit Halaman'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit Halaman</h4>
            <p class="text-muted mb-0">Perbarui informasi halaman statis website.</p>
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
                <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Halaman <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Tentang Kami" required value="{{ old('title', $page->title) }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-medium">Konten Halaman</label>
                        <textarea name="content" id="content" rows="10" class="form-control" placeholder="Isi halaman Anda di sini...">{{ old('content', $page->content) }}</textarea>
                        @error('content') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="meta_title" class="form-label fw-medium">Meta Title (SEO)</label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Judul untuk mesin pencari" value="{{ old('meta_title', $page->meta_title) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="meta_description" class="form-label fw-medium">Meta Description (SEO)</label>
                            <input type="text" name="meta_description" id="meta_description" class="form-control" placeholder="Deskripsi singkat..." value="{{ old('meta_description', $page->meta_description) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $page->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">Publikasikan Halaman</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Perbarui Halaman
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
