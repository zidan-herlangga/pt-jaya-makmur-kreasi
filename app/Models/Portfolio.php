<?php

namespace App\Models;

use App\Services\SeoService;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Portfolio extends Model
{
    use HasFactory, HasSeo, SoftDeletes;

    protected string $seoRoutePrefix = 'portofolio';

    protected $fillable = [
        'title',
        'slug',
        'client_name',
        'category_id',
        'description',
        'thumbnail',
        'images',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'json_ld_schema',
        'published_at',
    ];

    protected $casts = [
        'images' => 'array',
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title);
            }
            if (empty($portfolio->meta_title)) {
                $portfolio->meta_title = $portfolio->title;
            }
            if (empty($portfolio->meta_description)) {
                $portfolio->meta_description = str(strip_tags($portfolio->description ?? ''))->limit(160)->value();
            }
        });

        static::saving(function (self $portfolio) {
            // Auto-set published_at when publishing
            if ($portfolio->status === 'published' && empty($portfolio->published_at)) {
                $portfolio->published_at = now();
            }

            $portfolio->json_ld_schema = json_encode(
                SeoService::generatePortfolioSchema($portfolio),
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeRelated($query, int $limit = 4)
    {
        return $query->published()
            ->where('id', '!=', $this->id)
            ->when($this->category_id, function ($q) {
                $q->where('category_id', $this->category_id);
            })
            ->inRandomOrder()
            ->limit($limit);
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function generateJsonLd(): array
    {
        return SeoService::generatePortfolioSchema($this);
    }
}
