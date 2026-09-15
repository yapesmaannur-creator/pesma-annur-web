{{-- Team Section - Ultra-Modern Interactive Redesign --}}
<style>
    .team-card-executive {
        background: var(--card-bg);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }
    .team-card-executive:hover {
        transform: translateY(-8px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.4);
    }
    .team-avatar-container {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid var(--gold-primary);
        box-shadow: 0 8px 24px rgba(201, 162, 39, 0.25);
        transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .team-card-executive:hover .team-avatar-container {
        transform: scale(1.08);
        box-shadow: 0 12px 30px rgba(201, 162, 39, 0.4);
    }
    .team-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .team-card-executive:hover .team-avatar-img {
        transform: scale(1.05);
    }
</style>

<div class="section py-5" style="background: radial-gradient(circle at 50% 90%, rgba(11, 31, 58, 0.05) 0%, transparent 60%), var(--sand-accent);">
    <div class="container py-3">
        <div class="row mb-5 text-center">
            <div class="col-lg-12">
                <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                    {{ strtoupper($section->subtitle ?? 'TIM KAMI') }}
                </span>
                <h2 class="section-title mt-2" style="font-size: 34px; font-weight: 800; letter-spacing: -0.02em;">
                    {!! $section->title ?? 'Pengajar & Pengasuh Pesantren' !!}
                </h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @foreach($section->items as $index => $item)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="team-card-executive h-100 text-center p-4">
                    <!-- Team Avatar Image -->
                    <div class="team-avatar-container mb-3 mx-auto">
                        <img class="team-avatar-img" src="{{ $item->image ? asset('storage/' . $item->image) : asset('frontend/assets/images/team/team-1' . (($index % 4) + 1) . '.png') }}" alt="{{ $item->title }}">
                    </div>

                    <!-- Team Details -->
                    <h4 style="font-size: 17.5px; font-weight: 800; color: var(--text-main); margin-bottom: 6px; letter-spacing: -0.01em;">{{ $item->title }}</h4>
                    <p style="font-size: 13.5px; color: var(--gold-primary); font-weight: 700; margin-bottom: 14px;">{{ $item->description }}</p>

                    @if($item->url)
                    <div class="pt-2">
                        <a href="{{ $item->url }}" target="_blank" class="btn-outline-navy" style="min-height: 38px; font-size: 12.5px; padding: 0 18px; display: inline-flex; align-items: center; gap: 6px; border-radius: 50px;">
                            Profil Lengkap
                            <i class="feather-arrow-right"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>