@extends('frontend.layouts.app')

@section('meta_title', 'Profil Penulis - ' . $author->name)

@section('content')
<!-- Author Profile Executive Navy Hero Banner -->
<div class="rbt-page-banner-wrapper" style="background: linear-gradient(135deg, #071526 0%, #0B1F3A 50%, #102A4C 100%) !important; padding: 55px 0 55px; border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
    <div class="container">
        <!-- Breadcrumb -->
        <ul class="page-list mb-4" style="list-style: none; display: flex; align-items: center; gap: 8px; padding: 0; font-size: 13.5px; color: rgba(255,255,255,0.7);">
            <li><a href="/" style="color: rgba(255,255,255,0.85); text-decoration: none;">Beranda</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li><a href="{{ route('article.index') }}" style="color: rgba(255,255,255,0.85); text-decoration: none;">Artikel</a></li>
            <li><i class="feather-chevron-right" style="font-size: 11px; color: rgba(255,255,255,0.5);"></i></li>
            <li style="color: #E8C766; font-weight: 600;">Profil Penulis</li>
        </ul>

        <!-- Author Info Box inside Banner -->
        <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-4">
            <!-- Perfect Round Circle Avatar (No Oval Stretching) -->
            <div style="width: 110px !important; height: 110px !important; min-width: 110px !important; max-width: 110px !important; min-height: 110px !important; max-height: 110px !important; border-radius: 50% !important; overflow: hidden !important; border: 3px solid #E8C766 !important; flex-shrink: 0 !important; box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important; display: flex !important; align-items: center !important; justify-content: center !important; background: #0B1F3A !important;">
                @if($author->avatar)
                    <img src="{{ asset('storage/' . $author->avatar) }}" alt="{{ $author->name }}" style="width: 100% !important; height: 100% !important; object-fit: cover !important; border-radius: 50% !important; display: block !important;">
                @else
                    <span style="font-size: 42px !important; font-weight: 800 !important; color: #E8C766 !important; line-height: 1 !important;">{{ strtoupper(substr($author->name, 0, 1)) }}</span>
                @endif
            </div>

            <!-- Author Details -->
            <div class="flex-grow-1">
                <h1 class="mb-2" style="color: #FFFFFF !important; font-size: 32px !important; font-weight: 800 !important; letter-spacing: -0.02em !important;">{{ $author->name }}</h1>
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    <span style="padding: 4px 16px; background: rgba(232, 199, 102, 0.15); color: #E8C766; border: 1px solid rgba(232, 199, 102, 0.35); border-radius: 50px; font-size: 13px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px;">
                        <i class="feather-award"></i>
                        {{ strtolower($bio->role ?? '') === 'editor' ? 'Dewan Redaksi' : ($bio->role ?? 'Penulis Aktif') }}
                    </span>
                    <span style="font-size: 14px; color: rgba(255,255,255,0.85);">
                        <i class="feather-book-open me-1" style="color: #E8C766;"></i> {{ $posts->total() }} Artikel Diterbitkan
                    </span>
                </div>
                <p class="mb-0" style="font-size: 14.5px; color: rgba(255, 255, 255, 0.8); line-height: 1.65; max-width: 800px;">
                    {{ $bio->bio ?? 'Berkontribusi melalui tulisan yang bermanfaat bagi kemajuan keilmuan dan keumatan.' }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Author Articles Grid Area -->
<div class="section py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-12 mb-2">
                <span class="eyebrow">KARYA TULIS</span>
                <h3 class="section-title" style="font-size: 22px; font-weight: 800;">Artikel Terkini dari {{ $author->name }}</h3>
            </div>

            <div class="row g-4">
                @forelse($posts as $index => $post)
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="annur-article-card" style="background: var(--card-bg); border: 1px solid var(--border-color); border-radius: var(--radius-md); overflow: hidden; box-shadow: var(--card-shadow); height: 100%; display: flex; flex-direction: column;">
                        <div style="position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden;">
                            @if($post->category)
                            <span style="position: absolute; top: 12px; left: 12px; padding: 4px 14px; background: rgba(11, 31, 58, 0.85); backdrop-filter: blur(8px); color: var(--gold-secondary); border: 1px solid rgba(232, 199, 102, 0.4); border-radius: 50px; font-size: 11.5px; font-weight: 700; z-index: 2;">
                                {{ $post->category->name }}
                            </span>
                            @endif
                            <a href="{{ route('article.show', $post->slug) }}">
                                <img src="{{ !empty($post->image_path) ? asset('storage/' . $post->image_path) : asset('frontend/assets/images/blog/islamic-blog-0' . (($index % 3) + 1) . '.png') }}" alt="{{ $post->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-3 mb-2" style="font-size: 12.5px; color: var(--text-muted);">
                                    <span><i class="feather-calendar me-1"></i> {{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                </div>
                                <h4 style="font-size: 17px; font-weight: 700; line-height: 1.45; margin-bottom: 10px;">
                                    <a href="{{ route('article.show', $post->slug) }}" style="color: var(--text-main); text-decoration: none;">{{ $post->title }}</a>
                                </h4>
                                <p style="font-size: 13.5px; color: var(--text-muted); line-height: 1.6; margin-bottom: 16px;">
                                    {{ Str::limit(strip_tags($post->excerpt ?? $post->body_content), 95) }}
                                </p>
                            </div>
                            <div class="pt-3 border-top" style="border-color: var(--border-color) !important;">
                                <a class="btn-gold w-100" style="min-height: 40px; padding: 0 16px; font-size: 13px;" href="{{ route('article.show', $post->slug) }}">
                                    Baca Selengkapnya
                                    <i class="feather-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <i class="feather-file-text fs-1 text-muted d-block mb-3"></i>
                    <h4 class="text-muted">Belum Ada Artikel</h4>
                    <p class="text-muted">Penulis ini belum mempublikasikan artikel apa pun.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="row mt-5">
                <div class="col-lg-12">
                    <nav class="d-flex justify-content-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                    </nav>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
