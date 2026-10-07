<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['key', 'label', 'value'])]
class Setting extends Model
{
    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings'));
        static::deleted(fn () => Cache::forget('settings'));
    }

    /**
     * All settings as a key => value map, cached until a setting changes.
     *
     * @return array<string, string|null>
     */
    public static function map(): array
    {
        return Cache::rememberForever('settings', fn () => static::query()->pluck('value', 'key')->all());
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::map()[$key] ?? $default;
    }
}
