@extends('layouts.vertical', ['title' => 'Tambah Produk'])

@section('css')
    <!-- Quill CSS for Rich Text Editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection

@section('content')

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    <div class="row">
        {{-- Sidebar Preview --}}
        <div class="col-xl-3 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <img id="image-preview" src="https://ui-avatars.com/api/?name=Cover+Buku&background=f8f9fa&color=6c757d&size=600&font-size=0.15" alt="Preview" class="img-fluid rounded bg-light">
                    <div class="mt-3">
                        <h4 id="preview-name">Nama Produk</h4>
                        <h5 class="text-dark fw-medium mt-3">Harga :</h5>
                        <h4 class="fw-semibold text-dark mt-2 d-flex align-items-center justify-content-center gap-2">
                            <span class="text-muted text-decoration-line-through" id="preview-price-old"></span>
                            <span id="preview-price">Rp 0</span>
                        </h4>
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
                        <span class="text-muted fs-13">Format: PNG, JPG, GIF. Maksimal 2MB.</span>
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
                                <input type="text" id="product-name" name="name" class="form-control" placeholder="Contoh: Buku Edukasi" value="{{ old('name') }}" required oninput="document.getElementById('preview-name').textContent=this.value||'Nama Produk'">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="product-sku" class="form-label">Kode SKU</label>
                                <input type="text" id="product-sku" name="sku" class="form-control" placeholder="Contoh: BK-EDU-001" value="{{ old('sku') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Produk</label>
                                <div id="snow-editor" style="height: 300px;">{!! old('description') !!}</div>
                                <input type="hidden" name="description" id="description_input">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" checked>
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
                            <input type="text" id="authors" name="authors" class="form-control" placeholder="Contoh: John Doe, Jane Smith" value="{{ old('authors') }}">
                            <small class="text-muted">Pisahkan nama dengan koma jika lebih dari satu.</small>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="editors" class="form-label">Editor</label>
                            <input type="text" id="editors" name="editors" class="form-control" placeholder="Contoh: Ali, Budi" value="{{ old('editors') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="translators" class="form-label">Penerjemah</label>
                            <input type="text" id="translators" name="translators" class="form-control" placeholder="Contoh: Ahmad, Siti" value="{{ old('translators') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="edition" class="form-label">Edisi</label>
                            <input type="text" id="edition" name="edition" class="form-control" placeholder="1st Edition" value="{{ old('edition') }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="publication_date" class="form-label">Tanggal Rilis (Published)</label>
                            <input type="date" id="publication_date" name="publication_date" class="form-control" value="{{ old('publication_date') }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="pages" class="form-label">Jumlah Halaman</label>
                            <input type="number" id="pages" name="pages" class="form-control" placeholder="250" value="{{ old('pages') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 mb-3">
                            <label for="publisher_imprint" class="form-label">Imprint / Penerbit</label>
                            <input type="text" id="publisher_imprint" name="publisher_imprint" class="form-control" placeholder="Routledge" value="{{ old('publisher_imprint') }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="publication_location" class="form-label">Lokasi Terbit</label>
                            <input type="text" id="publication_location" name="publication_location" class="form-control" placeholder="London" value="{{ old('publication_location') }}">
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" id="isbn" name="isbn" class="form-control" placeholder="978xxxxxx" value="{{ old('isbn') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="doi" class="form-label">Link DOI</label>
                            <input type="url" id="doi" name="doi" class="form-control" placeholder="https://doi.org/10.xxxx" value="{{ old('doi') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="subjects" class="form-label">Subjek / Area Studi</label>
                            <input type="text" id="subjects" name="subjects" class="form-control" placeholder="Humanities, Education" value="{{ old('subjects') }}">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-lg-12">
                            <label for="preview_document_path" class="form-label">Preview Dokumen (PDF) untuk Pratinjau Buku</label>
                            <input type="file" id="preview_document_path" name="preview_document_path" class="form-control" accept=".pdf">
                            <small class="text-muted">Maksimal 10MB. Biasanya berisi Daftar Isi atau Bab 1.</small>
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
                                <input type="number" id="product-price" name="price" class="form-control" placeholder="0" value="{{ old('price', 0) }}" required min="0">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label for="product-discount" class="form-label">Harga Diskon</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text fs-20"><i class='bx bxs-discount'></i></span>
                                <input type="number" id="product-discount" name="discount_price" class="form-control" placeholder="0" value="{{ old('discount_price') }}" min="0">
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
                                <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Judul untuk Google" value="{{ old('meta_title') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="meta_keywords" class="form-label">Kata Kunci SEO</label>
                                <input type="text" id="meta_keywords" name="meta_keywords" class="form-control" placeholder="Contoh: buku, edukasi, premium" value="{{ old('meta_keywords') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" class="form-control" rows="2" placeholder="Ringkasan singkat untuk hasil pencarian">{{ old('meta_description') }}</textarea>
                            </div>
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
                            <textarea id="help_text" name="help_text" class="form-control" rows="2" placeholder="Contoh: Butuh bantuan atau informasi lebih lanjut mengenai produk ini?">{{ old('help_text') }}</textarea>
                            <small class="text-muted">Teks ini akan muncul di sidebar atas kontak di halaman detail produk.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="external_link_wa" class="form-label">Link WhatsApp</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-success text-white"><i class="bx bxl-whatsapp fs-20"></i></span>
                                <input type="text" id="external_link_wa" name="external_link_wa" class="form-control" placeholder="https://wa.me/628xxx" value="{{ old('external_link_wa') }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="external_link_marketplace" class="form-label">Link Marketplace</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bx bx-store fs-20"></i></span>
                                <input type="text" id="external_link_marketplace" name="external_link_marketplace" class="form-control" placeholder="Link Tokopedia / Shopee" value="{{ old('external_link_marketplace') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bottom Actions --}}
            <div class="p-3 bg-light mb-3 rounded">
                <div class="row justify-content-end g-2">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-outline-secondary px-4 text-nowrap">Simpan Produk</button>
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
