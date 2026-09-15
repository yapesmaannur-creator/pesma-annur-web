@extends('frontend.layouts.app')

@section('meta_title', 'Kirim Tulisan & Artikel - Pesantren Mahasiswa An-Nur')
@section('meta_description', 'Kirimkan karya ilmiah, opini, dan gagasan Anda untuk dipublikasikan di portal resmi Pesantren Mahasiswa An-Nur Surabaya.')

@section('content')
<!-- INSPIRING HERO BANNER -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 55px 0 50px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <!-- Breadcrumb -->
        <ul style="list-style: none; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 0; margin-bottom: 14px; font-size: 13.5px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li style="color: #E8C766; font-weight: 600;">Kirim Tulisan</li>
        </ul>

        <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.15); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.35); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 12px; letter-spacing: 0.04em;">
            RUANG KARYA & INSPIRASI
        </span>

        <h1 style="color: #FFFFFF !important; font-size: 36px; font-weight: 800; line-height: 1.3; margin-bottom: 10px; letter-spacing: -0.02em;">
            Suarakan Gagasan Terbaik Anda
        </h1>
        <p style="color: rgba(255,255,255,0.85); font-size: 16px; margin: 0; max-width: 680px; line-height: 1.6;">
            Bagikan karya tulis, riset, artikel keislaman, maupun cerita inspiratif Anda untuk menginspirasi ribuan pembaca Pesma An-Nur.
        </p>
    </div>
</div>

<!-- MAIN SUBMISSION WORKSPACE -->
<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">

        @if(session('success'))
            <div class="row justify-content-center mb-4">
                <div class="col-lg-10">
                    <div class="p-3 text-center" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: var(--radius-md); color: #10B981;">
                        <i class="feather-check-circle me-1" style="font-size: 18px;"></i>
                        <strong style="font-size: 15px;">{{ session('success') }}</strong>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-5">
            <!-- LEFT COLUMN: PANDUAN PENULISAN CARD -->
            <div class="col-lg-4 col-12">
                <div class="p-4 h-100" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 100%); border-radius: var(--radius-lg); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: var(--card-shadow); color: #FFFFFF;">
                    <h3 style="color: #FFFFFF !important; font-size: 22px; font-weight: 800; margin-bottom: 20px;">
                        Panduan Penulisan
                    </h3>

                    <ul style="list-style: none; padding: 0; margin: 0;" class="d-flex flex-column gap-3">
                        <li class="d-flex align-items-start gap-3">
                            <div style="width: 26px; height: 26px; min-width: 26px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 12px; margin-top: 2px;">
                                <i class="feather-check"></i>
                            </div>
                            <span style="font-size: 14px; color: rgba(255, 255, 255, 0.85); line-height: 1.5;"><strong style="color: #E8C766;">Karya Asli & Inspiratif:</strong> Tulisan merupakan karya orisinal Anda yang mencerahkan.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <div style="width: 26px; height: 26px; min-width: 26px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 12px; margin-top: 2px;">
                                <i class="feather-check"></i>
                            </div>
                            <span style="font-size: 14px; color: rgba(255, 255, 255, 0.85); line-height: 1.5;"><strong style="color: #E8C766;">Tema Beragam:</strong> Studi Islam, artikel akademik, pendidikan, opini santri, maupun pengalaman positif.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <div style="width: 26px; height: 26px; min-width: 26px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 12px; margin-top: 2px;">
                                <i class="feather-check"></i>
                            </div>
                            <span style="font-size: 14px; color: rgba(255, 255, 255, 0.85); line-height: 1.5;"><strong style="color: #E8C766;">Bahasa Santun:</strong> Menggunakan tata bahasa yang baik, santun, dan bebas SARA.</span>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <div style="width: 26px; height: 26px; min-width: 26px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 12px; margin-top: 2px;">
                                <i class="feather-check"></i>
                            </div>
                            <span style="font-size: 14px; color: rgba(255, 255, 255, 0.85); line-height: 1.5;"><strong style="color: #E8C766;">Penyuntingan Ringan:</strong> Tim editor berhak merapikan tata bahasa tanpa mengubah maksud gagasan Anda.</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- RIGHT COLUMN: FORMULIR PENGIRIMAN -->
            <div class="col-lg-8 col-12">
                <div class="p-4 p-md-5" style="background: var(--card-bg); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <h4 style="font-size: 22px; font-weight: 800; color: var(--text-main); margin-bottom: 8px;">
                        Kirimkan Karya Terbaik Anda
                    </h4>
                    <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 24px;">
                        Isi identitas singkat dan tempelkan naskah Anda di bawah ini untuk ditinjau oleh tim penyunting.
                    </p>

                    <form action="{{ route('submission.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="author_name" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Nama Lengkap Penulis *</label>
                                <input type="text" name="author_name" id="author_name" value="{{ old('author_name') }}" placeholder="Nama lengkap Anda" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none;">
                                @error('author_name') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="author_email" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Email Aktif *</label>
                                <input type="email" name="author_email" id="author_email" value="{{ old('author_email') }}" placeholder="contoh@email.com" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none;">
                                @error('author_email') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="author_phone" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">No. WhatsApp (Opsional)</label>
                                <input type="text" name="author_phone" id="author_phone" value="{{ old('author_phone') }}" placeholder="08xxxxxxxxxx" style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none;">
                                @error('author_phone') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="title" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Judul Naskah / Artikel *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" placeholder="Judul tulisan Anda..." required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none;">
                                @error('title') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label for="content" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Naskah / Isi Tulisan *</label>
                                <textarea name="content" id="content" rows="8" placeholder="Ketik atau tempel naskah artikel Anda di sini..." required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none; resize: vertical;">{{ old('content') }}</textarea>
                                @error('content') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label for="attachment" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Lampiran Berkas (Opsional - PDF/Doc/Gambar, Max 5MB)</label>
                                <input class="form-control" id="attachment" name="attachment" type="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" style="border-radius: 10px; border: 1px solid var(--border-color); font-size: 13.5px;">
                                @error('attachment') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 pt-2">
                                <button type="submit" style="background: linear-gradient(135deg, #C9A227 0%, #E8C766 100%) !important; color: #071526 !important; border: none !important; border-radius: 50px !important; padding: 14px 32px !important; font-size: 14.5px !important; font-weight: 700 !important; cursor: pointer; width: 100%; box-shadow: 0 6px 20px rgba(201, 162, 39, 0.35) !important; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                    <i class="feather-send me-1"></i> Kirim Karya Saya
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
