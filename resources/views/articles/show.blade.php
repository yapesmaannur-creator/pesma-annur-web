@extends('frontend.layouts.app')

@section('meta_title', $article->meta_title ?? $article->title)
@section('meta_description', $article->meta_description ?? $article->excerpt)
@if($article->meta_keywords)
@section('meta_keywords', $article->meta_keywords)
@endif

@if($article->image_path)
@section('meta_image', asset('storage/' . $article->image_path))
@endif

@push('meta')
@if(isset($article) && $article->image_path)
    <meta name="twitter:image" content="{{ asset('storage/' . $article->image_path) }}">
@endif
@endpush

@section('content')
{{-- ===== BANNER PREVIEW MODE (hanya muncul saat admin preview) ===== --}}
@if(isset($isPreview) && $isPreview)
<div style="position: sticky; top: 0; z-index: 9999; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; box-shadow: 0 4px 16px rgba(245,158,11,0.35); font-family: 'Plus Jakarta Sans', sans-serif;">
    <div style="display:flex; align-items:center; gap:10px;">
        <span style="font-size:1.3rem;">🔍</span>
        <div>
            <span style="font-weight: 700; font-size: 15px; letter-spacing: 0.3px;">MODE PREVIEW ARTIKEL</span>
            <span style="margin-left: 10px; font-size: 12px; background: rgba(0,0,0,0.2); padding: 2px 10px; border-radius: 20px; font-weight: 600;">
                {{ $article->published_at ? '✅ PUBLISHED' : '📝 DRAFT' }}
            </span>
            <p style="margin:0; font-size: 12px; opacity: 0.85;">Halaman ini hanya bisa diakses oleh admin dan tidak terlihat oleh publik.</p>
        </div>
    </div>
    <a href="{{ route('admin.posts.edit', $article->id) }}" style="background: rgba(0,0,0,0.25); color: #fff; text-decoration: none; padding: 8px 20px; border-radius: 8px; font-weight: 600; font-size: 14px; display: flex; align-items: center; gap: 6px;">
        ✏️ Kembali ke Editor
    </a>
</div>
@endif

