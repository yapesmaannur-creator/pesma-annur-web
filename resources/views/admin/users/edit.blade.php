@extends('layouts.vertical', ['title' => 'Edit Pengguna'])

@section('content')

<div class="row">
    <div class="col-xl-8 col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Pengguna: {{ $user->name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="password" class="form-label">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                            <input type="password" id="password" name="password" class="form-control">
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="role" class="form-label">Role / Hak Akses <span class="text-danger">*</span></label>
                            <select id="role" name="role" class="form-select" required>
                                <option value="admin" {{ old('role', $user->role)=='admin'?'selected':'' }}>Super Admin</option>
                                <option value="editor" {{ old('role', $user->role)=='editor'?'selected':'' }}>Dewan Redaksi</option>
                                <option value="pengasuh" {{ old('role', $user->role)=='pengasuh'?'selected':'' }}>Pengasuh</option>
                                <option value="ustadz" {{ old('role', $user->role)=='ustadz'?'selected':'' }}>Asatidz</option>
                                <option value="pengurus" {{ old('role', $user->role)=='pengurus'?'selected':'' }}>Pengurus Pesantren</option>
                                <option value="santri" {{ old('role', $user->role)=='santri'?'selected':'' }}>Santri</option>
                                <option value="alumni" {{ old('role', $user->role)=='alumni'?'selected':'' }}>Alumni</option>
                                <option value="kontributor" {{ old('role', $user->role)=='kontributor'?'selected':'' }}>Kontributor</option>
                            </select>
                            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
                            <small class="text-muted mt-1 d-block">
                                <strong>Super Admin / Dewan Redaksi:</strong> Dapat mengelola dashboard.<br>
                                <strong>Role Lainnya:</strong> Menjadi lencana jabatan untuk penulis.
                            </small>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="phone_number" class="form-label">No. Telepon</label>
                            <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ old('phone_number', $user->phone_number) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="avatar" class="form-label">Foto Profil</label>
                            @if($user->avatar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;">
                            </div>
                            @endif
                            <input type="file" id="avatar" name="avatar" class="form-control" accept="image/*">
                            <small class="text-muted">Foto akan tampil di halaman artikel sebagai profil penulis.</small>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="bio" class="form-label">Bio / Deskripsi Singkat</label>
                            <textarea id="bio" name="bio" class="form-control" rows="3" placeholder="Tulis bio singkat penulis...">{{ old('bio', $user->bio) }}</textarea>
                            <small class="text-muted">Akan tampil di halaman detail artikel.</small>
                        </div>
                    </div>
                    <hr>
                    <h5 class="mb-3">Jejaring Sosial Penulis (Opsional)</h5>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="social_fb" class="form-label">URL Facebook</label>
                            <input type="url" id="social_fb" name="social_fb" class="form-control" value="{{ old('social_fb', $user->social_fb) }}" placeholder="https://facebook.com/username">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="social_ig" class="form-label">URL Instagram</label>
                            <input type="url" id="social_ig" name="social_ig" class="form-control" value="{{ old('social_ig', $user->social_ig) }}" placeholder="https://instagram.com/username">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="social_x" class="form-label">URL X (Twitter)</label>
                            <input type="url" id="social_x" name="social_x" class="form-control" value="{{ old('social_x', $user->social_x) }}" placeholder="https://x.com/username">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="social_linkedin" class="form-label">URL LinkedIn</label>
                            <input type="url" id="social_linkedin" name="social_linkedin" class="form-control" value="{{ old('social_linkedin', $user->social_linkedin) }}" placeholder="https://linkedin.com/in/username">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="social_scholar" class="form-label">URL Google Scholar</label>
                            <input type="url" id="social_scholar" name="social_scholar" class="form-control" value="{{ old('social_scholar', $user->social_scholar) }}" placeholder="https://scholar.google.com/citations?user=xxx">
                        </div>
                    </div>
                    <div class="p-3 bg-light rounded mt-3">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-2"><button type="submit" class="btn btn-outline-secondary w-100">Update</button></div>
                            <div class="col-lg-2"><a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">Batal</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
