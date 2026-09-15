@extends('layouts.vertical', ['title' => 'Edit Artikel'])

@section('css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit Artikel</h4>
            <p class="text-muted mb-0">{{ $post->title }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.posts.preview', $post->id) }}" target="_blank" class="btn btn-warning fw-medium">
                <iconify-icon icon="solar:eye-bold-duotone" class="align-middle me-1"></iconify-icon> Preview
            </a>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="postForm">
    @csrf @method('PUT')

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
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-semibold m-0">Konten Utama</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Artikel <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $post->title) }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label fw-medium">Kutipan Singkat (Excerpt)</label>
                        <textarea name="excerpt" id="excerpt" rows="3" class="form-control">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium">Isi Artikel (Rich Text Format) <span class="text-danger">*</span></label>
                        <div id="snow-editor" style="height: 350px;">{!! old('body_content', $post->body_content) !!}</div>
                        <input type="hidden" name="body_content" id="body_content" value="{{ old('body_content', $post->body_content) }}">
                        @error('body_content') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                    <iconify-icon icon="solar:global-search-bold-duotone" class="fs-20 text-primary me-2"></iconify-icon>
                    <h5 class="card-title fw-semibold m-0">Optimasi SEO & Kata Kunci</h5>
                </div>
                <div class="card-body bg-light bg-opacity-50">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label fw-medium">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title) }}">
                    </div>
                    <div class="mb-3">
                        <label for="meta_description" class="form-label fw-medium">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="2" class="form-control">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label fw-medium">Meta Keywords / Tags</label>
                        <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', $post->meta_keywords) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="card-title fw-semibold m-0">Publikasi & Media</h5>
                </div>
                <div class="card-body">
                    {{-- Penulis --}}
                    <div class="mb-3 d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-primary-subtle avatar-sm d-flex align-items-center justify-content-center">
                            <span class="text-primary fw-bold fs-16">{{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}</span>
                        </div>
                        <div>
                            <small class="text-muted d-block">Penulis</small>
                            <span class="fw-medium">{{ $post->user->name ?? '-' }}</span>
                        </div>
                    </div>

                    {{-- Penulis --}}
                    <div class="mb-3">
                        <label for="user_id" class="form-label fw-medium">Penulis / Author</label>
                        <select name="user_id" id="user_id" class="form-select">
                            @foreach($users as $usr)
                                <option value="{{ $usr->id }}" {{ old('user_id', $post->user_id) == $usr->id ? 'selected' : '' }}>{{ $usr->name }} ({{ $usr->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-3">
                        <label for="category_id" class="form-label fw-medium">Kategori</label>
                        <select name="category_id" id="category_id" class="form-select">
                            <option value="">— Tidak Ada Kategori —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Gambar --}}
                    <div class="mb-3 text-center">
                        <label class="form-label fw-medium d-block text-start">Gambar Sampul</label>
                        <div class="avatar-xl mx-auto border rounded bg-light mb-3 d-flex align-items-center justify-content-center" style="width: 100%; height: 200px; cursor: pointer;" id="imgPreviewContainer">
                            @if($post->image_url)
                                <img id="imagePreview" src="{{ $post->image_url }}" class="w-100 h-100 object-fit-cover rounded" onerror="this.classList.add('d-none'); if(this.nextElementSibling) this.nextElementSibling.classList.remove('d-none');">
                                <iconify-icon icon="solar:gallery-add-bold-duotone" class="fs-48 text-muted d-none"></iconify-icon>
                            @else
                                <iconify-icon icon="solar:gallery-add-bold-duotone" class="fs-48 text-muted"></iconify-icon>
                                <img id="imagePreview" src="" class="d-none w-100 h-100 object-fit-cover rounded">
                            @endif
                        </div>
                        <input type="file" name="image_path" id="image_path" class="form-control d-none" accept="image/*" onchange="previewImage(this)">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill w-100" onclick="document.getElementById('image_path').click()">Ganti Gambar</button>
                    </div>

                    {{-- Caption --}}
                    <div class="mb-3">
                        <label for="image_caption" class="form-label fw-medium">Deskripsi Gambar</label>
                        <input type="text" name="image_caption" id="image_caption" class="form-control" value="{{ old('image_caption', $post->image_caption) }}" placeholder="Contoh: Suasana kegiatan pesantren">
                        <small class="text-muted">Muncul sebagai caption di landing page.</small>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-3">
                        <label for="published_at" class="form-label fw-medium">Tanggal Terbit</label>
                        <input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    {{-- Terbitkan --}}
                    <div class="mb-4 border-top pt-3">
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ $post->published_at ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_published">Terbitkan?</label>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary fw-medium rounded-pill py-2">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon> Update Artikel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#snow-editor', {
            theme: 'snow',
            placeholder: 'Tuliskan isi artikel Anda di sini...',
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
        form.addEventListener('submit', function(e) {
            var content = quill.root.innerHTML;
            document.querySelector('input[name=body_content]').value = content;
            if (!content || content === '<p><br></p>') {
                e.preventDefault();
                alert('Isi artikel tidak boleh kosong.');
                return false;
            }
            return true;
        });
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var icon = document.getElementById('imgPreviewContainer').querySelector('iconify-icon');
                if (icon) icon.classList.add('d-none');
                var img = document.getElementById('imagePreview');
                img.src = e.target.result;
                img.classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
