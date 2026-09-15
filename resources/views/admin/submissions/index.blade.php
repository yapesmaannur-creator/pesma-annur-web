@extends('layouts.vertical', ['title' => 'Daftar Kiriman Tulisan'])

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title">Daftar Kiriman Tulisan (Review)</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <strong>Gagal memproses review!</strong> Periksa kesalahan berikut:
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pengirim</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $item)
                            <tr>
                                <td>{{ $submissions->firstItem() + $loop->index }}</td>
                                <td>{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <strong>{{ $item->author_name }}</strong><br>
                                    <small class="text-muted">{{ $item->author_email }}</small>
                                </td>
                                <td>{{ \Illuminate\Support\Str::limit($item->title, 50) }}</td>
                                <td>
                                    @if($item->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu Review</span>
                                    @elseif($item->status == 'approved')
                                        <span class="badge bg-success">Disetujui & Publish</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}" title="Lihat & Review">
                                        <iconify-icon icon="solar:eye-bold-duotone" class="align-middle fs-16"></iconify-icon> Review
                                    </button>
                                    <form action="{{ route('admin.submissions.destroy', $item->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Hapus data kiriman ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <iconify-icon icon="solar:trash-bin-trash-bold-duotone" class="align-middle fs-16"></iconify-icon>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Review Modal -->
                            <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="reviewModalLabel{{ $item->id }}">Review Kiriman: {{ $item->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <h6>Informasi Penulis</h6>
                                                <p class="mb-1"><strong>Nama:</strong> {{ $item->author_name }}</p>
                                                <p class="mb-1"><strong>Email:</strong> {{ $item->author_email }}</p>
                                                <p class="mb-0"><strong>Telepon:</strong> {{ $item->author_phone ?? '-' }}</p>
                                            </div>
                                            <hr>
                                            <div class="mb-3 text-break">
                                                <h6>Isi Tulisan</h6>
                                                <div class="p-3 bg-light rounded" style="max-height: 300px; overflow-y: auto;">
                                                    {!! nl2br(e($item->content)) !!}
                                                </div>
                                            </div>
                                            @if($item->attachment_path)
                                            <div class="mb-3">
                                                <h6>Lampiran</h6>
                                                <a href="{{ asset('storage/' . $item->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Lihat / Unduh Dokumen</a>
                                            </div>
                                            @endif
                                            
                                            <hr>
                                            <form action="{{ route('admin.submissions.update', $item->id) }}" method="POST" id="formReview{{ $item->id }}">
                                                @csrf @method('PUT')
                                                <div class="mb-3">
                                                    <label class="form-label">Tindakan Review <span class="text-danger">*</span></label>
                                                    <select name="status" class="form-select" required onchange="toggleCategorySelect('{{ $item->id }}', this.value)">
                                                        <option value="">-- Pilih Tindakan --</option>
                                                        <option value="approved" {{ $item->status == 'approved' ? 'selected' : '' }}>Setujui & Publikasikan</option>
                                                        <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Tolak / Minta Revisi</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="mb-3 d-none" id="categoryGroup{{ $item->id }}">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tindakan Lanjutan <span class="text-danger">*</span></label>
                                                        <select name="post_status" class="form-select">
                                                            <option value="draft" selected>Simpan sebagai Draft (Proses Copy Editing)</option>
                                                            <option value="publish">Langsung Publikasikan Live (Tanpa Edit)</option>
                                                        </select>
                                                        <small class="text-muted">Masukkan tulisan ke ruang redaksi (draft) atau lempar ke publik.</small>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Pilih Kategori Artikel <span class="text-danger">*</span></label>
                                                        <select name="category_id" class="form-select">
                                                            <option value="">-- Kategori --</option>
                                                            @foreach(\App\Models\Category::all() as $cat)
                                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <small class="text-muted">Kategori diperlukan jika status Disetujui.</small>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Catatan untuk Penulis (Opsional)</label>
                                                    <textarea name="admin_notes" class="form-control" rows="3" placeholder="Misal: Tulisan bagus, tapi mohon perbaiki bagian...">{{ $item->admin_notes }}</textarea>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" form="formReview{{ $item->id }}" class="btn btn-primary">Simpan Keputusan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Belum ada kiriman tulisan baru.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $submissions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleCategorySelect(id, value) {
        const group = document.getElementById('categoryGroup' + id);
        const categorySelect = group.querySelector('select[name="category_id"]');
        const postStatusSelect = group.querySelector('select[name="post_status"]');
        if (value === 'approved') {
            group.classList.remove('d-none');
            categorySelect.setAttribute('required', 'required');
            postStatusSelect.setAttribute('required', 'required');
        } else {
            group.classList.add('d-none');
            categorySelect.removeAttribute('required');
            postStatusSelect.removeAttribute('required');
        }
    }
</script>
@endsection
