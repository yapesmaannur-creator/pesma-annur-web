{{-- Features Section - Compact Luxury Redesign --}}
<style>
    .annur-why-wrapper {
        padding: 40px 0;
    }
    .annur-why-header {
        text-align: center;
        margin-bottom: 32px;
    }
    .annur-why-header .eyebrow-badge {
        display: inline-block;
        padding: 4px 16px;
        background: rgba(201, 162, 39, 0.1);
        color: var(--gold-primary, #C9A227);
        border: 1px solid rgba(201, 162, 39, 0.25);
        border-radius: 50px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.1em;
        margin-bottom: 8px;
    }
    .annur-why-header h2 {
        font-size: 28px;
        font-weight: 800;
        color: var(--text-main, #071526);
        letter-spacing: -0.02em;
        margin: 0;
    }
    .annur-why-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
    }
    @media (max-width: 991px) {
        .annur-why-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 576px) {
        .annur-why-grid { grid-template-columns: 1fr; gap: 14px; }
        .annur-why-wrapper { padding: 24px 0; }
        .annur-why-header h2 { font-size: 22px; }
    }
    .annur-why-card {
        background: #ffffff;
        border: 1px solid rgba(7, 21, 38, 0.08);
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: 0 4px 20px rgba(7, 21, 38, 0.04);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
    }
    .annur-why-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(7, 21, 38, 0.1);
        border-color: rgba(201, 162, 39, 0.4);
    }
    .annur-why-icon-box {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(201, 162, 39, 0.15) 0%, rgba(201, 162, 39, 0.05) 100%);
        border: 1px solid rgba(201, 162, 39, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold-primary, #C9A227);
        transition: transform 0.3s ease;
    }
    .annur-why-card:hover .annur-why-icon-box {
        transform: scale(1.08);
        background: var(--gold-primary, #C9A227);
        color: #ffffff;
    }
    .annur-why-card h3 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main, #071526);
        margin-bottom: 4px;
        line-height: 1.3;
    }
    .annur-why-card p {
        font-size: 13px;
        color: var(--text-muted, #64748b);
        line-height: 1.5;
        margin: 0;
    }
</style>

<div class="container annur-why-wrapper">
    <div class="annur-why-header">
        @if($section->subtitle)
        <span class="eyebrow-badge">
            {{ strtoupper($section->subtitle) }}
        </span>
        @endif
        <h2>{!! $section->title ?? 'Mengapa Memilih An-Nur?' !!}</h2>
    </div>

    <div class="annur-why-grid">
        @php
            $iconifyIcons = [
                'solar:home-smile-angle-bold-duotone',
                'solar:user-speak-bold-duotone',
                'solar:book-bookmark-bold-duotone',
                'solar:users-group-rounded-bold-duotone',
                'solar:target-bold-duotone',
                'solar:shield-star-bold-duotone'
            ];
        @endphp

        @foreach($section->items as $index => $item)
        <div class="annur-why-card">
            <div class="annur-why-icon-box">
                <iconify-icon icon="{{ $iconifyIcons[$index % count($iconifyIcons)] }}" style="font-size: 22px;"></iconify-icon>
            </div>
            <div>
                <h3>{{ $item->title }}</h3>
                <p>{{ $item->description }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>