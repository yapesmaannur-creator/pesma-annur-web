@extends('frontend.layouts.app')

@section('meta_title', 'Hubungi Kami - Pesantren Mahasiswa An-Nur')
@section('meta_description', 'Hubungi pengurus Pesantren Mahasiswa An-Nur Surabaya. Layanan informasi pendaftaran santri, konsultasi, dan silaturahmi.')

@section('content')
<!-- WARM & INVITING HERO BANNER -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 55px 0 50px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <!-- Breadcrumb -->
        <ul style="list-style: none; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 0; margin-bottom: 14px; font-size: 13.5px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li style="color: #E8C766; font-weight: 600;">Kontak Kami</li>
        </ul>

        <span style="padding: 4px 16px; background: rgba(232, 199, 102, 0.15); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.35); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 12px; letter-spacing: 0.04em;">
            KAMI SIAP MENDENGAR & MEMBANTU
        </span>

        <h1 style="color: #FFFFFF !important; font-size: 36px; font-weight: 800; line-height: 1.3; margin-bottom: 10px; letter-spacing: -0.02em;">
            Mari Berhubung & Bersilaturahmi
        </h1>
        <p style="color: rgba(255,255,255,0.85); font-size: 16px; margin: 0; max-width: 650px; line-height: 1.6;">
            Punya pertanyaan seputar pendaftaran mahasantri, kegiatan akademik, atau ingin berkunjung langsung? Layanan informasi Pesantren Mahasiswa An-Nur siap membantu Anda.
        </p>
    </div>
</div>

<!-- MAIN CONTACT WORKSPACE -->
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
            <!-- LEFT COLUMN: PINTU SILATURAHMI CARD -->
            <div class="col-lg-5 col-12">
                <div class="p-4 p-md-5 h-100" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 100%); border-radius: var(--radius-lg); border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: var(--card-shadow); color: #FFFFFF;">
                    <h3 style="color: #FFFFFF !important; font-size: 24px; font-weight: 800; margin-bottom: 12px; letter-spacing: -0.01em;">
                        Sekretariat & Layanan Informasi
                    </h3>
                    <p style="color: rgba(255, 255, 255, 0.8); font-size: 14.5px; line-height: 1.65; margin-bottom: 32px;">
                        Silakan hubungi kami melalui saluran resmi yang tersedia. Pengurus Pesantren Mahasiswa An-Nur siap membantu kebutuhan informasi Anda.
                    </p>

                    <div class="d-flex flex-column gap-4 mb-4">
                        @if(isset($settings['contact_phone']) && $settings['contact_phone'])
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 46px; height: 46px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); border: 1px solid rgba(201, 162, 39, 0.3); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="feather-phone"></i>
                            </div>
                            <div>
                                <small style="color: rgba(255, 255, 255, 0.6); font-size: 12px; display: block; font-weight: 700; letter-spacing: 0.03em;">TELEPON / WHATSAPP</small>
                                <a href="tel:{{ $settings['contact_phone'] }}" style="color: #FFFFFF !important; text-decoration: none; font-weight: 700; font-size: 16px;">{{ $settings['contact_phone'] }}</a>
                            </div>
                        </div>
                        @endif

                        @if(isset($settings['contact_email']) && $settings['contact_email'])
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 46px; height: 46px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); border: 1px solid rgba(201, 162, 39, 0.3); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0;">
                                <i class="feather-mail"></i>
                            </div>
                            <div>
                                <small style="color: rgba(255, 255, 255, 0.6); font-size: 12px; display: block; font-weight: 700; letter-spacing: 0.03em;">EMAIL SURAT & PERTANYAAN</small>
                                <a href="mailto:{{ $settings['contact_email'] }}" style="color: #FFFFFF !important; text-decoration: none; font-weight: 700; font-size: 16px;">{{ $settings['contact_email'] }}</a>
                            </div>
                        </div>
                        @endif

                        @if(isset($settings['contact_address']) && $settings['contact_address'])
                        <div class="d-flex align-items-start gap-3">
                            <div style="width: 46px; height: 46px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); border: 1px solid rgba(201, 162, 39, 0.3); color: #E8C766; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; margin-top: 2px;">
                                <i class="feather-map-pin"></i>
                            </div>
                            <div>
                                <small style="color: rgba(255, 255, 255, 0.6); font-size: 12px; display: block; font-weight: 700; letter-spacing: 0.03em;">LOKASI PESANTREN</small>
                                <span style="color: rgba(255, 255, 255, 0.95); font-weight: 600; font-size: 14.5px; line-height: 1.5; display: block;">{{ $settings['contact_address'] }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: FORMULIR MENYAPA -->
            <div class="col-lg-7 col-12">
                <div class="p-4 p-md-5" style="background: var(--card-bg); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <h4 style="font-size: 22px; font-weight: 800; color: var(--text-main); margin-bottom: 8px;">
                        Tinggalkan Pesan Untuk Kami
                    </h4>
                    <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 24px;">
                        Tuliskan pesan atau pertanyaan Anda di bawah ini, tim kami akan merespons dengan cepat.
                    </p>

                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="name" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Nama Lengkap *</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Ketik nama Anda di sini" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none;">
                                @error('name') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Alamat Email *</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="contoh@email.com" required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none;">
                                @error('email') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label for="subject" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Topik / Subjek Pesan *</label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" placeholder="Misal: Pendaftaran Santri / Informasi Program..." required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none;">
                                @error('subject') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label for="message" style="font-size: 13.5px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: 6px;">Isi Pesan Anda *</label>
                                <textarea name="message" id="message" rows="5" placeholder="Tuliskan detail pertanyaan atau masukan Anda..." required style="width: 100%; border: 1px solid var(--border-color); border-radius: 10px; padding: 12px 16px; background: var(--card-bg); color: var(--text-main); font-size: 14px; outline: none; resize: vertical;">{{ old('message') }}</textarea>
                                @error('message') <small style="color: #e74c3c; font-size: 12px;">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 pt-2">
                                <button type="submit" style="background: linear-gradient(135deg, #C9A227 0%, #E8C766 100%) !important; color: #071526 !important; border: none !important; border-radius: 50px !important; padding: 14px 32px !important; font-size: 14.5px !important; font-weight: 700 !important; cursor: pointer; width: 100%; box-shadow: 0 6px 20px rgba(201, 162, 39, 0.35) !important; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                    <i class="feather-send me-1"></i> Kirim Pesan Sekarang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Google Maps Embed --}}
        @if(isset($settings['google_maps_embed']) && $settings['google_maps_embed'])
        <div class="row mt-5">
            <div class="col-12">
                <div style="border-radius: var(--radius-lg); overflow: hidden; height: 380px; border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    {!! $settings['google_maps_embed'] !!}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
