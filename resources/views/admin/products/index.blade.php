@extends('layouts.vertical', ['title' => 'Daftar Produk'])

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
                <h4 class="card-title flex-grow-1">Semua Produk</h4>
                <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex me-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-secondary ms-1"><iconify-icon icon="solar:magnifer-linear"></iconify-icon></button>
                </form>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary text-nowrap">
                    Tambah
                </a>
            </div>
            <div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0 table-hover table-centered">
                        <thead class="bg-light-subtle">
                            <tr>
                                <th style="width: 20px;">
                                    <div class="form-check ms-1">
                                        <input type="checkbox" class="form-check-input" id="customCheck1">
                                        <label class="form-check-label" for="customCheck1"></label>
                                    </div>
                                </th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>SKU</th>
                                <th>Status</th>
                                <th>Link Checkout</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>
                                    <div class="form-check ms-1">
                                        <input type="checkbox" class="form-check-input" id="check-{{ $product->id }}">
                                        <label class="form-check-label" for="check-{{ $product->id }}">&nbsp;</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded bg-light avatar-md d-flex align-items-center justify-content-center">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="avatar-md" style="object-fit: contain; background-color: #f8f9fa;">
                                            @else
                                                <iconify-icon icon="solar:gallery-bold-duotone" class="fs-24 text-muted"></iconify-icon>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="text-dark fw-medium fs-15">{{ $product->name }}</a>
                                            @if($product->meta_keywords)
                                            <p class="text-muted mb-0 mt-1 fs-13"><span>Tags : </span>{{ Str::limit($product->meta_keywords, 30) }}</p>
                                            @endif
                                            @if(is_array($product->translators) && count($product->translators) > 0)
                                            <p class="text-muted mb-0 mt-1 fs-13"><span>Penerjemah: </span>{{ implode(', ', $product->translators) }}</p>
                                            @endif
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    @if($product->discount_price > 0 && $product->discount_price < $product->price)
                                        <span class="text-muted text-decoration-line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span><br>
                                        <span class="fw-medium text-primary">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark fs-12">{{ $product->sku ?? '-' }}</span>
                                </td>
                                <td>
                                    @if($product->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Nonaktif</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->external_link_wa)
                                        <span class="badge bg-success-subtle text-success p-1 fs-12"><i class="bx bxl-whatsapp me-1"></i>WA</span>
                                    @endif
                                    @if($product->external_link_marketplace)
                                        <span class="badge bg-primary-subtle text-primary p-1 fs-12"><i class="bx bx-store me-1"></i>Marketplace</span>
                                    @endif
                                    @if(!$product->external_link_wa && !$product->external_link_marketplace)
                                        <span class="text-muted fs-13">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <iconify-icon icon="solar:box-minimalistic-bold-duotone" class="fs-36 text-muted mb-2 d-block"></iconify-icon>
                                    <p class="text-muted mb-2">Belum ada produk.</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">Tambah Produk Pertama</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- end table-responsive -->
            </div>
            @if($products->hasPages())
            <div class="card-footer border-top">
                <nav aria-label="Page navigation">
                    {{ $products->links('pagination::bootstrap-5') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection
