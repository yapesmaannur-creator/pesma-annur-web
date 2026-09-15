{{-- Contact Section - Executive Redesign --}}
<style>
    .annur-contact-card {
        background: var(--card-bg, #ffffff);
        border: 1px solid var(--border-color, #e2e8f0);
        border-radius: 18px;
        padding: 24px 20px;
        box-shadow: 0 10px 25px rgba(11, 31, 58, 0.05);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        align-items: flex-start;
        gap: 16px;
    }
    .annur-contact-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px rgba(11, 31, 58, 0.1);
        border-color: rgba(201, 162, 39, 0.4);
    }
    .annur-contact-icon {
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #071526 0%, #102A4C 100%);
        border: 1px solid rgba(201, 162, 39, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #E8C766;
    }
    .annur-contact-info h4 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main, #0F172A);
        margin-bottom: 4px;
    }
    .annur-contact-info p, .annur-contact-info a {
        font-size: 13.5px;
        color: var(--text-muted, #475569);
        margin: 0;
        text-decoration: none;
    }
    .annur-contact-info a:hover {
        color: #C9A227;
    }
    .annur-social-links {
        display: flex;
        gap: 10px;
        margin-top: 6px;
    }
    .annur-social-links a {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #F1F5F9;
        border: 1px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #071526;
        transition: all 0.25s ease;
    }
    .annur-social-links a:hover {
        background: #C9A227;
        color: #071526;
        border-color: #C9A227;
        transform: scale(1.1);
    }
</style>

<div class="section py-5" style="background: var(--ivory-bg, #F8FAFC);">
    <div class="container py-3">
        <div class="text-center mb-5">
            <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 18px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                {{ strtoupper($section->subtitle ?? 'HUBUNGI KAMI') }}
            </span>
            <h2 class="section-title mt-2" style="font-size: 34px; font-weight: 800; letter-spacing: -0.02em; text-align: center;">
                {!! $section->title ?? 'Hubungi Kami' !!}
            </h2>
        </div>

        @php
            $address = \App\Models\Setting::getByKey('contact_address', 'Jl. Kebangkitan No. 123, Surabaya');
            $phone = \App\Models\Setting::getByKey('contact_phone', '+62 812-3456-7890');
            $email = \App\Models\Setting::getByKey('contact_email', 'info@pesma-annur.net');
            $hours = \App\Models\Setting::getByKey('contact_hours', 'Senin - Sabtu (08.00 - 21.00 WIB)');
            $ig = \App\Models\Setting::getByKey('social_instagram', '#');
            $fb = \App\Models\Setting::getByKey('social_facebook', '#');
            $yt = \App\Models\Setting::getByKey('social_youtube', '#');
        @endphp

        <div class="row g-4 justify-content-center">
            <!-- 1. Lokasi -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="annur-contact-card">
                    <div class="annur-contact-icon">
                        <iconify-icon icon="solar:map-point-wave-bold-duotone" style="font-size: 24px;"></iconify-icon>
                    </div>
                    <div class="annur-contact-info">
                        <h4>Lokasi</h4>
                        <p>{!! nl2br(e($address)) !!}</p>
                    </div>
                </div>
            </div>

            <!-- 2. Telepon -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="annur-contact-card">
                    <div class="annur-contact-icon">
                        <iconify-icon icon="solar:phone-calling-bold-duotone" style="font-size: 24px;"></iconify-icon>
                    </div>
                    <div class="annur-contact-info">
                        <h4>Telepon / WhatsApp</h4>
                        <p><a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phone) }}" target="_blank">{{ $phone }}</a></p>
                    </div>
                </div>
            </div>

            <!-- 3. Email -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="annur-contact-card">
                    <div class="annur-contact-icon">
                        <iconify-icon icon="solar:letter-bold-duotone" style="font-size: 24px;"></iconify-icon>
                    </div>
                    <div class="annur-contact-info">
                        <h4>Email</h4>
                        <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
                    </div>
                </div>
            </div>

            <!-- 4. Jam Operasional -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="annur-contact-card">
                    <div class="annur-contact-icon">
                        <iconify-icon icon="solar:clock-circle-bold-duotone" style="font-size: 24px;"></iconify-icon>
                    </div>
                    <div class="annur-contact-info">
                        <h4>Jam Operasional</h4>
                        <p>{{ $hours }}</p>
                    </div>
                </div>
            </div>

            <!-- 5. Media Sosial -->
            <div class="col-lg-4 col-md-6 col-12">
                <div class="annur-contact-card">
                    <div class="annur-contact-icon">
                        <iconify-icon icon="solar:share-bold-duotone" style="font-size: 24px;"></iconify-icon>
                    </div>
                    <div class="annur-contact-info">
                        <h4>Media Sosial</h4>
                        <div class="annur-social-links">
                            @if($ig)<a href="{{ $ig }}" target="_blank" title="Instagram"><iconify-icon icon="solar:instagram-bold-duotone" style="font-size: 16px;"></iconify-icon></a>@endif
                            @if($fb)<a href="{{ $fb }}" target="_blank" title="Facebook"><iconify-icon icon="solar:facebook-bold-duotone" style="font-size: 16px;"></iconify-icon></a>@endif
                            @if($yt)<a href="{{ $yt }}" target="_blank" title="YouTube"><iconify-icon icon="solar:videocamera-record-bold-duotone" style="font-size: 16px;"></iconify-icon></a>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