<!-- NEWS MEDIA HIGH-LEGIBILITY ARTICLE DETAIL -->
<div class="section py-4 py-md-5" style="background: var(--ivory-bg);">
    <div class="container py-2">
        <div class="row">
            <div class="col-lg-8 col-xl-8 mx-auto">
                
                <!-- BREADCRUMB -->
                <ul style="list-style: none; display: flex; align-items: center; flex-wrap: wrap; gap: 8px; padding: 0; margin-bottom: 16px; font-size: 13px; color: var(--text-muted);">
                    <li><a href="/" style="color: var(--text-muted); text-decoration: none;">Beranda</a></li>
                    <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; opacity: 0.5; vertical-align: middle;"></iconify-icon></li>
                    <li><a href="{{ url('/artikel') }}" style="color: var(--text-muted); text-decoration: none;">Artikel</a></li>
                    @if($article->category)
                    <li><iconify-icon icon="solar:alt-arrow-right-linear" style="font-size: 11px; opacity: 0.5; vertical-align: middle;"></iconify-icon></li>
                    <li style="color: var(--gold-primary); font-weight: 700;">{{ $article->category->name }}</li>
                    @endif
                </ul>

                <!-- CATEGORY BADGE -->
                @if($article->category)
                <div class="mb-3">
                    <span style="padding: 4px 14px; background: rgba(201, 162, 39, 0.12); color: var(--gold-primary); border: 1px solid rgba(201, 162, 39, 0.3); border-radius: 50px; font-size: 12px; font-weight: 700; display: inline-block; letter-spacing: 0.04em;">
                        {{ strtoupper($article->category->name) }}
                    </span>
                </div>
                @endif

                <!-- MAIN ARTICLE TITLE (LANGSUNG JUDUL) -->
                <h1 style="font-size: clamp(26px, 3.2vw, 40px); font-weight: 800; line-height: 1.25; color: var(--text-main); margin-bottom: 24px; letter-spacing: -0.02em;">
                    {{ $article->title }}
                </h1>

                <!-- AUTHOR & DATE META ROW -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 pb-4 mb-4 border-bottom" style="border-color: var(--border-color) !important;">
                    <div class="d-flex align-items-center gap-3">
                        @if($article->user && $article->user->avatar)
                            <img src="{{ asset('storage/' . $article->user->avatar) }}" alt="{{ $article->user->name }}" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; border: 2px solid var(--gold-primary); flex-shrink: 0;">
                        @else
                            <div style="width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, #071526, #102A4C); border: 2px solid var(--gold-primary); display: flex; align-items: center; justify-content: center; color: #E8C766; font-weight: 800; font-size: 18px; flex-shrink: 0;">
                                {{ strtoupper(substr($article->user->name ?? 'A', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h5 style="font-size: 15px; font-weight: 800; color: var(--text-main); margin: 0; line-height: 1.2;">
                                @if($article->user)
                                    <a href="{{ route('article.author', $article->user->id) }}" style="color: var(--text-main); text-decoration: none;">{{ $article->user->name }}</a>
                                @else
                                    Redaksi
                                @endif
                            </h5>
                            <small style="font-size: 12.5px; color: var(--text-muted); font-weight: 600;">
                                {{ $article->published_at ? $article->published_at->translatedFormat('d F Y') : $article->created_at->translatedFormat('d F Y') }}
                            </small>
                        </div>
                    </div>

                    <!-- MINIMALIST ICON-ONLY SHARE BUTTONS ROW -->
                    <div class="d-flex align-items-center gap-2">
                        <small style="font-weight: 700; color: var(--text-muted); font-size: 13px; margin-right: 4px;">Bagikan:</small>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="annur-icon-share share-wa" title="Bagikan ke WhatsApp">
                            <iconify-icon icon="ri:whatsapp-fill"></iconify-icon>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="annur-icon-share share-fb" title="Bagikan ke Facebook">
                            <iconify-icon icon="ri:facebook-fill"></iconify-icon>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="annur-icon-share share-x" title="Bagikan ke Twitter / X">
                            <iconify-icon icon="ri:twitter-x-fill"></iconify-icon>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="annur-icon-share share-tg" title="Bagikan ke Telegram">
                            <iconify-icon icon="ri:telegram-fill"></iconify-icon>
                        </a>
                        <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan artikel berhasil disalin!');" class="annur-icon-share share-copy" title="Salin Tautan">
                            <iconify-icon icon="solar:link-bold-duotone"></iconify-icon>
                        </button>
                    </div>
                </div>

                {{-- Excerpt Subtitle --}}
                @if($article->excerpt)
                <div class="mb-4">
                    <p style="font-size: 18px; color: var(--text-main); line-height: 1.7; font-weight: 500; font-style: italic; margin: 0; padding-left: 18px; border-left: 4px solid var(--gold-primary);">
                        "{{ $article->excerpt }}"
                    </p>
                </div>
                @endif

                {{-- Featured Image --}}
                @if($article->image_url)
                <div class="mb-5">
                    <figure class="m-0">
                        <img src="{{ $article->image_url }}" alt="{{ $article->image_caption ?? $article->title }}" style="width: 100%; max-height: 520px; object-fit: cover; object-position: top center; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);" onerror="this.onerror=null; this.parentElement.parentElement.style.display='none';">
                        @if($article->image_caption)
                        <figcaption class="text-center mt-2" style="color: var(--text-muted); font-size: 13px; font-style: italic;">
                            {{ $article->image_caption }}
                        </figcaption>
                        @endif
                    </figure>
                </div>
                @endif

                {{-- Article Body Content (High Legibility News Typography) --}}
                <div class="news-article-content mb-5">
                    {!! $article->body_content !!}
                </div>

                {{-- Tags --}}
                @if($article->meta_keywords)
                <div class="mb-4 pt-3 border-top" style="border-color: var(--border-color) !important;">
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <span style="font-weight: 700; color: var(--text-main); font-size: 13.5px;"><i class="feather-tag me-1" style="color: var(--gold-primary);"></i> Tags:</span>
                        @foreach(explode(',', $article->meta_keywords) as $keyword)
                        <span style="padding: 5px 14px; background: var(--card-bg); color: var(--text-main); border: 1px solid var(--border-color); border-radius: 50px; font-size: 12.5px; font-weight: 600;">{{ trim($keyword) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Author Profile Box --}}
                @if($article->user)
                <div class="p-4 p-md-5 mb-5" style="background: var(--card-bg); border-radius: var(--radius-lg); border: 1px solid var(--border-color); box-shadow: var(--card-shadow);">
                    <div class="d-flex align-items-start gap-4 flex-column flex-sm-row">
                        <div style="flex-shrink: 0;">
                            @if($article->user->avatar)
                            <img src="{{ asset('storage/' . $article->user->avatar) }}" alt="{{ $article->user->name }}" style="width: 76px; height: 76px; border-radius: 50%; object-fit: cover; border: 3px solid var(--gold-primary);">
                            @else
                            <div style="width: 76px; height: 76px; border-radius: 50%; background: linear-gradient(135deg, #071526, #102A4C); border: 3px solid var(--gold-primary); display: flex; align-items: center; justify-content: center; color: #E8C766; font-size: 26px; font-weight: 800;">
                                {{ strtoupper(substr($article->user->name, 0, 1)) }}
                            </div>
                            @endif
                        </div>
                        <div>
                            <small style="color: var(--gold-primary); font-size: 12px; font-weight: 700; letter-spacing: 0.05em; display: block; margin-bottom: 2px;">DITULIS OLEH</small>
                            <h4 style="font-size: 20px; font-weight: 800; color: var(--text-main); margin-bottom: 4px;">
                                <a href="{{ route('article.author', $article->user->id) }}" style="color: var(--text-main); text-decoration: none;">{{ $article->user->name }}</a>
                            </h4>
                            <span style="font-size: 12px; font-weight: 700; color: var(--gold-primary); background: rgba(201, 162, 39, 0.12); border: 1px solid rgba(201, 162, 39, 0.3); padding: 3px 12px; border-radius: 50px; display: inline-block; margin-bottom: 12px;">{{ $article->user->role_label }}</span>
                            
                            @if($article->user->bio)
                            <p style="color: var(--text-muted); font-size: 14px; line-height: 1.65; margin: 0;">{{ $article->user->bio }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- Prev / Next Navigation --}}
                <div class="row g-3 mb-5">
                    <div class="col-6">
                        @if($prevArticle)
                        <a href="{{ route('article.show', $prevArticle->slug) }}" class="p-3 d-block text-decoration-none h-100" style="background: var(--card-bg); border-radius: var(--radius-sm); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); transition: all 0.3s ease;">
                            <small style="color: var(--gold-primary); font-weight: 700; font-size: 12px; display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                <iconify-icon icon="solar:alt-arrow-left-linear" style="vertical-align: middle;"></iconify-icon> Artikel Sebelumnya
                            </small>
                            <span style="font-size: 14px; font-weight: 700; color: var(--text-main); line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $prevArticle->title }}</span>
                        </a>
                        @endif
                    </div>
                    <div class="col-6 text-end">
                        @if($nextArticle)
                        <a href="{{ route('article.show', $nextArticle->slug) }}" class="p-3 d-block text-decoration-none h-100" style="background: var(--card-bg); border-radius: var(--radius-sm); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); transition: all 0.3s ease;">
                            <small style="color: var(--gold-primary); font-weight: 700; font-size: 12px; display: flex; align-items: center; justify-content: flex-end; gap: 4px; margin-bottom: 4px;">
                                Artikel Berikutnya <iconify-icon icon="solar:alt-arrow-right-linear" style="vertical-align: middle;"></iconify-icon>
                            </small>
                            <span style="font-size: 14px; font-weight: 700; color: var(--text-main); line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $nextArticle->title }}</span>
                        </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Related Articles Section --}}
@if($relatedArticles->count() > 0)
<div class="section py-5" style="background: var(--sand-accent);">
    <div class="container py-3">
        <div class="row mb-4 text-center">
            <div class="col-lg-12">
                <span class="eyebrow mb-2" style="background: rgba(201, 162, 39, 0.1); padding: 5px 16px; border-radius: 50px; border: 1px solid rgba(201, 162, 39, 0.25);">
                    BACA JUGA
                </span>
                <h3 class="section-title mt-2" style="font-size: 28px; font-weight: 800; text-align: center;">Artikel Terkait</h3>
            </div>
        </div>
        <div class="row g-4">
            @foreach($relatedArticles as $index => $related)
            <div class="col-lg-4 col-md-6 col-12">
                <div style="background: var(--card-bg); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); overflow: hidden; height: 100%; display: flex; flex-direction: column;" class="annur-article-hover-card">
                    <div style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden;">
                        <a href="{{ route('article.show', $related->slug) }}">
                            <img src="{{ !empty($related->image_path) ? asset('storage/' . $related->image_path) : asset('frontend/assets/images/blog/islamic-blog-0' . (($index % 3) + 1) . '.png') }}" alt="{{ $related->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        </a>
                    </div>
                    <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                        <div>
                            <small style="color: var(--text-muted); font-size: 12px; display: block; margin-bottom: 6px;">
                                <i class="feather-calendar me-1" style="color: var(--gold-primary);"></i> {{ $related->published_at ? $related->published_at->translatedFormat('d M Y') : '' }}
                            </small>
                            <h4 style="font-size: 16px; font-weight: 800; line-height: 1.4; margin-bottom: 10px;">
                                <a href="{{ route('article.show', $related->slug) }}" style="color: var(--text-main); text-decoration: none;">{{ $related->title }}</a>
                            </h4>
                        </div>
                        <div class="pt-3 border-top" style="border-color: var(--border-color) !important;">
                            <a href="{{ route('article.show', $related->slug) }}" class="btn-gold w-100" style="min-height: 38px; padding: 0 16px; font-size: 12.5px; color: #071526 !important; font-weight: 700;">
                                Baca Selengkapnya <i class="feather-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<style>
    /* HIGH LEGIBILITY NEWS MEDIA TYPOGRAPHY */
    .news-article-content {
        font-size: 1.15rem;
        line-height: 1.85;
        color: var(--text-main);
    }
    .news-article-content p {
        margin-bottom: 1.6em;
        line-height: 1.85;
        font-size: 1.15rem;
    }
    .news-article-content h2 {
        font-size: 1.75rem !important;
        font-weight: 800 !important;
        margin-top: 1.8em !important;
        margin-bottom: 0.8em !important;
        color: var(--text-main) !important;
    }
    .news-article-content h3 {
        font-size: 1.45rem !important;
        font-weight: 800 !important;
        margin-top: 1.5em !important;
        margin-bottom: 0.6em !important;
        color: var(--text-main) !important;
    }
    .news-article-content blockquote {
        position: relative;
        background: rgba(212, 175, 55, 0.04);
        border: none !important;
        border-top: 2px solid var(--gold-primary) !important;
        border-bottom: 2px solid var(--gold-primary) !important;
        border-radius: 0 !important;
        padding: 30px 36px 30px 52px;
        margin: 2.2em 0;
        font-family: Georgia, 'Times New Roman', serif;
        font-style: italic;
        font-size: 1.3rem !important;
        line-height: 1.85;
        color: var(--text-main);
        box-shadow: none !important;
    }
    .news-article-content blockquote::before {
        content: "“";
        position: absolute;
        top: -4px;
        left: 12px;
        font-size: 4.5rem;
        font-family: Georgia, serif;
        color: var(--gold-primary);
        opacity: 0.35;
        line-height: 1;
        pointer-events: none;
    }
    .news-article-content blockquote p {
        margin: 0 !important;
        font-style: italic;
        font-size: 1.3rem !important;
        line-height: 1.85 !important;
    }
    .news-article-content blockquote cite,
    .news-article-content blockquote footer {
        display: block;
        margin-top: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        font-style: normal;
        font-family: var(--font-main, sans-serif);
        color: var(--gold-primary);
    }
    .news-article-content img {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius-md);
        margin: 1.5em 0;
    }

    /* MINIMALIST ICON-ONLY SHARE BUTTONS */
    .annur-icon-share {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        text-decoration: none;
        transition: all 0.25s ease;
        border: none;
        cursor: pointer;
    }
    .share-wa { background: rgba(37, 211, 102, 0.12); color: #15803D !important; }
    .share-wa:hover { background: #25D366; color: #FFFFFF !important; transform: translateY(-2px); }
    
    .share-fb { background: rgba(24, 119, 242, 0.12); color: #1877F2 !important; }
    .share-fb:hover { background: #1877F2; color: #FFFFFF !important; transform: translateY(-2px); }
    
    .share-x { background: rgba(15, 23, 42, 0.1); color: var(--text-main) !important; }
    .share-x:hover { background: #0F172A; color: #FFFFFF !important; transform: translateY(-2px); }
    
    .share-tg { background: rgba(34, 158, 217, 0.12); color: #0284C7 !important; }
    .share-tg:hover { background: #229ED9; color: #FFFFFF !important; transform: translateY(-2px); }

    .share-copy { background: rgba(201, 162, 39, 0.12); color: var(--gold-primary) !important; }
    .share-copy:hover { background: var(--gold-primary) !important; color: #071526 !important; transform: translateY(-2px); }
</style>
@endsection
