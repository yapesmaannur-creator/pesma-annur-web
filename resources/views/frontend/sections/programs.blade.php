{{-- Programs Section - Modern Executive Centered Iconify Redesign --}}
<style>
    .annur-program-header {
        text-align: center !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
    }
    .annur-program-header .section-title,
    .annur-program-header h2 {
        text-align: center !important;
        margin-left: auto !important;
        margin-right: auto !important;
        width: 100% !important;
        display: block !important;
    }
    .annur-program-card-centered {
        padding: 34px 26px;
        border-radius: var(--radius-md);
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        box-shadow: var(--card-shadow);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center !important;
    }
    .annur-program-card-centered:hover {
        transform: translateY(-6px);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.45);
    }
    .annur-program-icon-badge {
        width: 58px;
        height: 58px;
        min-width: 58px;
        border-radius: 16px;
        background: linear-gradient(135deg, #071526 0%, #102A4C 100%);
        border: 1px solid rgba(201, 162, 39, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 22px rgba(7, 21, 38, 0.2);
        transition: transform 0.3s ease;
    }
    .annur-program-card-centered:hover .annur-program-icon-badge {
        transform: scale(1.1) rotate(4deg);
        background: linear-gradient(135deg, #0B1F3A 0%, #163660 100%);
    }
    .annur-program-desc-centered {
        font-size: 14px;
        color: #334155;
        line-height: 1.65;
        margin-bottom: 0;
        text-align: center !important;
    }
    body.active-dark-mode .annur-program-desc-centered {
        color: #CBD5E1;
    }
</style>

<div class="section py-5" style="background: var(--ivory-bg);">
    <div class="container py-3">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-12 annur-program-header">
                @if($section->subtitle)
                <span class="eyebrow mb-2 text-center mx-auto" style="background: rgba(201, 162, 39, 0.1); padding: 5px 18px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25); display: inline-flex !important; align-items: center; justify-content: center;">
                    {{ strtoupper($section->subtitle) }}
                </span>
                @endif

                <h2 class="section-title mt-2 text-center mx-auto" style="font-size: 34px; font-weight: 800; letter-spacing: -0.02em; text-align: center !important; width: 100% !important; margin-left: auto !important; margin-right: auto !important;">
                    {!! $section->title ?? 'Program Pembinaan & Akademik' !!}
                </h2>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @php
               $programsList = [];
               if (class_exists('\App\Models\Program')) {
                   $rawList = \App\Models\Program::where('is_active', true)->orderBy('id', 'asc')->get();
                   $seenTitles = [];
                   
                   foreach ($rawList as $prog) {
                        $titleLower = strtolower(trim($prog->title));
                        
                        // Skip exact duplicate titles
                        if (in_array($titleLower, $seenTitles)) {
                            continue;
                        }

                        // Skip redundant legacy program entries
                        if (str_contains($titleLower, 'pendidikan bahasa arab')) {
                            continue;
                        }

                        $seenTitles[] = $titleLower;
                        $programsList[] = $prog;
                    }
                   
                   if (!request()->is('program') && !request()->is('program/*')) {
                       $programsList = array_slice($programsList, 0, 6);
                   }
               }
               $iconifyProgramIcons = [
                   'solar:book-2-bold-duotone',
                   'solar:diploma-bold-duotone',
                   'solar:users-group-two-rounded-bold-duotone',
                   'solar:target-bold-duotone',
                   'solar:star-circle-bold-duotone',
                   'solar:medal-star-bold-duotone'
               ];
            @endphp

            @forelse($programsList as $index => $program)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="annur-program-card-centered">
                    <div class="annur-program-icon-badge mb-3">
                        @if(!empty($program->icon))
                            <iconify-icon icon="{{ $program->icon }}" style="font-size: 28px; color: #E8C766;"></iconify-icon>
                        @elseif(!empty($program->image))
                            <img src="{{ asset('storage/' . $program->image) }}" alt="{{ $program->title }}" style="width: 28px; height: 28px; object-fit: contain;">
                        @else
                            <iconify-icon icon="{{ $iconifyProgramIcons[$index % count($iconifyProgramIcons)] }}" style="font-size: 28px; color: #E8C766;"></iconify-icon>
                        @endif
                    </div>
                    <h3 style="font-size: 17.5px; font-weight: 800; color: var(--text-main); margin-bottom: 12px; line-height: 1.35; text-align: center !important;">{{ $program->title }}</h3>
                    <p class="annur-program-desc-centered flex-grow-1">{!! strip_tags($program->description) !!}</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-4">
                <p class="text-muted">Belum ada program yang tersedia.</p>
            </div>
            @endforelse
        </div>

        @if(!request()->is('program') && !request()->is('program/*'))
            <div class="text-center mt-5">
                @if($section->button_text && $section->button_url)
                    <a class="btn-gold" href="{{ $section->button_url }}" style="min-height: 46px; font-size: 14px; padding: 0 26px; color: #071526 !important; font-weight: 700;">
                        {{ $section->button_text }}
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-2" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                    </a>
                @else
                    <a class="btn-gold" href="{{ url('/program') }}" style="min-height: 46px; font-size: 14px; padding: 0 26px; color: #071526 !important; font-weight: 700;">
                        Lihat Semua Program
                        <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-2" style="font-size: 16px; vertical-align: middle;"></iconify-icon>
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>