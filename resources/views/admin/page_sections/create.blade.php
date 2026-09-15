@extends('layouts.vertical', ['title' => 'Tambah Section Beranda'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah Section</h4>
            <p class="text-muted mb-0">Tambah bagian (section) baru ke halaman tertentu.</p>
        </div>
        <a href="{{ route('admin.page-sections.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.page-sections.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="page_id" class="form-label fw-medium">Halaman Induk <span class="text-danger">*</span></label>
                        <select name="page_id" id="page_id" class="form-select" required>
                            <option value="">-- Pilih Halaman --</option>
                            @foreach($pages as $page)
                                <option value="{{ $page->id }}" {{ old('page_id', $selectedPageId ?? '') == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                            @endforeach
                        </select>
                        @error('page_id') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="section_name" class="form-label fw-medium">Nama Section (Internal) <span class="text-danger">*</span></label>
                            <input type="text" name="section_name" id="section_name" class="form-control" placeholder="Contoh: Hero Banner, Profil Singkat" required value="{{ old('section_name') }}">
                            @error('section_name') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-medium">Tipe Section (Template) <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="hero" {{ old('type') == 'hero' ? 'selected' : '' }}>Hero / Banner Utama</option>
                                <option value="about" {{ old('type') == 'about' ? 'selected' : '' }}>About / Tentang Kami</option>
                                <option value="features" {{ old('type') == 'features' ? 'selected' : '' }}>Keunggulan / Fitur (Card dengan Icon)</option>
                                <option value="programs" {{ old('type') == 'programs' ? 'selected' : '' }}>Daftar Program (Otomatis dari Master Program)</option>
                                <option value="activities" {{ old('type') == 'activities' ? 'selected' : '' }}>Daftar Kegiatan (Otomatis dari Master)</option>
                                <option value="galleries" {{ old('type') == 'galleries' ? 'selected' : '' }}>Galeri (Otomatis dari Master)</option>
                                <option value="articles" {{ old('type') == 'articles' ? 'selected' : '' }}>Artikel Terbaru (Otomatis dari Master)</option>
                                <option value="faq" {{ old('type') == 'faq' ? 'selected' : '' }}>FAQ (Otomatis dari Master)</option>
                                <option value="testimonials" {{ old('type') == 'testimonials' ? 'selected' : '' }}>Testimoni (Otomatis dari Master)</option>
                                <option value="contact" {{ old('type') == 'contact' ? 'selected' : '' }}>Form Kontak</option>
                                <option value="repeater" {{ old('type') == 'repeater' ? 'selected' : '' }}>Custom Repeater (Bisa tambah item manual)</option>
                                <option value="custom_html" {{ old('type') == 'custom_html' ? 'selected' : '' }}>Custom HTML / Teks Bebas</option>
                                <option value="sejarah" {{ old('type') == 'sejarah' ? 'selected' : '' }}>Sejarah / Timeline</option>
                                <option value="counter" {{ old('type') == 'counter' ? 'selected' : '' }}>Statistik / Counter (Angka Animasi)</option>
                                <option value="team" {{ old('type') == 'team' ? 'selected' : '' }}>Tim / Pengurus</option>
                                <option value="shop" {{ old('type') == 'shop' ? 'selected' : '' }}>Produk / Toko</option>
                                <option value="gallery" {{ old('type') == 'gallery' ? 'selected' : '' }}>Album Galeri</option>
                                <option value="testimonial" {{ old('type') == 'testimonial' ? 'selected' : '' }}>Testimoni</option>
                                <option value="breadcrumb" {{ old('type') == 'breadcrumb' ? 'selected' : '' }}>Breadcrumb</option>
                            </select>
                            @error('type') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                    </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-medium">Judul Section (Publik)</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="subtitle" class="form-label fw-medium">Sub Judul Section</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle') }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-medium">Konten Text HTML</label>
                        <textarea name="content" id="content" rows="6" class="form-control">{{ old('content') }}</textarea>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-medium mb-1">Gambar / Background Utama</label>
                            <p class="text-muted fs-12 mb-2">Opsional: Gambar pendukung section ini.</p>
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            @error('image') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium mb-1">Gambar 2</label>
                            <p class="text-muted fs-12 mb-2">Opsional: Jika section butuh >1 gambar.</p>
                            <input type="file" name="image2" id="image2" class="form-control" accept="image/*">
                            @error('image2') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium mb-1">Gambar 3</label>
                            <p class="text-muted fs-12 mb-2">Opsional: Jika section butuh >2 gambar.</p>
                            <input type="file" name="image3" id="image3" class="form-control" accept="image/*">
                            @error('image3') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="button_text" class="form-label fw-medium">Teks Tombol Aksi</label>
                            <input type="text" name="button_text" id="button_text" class="form-control" placeholder="Contoh: Selengkapnya" value="{{ old('button_text') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="button_url" class="form-label fw-medium">URL Tombol Aksi</label>
                            <input type="text" name="button_url" id="button_url" class="form-control" placeholder="Contoh: /about atau https://..." value="{{ old('button_url') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="order" class="form-label fw-medium mb-1">Urutan Tampil (Order)</label>
                            <p class="text-muted fs-12 mb-2">Angka kecil tampil lebih atas.</p>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Aktif Tanggal Ini</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
