<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProgramCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $cat) {
            if (empty($cat->slug) && $cat->name_ar) {
                $cat->slug = Str::slug($cat->name_en ?: $cat->name_ar)
                    ?: 'cat-' . Str::random(5);
            }
        });
        static::saved(fn () => Cache::forget('public_nav_data:v1'));
        static::deleted(fn () => Cache::forget('public_nav_data:v1'));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
