<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const CACHE_KEY = 'site_settings_all';

    protected static function booted(): void
    {
        static::saved(function () {
            Cache::forget(self::CACHE_KEY);
            Cache::forget('site_settings:all');
        });
        static::deleted(function () {
            Cache::forget(self::CACHE_KEY);
            Cache::forget('site_settings:all');
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = self::all_settings();
        return $all[$key] ?? $default;
    }

    public static function set(string $key, mixed $value, array $attrs = []): self
    {
        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
        foreach ($attrs as $k => $v) $setting->$k = $v;
        $setting->save();
        return $setting;
    }

    public static function all_settings(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return self::all()->mapWithKeys(function ($s) {
                $v = $s->value;
                if ($s->type === 'json' && $v) $v = json_decode($v, true);
                if ($s->type === 'bool')      $v = filter_var($v, FILTER_VALIDATE_BOOLEAN);
                if ($s->type === 'number')    $v = is_numeric($v) ? $v + 0 : 0;
                return [$s->key => $v];
            })->toArray();
        });
    }

    public function getValueDisplayAttribute(): string
    {
        if (in_array($this->type, ['image'])) {
            return $this->value ? asset('storage/' . $this->value) : '';
        }
        return (string) $this->value;
    }
}
