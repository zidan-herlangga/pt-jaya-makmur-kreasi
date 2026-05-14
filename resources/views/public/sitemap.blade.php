<?php echo '<' . '?xml version="1.0" encoding="UTF-8"?' . '>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
    <url>
        <loc>{{ url('/') }}</loc>
        <priority>1.00</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <priority>0.80</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('catalog.index') }}</loc>
        <priority>0.90</priority>
        <changefreq>daily</changefreq>
    </url>
    <url>
        <loc>{{ route('portofolio.index') }}</loc>
        <priority>0.80</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('posts.index') }}</loc>
        <priority>0.70</priority>
        <changefreq>weekly</changefreq>
    </url>
    <url>
        <loc>{{ route('inquiry.create') }}</loc>
        <priority>0.60</priority>
        <changefreq>monthly</changefreq>
    </url>
    <url>
        <loc>{{ route('privacy') }}</loc>
        <priority>0.30</priority>
        <changefreq>yearly</changefreq>
    </url>
    <url>
        <loc>{{ route('terms') }}</loc>
        <priority>0.30</priority>
        <changefreq>yearly</changefreq>
    </url>
    @foreach($points as $point)
    <url>
        <loc>{{ $point->getCanonicalUrl() }}</loc>
        <priority>0.70</priority>
        <changefreq>weekly</changefreq>
        @if($point->updated_at)
        <lastmod>{{ $point->updated_at->toIso8601String() }}</lastmod>
        @endif
    </url>
    @endforeach
    @foreach($posts as $post)
    <url>
        <loc>{{ $post->getCanonicalUrl() }}</loc>
        <priority>0.60</priority>
        <changefreq>monthly</changefreq>
        @if($post->updated_at)
        <lastmod>{{ $post->updated_at->toIso8601String() }}</lastmod>
        @endif
    </url>
    @endforeach
    @foreach($portfolios as $portfolio)
    <url>
        <loc>{{ $portfolio->getCanonicalUrl() }}</loc>
        <priority>0.60</priority>
        <changefreq>monthly</changefreq>
        @if($portfolio->updated_at)
        <lastmod>{{ $portfolio->updated_at->toIso8601String() }}</lastmod>
        @endif
    </url>
    @endforeach
</urlset>
