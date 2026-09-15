@extends('layouts.vertical', ['title' => 'Edit Produk'])

@section('css')
    <!-- Quill CSS for Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method('PUT')
    <div class="row">
        {{-- Sidebar Preview --}}
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($product->image)
                        <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded bg-light">
                    @else
                        <img id="image-preview" src="https://ui-avatars.com/api/?name=Cover+Buku&background=f8f9fa&color=6c757d&size=600&font-size=0.15" alt="Preview" class="img-fluid rounded bg-light">
                    @endif
                    <div class="mt-3">
                        <h4 id="preview-name">{{ $product->name }}</h4>
                        <h5 class="text-dark fw-medium mt-3">Harga :</h5>
                        <h4 class="fw-semibold text-dark mt-2 d-flex align-items-center justify-content-center gap-2">
                            @if($product->discount_price > 0 && $product->discount_price < $product->price)
                                <span class="text-muted text-decoration-line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                            @else
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            @endif
                        </h4>
                        @if($product->sku)
                        <span class="badge bg-light text-dark p-1 fs-12">SKU: {{ $product->sku }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-footer bg-light-subtle">
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-outline-secondary w-100">Simpan</button>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-primary w-100">Batal</a>
                        </div>
                        <div class="col-lg-12">
                            <a href="{{ route('admin.products.preview', $product->id) }}" target="_blank" class="btn btn-warning fw-medium w-100">
                                <iconify-icon icon="solar:eye-bold-duotone" class="align-middle me-1"></iconify-icon> Preview Halaman
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Utama --}}
        <div class="col-xl-9 col-lg-8">
            {{-- Upload Gambar --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Foto Produk</h4>
                </div>
                <div class="card-body">
                    <div class="bg-light-subtle py-4 text-center rounded border-2 border-dashed">
                        <i class="bx bx-cloud-upload fs-48 text-primary"></i>
                        <h5 class="mt-3">Drop gambar di sini, atau <label for="image-upload" class="text-primary" style="cursor:pointer;">klik untuk upload</label></h5>
                        <span class="text-muted fs-13">Format: PNG, JPG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengganti gambar.</span>
                        <input id="image-upload" type="file" name="image" class="d-none" accept="image/*" onchange="previewImg(event)">
                    </div>
                    @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Informasi Produk --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Produk</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="product-name" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                                <input type="text" id="product-name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required oninput="document.getElementById('preview-name').textContent=this.value||'Nama Produk'">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="product-sku" class="form-label">Kode SKU</label>
                                <input type="text" id="product-sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Produk</label>
                                <div id="snow-editor" style="height: 300px;">{!! old('description', $product->description) !!}</div>
                                <input type="hidden" name="description" id="description_input">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" {{ $product->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Produk Aktif (tampilkan di toko)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Atribut Buku --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Atribut Buku (Opsional)</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="authors" class="form-label">Penulis</label>
                            <input type="text" id="authors" name="authors" class="form-control" placeholder="Contoh: John Doe, Jane Smith" value="{{ old('authors', is_array($product->authors) ? implode(', ', $product->authors) : $product->authors) }}">
                            <small class="text-muted">Pisahkan nama dengan koma jika lebih dari satu.</small>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="editors" class="form-label">Editor</label>
                            <input type="text" id="editors" name="editors" class="form-control" placeholder="Contoh: Ali, Budi" value="{{ old('editors', is_array($product->editors) ? implode(', ', $product->editors) : $product->editors) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="translators" class="form-label">Penerjemah</label>
                            <input type="text" id="translators" name="translators" class="form-control" placeholder="Contoh: Ahmad, Siti" value="{{ old('translators', is_array($product->translators) ? implode(', ', $product->translators) : $product->translators) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="edition" class="form-label">Edisi</label>
                            <input type="text" id="edition" name="edition" class="form-control" placeholder="1st Edition" value="{{ old('edition', $product->edition) }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="publication_date" class="form-label">Tanggal Rilis (Published)</label>
                            <input type="date" id="publication_date" name="publication_date" class="form-control" value="{{ old('publication_date', optional($product->publication_date)->format('Y-m-d')) }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="pages" class="form-label">Jumlah Halaman</label>
                            <input type="number" id="pages" name="pages" class="form-control" placeholder="250" value="{{ old('pages', $product->pages) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="publisher_imprint" class="form-label">Imprint / Penerbit</label>
                            <input type="text" id="publisher_imprint" name="publisher_imprint" class="form-control" placeholder="Routledge" value="{{ old('publisher_imprint', $product->publisher_imprint) }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="publication_location" class="form-label">Lokasi Terbit</label>
                            <input type="text" id="publication_location" name="publication_location" class="form-control" placeholder="London" value="{{ old('publication_location', $product->publication_location) }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" id="isbn" name="isbn" class="form-control" placeholder="978xxxxxx" value="{{ old('isbn', $product->isbn) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="doi" class="form-label">Link DOI</label>
                            <input type="url" id="doi" name="doi" class="form-control" placeholder="https://doi.org/10.xxxx" value="{{ old('doi', $product->doi) }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="subjects" class="form-label">Subjek / Area Studi</label>
                            <input type="text" id="subjects" name="subjects" class="form-control" placeholder="Humanities, Education" value="{{ old('subjects', $product->subjects) }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="preview_document_path" class="form-label">Preview Dokumen (PDF) untuk Pratinjau Buku</label>
                            @if($product->preview_document_path)
                                <div class="mb-2">
                                    <a href="{{ asset('storage/' . $product->preview_document_path) }}" target="_blank" class="btn btn-sm btn-soft-primary"><i class="bx bx-file"></i> Lihat File Saat Ini</a>
                                </div>
                            @endif
                            <input type="file" id="preview_document_path" name="preview_document_path" class="form-control" accept=".pdf">
                            <small class="text-muted">Maksimal 10MB. Biasanya berisi Daftar Isi atau Bab 1. Kosongkan jika tidak ingin mengubah.</small>
                            @error('preview_document_path') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Harga --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail Harga</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="product-price" class="form-label">Harga Normal <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fs-20"><i class='bx bx-wallet'></i></span>
                                <input type="number" id="product-price" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="product-discount" class="form-label">Harga Diskon</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fs-20"><i class='bx bxs-discount'></i></span>
                                <input type="number" id="product-discount" name="discount_price" class="form-control" value="{{ old('discount_price', $product->discount_price) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">SEO & Meta Tags</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ old('meta_title', $product->meta_title) }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Kata Kunci SEO</label>
                                <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $product->meta_keywords) }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" class="form-control" rows="2">{{ old('meta_description', $product->meta_description) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== GOOGLE SCHOLAR INDEXING VALIDATOR ===== --}}
            @php
                $scholarChecks = [
                    ['field' => 'Judul (citation_title)',              'ok' => !empty($product->name),                                    'value' => $product->name ?? null],
                    ['field' => 'Penulis (citation_author)',           'ok' => is_array($product->authors) && count($product->authors) > 0, 'value' => is_array($product->authors) ? implode(', ', $product->authors) : null],
                    ['field' => 'Penerbit (citation_publisher)',       'ok' => !empty($product->publisher_imprint),                       'value' => $product->publisher_imprint ?? null],
                    ['field' => 'Tahun Terbit (citation_publ._date)', 'ok' => !empty($product->publication_date),                       'value' => $product->publication_date ? $product->publication_date->format('Y') : null],
                    ['field' => 'ISBN (citation_isbn)',                'ok' => !empty($product->isbn),                                    'value' => $product->isbn ?? null],
                    ['field' => 'DOI (citation_doi)',                  'ok' => !empty($product->doi),                                     'value' => $product->doi ?? null],
                    ['field' => 'PDF Preview (citation_pdf_url)',      'ok' => !empty($product->preview_document_path),                   'value' => !empty($product->preview_document_path) ? 'Ada' : null],
                    ['field' => 'Meta Description',                   'ok' => !empty($product->meta_description),                        'value' => $product->meta_description ? \Str::limit($product->meta_description, 50) : null],
                ];
                $scholarScore = collect($scholarChecks)->filter(fn($c) => $c['ok'])->count();
                $scholarTotal = count($scholarChecks);
                $scholarPct   = round(($scholarScore / $scholarTotal) * 100);
                $scholarColor = $scholarPct >= 80 ? 'success' : ($scholarPct >= 50 ? 'warning' : 'danger');
            @endphp
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center gap-2">
                    <iconify-icon icon="solar:diploma-bold-duotone" class="fs-22 text-primary"></iconify-icon>
                    <div>
                        <h5 class="card-title fw-semibold m-0">Google Scholar Indexing Validator</h5>
                        <small class="text-muted">Cek kelengkapan metadata agar buku ini terindeks scholar.</small>
                    </div>
                </div>
                <div class="card-body">
                    {{-- Score Bar --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="fw-medium text-muted">Kesiapan Metadata</small>
                            <span class="badge bg-{{ $scholarColor }}-subtle text-{{ $scholarColor }} fw-bold px-3 py-1">
                                {{ $scholarScore }}/{{ $scholarTotal }} field &mdash; {{ $scholarPct }}%
                            </span>
                        </div>
                        <div class="progress rounded-pill" style="height: 10px;">
                            <div class="progress-bar bg-{{ $scholarColor }} rounded-pill" style="width: {{ $scholarPct }}%" role="progressbar"></div>
                        </div>
                        @if($scholarPct < 50)
                        <div class="alert alert-danger d-flex align-items-start gap-2 mt-2 mb-0 py-2 px-3" style="font-size:13px;">
                            <iconify-icon icon="solar:danger-triangle-bold-duotone" class="fs-16 flex-shrink-0 mt-1"></iconify-icon>
                            <span>Metadata belum cukup untuk diindeks Scholar. Isi minimal: <strong>Penulis, Penerbit, Tahun Terbit</strong>, dan <strong>ISBN atau DOI</strong>.</span>
                        </div>
                        @elseif($scholarPct < 80)
                        <div class="alert alert-warning d-flex align-items-start gap-2 mt-2 mb-0 py-2 px-3" style="font-size:13px;">
                            <iconify-icon icon="solar:shield-warning-bold-duotone" class="fs-16 flex-shrink-0 mt-1"></iconify-icon>
                            <span>Cukup baik. Tambahkan <strong>PDF Preview</strong> dan <strong>DOI</strong> untuk hasil indeks yang lebih optimal.</span>
                        </div>
                        @else
                        <div class="alert alert-success d-flex align-items-start gap-2 mt-2 mb-0 py-2 px-3" style="font-size:13px;">
                            <iconify-icon icon="solar:verified-check-bold-duotone" class="fs-16 flex-shrink-0 mt-1"></iconify-icon>
                            <span>Metadata <strong>lengkap</strong>! Buku ini siap untuk diindeks Google Scholar.</span>
                        </div>
                        @endif
                    </div>

                    {{-- Checklist Table --}}
                    <table class="table table-sm table-borderless mb-0" style="font-size: 12.5px;">
                        <thead>
                            <tr class="text-muted border-bottom" style="font-size:11px; text-transform:uppercase; letter-spacing:.5px;">
                                <th style="width:28px;"></th>
                                <th>Field</th>
                                <th class="text-end">Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($scholarChecks as $check)
                        <tr class="align-middle">
                            <td>
                                @if($check['ok'])
                                    <span class="badge bg-success-subtle text-success" style="font-size:12px; width:22px; height:22px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">✓</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger" style="font-size:12px; width:22px; height:22px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">✗</span>
                                @endif
                            </td>
                            <td class="fw-medium text-muted">{{ $check['field'] }}</td>
                            <td class="text-end">
                                @if($check['ok'])
                                    <span class="text-dark" style="font-size:12px;">{{ \Str::limit($check['value'] ?? '', 40) }}</span>
                                @else
                                    <span class="text-danger fst-italic" style="font-size:11px;">Belum diisi</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{-- Generated Meta Tags Preview --}}
                    <div class="mt-3 border-top pt-3">
                        <small class="text-muted fw-semibold d-block mb-2">
                            <iconify-icon icon="solar:code-bold-duotone" class="me-1"></iconify-icon>
                            Meta tag yang akan ter-generate di &lt;head&gt;:
                        </small>
                        <div style="background:#1e293b; border-radius:8px; padding:12px; font-size:11px; font-family:monospace; max-height:140px; overflow-y:auto; line-height:1.7;">
                            @if(!empty($product->name))
                            <div style="color:#86efac;">&lt;meta name="<span style="color:#fde68a;">citation_title</span>" content="<span style="color:#93c5fd;">{{ e(\Str::limit($product->name, 60)) }}</span>"&gt;</div>
                            @endif
                            @if(is_array($product->authors))
                                @foreach($product->authors as $au)
                                <div style="color:#86efac;">&lt;meta name="<span style="color:#fde68a;">citation_author</span>" content="<span style="color:#93c5fd;">{{ e($au) }}</span>"&gt;</div>
                                @endforeach
                            @endif
                            @if(!empty($product->publisher_imprint))
                            <div style="color:#86efac;">&lt;meta name="<span style="color:#fde68a;">citation_publisher</span>" content="<span style="color:#93c5fd;">{{ e($product->publisher_imprint) }}</span>"&gt;</div>
                            @endif
                            @if(!empty($product->publication_date))
                            <div style="color:#86efac;">&lt;meta name="<span style="color:#fde68a;">citation_publication_date</span>" content="<span style="color:#93c5fd;">{{ $product->publication_date->format('Y/m/d') }}</span>"&gt;</div>
                            @endif
                            @if(!empty($product->isbn))
                            <div style="color:#86efac;">&lt;meta name="<span style="color:#fde68a;">citation_isbn</span>" content="<span style="color:#93c5fd;">{{ e($product->isbn) }}</span>"&gt;</div>
                            @endif
                            @if(!empty($product->doi))
                            <div style="color:#86efac;">&lt;meta name="<span style="color:#fde68a;">citation_doi</span>" content="<span style="color:#93c5fd;">{{ e($product->doi) }}</span>"&gt;</div>
                            @endif
                            @if(!empty($product->preview_document_path))
                            <div style="color:#86efac;">&lt;meta name="<span style="color:#fde68a;">citation_pdf_url</span>" content="<span style="color:#93c5fd;">{{ asset('storage/'.$product->preview_document_path) }}</span>"&gt;</div>
                            @endif
                            @if(empty($product->authors) && empty($product->isbn) && empty($product->doi) && empty($product->publisher_imprint))
                            <div style="color:#6b7280; font-style:italic;">— Isi data buku terlebih dahulu —</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Checkout & Help Links --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Link Checkout & Teks Bantuan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="help_text" class="form-label">Teks Bantuan (Opsional)</label>
                            <textarea id="help_text" name="help_text" class="form-control" rows="2" placeholder="Contoh: Butuh bantuan atau informasi lebih lanjut mengenai produk ini?">{{ old('help_text', $product->help_text) }}</textarea>
                            <small class="text-muted">Teks ini akan muncul di sidebar atas kontak di halaman detail produk.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="external_link_wa" class="form-label">Link WhatsApp</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-success text-white"><i class="bx bxl-whatsapp fs-20"></i></span>
                                <input type="text" id="external_link_wa" name="external_link_wa" class="form-control" value="{{ old('external_link_wa', $product->external_link_wa) }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="external_link_marketplace" class="form-label">Link Marketplace</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bx bx-store fs-20"></i></span>
                                <input type="text" id="external_link_marketplace" name="external_link_marketplace" class="form-control" value="{{ old('external_link_marketplace', $product->external_link_marketplace) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom Actions --}}
            <div class="p-3 bg-light mb-3 rounded">
                <div class="row justify-content-end g-2">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-outline-secondary px-4 text-nowrap">Update Produk</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-primary px-4 text-nowrap">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@section('script-bottom')
<!-- Quill JS for RTE -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var quill = new Quill('#snow-editor', {
            theme: 'snow',
            placeholder: 'Tuliskan deskripsi produk Anda di sini...',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        var form = document.getElementById('productForm');
        form.onsubmit = function() {
            var descInput = document.getElementById('description_input');
            descInput.value = quill.root.innerHTML;
        };
    });

    function previewImg(event) {
        var reader = new FileReader();
        reader.onload = function() {
            document.getElementById('image-preview').src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
