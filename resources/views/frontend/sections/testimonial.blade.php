{{-- Testimonial Section - Executive Navy Marquee Redesign --}}
<style>
    .annur-testimonial-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        padding: 24px;
        margin: 0 10px;
        min-width: 320px;
        max-width: 340px;
        transition: all 0.3s ease;
    }
    .annur-testimonial-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.35);
    }
    .annur-testimonial-avatar {
        width: 50px !important;
        height: 50px !important;
        min-width: 50px !important;
        max-width: 50px !important;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 2px solid var(--gold-primary) !important;
        flex-shrink: 0 !important;
    }
    .scroll-animation.scroll-right-left {
        animation-duration: 35s !important;
    }
    .scroll-animation.scroll-left-right {
        animation-duration: 35s !important;
    }
    .scroll-animation-wrapper::before,
    .scroll-animation-wrapper::after,
    .scroll-animation-all-wrapper::before,
    .scroll-animation-all-wrapper::after {
        display: none !important;
    }
</style>

<div class="section py-5 overflow-hidden" style="background: var(--sand-accent);">
    <div class="container-fluid py-3">
        <div class="row g-5 align-items-center">
            <!-- Kolom Kiri: Title & CTA -->
            <div class="col-xl-3">
                <div class="ps-xl-4 pe-xl-2">
                    <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                        {{ strtoupper($section->subtitle ?? 'TESTIMONI SANTRI') }}
                    </span>
                    <h2 class="section-title mt-2 mb-3" style="font-size: 32px; font-weight: 800; letter-spacing: -0.02em;">
                        {!! $section->title ?? 'Apa Kata Santri & Alumni Pesantren An-Nur' !!}
                    </h2>
                    <p class="mb-4" style="font-size: 14.5px; color: var(--text-muted); line-height: 1.6;">
                        {{ $section->description ?? 'Inilah pengalaman dan kesan nyata dari para santri dan alumni kami.' }}
                    </p>

                    @if($section->button_text && $section->button_url)
                        <a class="btn-gold" href="{{ $section->button_url }}" style="min-height: 44px; font-size: 13.5px; padding: 0 22px; color: #071526 !important; font-weight: 700;">
                            {{ $section->button_text }}
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-2" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                        </a>
                    @else
                        <a class="btn-gold" href="{{ route('contact') }}" style="min-height: 44px; font-size: 13.5px; padding: 0 22px; color: #071526 !important; font-weight: 700;">
                            Hubungi Kami
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-2" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Kolom Kanan: Smooth Infinite Marquee Carousel -->
            <div class="col-xl-9 overflow-hidden">
                @php
                   $testimonials = collect();
                   if (class_exists('\App\Models\Testimonial')) {
                       $testimonials = \App\Models\Testimonial::where('is_active', true)->limit(12)->get();
                   }
                   $half = (int) ceil($testimonials->count() / 2);
                   $row1 = $testimonials->slice(0, $half);
                   $row2 = $testimonials->slice($half);

                   $placeholders = [
                       ['name' => 'Ahmad Fauzi', 'position' => 'Santri Angkatan 2023', 'message' => 'Tinggal di pesantren ini benar-benar mengubah cara pandang saya. Pembinaannya luar biasa dan penuh kasih!', 'img' => 1],
                       ['name' => 'Siti Rahma', 'position' => 'Santri Angkatan 2022', 'message' => 'Lingkungan yang kondusif dan ustadz yang sabar dalam membimbing. Sangat bersyukur bisa di sini.', 'img' => 2],
                       ['name' => 'Muhammad Haris', 'position' => 'Alumni 2021', 'message' => 'Ilmu yang saya dapat di pesantren ini menjadi bekal berharga dalam kehidupan sehari-hari saya.', 'img' => 3],
                       ['name' => 'Fatimah Zahra', 'position' => 'Santri Angkatan 2024', 'message' => 'Program tahfidz dan kajian kitabnya sangat terstruktur. Saya semakin semangat belajar setiap hari!', 'img' => 4],
                       ['name' => 'Rizki Pratama', 'position' => 'Alumni 2020', 'message' => 'Pesantren ini mengajarkan kemandirian dan tanggung jawab sejak dini. Sangat berpengaruh bagi saya.', 'img' => 5],
                       ['name' => 'Nur Hidayah', 'position' => 'Santri Angkatan 2023', 'message' => 'Metode pengajaran yang modern namun tetap menjaga nilai-nilai Islam. Benar-benar luar biasa!', 'img' => 6],
                   ];
                   $placeholderRow1 = array_slice($placeholders, 0, 3);
                   $placeholderRow2 = array_slice($placeholders, 3, 3);
                @endphp

                <!-- Row 1: Marquee Right-to-Left -->
                <div class="scroll-animation-wrapper py-2">
                    <div class="scroll-animation scroll-right-left d-flex align-items-center">
                        @if($row1->count() > 0)
                            @foreach($row1 as $index => $t)
                            <div class="annur-testimonial-card">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img class="annur-testimonial-avatar" src="{{ $t->image ? asset('storage/' . $t->image) : asset('frontend/assets/images/testimonial/client-0' . (($index % 8) + 1) . '.png') }}" alt="{{ $t->name }}">
                                    <div>
                                        <h5 style="font-size: 15px; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2;">{{ $t->name }}</h5>
                                        <span style="font-size: 12.5px; color: var(--gold-primary); font-weight: 600;">{{ $t->position ?? 'Santri' }}</span>
                                    </div>
                                </div>
                                <p style="font-size: 14px; color: var(--text-main); line-height: 1.6; margin: 0; text-align: justify;">{{ $t->message }}</p>
                            </div>
                            @endforeach
                            {{-- Duplicate for smooth infinite loop --}}
                            @foreach($row1 as $index => $t)
                            <div class="annur-testimonial-card">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img class="annur-testimonial-avatar" src="{{ $t->image ? asset('storage/' . $t->image) : asset('frontend/assets/images/testimonial/client-0' . (($index % 8) + 1) . '.png') }}" alt="{{ $t->name }}">
                                    <div>
                                        <h5 style="font-size: 15px; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2;">{{ $t->name }}</h5>
                                        <span style="font-size: 12.5px; color: var(--gold-primary); font-weight: 600;">{{ $t->position ?? 'Santri' }}</span>
                                    </div>
                                </div>
                                <p style="font-size: 14px; color: var(--text-main); line-height: 1.6; margin: 0; text-align: justify;">{{ $t->message }}</p>
                            </div>
                            @endforeach
                        @else
                            @foreach($placeholderRow1 as $index => $p)
                            <div class="annur-testimonial-card">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img class="annur-testimonial-avatar" src="{{ asset('frontend/assets/images/testimonial/client-0' . $p['img'] . '.png') }}" alt="{{ $p['name'] }}">
                                    <div>
                                        <h5 style="font-size: 15px; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2;">{{ $p['name'] }}</h5>
                                        <span style="font-size: 12.5px; color: var(--gold-primary); font-weight: 600;">{{ $p['position'] }}</span>
                                    </div>
                                </div>
                                <p style="font-size: 14px; color: var(--text-main); line-height: 1.6; margin: 0; text-align: justify;">{{ $p['message'] }}</p>
                            </div>
                            @endforeach
                            @foreach($placeholderRow1 as $index => $p)
                            <div class="annur-testimonial-card">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img class="annur-testimonial-avatar" src="{{ asset('frontend/assets/images/testimonial/client-0' . $p['img'] . '.png') }}" alt="{{ $p['name'] }}">
                                    <div>
                                        <h5 style="font-size: 15px; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2;">{{ $p['name'] }}</h5>
                                        <span style="font-size: 12.5px; color: var(--gold-primary); font-weight: 600;">{{ $p['position'] }}</span>
                                    </div>
                                </div>
                                <p style="font-size: 14px; color: var(--text-main); line-height: 1.6; margin: 0; text-align: justify;">{{ $p['message'] }}</p>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>