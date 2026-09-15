@extends('layouts.vertical', ['title' => 'Kelola Item Section'])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Kelola Item: {{ $pageSection->section_name }} ({{ $pageSection->page->title }})</h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.pages.builder', $pageSection->page->slug) }}" class="btn btn-outline-secondary btn-sm">
                        <iconify-icon icon="solar:arrow-left-bold-duotone"></iconify-icon> Kembali
                    </a>
                    <a href="{{ route('admin.section-items.create', ['section_id' => $pageSection->id]) }}" class="btn btn-primary btn-sm">
                        <i class="bx bx-plus"></i> Tambah Item Baru
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order</th>
                                <th>Gambar/Icon</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pageSection->items as $item)
                            <tr>
                                <td>{{ $item->order }}</td>
                                <td>
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" class="rounded avatar-sm object-fit-cover shadow-sm">
                                    @elseif($item->icon)
                                        <iconify-icon icon="{{ $item->icon }}" class="fs-24"></iconify-icon>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    @if($item->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.section-items.edit', $item->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                        <form action="{{ route('admin.section-items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus item ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Section ini belum memiliki item. Silakan tambah item baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
