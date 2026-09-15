@extends('layouts.vertical', ['title' => 'Edit Kategori'])

@section('content')
<div class="row">
    <div class="col-xl-6 col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Kategori: {{ $category->name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                    </div>
                    <div class="p-3 bg-light rounded">
                        <div class="row justify-content-end g-2">
                            <div class="col-lg-3"><button type="submit" class="btn btn-outline-secondary w-100">Update</button></div>
                            <div class="col-lg-3"><a href="{{ route('admin.categories.index') }}" class="btn btn-primary w-100">Batal</a></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
