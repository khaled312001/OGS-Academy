<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public const CATEGORIES = [
        'news'       => 'أخبار',
        'insight'    => 'مقالات تخصصية',
        'case-study' => 'دراسات حالة',
        'press'      => 'تغطية إعلامية',
    ];

    protected $casts = [
        'tags'         => 'array',
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $a) {
            if (empty($a->slug) && $a->title_ar) {
                $a->slug = Str::slug($a->title_en ?: $a->title_ar) ?: 'article-' . Str::random(6);
            }
            if ($a->is_published && empty($a->published_at)) {
                $a->published_at = now();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) return asset('storage/' . $this->cover_image);
        return asset('images/placeholder-program.jpg');
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? $this->category;
    }
}
