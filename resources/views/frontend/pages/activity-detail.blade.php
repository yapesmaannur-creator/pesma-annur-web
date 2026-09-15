@extends('frontend.layouts.app')

@section('meta_title', $activity->title . ' - Detail Kegiatan')
@section('meta_description', Str::limit(strip_tags($activity->description), 160))

@section('content')
<!-- EXECUTIVE NAVY BANNER HERO -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 50px 0 45px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <ul style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; margin-bottom: 12px; font-size: 13px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li><a href="{{ url('/#kegiatan') }}" style="color: rgba(255,255,255,0.85); text-decoration: none;">Kegiatan</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li style="color: #E8C766; font-weight: 600;">Detail Kegiatan</li>
        </ul>

        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <span style="padding: 4px 14px; background: rgba(232, 199, 102, 0.18); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; margin-bottom: 10px; letter-spacing: 0.04em;">
                    {{ strtoupper($activity->status_label ?? 'KEGIATAN SANTRI') }}
                </span>
                <h1 style="color: #FFFFFF !important; font-size: clamp(24px, 3.2vw, 36px); font-weight: 800; line-height: 1.25; margin: 0; letter-spacing: -0.02em;">
                    {{ $activity->title }}
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <div class="row g-5">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($activity->image)
                <div class="mb-4" style="border-radius: var(--radius-md); overflow: hidden; border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <img class="w-100" src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" style="max-height: 480px; object-fit: cover; object-position: top center;">
                </div>
                @endif

                <div class="p-4 p-md-5 mb-4" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <h3 style="font-size: 20px; font-weight: 800; color: var(--text-main); margin-bottom: 16px;">Deskripsi Kegiatan</h3>
                    <div style="font-size: 15.5px; line-height: 1.8; color: var(--text-main);">
                        {!! nl2br(e($activity->description)) !!}
                    </div>

                    @if($activity->registration_link && $activity->status !== 'completed' && $activity->status !== 'cancelled')
                    <div class="mt-5 text-center pt-4 border-top" style="border-color: var(--border-color) !important;">
                        <a class="btn-gold" href="{{ $activity->registration_link }}" target="_blank" style="min-height: 46px; padding: 0 28px; font-size: 14.5px; color: #071526 !important; font-weight: 800;">
                            Daftar Sekarang <i class="feather-arrow-right ms-2"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <div class="p-4" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); position: sticky; top: 100px;">
                    <h4 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid var(--border-color);">
                        Informasi Kegiatan
                    </h4>

                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(201, 162, 39, 0.12); border: 1px solid rgba(201, 162, 39, 0.3); display: flex; align-items: center; justify-content: center; color: var(--gold-primary); font-size: 20px; flex-shrink: 0;">
                                <iconify-icon icon="solar:calendar-bold-duotone"></iconify-icon>
                            </div>
                            <div>
                                <small style="font-size: 11.5px; color: var(--text-muted); font-weight: 600; display: block;">TANGGAL</small>
                                <span style="font-size: 14px; font-weight: 700; color: var(--text-main);">{{ $activity->date ? $activity->date->translatedFormat('d F Y') : 'TBA' }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(201, 162, 39, 0.12); border: 1px solid rgba(201, 162, 39, 0.3); display: flex; align-items: center; justify-content: center; color: var(--gold-primary); font-size: 20px; flex-shrink: 0;">
                                <iconify-icon icon="solar:clock-circle-bold-duotone"></iconify-icon>
                            </div>
                            <div>
                                <small style="font-size: 11.5px; color: var(--text-muted); font-weight: 600; display: block;">WAKTU</small>
                                <span style="font-size: 14px; font-weight: 700; color: var(--text-main);">
                                    @if($activity->time_start)
                                        {{ \Carbon\Carbon::parse($activity->time_start)->format('H:i') }}{{ $activity->time_end ? ' - ' . \Carbon\Carbon::parse($activity->time_end)->format('H:i') : '' }} WIB
                                    @else
                                        TBA
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(201, 162, 39, 0.12); border: 1px solid rgba(201, 162, 39, 0.3); display: flex; align-items: center; justify-content: center; color: var(--gold-primary); font-size: 20px; flex-shrink: 0;">
                                <iconify-icon icon="solar:map-point-bold-duotone"></iconify-icon>
                            </div>
                            <div>
                                <small style="font-size: 11.5px; color: var(--text-muted); font-weight: 600; display: block;">LOKASI</small>
                                <span style="font-size: 14px; font-weight: 700; color: var(--text-main);">{{ $activity->location ?? 'TBA' }}</span>
                            </div>
                        </div>

                        @if($activity->organizer)
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 42px; height: 42px; border-radius: 12px; background: rgba(201, 162, 39, 0.12); border: 1px solid rgba(201, 162, 39, 0.3); display: flex; align-items: center; justify-content: center; color: var(--gold-primary); font-size: 20px; flex-shrink: 0;">
                                <iconify-icon icon="solar:users-group-two-rounded-bold-duotone"></iconify-icon>
                            </div>
                            <div>
                                <small style="font-size: 11.5px; color: var(--text-muted); font-weight: 600; display: block;">PENYELENGGARA</small>
                                <span style="font-size: 14px; font-weight: 700; color: var(--text-main);">{{ $activity->organizer }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
