<?php

namespace App\Models;

use App\Services\SeoService;
use App\Traits\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AdvertisingPoint extends Model
{
    use HasFactory, HasSeo, SoftDeletes;

    protected string $seoRoutePrefix = 'katalog';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'location_name',
        'city',
        'lat',
        'long',
        'orientation',
        'size_dimension',
        'light_type',
        'price',
        'status',
        'thumbnail',
        'gallery',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'json_ld_schema',
        'published_at',
    ];

    protected $casts = [
        'lat' => 'decimal:8',
        'long' => 'decimal:8',
        'price' => 'decimal:2',
        'gallery' => 'array',
        'published_at' => 'datetime',
        'view_count' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $point) {
            if (empty($point->slug)) {
                $point->slug = Str::slug($point->title);
            }

            // Auto-generate SEO fields if empty
            if (empty($point->meta_title)) {
                $point->meta_title = $point->title . ' - PT. Jaya Makmur ' . $point->city;
            }
            if (empty($point->meta_description)) {
                $point->meta_description = 'Sewa ' . $point->title . ' di ' . $point->location_name
                    . '. ' . $point->size_dimension . '. Harga terbaik untuk iklan billboard dan reklame Anda.';
            }
        });

        static::saving(function (self $point) {
            // Auto-set published_at when marked available
            if ($point->status === 'available' && empty($point->published_at)) {
                $point->published_at = now();
            }

            // Regenerate JSON-LD on save
            $point->json_ld_schema = json_encode(
                SeoService::generateProductSchema($point),
                JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class, 'product_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'available')
            ->whereNotNull('published_at');
    }

    public function getGalleryAttribute($value): array
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? array_values(array_filter($decoded, 'is_string')) : [];
        }
        if (is_array($value)) {
            return array_values(array_filter($value, 'is_string'));
        }
        return [];
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeByCity($query, string $city)
    {
        return $query->where('city', $city);
    }

    public function scopeFeatured($query, int $limit = 6)
    {
        return $query->published()
            ->orderBy('view_count', 'desc')
            ->limit($limit);
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function getFormattedPriceAttribute(): string
    {
        if (!$this->price) {
            return 'Hubungi Kami';
        }
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'available' => 'emerald',
            'booked' => 'amber',
            'maintenance' => 'rose',
            default => 'gray',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'booked' => 'Dipesan',
            'maintenance' => 'Perawatan',
            default => $this->status,
        };
    }

    public function generateJsonLd(): array
    {
        return SeoService::generateProductSchema($this);
    }
}
