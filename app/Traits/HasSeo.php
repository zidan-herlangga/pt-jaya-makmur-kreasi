<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HasSeo
{
    public function getSeoTitle(): string
    {
        return $this->meta_title ?? $this->title ?? config('app.name');
    }

    public function getSeoDescription(): string
    {
        return $this->meta_description ?? str($this->description ?? $this->excerpt ?? $this->content_body ?? '')->limit(160)->value();
    }

    public function getSeoKeywords(): string
    {
        return $this->meta_keywords ?? '';
    }

    public function getOgImage(): ?string
    {
        if ($this->og_image) {
            return Storage::url($this->og_image);
        }

        if (property_exists($this, 'featured_image') && $this->featured_image) {
            return Storage::url($this->featured_image);
        }

        if (property_exists($this, 'thumbnail') && $this->thumbnail) {
            return Storage::url($this->thumbnail);
        }

        return asset('images/og-default.jpg');
    }

    public function getCanonicalUrl(): string
    {
        $routePrefix = property_exists($this, 'seoRoutePrefix') ? $this->seoRoutePrefix : '';
        return url($routePrefix . '/' . $this->slug);
    }

    public function generateJsonLd(): array
    {
        return [];
    }

    public function getJsonLdScript(): ?string
    {
        if ($this->json_ld_schema) {
            return $this->json_ld_schema;
        }

        $schema = $this->generateJsonLd();
        return !empty($schema) ? json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : null;
    }
}
