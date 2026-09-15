@extends('layouts.vertical', ['title' => 'Edit Program'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit Program</h4>
            <p class="text-muted mb-0">Ubah detail atau status program pesantren.</p>
        </div>
        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Tahfidz Reguler" required value="{{ old('title', $program->title) }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label fw-medium">Ikon Tema</label>
                        <select name="icon" id="icon" class="form-select">
                            <option value="" {{ old('icon', $program->icon) == '' ? 'selected' : '' }}>-- Pilih Ikon (Kosongkan bila ingin otomatis) --</option>
                            <option value="feather-book-open" {{ old('icon', $program->icon) == 'feather-book-open' ? 'selected' : '' }}>Buku Terbuka (Pendidikan)</option>
                            <option value="feather-monitor" {{ old('icon', $program->icon) == 'feather-monitor' ? 'selected' : '' }}>Monitor (Komputer / IT)</option>
                            <option value="feather-target" {{ old('icon', $program->icon) == 'feather-target' ? 'selected' : '' }}>Target (Tujuan / Fokus)</option>
                            <option value="feather-briefcase" {{ old('icon', $program->icon) == 'feather-briefcase' ? 'selected' : '' }}>Tas Kerja (Karir / Bisnis)</option>
                            <option value="feather-users" {{ old('icon', $program->icon) == 'feather-users' ? 'selected' : '' }}>Grup Orang (Sosial / Komunitas)</option>
                            <option value="feather-award" {{ old('icon', $program->icon) == 'feather-award' ? 'selected' : '' }}>Piala (Prestasi / Lomba)</option>
                            <option value="feather-star" {{ old('icon', $program->icon) == 'feather-star' ? 'selected' : '' }}>Bintang (Unggulan)</option>
                            <option value="feather-heart" {{ old('icon', $program->icon) == 'feather-heart' ? 'selected' : '' }}>Hati (Kesehatan / Sosial)</option>
                            <option value="feather-activity" {{ old('icon', $program->icon) == 'feather-activity' ? 'selected' : '' }}>Aktivitas (Olahraga / Dinamis)</option>
                        </select>
                        <div class="form-text mt-1 fs-12">Ikon ini akan muncul bersama judul program pada bingkai beranda.</div>
                        @error('icon') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-medium">Deskripsi Program <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="5" class="form-control" required>{{ old('description', $program->description) }}</textarea>
                        @error('description') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium d-block">Gambar / Ikon Program</label>
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-xl border rounded bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; cursor: pointer;" id="imgPreviewContainer" onclick="document.getElementById('image').click()">
                                @if($program->image)
                                    <img id="imagePreview" src="{{ asset('storage/' . $program->image) }}" class="w-100 h-100 object-fit-cover rounded">
                                    <iconify-icon icon="solar:gallery-add-bold-duotone" class="fs-48 text-muted d-none"></iconify-icon>
                                @else
                                    <iconify-icon icon="solar:gallery-add-bold-duotone" class="fs-48 text-muted"></iconify-icon>
                                    <img id="imagePreview" src="" class="d-none w-100 h-100 object-fit-cover rounded">
                                @endif
                            </div>
                            <div>
                                <input type="file" name="image" id="image" class="form-control d-none" accept="image/*" onchange="previewImage(this)">
                                <button type="button" class="btn btn-soft-primary btn-sm mb-2" onclick="document.getElementById('image').click()"><iconify-icon icon="solar:upload-minimalistic-bold-duotone" class="me-1"></iconify-icon> Ganti Gambar</button>
                                <p class="text-muted fs-12 mb-0">Abaikan jika tidak ingin mengubah gambar.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $program->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">Status Aktif</label>
                        </div>
                        <p class="text-muted fs-13 mb-0">Menentukan apakah program ini tampil secara publik.</p>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:folder-with-files-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Perubahan
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
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var icon = document.getElementById('imgPreviewContainer').querySelector('iconify-icon');
                if(icon) icon.classList.add('d-none');
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
