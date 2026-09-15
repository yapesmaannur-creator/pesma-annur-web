{{-- Activities / Events Section - Executive Navy Redesign --}}
<style>
    .annur-activity-card {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .annur-activity-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.4);
    }
    .annur-activity-img {
        position: relative;
        height: 220px;
        overflow: hidden;
    }
    .annur-activity-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .annur-activity-card:hover .annur-activity-img img {
        transform: scale(1.05);
    }
    .annur-activity-date-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(7, 21, 38, 0.9);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(201, 162, 39, 0.4);
        color: #FFFFFF;
        border-radius: 12px;
        padding: 6px 14px;
        text-align: center;
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
    }
</style>

@php
    $activities = \App\Models\Activity::where('is_active', true)->latest()->take(3)->get();
    $items = $section->items->count() > 0 ? $section->items : $activities;
@endphp

<div class="section py-5" style="background: var(--sand-accent);">
    <div class="container py-3">
        <div class="row mb-5 text-center">
            <div class="col-lg-12">
                <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                    {{ strtoupper($section->subtitle ?? 'KEGIATAN & EVENT') }}
                </span>
                <h2 class="section-title mt-2" style="font-size: 34px; font-weight: 800; letter-spacing: -0.02em;">
                    {!! $section->title ?? 'Agenda & Kegiatan Terbaru' !!}
                </h2>
            </div>
        </div>

        <div class="row g-4">
            @foreach($items as $item)
                @php
                    $imageUrl = isset($item->image) && !empty($item->image) ? asset('storage/' . $item->image) : asset('frontend/assets/images/event/grid-type-0' . ($loop->iteration % 6 + 1) . '.jpg');
                    $date = isset($item->date) && !empty($item->date) ? \Carbon\Carbon::parse($item->date) : now();
                    $detailUrl = isset($item->slug) ? route('activity.detail', $item->slug) : '#';
                @endphp
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="annur-activity-card">
                        <div class="annur-activity-img">
                            <a href="{{ $detailUrl }}">
                                <img src="{{ $imageUrl }}" alt="{{ $item->title ?? 'Kegiatan Pesma An-Nur' }}">
                            </a>
                            <div class="annur-activity-date-badge">
                                <div style="font-size: 16px; font-weight: 800; color: #E8C766; line-height: 1;">{{ $date->format('d') }}</div>
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase;">{{ $date->format('M Y') }}</div>
                            </div>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center gap-3 mb-3" style="font-size: 13px; color: var(--text-muted);">
                                <span><iconify-icon icon="solar:map-point-bold-duotone" class="me-1" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon>{{ $item->location ?? 'Pesantren An-Nur' }}</span>
                                <span><iconify-icon icon="solar:clock-circle-bold-duotone" class="me-1" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon>
                                    @if(isset($item->time_start) && $item->time_start)
                                        {{ \Carbon\Carbon::parse($item->time_start)->format('H:i') }} WIB
                                    @else
                                        {{ $date->format('H:i') }} WIB
                                    @endif
                                </span>
                            </div>

                            <h4 style="font-size: 17.5px; font-weight: 800; line-height: 1.4; margin-bottom: 14px;" class="flex-grow-1">
                                <a href="{{ $detailUrl }}" style="color: var(--text-main); text-decoration: none;">{{ $item->title ?? 'Kegiatan Santri' }}</a>
                            </h4>

                            <div class="pt-2">
                                <a class="btn-outline-navy w-100" href="{{ $detailUrl }}" style="min-height: 40px; font-size: 13px;">
                                    Detail Kegiatan
                                    <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
