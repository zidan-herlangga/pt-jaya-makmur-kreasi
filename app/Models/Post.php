<?php

namespace App\Models;

use App\Services\SeoService;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, HasSeo, SoftDeletes;

    protected string $seoRoutePrefix = 'berita';

    protected $fillable = [
        'author_id',
        'category_id',
        'title',
        'slug',
        'content_body',
        'featured_image',
        'excerpt',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'json_ld_schema',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            if (empty($post->excerpt) && !empty($post->content_body)) {
                $post->excerpt = str(strip_tags($post->content_body))->limit(300)->value();
            }

            if (empty($post->meta_title)) {
                $post->meta_title = $post->title;
            }
            if (empty($post->meta_description)) {
                $post->meta_description = str(strip_tags($post->excerpt ?? $post->content_body))->limit(160)->value();
            }
        });

        static::saving(function (self $post) {
            // Auto-set published_at when publishing
            if ($post->status === 'published' && empty($post->published_at)) {
                $post->published_at = now();
            }

            $post->json_ld_schema = json_encode(
                SeoService::generateArticleSchema($post),
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );
        });
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
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

    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->content_body));
        return max(1, ceil($words / 200));
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function generateJsonLd(): array
    {
        return SeoService::generateArticleSchema($this);
    }
}
