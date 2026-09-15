@extends('layouts.vertical', ['title' => 'Edit Section Beranda'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit Section</h4>
            <p class="text-muted mb-0">Perbarui informasi bagian (section) halaman.</p>
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
                <form action="{{ route('admin.page-sections.update', $pageSection->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="page_id" class="form-label fw-medium">Halaman Induk <span class="text-danger">*</span></label>
                        <select name="page_id" id="page_id" class="form-select" required>
                            <option value="">-- Pilih Halaman --</option>
                            @foreach($pages as $page)
                                <option value="{{ $page->id }}" {{ old('page_id', $pageSection->page_id) == $page->id ? 'selected' : '' }}>{{ $page->title }}</option>
                            @endforeach
                        </select>
                        @error('page_id') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="section_name" class="form-label fw-medium">Nama Section (Internal) <span class="text-danger">*</span></label>
                            <input type="text" name="section_name" id="section_name" class="form-control" placeholder="Contoh: Hero Banner, Profil Singkat" required value="{{ old('section_name', $pageSection->section_name) }}">
                            @error('section_name') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-medium">Tipe Section (Template) <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="hero" {{ old('type', $pageSection->type) == 'hero' ? 'selected' : '' }}>Hero / Banner Utama</option>
                                <option value="about" {{ old('type', $pageSection->type) == 'about' ? 'selected' : '' }}>About / Tentang Kami</option>
                                <option value="features" {{ old('type', $pageSection->type) == 'features' ? 'selected' : '' }}>Keunggulan / Fitur (Card dengan Icon)</option>
                                <option value="programs" {{ old('type', $pageSection->type) == 'programs' ? 'selected' : '' }}>Daftar Program (Otomatis dari Master Program)</option>
                                <option value="activities" {{ old('type', $pageSection->type) == 'activities' ? 'selected' : '' }}>Daftar Kegiatan (Otomatis dari Master)</option>
                                <option value="galleries" {{ old('type', $pageSection->type) == 'galleries' ? 'selected' : '' }}>Galeri (Otomatis dari Master)</option>
                                <option value="articles" {{ old('type', $pageSection->type) == 'articles' ? 'selected' : '' }}>Artikel Terbaru (Otomatis dari Master)</option>
                                <option value="faq" {{ old('type', $pageSection->type) == 'faq' ? 'selected' : '' }}>FAQ (Otomatis dari Master)</option>
                                <option value="testimonials" {{ old('type', $pageSection->type) == 'testimonials' ? 'selected' : '' }}>Testimoni (Otomatis dari Master)</option>
                                <option value="contact" {{ old('type', $pageSection->type) == 'contact' ? 'selected' : '' }}>Form Kontak</option>
                                <option value="repeater" {{ old('type', $pageSection->type) == 'repeater' ? 'selected' : '' }}>Custom Repeater (Bisa tambah item manual)</option>
                                <option value="custom_html" {{ old('type', $pageSection->type) == 'custom_html' ? 'selected' : '' }}>Custom HTML / Teks Bebas</option>
                                <option value="sejarah" {{ old('type', $pageSection->type) == 'sejarah' ? 'selected' : '' }}>Sejarah / Timeline</option>
                                <option value="counter" {{ old('type', $pageSection->type) == 'counter' ? 'selected' : '' }}>Statistik / Counter (Angka Animasi)</option>
                                <option value="team" {{ old('type', $pageSection->type) == 'team' ? 'selected' : '' }}>Tim / Pengurus</option>
                                <option value="shop" {{ old('type', $pageSection->type) == 'shop' ? 'selected' : '' }}>Produk / Toko</option>
                                <option value="gallery" {{ old('type', $pageSection->type) == 'gallery' ? 'selected' : '' }}>Album Galeri</option>
                                <option value="testimonial" {{ old('type', $pageSection->type) == 'testimonial' ? 'selected' : '' }}>Testimoni</option>
                                <option value="breadcrumb" {{ old('type', $pageSection->type) == 'breadcrumb' ? 'selected' : '' }}>Breadcrumb</option>
                            </select>
                            @error('type') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label fw-medium">Judul Section (Publik)</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $pageSection->title) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="subtitle" class="form-label fw-medium">Sub Judul Section</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle', $pageSection->subtitle) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label fw-medium">Konten Text HTML</label>
                        <textarea name="content" id="content" rows="6" class="form-control">{{ old('content', $pageSection->content) }}</textarea>
                    </div>

                    <div class="row mb-4">
                        {{-- Dynamic help text based on section type --}}
                        <div class="col-12 mb-3" id="image-help-box">
                            @if($pageSection->type === 'about')
                            <div class="alert alert-info border-0 bg-light py-2 px-3 mb-0">
                                <iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle me-1 text-primary"></iconify-icon>
                                <strong>Tentang Kami:</strong> <em>Gambar Utama</em> = foto besar di kiri (793×557px ideal), <em>Gambar 2</em> = foto kecil overlay di kiri bawah (340×400px ideal).
                            </div>
                            @elseif($pageSection->type === 'faq')
                            <div class="alert alert-info border-0 bg-light py-2 px-3 mb-0">
                                <iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle me-1 text-primary"></iconify-icon>
                                <strong>FAQ:</strong> <em>Gambar Utama</em> = foto besar di bagian kanan (390×430px ideal), <em>Gambar 2</em> = foto kecil overlay di kanan bawah (300×340px ideal).
                            </div>
                            @elseif($pageSection->type === 'hero')
                            <div class="alert alert-info border-0 bg-light py-2 px-3 mb-0">
                                <iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle me-1 text-primary"></iconify-icon>
                                <strong>Hero Banner:</strong> Gambar banner dikelola melalui menu <a href="{{ route('admin.banners.index') }}" class="fw-bold">Banner / Slider</a>. Upload gambar di sini tidak berpengaruh pada Hero.
                            </div>
                            @elseif(in_array($pageSection->type, ['programs', 'testimonials', 'testimonial', 'articles', 'shop', 'activities', 'galleries', 'gallery']))
                            <div class="alert alert-warning border-0 bg-light py-2 px-3 mb-0">
                                <iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle me-1 text-warning"></iconify-icon>
                                <strong>{{ ucfirst($pageSection->type) }}:</strong> Section ini mengambil data & gambar otomatis dari master datanya. Upload gambar di sini tidak berpengaruh.
                            </div>
                            @else
                            <div class="alert alert-secondary border-0 bg-light py-2 px-3 mb-0">
                                <iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle me-1"></iconify-icon>
                                Upload gambar pendukung section. Biarkan kosong jika tidak diperlukan. Maks 2MB per gambar.
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold mb-1 text-dark">
                                @if($pageSection->type === 'about')
                                    Foto Utama (Kiri - Big Image)
                                @elseif($pageSection->type === 'faq')
                                    Foto FAQ (Kanan)
                                @else
                                    Gambar Utama (Image 1)
                                @endif
                            </label>
                            <p class="text-muted fs-12 mb-2">Biarkan kosong jika tidak diubah.</p>
                            @if($pageSection->image)
                                <div class="mb-2 position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $pageSection->image) }}" class="rounded shadow-sm" style="width: 90px; height: 90px; object-fit: cover;">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="delete_image" value="1" id="delete_image">
                                        <label class="form-check-label text-danger fs-12" for="delete_image">
                                            Hapus Gambar
                                        </label>
                                    </div>
                                </div>
                            @else
                                <div class="mb-2"><span class="badge bg-light text-muted border fs-12">Belum ada gambar</span></div>
                            @endif
                            <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            @error('image') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold mb-1 text-dark">
                                @if($pageSection->type === 'about')
                                    Foto Sekunder (Kiri Kanan / Overlay)
                                @elseif($pageSection->type === 'faq')
                                    Foto Sekunder FAQ (Opsional)
                                @else
                                    Gambar 2 (Image 2)
                                @endif
                            </label>
                            <p class="text-muted fs-12 mb-2">Biarkan kosong jika tidak diubah.</p>
                            @if($pageSection->image2)
                                <div class="mb-2 position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $pageSection->image2) }}" class="rounded shadow-sm" style="width: 90px; height: 90px; object-fit: cover;">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="delete_image2" value="1" id="delete_image2">
                                        <label class="form-check-label text-danger fs-12" for="delete_image2">
                                            Hapus Gambar
                                        </label>
                                    </div>
                                </div>
                            @else
                                <div class="mb-2"><span class="badge bg-light text-muted border fs-12">Belum ada gambar</span></div>
                            @endif
                            <input type="file" name="image2" id="image2" class="form-control" accept="image/*">
                            @error('image2') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium mb-1">Gambar 3</label>
                            <p class="text-muted fs-12 mb-2">Biarkan kosong jika tidak diubah.</p>
                            @if($pageSection->image3)
                                <div class="mb-2 position-relative d-inline-block">
                                    <img src="{{ asset('storage/' . $pageSection->image3) }}" class="rounded avatar-md object-fit-cover shadow-sm">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" name="delete_image3" value="1" id="delete_image3">
                                        <label class="form-check-label text-danger fs-12" for="delete_image3">
                                            Hapus Gambar
                                        </label>
                                    </div>
                                </div>
                            @else
                                <div class="mb-2"><span class="badge bg-light text-muted border fs-12">Belum ada gambar</span></div>
                            @endif
                            <input type="file" name="image3" id="image3" class="form-control" accept="image/*">
                            @error('image3') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="button_text" class="form-label fw-medium">Teks Tombol Aksi</label>
                            <input type="text" name="button_text" id="button_text" class="form-control" placeholder="Contoh: Selengkapnya" value="{{ old('button_text', $pageSection->button_text) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="button_url" class="form-label fw-medium">URL Tombol Aksi</label>
                            <input type="text" name="button_url" id="button_url" class="form-control" placeholder="Contoh: /about atau https://..." value="{{ old('button_url', $pageSection->button_url) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="order" class="form-label fw-medium mb-1">Urutan Tampil (Order)</label>
                            <p class="text-muted fs-12 mb-2">Angka kecil tampil lebih atas.</p>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $pageSection->order) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $pageSection->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">Aktif Tanggal Ini</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Perbarui Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
