@extends('layouts.vertical', ['title' => 'Setting ' . $page->title])

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manajemen Section: {{ $page->title }}</h4>
                <a href="{{ route('admin.page-sections.create', ['page_id' => $page->id]) }}" class="btn btn-primary btn-sm">
                    <iconify-icon icon="solar:add-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Tambah Section Baru
                </a>
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
                                <th>Nama Section</th>
                                <th>Tipe (Template)</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($page->sections as $section)
                            <tr>
                                <td>{{ $section->order }}</td>
                                <td>{{ $section->section_name }}</td>
                                <td><span class="badge bg-info">{{ $section->type }}</span></td>
                                <td>
                                    @if($section->image)
                                        <img src="{{ asset('storage/' . $section->image) }}" class="avatar-xs rounded object-fit-cover shadow-sm" title="Gambar Utama">
                                    @else
                                        <span class="text-muted fs-12">—</span>
                                    @endif
                                    @if($section->image2)
                                        <img src="{{ asset('storage/' . $section->image2) }}" class="avatar-xs rounded object-fit-cover shadow-sm ms-1" title="Gambar 2">
                                    @endif
                                </td>
                                <td>
                                    @if($section->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $typeHints = [
                                            'programs' => 'Data diambil otomatis dari menu Program Pesantren',
                                            'testimonials' => 'Data diambil otomatis dari menu Testimoni',
                                            'faq' => 'Data diambil dari menu FAQ. Upload gambar via Edit.',
                                            'articles' => 'Data diambil otomatis dari Artikel & Berita',
                                            'activities' => 'Data diambil otomatis dari menu Kegiatan',
                                            'galleries' => 'Data diambil otomatis dari Manajemen Galeri',
                                            'contact' => 'Form kontak otomatis tampil',
                                            'hero' => 'Banner dikelola lewat menu Banner/Slider',
                                            'about' => 'Upload 2 gambar via Edit. Checklist via Items.',
                                            'shop' => 'Data produk otomatis dari Manajemen Toko',
                                            'counter' => 'Statistik angka animasi, kelola via Items',
                                            'sejarah' => 'Timeline sejarah pesantren',
                                            'repeater' => 'Kelola card/item secara manual via tombol Items',
                                            'features' => 'Kelola card keunggulan (icon, judul, deskripsi) via Items',
                                        ];
                                    @endphp
                                    <small class="text-muted">{{ $typeHints[$section->type] ?? 'Kelola via Edit & Items' }}</small>
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.page-sections.edit', $section->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                        <form action="{{ route('admin.page-sections.destroy', $section->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus section ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></button>
                                        </form>
                                        @if(in_array($section->type, ['repeater', 'hero', 'about', 'custom_html', 'features', 'counter']))
                                            <a href="{{ route('admin.page-sections.items', $section->id) }}" class="btn btn-soft-warning btn-sm" title="Kelola Item"><iconify-icon icon="solar:list-bold-duotone" class="align-middle fs-18"></iconify-icon> Items</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Halaman ini belum memiliki section. Silakan tambah section.</td>
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
