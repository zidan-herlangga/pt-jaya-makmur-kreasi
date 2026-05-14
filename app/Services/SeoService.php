<?php

namespace App\Services;

use App\Models\AdvertisingPoint;
use App\Models\Portfolio;
use App\Models\Post;

class SeoService
{
    private array $defaults;

    public function __construct()
    {
        $this->defaults = [
            'title' => config('app.name'),
            'description' => 'PT. Jaya Makmur - Jasa reklame profesional untuk branding dan promosi bisnis Anda. Billboard, neon box, dan media luar ruang terbaik.',
            'keywords' => 'reklame, billboard, iklan, neon box, media luar ruang, advertising',
            'og_type' => 'website',
            'og_image' => asset('images/og-default.jpg'),
            'twitter_card' => 'summary_large_image',
        ];
    }

    public function forModel($model): self
    {
        $this->defaults = [
            'title' => $model->getSeoTitle(),
            'description' => $model->getSeoDescription(),
            'keywords' => $model->getSeoKeywords(),
            'og_type' => $model instanceof AdvertisingPoint ? 'product' : 'article',
            'og_image' => $model->getOgImage(),
            'canonical' => $model->getCanonicalUrl(),
            'json_ld' => $model->getJsonLdScript(),
            'twitter_card' => 'summary_large_image',
        ];

        return $this;
    }

    public function forPage(string $title, string $description = '', string $keywords = '', ?string $ogImage = null): self
    {
        $this->defaults = [
            'title' => $title . ' | ' . config('app.name'),
            'description' => $description,
            'keywords' => $keywords,
            'og_type' => 'website',
            'og_image' => $ogImage ?? asset('images/og-default.jpg'),
            'canonical' => url()->current(),
            'twitter_card' => 'summary_large_image',
        ];

        return $this;
    }

    public function render(): array
    {
        return $this->defaults;
    }

    public static function generateProductSchema(AdvertisingPoint $point): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $point->title,
            'image' => $point->getOgImage(),
            'description' => $point->getSeoDescription(),
            'offers' => [
                '@type' => 'Offer',
                'price' => $point->price,
                'priceCurrency' => 'IDR',
                'availability' => $point->status === 'available'
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'url' => $point->getCanonicalUrl(),
            ],
            'aggregateRating' => [
                '@type' => 'AggregateRating',
                'ratingValue' => '4.8',
                'reviewCount' => '124',
            ],
            'brand' => [
                '@type' => 'Brand',
                'name' => config('app.name'),
            ],
        ];
    }

    public static function generateArticleSchema(Post $post): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $post->title,
            'image' => $post->getOgImage(),
            'datePublished' => $post->published_at?->toIso8601String(),
            'dateModified' => $post->updated_at?->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $post->author?->name ?? config('app.name'),
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'description' => $post->getSeoDescription(),
            'url' => $post->getCanonicalUrl(),
        ];
    }

    public static function generatePortfolioSchema(Portfolio $portfolio): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CreativeWork',
            'name' => $portfolio->title,
            'image' => $portfolio->getOgImage(),
            'description' => $portfolio->getSeoDescription(),
            'dateCreated' => $portfolio->created_at?->toIso8601String(),
            'datePublished' => $portfolio->published_at?->toIso8601String(),
            'author' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
            ],
            'url' => $portfolio->getCanonicalUrl(),
        ];
    }

    public static function generateOrganizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => config('app.url'),
            'logo' => asset('images/logo.png'),
            'sameAs' => [
                config('app.social.facebook'),
                config('app.social.instagram'),
                config('app.social.linkedin'),
            ],
        ];
    }

    public static function generateLocalBusinessSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LocalBusiness',
            'name' => setting('site_name', config('app.name')),
            'image' => asset('images/og-default.jpg'),
            'description' => setting('site_description', 'Solusi Reklame Profesional & Billboard Terbaik'),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => setting('address', 'Jl. Sudirman No. 123'),
                'addressLocality' => 'Jakarta Pusat',
                'addressCountry' => 'ID',
            ],
            'telephone' => setting('phone', '+62 812-3456-7890'),
            'email' => setting('email', 'info@jayamakmur.com'),
            'url' => config('app.url'),
            'priceRange' => 'IDR 5.000.000 - IDR 100.000.000',
            'openingHours' => 'Mo-Fr 08:00-17:00',
        ];
    }

    public static function generateBreadcrumbSchema(array $items): array
    {
        $breadcrumbs = [];
        foreach ($items as $i => $item) {
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => $i + 1,
                'name' => $item['name'],
                'item' => $item['url'] ?? null,
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $breadcrumbs,
        ];
    }

    public function withBreadcrumbs(array $items): self
    {
        $this->defaults['breadcrumbs'] = self::generateBreadcrumbSchema($items);
        return $this;
    }
}
