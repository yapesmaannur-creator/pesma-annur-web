@extends('layouts.vertical', ['title' => 'Manajemen Menu'])

@section('css')
<style>
/* Nestable CSS */
.cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
* html .cf { zoom: 1; }
*:first-child+html .cf { zoom: 1; }
.dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }
.dd-item,
.dd-empty,
.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
.dd-handle { display: block; height: 45px; margin: 5px 0; padding: 12px 15px; color: #333; text-decoration: none; font-weight: 500; border: 1px solid #e0e0e0; background: #fff; border-radius: 5px; box-sizing: border-box; cursor: grab; display: flex; align-items: center; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.dd-handle:hover { color: #2ea8e5; background: #fdfdfd; }
.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 12px 5px 12px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }
.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 45px; background: #f2f2f2; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; border-radius: 5px; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5; background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff); background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff); background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff), linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff); background-size: 60px 60px; background-position: 0 0, 30px 30px; }
.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; opacity: 0.8; }
.dd-dragel .dd-placeholder { display: none; }
.item-actions { position: absolute; right: 10px; top: 12px; z-index: 50; }
</style>
@endsection

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h4 class="page-title mb-1">Manajemen Menu</h4>
        <p class="text-muted mb-0">Atur tautan navigasi Landing Page dengan mudah menggunakan drag and drop.</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success border-0 shadow-sm badge-soft-success mb-4">
    <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-18 align-middle me-1"></iconify-icon> {{ session('success') }}
</div>
@endif

<div class="row">
    <!-- Panel Kiri: Tambah Menu / Pilih Menu -->
    <div class="col-lg-4">
        <!-- Pilih Menu Aktif -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <form action="{{ route('admin.menus.builder') }}" method="GET" class="d-flex align-items-center gap-2">
                    <select name="menu_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Menu --</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ $currentMenu && $currentMenu->id == $menu->id ? 'selected' : '' }}>{{ $menu->name }} ({{ $menu->location }})</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <!-- Buat Menu Baru -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title fw-semibold m-0">Buat Menu Koleksi Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menus.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-medium">Nama Menu</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Menu Utama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Lokasi (Opsional)</label>
                        <select name="location" class="form-select">
                            <option value="header">Header Navigasi</option>
                            <option value="footer">Footer Menu</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Simpan Menu</button>
                </form>
            </div>
        </div>

        <!-- Tambah Item Baru ke Menu -->
        @if($currentMenu)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title fw-semibold m-0">Tambah Tautan Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.menus.items.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $currentMenu->id }}">
                    
                    <div class="mb-3">
                        <label class="form-label fw-medium">Judul Tautan <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Tentang Kami | Beranda" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-medium">URL Tautan <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" placeholder="Contoh: /about atau https://google.com" required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100 rounded-pill">
                        <iconify-icon icon="solar:plus-circle-bold-duotone" class="align-middle me-1"></iconify-icon> Tambahkan ke Struktur
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <!-- Panel Kanan: Struktur Drag and Drop -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm min-vh-100">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title fw-semibold m-0">
                    Struktur Navigasi: <span class="text-primary">{{ $currentMenu ? $currentMenu->name : 'Belum Ada Menu Terpilih' }}</span>
                </h5>
                @if($currentMenu)
                    <button class="btn btn-sm btn-primary px-3 rounded-pill" id="saveMenuBtn">
                        <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Posisi
                    </button>
                @endif
            </div>
            <div class="card-body bg-light bg-opacity-50">
                @if(!$currentMenu)
                    <div class="text-center py-5 text-muted">
                        <iconify-icon icon="solar:cursor-square-broken" class="fs-48 mb-2"></iconify-icon>
                        <p>Silakan buat atau pilih menu di sebelah kiri untuk mulai mengatur tata letak.</p>
                    </div>
                @else
                    <div class="dd" id="nestable">
                        <ol class="dd-list">
                            @foreach($items as $item)
                                @include('admin.menus.partials.item', ['item' => $item])
                            @endforeach
                        </ol>
                    </div>
                    
                    @if($items->isEmpty())
                        <div class="text-center py-5 text-muted">
                            <iconify-icon icon="solar:link-broken-bold-duotone" class="fs-48 mb-2"></iconify-icon>
                            <p>Menu ini belum memiliki tautan. Tambahkan dari panel kiri.</p>
                        </div>
                    @else
                        <div class="alert alert-info border-0 mt-4 fs-13">
                            <iconify-icon icon="solar:info-circle-bold-duotone" class="align-middle me-1 fs-16"></iconify-icon> <strong>Tips:</strong> Tarik dan lepas (Drag & Drop) kotak tautan di atas untuk mengubah urutan. Geser sedikit ke kanan untuk menjadikannya Sub-menu (Dropdown). Jangan lupa klik "Simpan Posisi" setelah selesai.
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Item Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <div class="modal-header border-bottom">
        <h5 class="modal-title fw-semibold">Edit Tautan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-body p-4">
              <div class="mb-3">
                  <label class="form-label fw-medium">Judul Tautan Terbaru</label>
                  <input type="text" name="title" id="editTitle" class="form-control" required>
              </div>
              <div class="mb-3">
                  <label class="form-label fw-medium">URL / Alamat Baru</label>
                  <input type="text" name="url" id="editUrl" class="form-control" required>
              </div>
          </div>
          <div class="modal-footer border-top bg-light">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script-bottom')
@if($currentMenu)
<script>
    window.addEventListener('load', function() {
        // Ensure the template's bundled jQuery is ready
        if (typeof window.$ !== 'undefined') {
            
            // CRITICAL FIX: Nestable relies on window.jQuery, but Vite bundles often only expose window.$ 
            if (typeof window.jQuery === 'undefined') {
                window.jQuery = window.$;
            }

            // Dynamically load nestable and attach to global jQuery
            var script = document.createElement('script');
            script.src = "https://cdnjs.cloudflare.com/ajax/libs/Nestable/2012-10-15/jquery.nestable.min.js";
            script.onload = function() {
                
                $('#nestable').nestable({
                    maxDepth: 3 // Max 3 levels of dropdowns
                });

                $('#saveMenuBtn').on('click', function() {
                    var btn = $(this);
                    btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
                    
                    var serializedData = window.JSON.stringify($('#nestable').nestable('serialize'));

                    $.ajax({
                        url: "{{ route('admin.menus.reorder') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            menu_info: serializedData
                        },
                        success: function(res) {
                            if(res.success) {
                                alert('Posisi dan hierarki (sub-menu) berhasil disimpan!');
                            }
                        },
                        complete: function() {
                            btn.prop('disabled', false).html('<iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1"></iconify-icon> Simpan Posisi');
                        }
                    });
                });

                // Edit Modal Filler
                $('.edit-item-btn').on('click', function() {
                    var url = $(this).data('action');
                    var title = $(this).data('title');
                    var link = $(this).data('url');

                    $('#editForm').attr('action', url);
                    $('#editTitle').val(title);
                    $('#editUrl').val(link);
                    
                    if (typeof bootstrap !== 'undefined') {
                        var myModal = new bootstrap.Modal(document.getElementById('editModal'));
                        myModal.show();
                    } else {
                        $('#editModal').modal('show');
                    }
                });
            };
            document.body.appendChild(script);
        } else {
            console.error('jQuery is not loaded by the template. Nestable cannot initialize.');
        }
    });
</script>
@endif
@endsection
