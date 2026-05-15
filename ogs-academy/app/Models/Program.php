<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'outcomes_ar'      => 'array',
        'outcomes_en'      => 'array',
        'prerequisites_ar' => 'array',
        'prerequisites_en' => 'array',
        'is_featured'      => 'boolean',
        'is_published'     => 'boolean',
        'price'            => 'decimal:2',
        'start_date'       => 'date',
        'end_date'         => 'date',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $program) {
            if (empty($program->slug) && $program->title_ar) {
                $program->slug = Str::slug($program->title_en ?: $program->title_ar)
                    ?: 'program-' . Str::random(6);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProgramCategory::class, 'category_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(ProgramModule::class)->orderBy('sort_order');
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(Inquiry::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/placeholder-program.jpg');
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return $this->cover_url;
    }
}
