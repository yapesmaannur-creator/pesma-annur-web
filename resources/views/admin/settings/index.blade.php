@extends('layouts.vertical', ['title' => 'Pengaturan Situs'])

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="page-title mb-1">Pengaturan Global Sistem</h4>
            <p class="text-muted mb-0">Ubah konfigurasi Header, Footer, SEO Global, dan Kontak.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm badge-soft-success mb-4">
            <iconify-icon icon="solar:check-circle-bold-duotone" class="fs-18 align-middle me-1"></iconify-icon>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <!-- Site Info & SEO -->
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm mb-4 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <iconify-icon icon="solar:monitor-bold-duotone" class="fs-20 text-primary me-2"></iconify-icon>
                        <h5 class="card-title fw-semibold m-0">Informasi Situs & SEO Dasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="site_name" class="form-label fw-medium">Nama Web / Lembaga</label>
                            <input type="text" name="site_name" id="site_name" class="form-control"
                                value="{{ $settings['site_name'] ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="site_description" class="form-label fw-medium">Deskripsi Singkat Utama (Meta
                                Description)</label>
                            <textarea name="site_description" id="site_description" rows="3"
                                class="form-control">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="site_keywords" class="form-label fw-medium">Kata Kunci Utama (Meta Keywords)</label>
                            <input type="text" name="site_keywords" id="site_keywords" class="form-control"
                                placeholder="pendidikan, islami, boarding school"
                                value="{{ $settings['site_keywords'] ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="footer_copyright" class="form-label fw-medium">Teks Copyright Footer</label>
                            <input type="text" name="footer_copyright" id="footer_copyright" class="form-control"
                                value="{{ $settings['footer_copyright'] ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="footer_description" class="form-label fw-medium">Deskripsi Pendek Footer</label>
                            <textarea name="footer_description" id="footer_description" rows="3"
                                class="form-control">{{ $settings['footer_description'] ?? '' }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="newsletter_description" class="form-label fw-medium">Teks Ajakan Newsletter</label>
                            <textarea name="newsletter_description" id="newsletter_description" rows="2"
                                class="form-control">{{ $settings['newsletter_description'] ?? '' }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="footer_col2_title" class="form-label fw-medium">Judul Kolom 2 Footer</label>
                                <input type="text" name="footer_col2_title" id="footer_col2_title" class="form-control"
                                    placeholder="Tautan Cepat" value="{{ $settings['footer_col2_title'] ?? '' }}">
                            </div>
                            <div class="col-4 mb-3">
                                <label for="footer_col3_title" class="form-label fw-medium">Judul Kolom 3 Footer</label>
                                <input type="text" name="footer_col3_title" id="footer_col3_title" class="form-control"
                                    placeholder="Halaman" value="{{ $settings['footer_col3_title'] ?? '' }}">
                            </div>
                            <div class="col-4 mb-3">
                                <label for="footer_col4_title" class="form-label fw-medium">Judul Kolom 4 Footer</label>
                                <input type="text" name="footer_col4_title" id="footer_col4_title" class="form-control"
                                    placeholder="Hubungi Kami" value="{{ $settings['footer_col4_title'] ?? '' }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="credit_text" class="form-label fw-medium">Teks Kredit (Dibuat Oleh)</label>
                                <input type="text" name="credit_text" id="credit_text" class="form-control"
                                    value="{{ $settings['credit_text'] ?? '' }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="credit_link" class="form-label fw-medium">Link Kredit</label>
                                <input type="url" name="credit_link" id="credit_link" class="form-control"
                                    value="{{ $settings['credit_link'] ?? '' }}">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label for="custom_script" class="form-label fw-medium">Custom Script Footer
                                (Analytics/Tags)</label>
                            <textarea name="custom_script" id="custom_script" rows="4" class="form-control font-monospace"
                                placeholder="<script>...</script>">{{ $settings['custom_script'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Social -->
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm mb-4 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <iconify-icon icon="solar:phone-calling-bold-duotone"
                            class="fs-20 text-primary me-2"></iconify-icon>
                        <h5 class="card-title fw-semibold m-0">Kontak & Media Sosial</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="contact_email" class="form-label fw-medium">Alamat Email Publik</label>
                            <input type="email" name="contact_email" id="contact_email" class="form-control"
                                value="{{ $settings['contact_email'] ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="contact_phone" class="form-label fw-medium">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="contact_phone" id="contact_phone" class="form-control"
                                value="{{ $settings['contact_phone'] ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label for="contact_address" class="form-label fw-medium">Alamat Lengkap</label>
                            <textarea name="contact_address" id="contact_address" rows="2"
                                class="form-control">{{ $settings['contact_address'] ?? '' }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="social_facebook" class="form-label fw-medium">Link Facebook</label>
                                <input type="url" name="social_facebook" id="social_facebook" class="form-control"
                                    value="{{ $settings['social_facebook'] ?? '' }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="social_instagram" class="form-label fw-medium">Link Instagram</label>
                                <input type="url" name="social_instagram" id="social_instagram" class="form-control"
                                    value="{{ $settings['social_instagram'] ?? '' }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="social_tiktok" class="form-label fw-medium">Link TikTok</label>
                                <input type="url" name="social_tiktok" id="social_tiktok" class="form-control"
                                    value="{{ $settings['social_tiktok'] ?? '' }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="social_youtube" class="form-label fw-medium">Link YouTube</label>
                                <input type="url" name="social_youtube" id="social_youtube" class="form-control"
                                    value="{{ $settings['social_youtube'] ?? '' }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="social_twitter" class="form-label fw-medium">Link Twitter/X</label>
                                <input type="url" name="social_twitter" id="social_twitter" class="form-control"
                                    value="{{ $settings['social_twitter'] ?? '' }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="social_linkedin" class="form-label fw-medium">Link LinkedIn</label>
                                <input type="url" name="social_linkedin" id="social_linkedin" class="form-control"
                                    value="{{ $settings['social_linkedin'] ?? '' }}">
                            </div>
                        </div>

                        <hr class="my-3">
                        <h6 class="fw-semibold text-primary mb-3"><iconify-icon icon="solar:play-circle-bold-duotone"
                                class="me-1"></iconify-icon> Video YouTube Beranda</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="youtube_channel_id" class="form-label fw-medium">YouTube Channel ID</label>
                                <input type="text" name="youtube_channel_id" id="youtube_channel_id" class="form-control"
                                    placeholder="contoh: UCKZmhY77OUZBs30S_vKhK8A"
                                    value="{{ $settings['youtube_channel_id'] ?? '' }}">
                                <small class="text-muted">ID channel YouTube. Buka YouTube → Channel → URL → ambil bagian setelah /channel/.</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="youtube_api_key" class="form-label fw-medium">YouTube API Key <span class="badge bg-danger-subtle text-danger">Wajib</span></label>
                                <input type="text" name="youtube_api_key" id="youtube_api_key" class="form-control"
                                    placeholder="contoh: AIzaSyC..."
                                    value="{{ $settings['youtube_api_key'] ?? '' }}">
                                <small class="text-muted">API Key dari <a href="https://console.cloud.google.com/apis/credentials" target="_blank">Google Cloud Console</a>. Aktifkan "YouTube Data API v3" di project Anda.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upload Logos -->
        <div class="row mt-2">
            <div class="col-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <iconify-icon icon="solar:gallery-bold-duotone" class="fs-20 text-primary me-2"></iconify-icon>
                        <h5 class="card-title fw-semibold m-0">Pengaturan Logo Penuh (Terang & Gelap)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <!-- Header Ligh Mode Logo -->
                            <div class="col-md-3 mb-4 px-3 border-end">
                                <label class="form-label fw-medium d-block text-start mb-3">Header Logo (Tema
                                    Terang)</label>
                                <div class="bg-light rounded p-4 mb-3 mx-auto"
                                    style="max-width: 250px; border: 1px dashed #ccc;">
                                    @if(isset($settings['header_logo']) && $settings['header_logo'])
                                        <img src="{{ asset('storage/' . $settings['header_logo']) }}" style="max-height: 80px;"
                                            class="img-fluid" id="hl-preview">
                                    @else
                                        <img src="" style="max-height: 80px;" class="img-fluid d-none" id="hl-preview">
                                        <span class="text-muted d-block my-2" id="hl-text">Belum ada logo Terang</span>
                                    @endif
                                </div>
                                <input type="file" name="header_logo" id="header_logo" class="form-control form-control-sm"
                                    accept="image/*" onchange="previewImg(this, 'hl')">
                            </div>

                            <!-- Header Dark Mode Logo -->
                            <div class="col-md-3 mb-4 px-3 border-end">
                                <label class="form-label fw-medium d-block text-start mb-3">Header Logo (Tema Gelap)</label>
                                <div class="bg-dark rounded p-4 mb-3 mx-auto"
                                    style="max-width: 250px; border: 1px dashed #666;">
                                    @if(isset($settings['header_logo_dark']) && $settings['header_logo_dark'])
                                        <img src="{{ asset('storage/' . $settings['header_logo_dark']) }}"
                                            style="max-height: 80px;" class="img-fluid" id="hld-preview">
                                    @else
                                        <img src="" style="max-height: 80px;" class="img-fluid d-none" id="hld-preview">
                                        <span class="text-light d-block my-2" id="hld-text">Belum ada logo Gelap</span>
                                    @endif
                                </div>
                                <input type="file" name="header_logo_dark" id="header_logo_dark"
                                    class="form-control form-control-sm" accept="image/*"
                                    onchange="previewImg(this, 'hld')">
                            </div>

                            <!-- Footer Light Mode Logo -->
                            <div class="col-md-3 mb-4 px-3 border-end">
                                <label class="form-label fw-medium d-block text-start mb-3">Footer Logo (Tema
                                    Terang)</label>
                                <div class="bg-light rounded p-4 mb-3 mx-auto"
                                    style="max-width: 250px; border: 1px dashed #ccc;">
                                    @if(isset($settings['footer_logo']) && $settings['footer_logo'])
                                        <img src="{{ asset('storage/' . $settings['footer_logo']) }}" style="max-height: 80px;"
                                            class="img-fluid" id="fl-preview">
                                    @else
                                        <img src="" style="max-height: 80px;" class="img-fluid d-none" id="fl-preview">
                                        <span class="text-muted d-block my-2" id="fl-text">Belum ada logo Footer Terang</span>
                                    @endif
                                </div>
                                <input type="file" name="footer_logo" id="footer_logo" class="form-control form-control-sm"
                                    accept="image/*" onchange="previewImg(this, 'fl')">
                            </div>

                            <!-- Footer Dark Mode Logo -->
                            <div class="col-md-3 mb-4 px-3 border-end">
                                <label class="form-label fw-medium d-block text-start mb-3">Footer Logo (Tema Gelap)</label>
                                <div class="bg-dark rounded p-4 mb-3 mx-auto"
                                    style="max-width: 250px; border: 1px dashed #666;">
                                    @if(isset($settings['footer_logo_dark']) && $settings['footer_logo_dark'])
                                        <img src="{{ asset('storage/' . $settings['footer_logo_dark']) }}"
                                            style="max-height: 80px;" class="img-fluid" id="fld-preview">
                                    @else
                                        <img src="" style="max-height: 80px;" class="img-fluid d-none" id="fld-preview">
                                        <span class="text-light d-block my-2" id="fld-text">Belum ada logo Footer Gelap</span>
                                    @endif
                                </div>
                                <input type="file" name="footer_logo_dark" id="footer_logo_dark"
                                    class="form-control form-control-sm" accept="image/*"
                                    onchange="previewImg(this, 'fld')">
                            </div>

                            <div class="col-md-12 mb-4 px-4 pt-3 border-top">
                                <label class="form-label fw-medium d-block text-start mb-3">Favicon (Ikon Tab)</label>
                                <div class="bg-light rounded p-4 mb-3 mx-auto"
                                    style="max-width: 150px; border: 1px dashed #ccc;">
                                    @if(isset($settings['favicon']) && $settings['favicon'])
                                        <img src="{{ asset('storage/' . $settings['favicon']) }}" style="max-height: 64px;"
                                            class="img-fluid" id="fv-preview">
                                    @else
                                        <img src="" style="max-height: 64px;" class="img-fluid d-none" id="fv-preview">
                                        <span class="text-muted d-block my-2" id="fv-text">Belum ada favicon</span>
                                    @endif
                                </div>
                                <input type="file" name="favicon" id="favicon" class="form-control form-control-sm"
                                    accept="image/png, image/x-icon, image/jpeg" onchange="previewImg(this, 'fv')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Header & WhatsApp Float -->
        <div class="row mt-2">
            <div class="col-xl-6">
                <div class="card border-0 shadow-sm mb-4 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <iconify-icon icon="solar:cursor-bold-duotone" class="fs-20 text-success me-2"></iconify-icon>
                        <h5 class="card-title fw-semibold m-0">Tombol CTA Header</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Tombol ajakan bertindak yang tampil di bagian kanan atas header
                            website.</p>
                        <div class="mb-3">
                            <label for="cta_header_text" class="form-label fw-medium">Teks Tombol CTA</label>
                            <input type="text" name="cta_header_text" id="cta_header_text" class="form-control"
                                placeholder="contoh: Daftar Sekarang"
                                value="{{ $settings['cta_header_text'] ?? 'Daftar Sekarang' }}">
                        </div>
                        <div class="mb-0">
                            <label for="cta_header_url" class="form-label fw-medium">URL Tujuan Tombol CTA</label>
                            <input type="url" name="cta_header_url" id="cta_header_url" class="form-control"
                                placeholder="https://e-maktab.pesma-annur.net/psb"
                                value="{{ $settings['cta_header_url'] ?? '' }}">
                            <small class="text-muted">Masukkan URL lengkap, contoh:
                                https://e-maktab.pesma-annur.net/psb</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card border-0 shadow-sm mb-4 h-100">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <iconify-icon icon="solar:chat-round-call-bold-duotone"
                            class="fs-20 text-success me-2"></iconify-icon>
                        <h5 class="card-title fw-semibold m-0">Tombol WhatsApp Melayang</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">Tombol WhatsApp hijau yang muncul di pojok kanan bawah semua
                            halaman publik.</p>
                        <div class="mb-3">
                            <label for="whatsapp_number" class="form-label fw-medium">Nomor WhatsApp</label>
                            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control"
                                placeholder="contoh: 6281234567890" value="{{ $settings['whatsapp_number'] ?? '' }}">
                            <small class="text-muted">Format internasional tanpa tanda + (contoh: 6281234567890). Jika
                                kosong, akan menggunakan Nomor Telepon di atas.</small>
                        </div>
                        <div class="mb-0">
                            <label for="whatsapp_message" class="form-label fw-medium">Pesan Pembuka WhatsApp</label>
                            <textarea name="whatsapp_message" id="whatsapp_message" rows="2" class="form-control"
                                placeholder="Assalamu'alaikum, saya ingin bertanya...">{{ $settings['whatsapp_message'] ?? "Assalamu'alaikum, saya ingin bertanya tentang Pesantren Mahasiswa An-Nur" }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SEO & Analytics Lanjutan -->
        <div class="row mt-2">
            <div class="col-12">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex align-items-center">
                        <iconify-icon icon="solar:chart-2-bold-duotone" class="fs-20 text-warning me-2"></iconify-icon>
                        <h5 class="card-title fw-semibold m-0">SEO & Analytics Lanjutan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="google_analytics_id" class="form-label fw-medium">Google Analytics Measurement
                                    ID</label>
                                <input type="text" name="google_analytics_id" id="google_analytics_id" class="form-control"
                                    placeholder="G-XXXXXXXXXX" value="{{ $settings['google_analytics_id'] ?? '' }}">
                                <small class="text-muted">Masukkan GA4 Measurement ID. Contoh: G-AB1CD2EF3G</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="og_default_image" class="form-label fw-medium">OG Image Default (Gambar
                                    Share)</label>
                                <div class="d-flex align-items-center gap-3">
                                    <input type="file" name="og_default_image" id="og_default_image" class="form-control"
                                        accept="image/*" onchange="previewImg(this, 'og')">
                                </div>
                                @if(isset($settings['og_default_image']) && $settings['og_default_image'])
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $settings['og_default_image']) }}"
                                            style="max-height: 60px; border-radius:6px;" class="img-fluid border"
                                            id="og-preview">
                                    </div>
                                @else
                                    <img src="" style="max-height: 60px;" class="img-fluid d-none mt-2" id="og-preview">
                                @endif
                                <small class="text-muted">Gambar yang muncul saat halaman di-share di sosial media (maks
                                    1200x630px).</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-end">
                        <button type="submit" class="btn btn-primary fw-medium px-4 py-2">
                            <iconify-icon icon="solar:diskette-bold-duotone" class="align-middle me-1 fs-18"></iconify-icon>
                            Simpan Semua Pengaturan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        function previewImg(input, type) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var txt = document.getElementById(type + '-text');
                    if (txt) txt.classList.add('d-none');

                    var img = document.getElementById(type + '-preview');
                    img.src = e.target.result;
                    img.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection