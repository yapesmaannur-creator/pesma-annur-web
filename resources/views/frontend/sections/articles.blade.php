        <!-- Start Blog Area -->
        <style>
            .annur-article-card {
                background: var(--card-bg);
                border: 1px solid var(--border-color);
                border-radius: var(--radius-md);
                overflow: hidden;
                box-shadow: var(--card-shadow);
                transition: transform 0.3s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.3s ease;
                height: 100%;
                display: flex;
                flex-direction: column;
            }
            .annur-article-card:hover {
                transform: translateY(-6px);
                box-shadow: var(--card-shadow-hover);
                border-color: rgba(201, 162, 39, 0.35);
            }
            .annur-article-img {
                position: relative;
                width: 100%;
                aspect-ratio: 16/10;
                overflow: hidden;
            }
            .annur-article-img img {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
            }
            .annur-article-card:hover .annur-article-img img {
                transform: scale(1.05);
            }
            .annur-category-badge {
                position: absolute;
                top: 14px;
                left: 14px;
                padding: 4px 14px;
                background: rgba(11, 31, 58, 0.85);
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                color: var(--gold-secondary);
                border: 1px solid rgba(232, 199, 102, 0.4);
                border-radius: 50px;
                font-size: 11.5px;
                font-weight: 700;
                z-index: 2;
                letter-spacing: 0.04em;
            }
            .annur-article-body {
                padding: 24px;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
                justify-content: space-between;
            }
            .annur-article-title {
                font-size: 17px;
                font-weight: 700;
                line-height: 1.45;
                margin-bottom: 12px;
            }
            .annur-article-title a {
                color: var(--text-main);
                text-decoration: none;
                transition: color 0.25s ease;
            }
            .annur-article-title a:hover {
                color: var(--gold-primary);
            }
            .annur-article-excerpt {
                font-size: 13.5px;
                color: var(--text-muted);
                line-height: 1.6;
                margin-bottom: 16px;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            @media (max-width: 576px) {
                .annur-article-body {
                    padding: 16px;
                }
                .annur-article-title {
                    font-size: 15.5px;
                }
            }
        </style>

        <div class="section">
            <div class="container">
                <div class="row mb--40 g-4 align-items-end">
                    <div class="col-lg-8 col-md-8 col-12">
                        <div class="text-start">
                            <span class="eyebrow">{{ $section->subtitle ?? 'BERITA & ARTIKEL' }}</span>
                            <h2 class="section-title">{!! $section->title ?? 'Kabar & Wawasan Terbaru' !!}</h2>
                        </div>
                    </div>
                    @if($section->button_text && $section->button_url)
                    <div class="col-lg-4 col-md-4 col-12 text-md-end">
                        <a class="btn-outline-navy" href="{{ $section->button_url }}">
                            {{ $section->button_text }}
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                        </a>
                    </div>
                    @else
                    <div class="col-lg-4 col-md-4 col-12 text-md-end">
                        <a class="btn-outline-navy" href="{{ url('/artikel') }}">
                            Semua Artikel
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Start Card Area -->
                <div class="row g-4">
                    @php
                       $posts = [];
                       
                       if (class_exists('\App\Models\Post')) {
                           $posts = \App\Models\Post::with(['category', 'user'])->whereNotNull('published_at')
                                        ->where('published_at', '<=', now())
                                        ->orderBy('published_at', 'desc')
                                        ->limit(3)->get();
                       }
                    @endphp

                    @forelse($posts as $index => $post)
                    <!-- Start Single Card  -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="annur-article-card">
                            <div class="annur-article-img">
                                @if(isset($post->category) && $post->category)
                                    <span class="annur-category-badge">{{ $post->category->name }}</span>
                                @endif
                                @php
                                    $defaultImg = asset('frontend/assets/images/blog/islamic-blog-0' . (($loop->index % 3) + 1) . '.png');
                                @endphp
                                <a href="{{ url('/artikel/' . $post->slug) }}">
                                    <img src="{{ $post->image_url ?? $defaultImg }}" alt="{{ $post->title }}" onerror="this.onerror=null; this.src='{{ $defaultImg }}';">
                                </a>
                            </div>
                            <div class="annur-article-body">
                                <div>
                                    <div class="d-flex align-items-center gap-3 mb-2" style="font-size: 12.5px; color: var(--text-muted);">
                                        <span><iconify-icon icon="solar:calendar-bold-duotone" class="me-1" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon> {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d M Y') : date('d M Y') }}</span>
                                        @if(isset($post->user) && $post->user)
                                            <span><iconify-icon icon="solar:user-bold-duotone" class="me-1" style="color: var(--gold-primary); vertical-align: middle;"></iconify-icon> {{ $post->user->name }}</span>
                                        @endif
                                    </div>
                                    <h3 class="annur-article-title">
                                        <a href="{{ url('/artikel/' . $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                    @if($post->excerpt || $post->content)
                                    <p class="annur-article-excerpt">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                                    </p>
                                    @endif
                                </div>
                                <div class="pt-3 border-top" style="border-color: var(--border-color) !important;">
                                    <a href="{{ url('/artikel/' . $post->slug) }}" class="btn-gold w-100" style="min-height: 40px; padding: 0 18px; font-size: 13px;">
                                        Baca Selengkapnya
                                        <iconify-icon icon="solar:alt-arrow-right-linear" class="ms-1" style="vertical-align: middle;"></iconify-icon>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Card  -->
                    @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">Belum ada artikel yang tersedia.</p>
                    </div>
                    @endforelse
                </div>
                <!-- End Card Area -->
            </div>
        </div>
        <!-- End Blog Area -->