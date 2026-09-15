@extends('layouts.vertical', ['title' => 'Kategori Artikel'])

@section('content')

<div class="row">
    <div class="col-xl-12">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center gap-1">
                <h4 class="card-title flex-grow-1">Semua Kategori</h4>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary">Tambah Kategori</a>
            </div>
            <div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover table-centered">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th style="width: 20px;">#</th>
                                <th>Nama Kategori</th>
                                <th>Slug</th>
                                <th>Jumlah Artikel</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ method_exists($categories, 'firstItem') ? ($categories->firstItem() + $loop->index) : $loop->iteration }}</td>
                                <td>
                                    <span class="fw-medium fs-15">{{ $category->name }}</span>
                                    @if($category->description)
                                        <p class="text-muted mb-0 mt-1 fs-13">{{ Str::limit($category->description, 50) }}</p>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark">{{ $category->slug }}</span></td>
                                <td><span class="badge bg-primary-subtle text-primary">{{ $category->posts_count }} Artikel</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus kategori ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($categories->hasPages())
            <div class="card-footer border-top">
                <nav>{{ $categories->links('pagination::bootstrap-5') }}</nav>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
