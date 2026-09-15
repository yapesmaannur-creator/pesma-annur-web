@extends('layouts.vertical', ['title' => 'Tulis Artikel Baru'])

@section('css')
    <!-- Quill CSS for Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tulis Artikel / Berita Baru</h4>
            <p class="text-muted mb-0">Buat konten informatif dengan optimasi SEO secara mudah.</p>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
    @csrf

    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <strong>Gagal menyimpan!</strong> Periksa kesalahan berikut:
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    <div class="row">
        <!-- Main Content Editor -->
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-semibold m-0">Konten Utama</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul menarik" required value="{{ old('title') }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label fw-medium">Kutipan Singkat (Excerpt)</label>
                        <textarea name="excerpt" id="excerpt" rows="3" class="form-control" placeholder="Ringkasan atau deskripsi singkat yang akan muncul di halaman daftar blog">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Isi Artikel (Rich Text Format) <span class="text-danger">*</span></label>
                        <!-- Quill Editor Container -->
                        <div id="snow-editor" style="height: 350px;">{!! old('body_content') !!}</div>
                        <input type="hidden" name="body_content" id="body_content" required>
                        @error('body_content') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            
            <!-- SEO Configuration Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                    <iconify-icon icon="solar:global-search-bold-duotone" class="fs-20 text-primary me-2"></iconify-icon>
                    <h5 class="card-title fw-semibold m-0">Optimasi SEO & Kata Kunci (Opsional)</h5>
                </div>
                <div class="card-body bg-light bg-opacity-50">
                    <p class="text-muted fs-13 mb-4">Pengaturan ini penting agar artikel Anda lebih mudah ditemukan di Google dan mesin pencari lainnya.</p>
                    
                    <div class="mb-3">
                        <label for="meta_title" class="form-label fw-medium">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Judul khusus untuk mesin pencari (maks 60 karakter)" value="{{ old('meta_title') }}">
                        <small class="text-muted ms-1">Bila kosong, sistem akan menggunakan "Judul Artikel".</small>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label fw-medium">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2" class="form-control" placeholder="Deskripsi meta untuk pencarian Google">{{ old('meta_description') }}</textarea>
                        <small class="text-muted ms-1">Bila kosong, sistem akan memotong 150 kata pertama dari "Kutipan Singkat".</small>
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label fw-medium">Meta Keywords / Tags</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" placeholder="pisahkan, dengan, koma, contoh: pendidikan, pesantren, beasiswa" value="{{ old('meta_keywords') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-xl-4">
            <!-- Publikasi & Media -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-semibold m-0">Publikasi & Media</h5>
                </div>
                <div class="card-body">
                    {{-- Penulis --}}
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-primary-subtle avatar-sm d-flex align-items-center justify-content-center">
                            <span class="text-primary fw-bold fs-16">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    {{-- Penulis --}}
                    <div class="mb-3">
                        <label for="user_id" class="form-label fw-medium">Penulis / Author</label>
                        <select name="user_id" id="user_id" class="form-select">
                            @foreach($users as $usr)
                                <option value="{{ $usr->id }}" {{ old('user_id', auth()->id()) == $usr->id ? 'selected' : '' }}>{{ $usr->name }} ({{ $usr->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-medium">Kategori</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">— Tidak Ada Kategori —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Gambar Sampul --}}
                    <div class="mb-3 text-center">
                        <label class="form-label fw-medium d-block text-start">Gambar Sampul (Thumbnail)</label>
                        <div class="avatar-xl mx-auto border rounded bg-light mb-3 d-flex align-items-center justify-content-center" style="width: 100%; height: 200px; cursor: pointer;" id="imgPreviewContainer">
                            <iconify-icon icon="solar:gallery-add-bold-duotone" class="fs-48 text-muted"></iconify-icon>
                            <img id="imagePreview" src="" class="d-none w-100 h-100 object-fit-cover rounded">
                        </div>
                        <input type="file" name="image_path" id="image_path" class="form-control d-none" accept="image/*" onchange="previewImage(this)">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill w-100" onclick="document.getElementById('image_path').click()">Pilih Gambar</button>
                    </div>

                    {{-- Deskripsi/Caption Gambar --}}
                    <div class="mb-3">
                        <label for="image_caption" class="form-label fw-medium">Deskripsi Gambar</label>
                        <input type="text" name="image_caption" id="image_caption" class="form-control" placeholder="Contoh: Suasana kegiatan pesantren" value="{{ old('image_caption') }}">
                        <small class="text-muted">Muncul sebagai caption di landing page.</small>
                    </div>

                    {{-- Tanggal Terbit --}}
                    <div class="mb-3">
                        <label for="published_at" class="form-label fw-medium">Tanggal Terbit</label>
                        <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at') }}">
                        <small class="text-muted">Kosongkan untuk menggunakan tanggal saat ini.</small>
                    </div>

                    {{-- Terbitkan --}}
                    <div class="mb-4 border-top pt-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_published">Terbitkan Sekarang?</label>
                        </div>
                        <p class="text-muted fs-13 mb-0">Jika dinonaktifkan, artikel akan disimpan sebagai <strong>Draft</strong>.</p>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary fw-medium rounded-pill py-2">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Simpan Artikel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<!-- Quill JS for RTE -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#snow-editor', {
            theme: 'snow',
            placeholder: 'Tuliskan isi artikel Anda di sini secara bebas...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        var form = document.getElementById('postForm');
        form.onsubmit = function() {
            var body = document.querySelector('input[name=body_content]');
            body.value = quill.root.innerHTML;
        };
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imgPreviewContainer').querySelector('iconify-icon').classList.add('d-none');
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
