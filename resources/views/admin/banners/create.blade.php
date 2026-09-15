@extends('layouts.vertical', ['title' => 'Tambah Banner'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah Banner</h4>
            <p class="text-muted mb-0">Unggah dan atur gambar banner baru.</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Besar (Opsional)</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Teks utama banner" value="{{ old('title') }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label fw-medium">Sub Judul (Opsional)</label>
                        <input type="text" name="subtitle" id="subtitle" class="form-control" placeholder="Teks deskripsi di bawah judul" value="{{ old('subtitle') }}">
                        @error('subtitle') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="link" class="form-label fw-medium">Tautan Aksi / Link (Opsional)</label>
                        <input type="url" name="link" id="link" class="form-control" placeholder="Contoh: https://example.com/pendaftaran" value="{{ old('link') }}">
                        @error('link') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4" id="link_type_wrapper" style="display:none;">
                        <label class="form-label fw-medium d-block">Tampilkan Link Sebagai</label>
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="link_type" id="link_type_button" value="button" checked>
                                <label class="form-check-label" for="link_type_button">
                                    <iconify-icon icon="solar:cursor-bold-duotone" class="fs-16 align-middle me-1"></iconify-icon>
                                    <strong>Tombol Teks</strong> &mdash; <span class="text-muted fs-12">Muncul tombol "Selengkapnya" di tengah banner</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="link_type" id="link_type_image" value="image">
                                <label class="form-check-label" for="link_type_image">
                                    <iconify-icon icon="solar:gallery-wide-bold-duotone" class="fs-16 align-middle me-1"></iconify-icon>
                                    <strong>Klik Gambar</strong> &mdash; <span class="text-muted fs-12">Seluruh gambar bisa diklik, tanpa tombol teks</span>
                                </label>
                            </div>
                        </div>
                        <p class="text-muted fs-12 mt-2"><iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle"></iconify-icon> Mode "Klik Gambar" cocok untuk banner promosi bergambar yang sudah memuat informasi visual lengkap.</p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium d-block">Gambar Banner <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                        <p class="text-muted mt-1 fs-12">Disarankan rasio lebar (misal: 1920x800px). JPG, PNG (Max 3MB).</p>
                        @error('image') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="order" class="form-label fw-medium">Urutan Menampilkan</label>
                            <input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Aktifkan Banner</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Tampilkan opsi link_type hanya jika link diisi
    const linkInput = document.getElementById('link');
    const ltWrapper = document.getElementById('link_type_wrapper');

    function toggleLinkType() {
        ltWrapper.style.display = linkInput.value.trim() ? 'block' : 'none';
    }

    linkInput.addEventListener('input', toggleLinkType);
    toggleLinkType(); // cek saat load
</script>
@endpush

@endsection
