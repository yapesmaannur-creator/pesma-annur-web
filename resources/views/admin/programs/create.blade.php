@extends('layouts.vertical', ['title' => 'Tambah Program'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Tambah Program</h4>
            <p class="text-muted mb-0">Tambahkan informasi program pesantren yang baru.</p>
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
                <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Nama Program <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Contoh: Tahfidz Reguler" required value="{{ old('title') }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label fw-medium">Ikon Tema</label>
                        <select name="icon" id="icon" class="form-select">
                            <option value="">-- Pilih Ikon (Kosongkan bila ingin otomatis) --</option>
                            <option value="feather-book-open">Buku Terbuka (Pendidikan)</option>
                            <option value="feather-monitor">Monitor (Komputer / IT)</option>
                            <option value="feather-target">Target (Tujuan / Fokus)</option>
                            <option value="feather-briefcase">Tas Kerja (Karir / Bisnis)</option>
                            <option value="feather-users">Grup Orang (Sosial / Komunitas)</option>
                            <option value="feather-award">Piala (Prestasi / Lomba)</option>
                            <option value="feather-star">Bintang (Unggulan)</option>
                            <option value="feather-heart">Hati (Kesehatan / Sosial)</option>
                            <option value="feather-activity">Aktivitas (Olahraga / Dinamis)</option>
                        </select>
                        <div class="form-text mt-1 fs-12">Ikon ini akan muncul bersama judul program pada bingkai beranda.</div>
                        @error('icon') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-medium">Deskripsi Program <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Jelaskan detail mengenai program ini..." required>{{ old('description') }}</textarea>
                        @error('description') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>


                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label fw-medium" for="is_active">Status Aktif</label>
                        </div>
                        <p class="text-muted fs-13 mb-0">Bila aktif, program akan otomatis tampil di halaman Beranda.</p>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Program
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
                document.getElementById('imgPreviewContainer').querySelector('iconify-icon').classList.add('d-none');
                document.getElementById('imagePreview').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
