{{-- About Section - Ultra-Modern Executive Layout --}}
<style>
    .about-card-wrapper {
        position: relative;
        background: var(--card-bg);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        overflow: hidden;
    }
    .about-card-wrapper:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.35);
    }
    .about-img-zoom {
        transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .about-card-wrapper:hover .about-img-zoom {
        transform: scale(1.04);
    }
    .about-badge-icon {
        width: 30px;
        height: 30px;
        min-width: 30px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(201, 162, 39, 0.18) 0%, rgba(232, 199, 102, 0.08) 100%);
        border: 1px solid rgba(201, 162, 39, 0.3);
        color: var(--gold-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: 0 4px 12px rgba(201, 162, 39, 0.12);
        transition: all 0.3s ease;
    }
    .about-item-row:hover .about-badge-icon {
        background: var(--gold-primary);
        color: #071526;
        transform: scale(1.15) rotate(5deg);
    }
    .pillar-badge-box {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }
    .pillar-badge-box:hover {
        border-color: rgba(201, 162, 39, 0.4);
        transform: translateY(-2px);
    }
</style>

<div class="section py-5" style="background: radial-gradient(circle at 10% 20%, rgba(201, 162, 39, 0.05) 0%, transparent 50%), var(--ivory-bg);">
    <div class="container py-4">
        <div class="row g-5 align-items-center">
            <!-- LEFT COLUMN: SIDE-BY-SIDE OR SINGLE IMAGE GRID -->
            <div class="col-lg-6">
                <div class="about-card-wrapper p-3">
                    @if($section->image && $section->image2)
                    <div class="row g-3">
                        <div class="col-6 overflow-hidden" style="border-radius: var(--radius-md);">
                            <img class="about-img-zoom w-100" src="{{ asset('storage/' . $section->image) }}" alt="Pesma An-Nur" style="height: 380px; object-fit: cover; object-position: top center; border-radius: var(--radius-md);">
                        </div>
                        <div class="col-6 overflow-hidden" style="border-radius: var(--radius-md);">
                            <img class="about-img-zoom w-100" src="{{ asset('storage/' . $section->image2) }}" alt="Pesma An-Nur" style="height: 380px; object-fit: cover; object-position: top center; border-radius: var(--radius-md);">
                        </div>
                    </div>
                    @else
                    <div class="overflow-hidden" style="border-radius: var(--radius-md);">
                        <img class="about-img-zoom w-100" src="{{ $section->image ? asset('storage/' . $section->image) : ($section->image2 ? asset('storage/' . $section->image2) : asset('frontend/assets/images/others/arabian.png')) }}" alt="Pesma An-Nur" style="height: 420px; object-fit: cover; object-position: top center; border-radius: var(--radius-md);">
                    </div>
                    @endif
                </div>
            </div>

            <!-- RIGHT COLUMN: CONTENT & 3 CORE PILLARS -->
            <div class="col-lg-6">
                <div class="ps-lg-3">
                    @if($section->subtitle)
                        <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                            {{ strtoupper($section->subtitle) }}
                        </span>
                    @endif

                    <h2 class="section-title mb-4 mt-2" style="font-size: 32px; font-weight: 800; line-height: 1.25; letter-spacing: -0.02em;">
                        {!! $section->title ?? 'Tentang Pesantren Mahasiswa An-Nur' !!}
                    </h2>

                    @if($section->content)
                        <div class="mb-4" style="font-size: 15px; color: var(--text-main); line-height: 1.75; text-align: justify;">
                            {!! $section->content !!}
                        </div>
                    @endif

                    <!-- 3 CORE VALUE PILLARS BADGES -->
                    <div class="row g-2 g-sm-3 mb-4">
                        <div class="col-12 col-sm-4">
                            <div class="pillar-badge-box">
                                <iconify-icon icon="solar:rocket-bold-duotone" style="font-size: 24px; color: var(--gold-primary); flex-shrink: 0;"></iconify-icon>
                                <div>
                                    <strong style="font-size: 13.5px; font-weight: 800; color: var(--text-main); display: block; line-height: 1.2;">Inovatif</strong>
                                    <small style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Keilmuan</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="pillar-badge-box">
                                <iconify-icon icon="solar:users-group-two-rounded-bold-duotone" style="font-size: 24px; color: var(--gold-primary); flex-shrink: 0;"></iconify-icon>
                                <div>
                                    <strong style="font-size: 13.5px; font-weight: 800; color: var(--text-main); display: block; line-height: 1.2;">Kolaboratif</strong>
                                    <small style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Sinergi</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="pillar-badge-box">
                                <iconify-icon icon="solar:lightbulb-bolt-bold-duotone" style="font-size: 24px; color: var(--gold-primary); flex-shrink: 0;"></iconify-icon>
                                <div>
                                    <strong style="font-size: 13.5px; font-weight: 800; color: var(--text-main); display: block; line-height: 1.2;">Produktif</strong>
                                    <small style="font-size: 11px; color: var(--text-muted); font-weight: 600;">Karya Riset</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($section->items && $section->items->count() > 0)
                        <div class="d-flex flex-column gap-3 mb-4">
                            @foreach($section->items as $item)
                            {{-- Skip items yang tidak representatif --}}
                            @php
                                $skipKeywords = ['online', 'offline', 'Online', 'Offline'];
                                $shouldSkip = false;
                                foreach($skipKeywords as $kw) {
                                    if(stripos($item->title, $kw) !== false) { $shouldSkip = true; break; }
                                }
                            @endphp
                            @if($shouldSkip) @continue @endif
                            <div class="about-item-row d-flex align-items-start gap-3 p-2 rounded-3" style="transition: background 0.2s ease;">
                                <div class="about-badge-icon mt-1">
                                    <iconify-icon icon="solar:check-read-bold-duotone" style="font-size: 16px; color: #E8C766; vertical-align: middle;"></iconify-icon>
                                </div>
                                <span style="font-size: 15px; color: var(--text-main); font-weight: 600; line-height: 1.5;">{{ $item->title }}</span>
                            </div>
                            @endforeach
                        </div>
                    @endif

                    @if($section->button_text && $section->button_url)
                    <div class="pt-2">
                        <a class="btn-gold" href="{{ $section->button_url }}" style="min-height: 46px; font-size: 14px; padding: 0 24px; color: #071526 !important; font-weight: 700;">
                            {{ $section->button_text }}
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-2" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>