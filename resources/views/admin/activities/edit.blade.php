@extends('layouts.vertical', ['title' => 'Edit Kegiatan'])

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h4 class="page-title mb-1">Edit Kegiatan</h4>
            <p class="text-muted mb-0">Perbarui informasi kegiatan "{{ $activity->title }}".</p>
        </div>
        <a href="{{ route('admin.activities.index') }}" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-bold-duotone" class="align-middle me-1"></iconify-icon> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 mx-auto">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.activities.update', $activity->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label fw-medium">Judul Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $activity->title) }}">
                        @error('title') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-xl-4">
                            <label for="date" class="form-label fw-medium">Tanggal Pelaksanaan</label>
                            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', optional($activity->date)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-xl-4">
                            <label for="time_start" class="form-label fw-medium">Jam Mulai</label>
                            <input type="time" name="time_start" id="time_start" class="form-control" value="{{ old('time_start', $activity->time_start ? \Carbon\Carbon::parse($activity->time_start)->format('H:i') : '') }}">
                        </div>
                        <div class="col-xl-4">
                            <label for="time_end" class="form-label fw-medium">Jam Selesai</label>
                            <input type="time" name="time_end" id="time_end" class="form-control" value="{{ old('time_end', $activity->time_end ? \Carbon\Carbon::parse($activity->time_end)->format('H:i') : '') }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-xl-6">
                            <label for="location" class="form-label fw-medium">Lokasi Pelaksanaan</label>
                            <input type="text" name="location" id="location" class="form-control" placeholder="Contoh: Aula Lantai 2" value="{{ old('location', $activity->location) }}">
                        </div>
                        <div class="col-xl-6">
                            <label for="organizer" class="form-label fw-medium">Penyelenggara / Divisi</label>
                            <input type="text" name="organizer" id="organizer" class="form-control" placeholder="Contoh: Divisi Dakwah" value="{{ old('organizer', $activity->organizer) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-xl-6">
                            <label for="contact_person" class="form-label fw-medium">Narahubung (CP)</label>
                            <input type="text" name="contact_person" id="contact_person" class="form-control" placeholder="Contoh: Ust. Ahmad (08123456789)" value="{{ old('contact_person', $activity->contact_person) }}">
                        </div>
                        <div class="col-xl-6">
                            <label for="registration_link" class="form-label fw-medium">Link Pendaftaran</label>
                            <input type="url" name="registration_link" id="registration_link" class="form-control" placeholder="https://forms.google.com/..." value="{{ old('registration_link', $activity->registration_link) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-xl-4">
                            <label for="max_participants" class="form-label fw-medium">Kuota Peserta</label>
                            <input type="number" name="max_participants" id="max_participants" class="form-control" min="1" value="{{ old('max_participants', $activity->max_participants) }}">
                        </div>
                        <div class="col-xl-4">
                            <label for="status" class="form-label fw-medium">Status Kegiatan</label>
                            <select name="status" id="status" class="form-select">
                                <option value="upcoming" {{ old('status', $activity->status) == 'upcoming' ? 'selected' : '' }}>Mendatang</option>
                                <option value="ongoing" {{ old('status', $activity->status) == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                <option value="completed" {{ old('status', $activity->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ old('status', $activity->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-xl-4">
                            <label for="created_at" class="form-label fw-medium">Tanggal Publikasi</label>
                            <input type="datetime-local" name="created_at" id="created_at" class="form-control" value="{{ old('created_at', $activity->created_at->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-medium">Deskripsi Kegiatan <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" rows="6" class="form-control" required>{{ old('description', $activity->description) }}</textarea>
                        @error('description') <div class="text-danger mt-1 fs-12">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium d-block">Poster / Foto Sampul</label>
                        @if($activity->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $activity->image) }}" class="rounded shadow-sm" style="max-height: 150px;">
                                <p class="text-muted fs-12 mt-1">Gambar saat ini. Upload baru untuk mengganti.</p>
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <p class="text-muted mt-1 fs-12">JPG, PNG, atau WEBP (Max 3MB).</p>
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch pt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $activity->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="is_active">Aktif (Tampilkan di Website)</label>
                        </div>
                    </div>

                    <div class="text-end border-top pt-4">
                        <button type="submit" class="btn btn-primary fw-medium px-4">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
