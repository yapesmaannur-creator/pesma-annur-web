{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <!-- Static Home Page -->
    <url>
        <loc>{{ url('/') }}</loc>
        <lastmod>{{ now()->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>

    <!-- Dynamic Pages -->
    @foreach($pages as $page)
        @if($page->slug !== 'beranda')
        <url>
            <loc>{{ url('/' . $page->slug) }}</loc>
            <lastmod>{{ $page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
        @endif
    @endforeach

    <!-- Dynamic Articles -->
    @foreach($posts as $post)
        <url>
            <loc>{{ route('article.show', $post->slug) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Dynamic Activities -->
    @foreach($activities as $activity)
        <url>
            <loc>{{ route('activity.detail', $activity->slug) }}</loc>
            <lastmod>{{ $activity->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Dynamic Shop Products (Books) -->
    @foreach($products as $product)
        <url>
            <loc>{{ route('shop.show', $product->slug) }}</loc>
            <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
