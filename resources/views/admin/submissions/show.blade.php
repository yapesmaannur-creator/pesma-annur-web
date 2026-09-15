@extends('layouts.vertical', ['title' => 'Review Tulisan'])

@section('content')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Detail Kiriman Tulisan</h4>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $submission->title }}</h3>
                <div class="d-flex gap-3 mb-4 pb-3 border-bottom">
                    <div>
                        <small class="text-muted d-block">Pengirim</small>
                        <strong>{{ $submission->author_name }}</strong>
                    </div>
                    <div>
                        <small class="text-muted d-block">Email</small>
                        <a href="mailto:{{ $submission->author_email }}">{{ $submission->author_email }}</a>
                    </div>
                    @if($submission->author_phone)
                    <div>
                        <small class="text-muted d-block">WhatsApp/HP</small>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $submission->author_phone) }}" target="_blank">{{ $submission->author_phone }}</a>
                    </div>
                    @endif
                    <div>
                        <small class="text-muted d-block">Tanggal Kirim</small>
                        <span>{{ $submission->created_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>

                <div class="post-content" style="font-size: 1.05rem; line-height: 1.8;">
                    {!! nl2br(e($submission->content)) !!}
                </div>

                @if($submission->attachment_path)
                <div class="mt-4 pt-3 border-top">
                    <h5>Lampiran File</h5>
                    <a href="{{ asset('storage/' . $submission->attachment_path) }}" target="_blank" class="btn btn-outline-primary">
                        <i class="bx bx-download"></i> Download / Lihat Lampiran
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <h4 class="card-title mb-0">Tindakan Review</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Status Saat Ini</label>
                    <div class="mb-2">
                        @if($submission->status == 'pending')
                            <span class="badge bg-warning fs-13 py-1 px-2">Menunggu Review</span>
                        @elseif($submission->status == 'approved')
                            <span class="badge bg-success fs-13 py-1 px-2">Disetujui & Publish</span>
                        @else
                            <span class="badge bg-danger fs-13 py-1 px-2">Ditolak</span>
                        @endif
                    </div>
                </div>

                @if($submission->status == 'pending')
                <form action="{{ route('admin.submissions.update', $submission->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Ubah Status</label>
                        <select id="status" name="status" class="form-select" onchange="toggleCategorySelect(this.value)">
                            <option value="pending" selected>Biarkan Pending</option>
                            <option value="approved">Setujui & Publikasikan</option>
                            <option value="rejected">Tolak Tulisan</option>
                        </select>
                    </div>

                    <div class="mb-3" id="categoryGroup" style="display: none;">
                        <div class="mb-3">
                            <label for="post_status" class="form-label">Tindakan Lanjutan <span class="text-danger">*</span></label>
                            <select id="post_status" name="post_status" class="form-select">
                                <option value="draft" selected>Simpan sebagai Draft (Proses Copy Editing)</option>
                                <option value="publish">Langsung Publikasikan Live (Tanpa Edit)</option>
                            </select>
                            <small class="text-muted">Masukkan tulisan ke ruang redaksi (draft) atau lempar ke publik.</small>
                        </div>
                        
                        <label for="category_id" class="form-label">Pilih Kategori Artikel <span class="text-danger">*</span></label>
                        <select id="category_id" name="category_id" class="form-select">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(\App\Models\Category::all() as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Kategori diperlukan jika status Disetujui.</small>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">Catatan Admin (Opsional)</label>
                        <textarea id="admin_notes" name="admin_notes" class="form-control" rows="3" placeholder="Alasan penolakan atau catatan internal...">{{ old('admin_notes', $submission->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Simpan Keputusan</button>
                </form>
                @else
                <div class="alert alert-info border-primary mt-3">
                    <i class="bx bx-check-circle text-primary"></i> Artikel ini sudah di-review. <br>
                    <strong>Catatan Keputusan:</strong> {{ $submission->admin_notes ?? '-' }}
                </div>
                @endif
                
                <hr class="my-4 border-dashed">
                <h5 class="card-title fw-bold">Kirim Pesan / Minta Revisi via Email</h5>
                <p class="text-muted small mb-3">Gunakan form di bawah untuk mengirim pesan langsung (misal: meminta revisi tulisan tambahan) ke email <strong>{{ $submission->author_email }}</strong> kapanpun walau statusnya masih pending.</p>
                
                <form action="{{ route('admin.submissions.follow_up', $submission->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="followup_message" class="form-control" rows="4" required placeholder="Contoh: Halo Mas, tolong kalimat ketiga ditambahkan penjelasan lebih rinci..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning text-dark fw-bold w-100 mb-2"><i class="bx bx-envelope"></i> Kirim Permintaan Revisi/Pesan</button>
                </form>

                @if($submission->status === 'approved')
                <hr class="my-4 border-dashed">
                <h5 class="card-title fw-bold text-success"><i class="bx bx-broadcast"></i> Beri Tahu Penulis (Artikel Telah Tayang)</h5>
                <p class="text-muted small mb-3">Jika sebelumnya artikel disimpan sebagai Draft (Copy Editing) dan <strong>sekarang sudah tayang usai penyuntingan</strong>, masukkan link URL artikel tersebut ke sini agar sistem menotifikasi penulis bahwa karyanya berhasil Rilis secara mutlak.</p>
                <form action="{{ route('admin.submissions.notify_live', $submission->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="url" name="post_link" class="form-control border-success" required placeholder="https://domain.com/artikel/judul-tulisan...">
                    </div>
                    <button type="submit" class="btn btn-success w-100"><i class="bx bx-send"></i> Kirim Notifikasi Tayang</button>
                </form>
                @endif
                
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-outline-secondary w-100 mt-3">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleCategorySelect(status) {
        if (status === 'approved') {
            document.getElementById('categoryGroup').style.display = 'block';
            document.getElementById('category_id').required = true;
        } else {
            document.getElementById('categoryGroup').style.display = 'none';
            document.getElementById('category_id').required = false;
        }
    }
</script>

@endsection
