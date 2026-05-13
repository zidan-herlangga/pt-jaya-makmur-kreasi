<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['group', 'key', 'value', 'type', 'label', 'description'];

    protected $casts = [
        'value' => 'string',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = static::all()->keyBy('key');

        if ($settings->has($key)) {
            return $settings->get($key)->value ?? $default;
        }

        return $default;
    }

    public static function getGroup(string $group): array
    {
        return static::where('group', $group)->get()->keyBy('key')->map->value->toArray();
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getAll(): array
    {
        return static::all()->keyBy('key')->map(function ($item) {
            return [
                'id' => $item->id,
                'group' => $item->group,
                'key' => $item->key,
                'value' => $item->value,
                'type' => $item->type,
                'label' => $item->label,
                'description' => $item->description,
            ];
        })->toArray();
    }
}
