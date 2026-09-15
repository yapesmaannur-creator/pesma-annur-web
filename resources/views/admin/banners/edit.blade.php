@extends('layouts.vertical', ['title' => 'Edit Banner'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit Banner</h4>
            <p class="text-muted mb-0">Ubah konfigurasi, urutan, atau gambar banner.</p>
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
                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Besar (Opsional)</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $banner->title) }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subtitle" class="form-label fw-medium">Sub Judul (Opsional)</label>
                        <input type="text" name="subtitle" id="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
                        @error('subtitle') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="link" class="form-label fw-medium">Tautan Aksi / Link (Opsional)</label>
                        <input type="url" name="link" id="link" class="form-control" value="{{ old('link', $banner->link) }}">
                        @error('link') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4" id="link_type_wrapper" style="display:none;">
                        <label class="form-label fw-medium d-block">Tampilkan Link Sebagai</label>
                        <div class="d-flex gap-3 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="link_type" id="link_type_button" value="button"
                                    {{ old('link_type', $banner->link_type ?? 'button') === 'button' ? 'checked' : '' }}>
                                <label class="form-check-label" for="link_type_button">
                                    <iconify-icon icon="solar:cursor-bold-duotone" class="fs-16 align-middle me-1"></iconify-icon>
                                    <strong>Tombol Teks</strong> &mdash; <span class="text-muted fs-12">Muncul tombol "Selengkapnya" di tengah banner</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="link_type" id="link_type_image" value="image"
                                    {{ old('link_type', $banner->link_type ?? 'button') === 'image' ? 'checked' : '' }}>
                                <label class="form-check-label" for="link_type_image">
                                    <iconify-icon icon="solar:gallery-wide-bold-duotone" class="fs-16 align-middle me-1"></iconify-icon>
                                    <strong>Klik Gambar</strong> &mdash; <span class="text-muted fs-12">Seluruh gambar bisa diklik, tanpa tombol teks</span>
                                </label>
                            </div>
                        </div>
                        <p class="text-muted fs-12 mt-2"><iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle"></iconify-icon> Mode "Klik Gambar" cocok untuk banner promosi bergambar yang sudah memuat informasi visual lengkap.</p>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium d-block">Ganti Gambar Banner (Opsional)</label>
                        @if($banner->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $banner->image) }}" class="rounded shadow-sm" style="max-height: 150px; width: auto; max-width: 100%;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <p class="text-muted mt-1 fs-12">Kosongkan jika tidak ingin mengubah tipe file dan gambar yg terekam.</p>
                        @error('image') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="order" class="form-label fw-medium">Urutan Menampilkan</label>
                            <input type="number" name="order" id="order" class="form-control" required value="{{ old('order', $banner->order) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $banner->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">Aktifkan Banner</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Perbarui Banner
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const linkInput = document.getElementById('link');
    const ltWrapper = document.getElementById('link_type_wrapper');

    function toggleLinkType() {
        ltWrapper.style.display = linkInput.value.trim() ? 'block' : 'none';
    }

    linkInput.addEventListener('input', toggleLinkType);
    toggleLinkType(); // cek nilai awal saat load
</script>
@endpush

@endsection
