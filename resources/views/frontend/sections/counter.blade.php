{{-- Stats / Counter Section - Deep Navy Executive Redesign --}}
<style>
    .annur-counter-section {
        background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important;
        position: relative;
        overflow: hidden;
        border-top: 1px solid rgba(201, 162, 39, 0.2);
        border-bottom: 1px solid rgba(201, 162, 39, 0.2);
    }
    .annur-counter-card {
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(201, 162, 39, 0.25);
        border-radius: var(--radius-md);
        padding: 36px 24px;
        text-align: center;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        height: 100%;
    }
    .annur-counter-card:hover {
        transform: translateY(-6px);
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(232, 199, 102, 0.6);
        box-shadow: 0 18px 40px rgba(201, 162, 39, 0.2);
    }
    .annur-counter-card .counter-number {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 46px;
        font-weight: 800;
        color: #E8C766 !important;
        line-height: 1;
        margin-bottom: 10px;
        letter-spacing: -0.02em;
    }
    .annur-counter-card .counter-label {
        font-size: 15px;
        font-weight: 700;
        color: rgba(255, 255, 255, 0.9);
        letter-spacing: 0.02em;
    }
</style>

<div class="section annur-counter-section py-5">
    <div class="container py-4">
        @if($section->title || $section->subtitle)
        <div class="text-center mb-5">
            @if($section->subtitle)
                <span class="eyebrow mb-2" style="background: rgba(232, 199, 102, 0.15); color: #E8C766; padding: 5px 18px; border-radius: 50px; border: 1px solid rgba(232, 199, 102, 0.35); font-weight: 700;">
                    {{ strtoupper($section->subtitle) }}
                </span>
            @endif
            @if($section->title)
                <h2 class="section-title mt-2" style="font-size: 34px; font-weight: 800; color: #FFFFFF !important; letter-spacing: -0.02em;">{!! $section->title !!}</h2>
            @endif
        </div>
        @endif

        <div class="row g-4 justify-content-center">
            @php
                $defaultIcons = ['feather-users', 'feather-award', 'feather-calendar', 'feather-book-open'];
            @endphp
            @foreach($section->items as $index => $item)
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="annur-counter-card">
                    <div class="icon-circle mx-auto mb-3" style="width: 50px; height: 50px; border-radius: 50%; background: rgba(201, 162, 39, 0.15); border: 1px solid rgba(201, 162, 39, 0.35); display: flex; align-items: center; justify-content: center; color: #E8C766; font-size: 20px;">
                        @if(!empty($item->icon) && str_contains($item->icon, ':'))
                            <iconify-icon icon="{{ $item->icon }}" style="font-size: 24px; color: #E8C766;"></iconify-icon>
                        @else
                            @php
                                $solarCounterIcons = ['solar:users-group-two-rounded-bold-duotone', 'solar:medal-star-bold-duotone', 'solar:calendar-bold-duotone', 'solar:book-2-bold-duotone'];
                            @endphp
                            <iconify-icon icon="{{ $solarCounterIcons[$index % count($solarCounterIcons)] }}" style="font-size: 24px; color: #E8C766;"></iconify-icon>
                        @endif
                    </div>
                    @php
                        $number = preg_replace('/[^0-9]/', '', $item->description ?? '0');
                        $hasPlus = str_contains($item->description ?? '', '+');
                    @endphp
                    <div class="counter-number">
                        <span class="odometer" data-count="{{ $number }}">0</span>{{ $hasPlus ? '+' : '' }}
                    </div>
                    <div class="counter-label">{{ $item->title }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                var el = entry.target;
                var count = el.getAttribute('data-count');
                if (count) {
                    el.innerHTML = count;
                }
                observer.unobserve(el);
            }
        });
    }, { threshold: 0.3 });
    document.querySelectorAll('.odometer').forEach(function(el) {
        observer.observe(el);
    });
});
</script>
@endpush
