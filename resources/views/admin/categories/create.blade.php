@extends('layouts.vertical', ['title' => 'Tambah Kategori'])

@section('content')
<div class="row">
    <div class="col-xl-6 col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Tambah Kategori Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Contoh: Berita Kegiatan">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3" placeholder="Deskripsi singkat kategori (opsional)">{{ old('description') }}</textarea>
                    </div>
                    <div class="p-3 bg-light rounded">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-3"><button type="submit" class="btn btn-outline-secondary w-100">Simpan</button></div>
                            <div class="col-lg-3"><a href="{{ route('admin.categories.index') }}" class="btn btn-primary w-100">Batal</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
