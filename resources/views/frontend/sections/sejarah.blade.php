{{-- Sejarah / History Timeline Section - Modern Animated Interactive Redesign --}}
<style>
    .sejarah-area {
        position: relative;
        padding: 85px 0;
        background: radial-gradient(circle at 90% 10%, rgba(11, 31, 58, 0.04) 0%, transparent 60%), var(--ivory-bg);
        overflow: hidden;
    }

    .sejarah-header {
        text-align: center;
        margin-bottom: 60px;
    }

    .sejarah-timeline {
        position: relative;
        padding: 20px 0;
    }

    .sejarah-timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(180deg, #C9A227 0%, #0B1F3A 50%, #C9A227 100%);
        border-radius: 3px;
        box-shadow: 0 0 10px rgba(201, 162, 39, 0.2);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 50px;
        display: flex;
        align-items: flex-start;
        opacity: 0;
        transform: translateY(35px);
        transition: opacity 0.7s cubic-bezier(0.165, 0.84, 0.44, 1), transform 0.7s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .timeline-item.in-view {
        opacity: 1;
        transform: translateY(0);
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item .timeline-dot {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: linear-gradient(135deg, #E8C766 0%, #C9A227 100%);
        border: 4px solid var(--card-bg, #ffffff);
        box-shadow: 0 0 0 4px rgba(201, 162, 39, 0.25), 0 0 15px rgba(201, 162, 39, 0.4);
        z-index: 2;
        top: 24px;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    .timeline-item:hover .timeline-dot {
        transform: translateX(-50%) scale(1.4);
        background: #C9A227;
        box-shadow: 0 0 0 8px rgba(201, 162, 39, 0.3), 0 0 25px rgba(201, 162, 39, 0.7);
    }

    .timeline-item .timeline-content {
        width: 45%;
        background: var(--card-bg);
        border-radius: var(--radius-md);
        padding: 32px;
        box-shadow: var(--card-shadow);
        border: 1px solid var(--border-color);
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
    }

    .timeline-item:nth-child(odd) .timeline-content {
        margin-right: auto;
    }
    .timeline-item:nth-child(even) .timeline-content {
        margin-left: auto;
    }

    .timeline-item .timeline-content:hover {
        transform: translateY(-6px) scale(1.01);
        box-shadow: var(--card-shadow-hover);
        border-color: rgba(201, 162, 39, 0.4);
    }

    .timeline-year-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 700;
        color: var(--gold-primary);
        background: rgba(201, 162, 39, 0.12);
        border: 1px solid rgba(201, 162, 39, 0.25);
        padding: 5px 16px;
        border-radius: 50px;
        margin-bottom: 14px;
        letter-spacing: 0.04em;
        transition: all 0.3s ease;
    }

    .timeline-item:hover .timeline-year-badge {
        background: var(--gold-primary);
        color: #071526;
    }

    .timeline-content h3 {
        font-size: 21px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 12px;
        line-height: 1.35;
        letter-spacing: -0.01em;
    }

    .timeline-content .body-text {
        font-size: 15px;
        line-height: 1.75;
        color: var(--text-main);
        text-align: justify;
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .sejarah-timeline::before {
            left: 20px;
        }
        .timeline-item .timeline-dot {
            left: 20px;
        }
        .timeline-item .timeline-content {
            width: calc(100% - 60px);
            margin-left: auto !important;
            margin-right: 0 !important;
        }
    }
</style>

<div class="sejarah-area">
    <div class="container">
        {{-- Section Header --}}
        <div class="sejarah-header">
            @if($section->subtitle)
                <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                    {{ strtoupper($section->subtitle) }}
                </span>
            @endif
            @if($section->title)
                <h2 class="section-title mt-2" style="font-size: 34px; font-weight: 800;">{!! $section->title !!}</h2>
            @endif
            @if($section->content && !$section->items->count())
                <p style="max-width: 740px; margin: 16px auto 0; font-size: 16px; color: var(--text-muted); line-height: 1.75; text-align: justify;">
                    {!! strip_tags($section->content) !!}
                </p>
            @endif
        </div>

        {{-- Featured Gallery Row --}}
        @if($section->image || $section->image2 || $section->image3)
        <div class="mb-5">
            <div class="row g-4 justify-content-center">
                @if($section->image)
                <div class="{{ ($section->image2 || $section->image3) ? 'col-lg-6' : 'col-lg-10' }}">
                    <div style="border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--card-shadow); border: 1px solid var(--border-color); height: 320px; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <img src="{{ asset('storage/' . $section->image) }}" alt="Pesma An-Nur" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                @endif
                @if($section->image2)
                <div class="col-lg-{{ $section->image3 ? '3' : '6' }}">
                    <div style="border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--card-shadow); border: 1px solid var(--border-color); height: 320px; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <img src="{{ asset('storage/' . $section->image2) }}" alt="Pesma An-Nur" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                @endif
                @if($section->image3)
                <div class="col-lg-3">
                    <div style="border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--card-shadow); border: 1px solid var(--border-color); height: 320px; transition: transform 0.4s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                        <img src="{{ asset('storage/' . $section->image3) }}" alt="Pesma An-Nur" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Interactive Timeline Items --}}
        @if($section->items->count())
        <div class="sejarah-timeline">
            @foreach($section->items as $index => $item)
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    @if($item->subtitle)
                    <span class="timeline-year-badge">
                        <i class="feather-calendar me-1"></i> {{ $item->subtitle }}
                    </span>
                    @endif
                    <h3>{{ $item->title }}</h3>
                    @if($item->content)
                        <div class="body-text">{!! $item->content !!}</div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
            @if($section->content)
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="p-4" style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); font-size: 15.5px; line-height: 1.8; color: var(--text-main); text-align: justify;">
                        {!! $section->content !!}
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.timeline-item');
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });

            items.forEach(item => observer.observe(item));
        } else {
            items.forEach(item => item.classList.add('in-view'));
        }
    });
</script>
