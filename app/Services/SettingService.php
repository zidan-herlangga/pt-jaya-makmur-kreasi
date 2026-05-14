<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingService
{
    private ?array $all = null;

    public function load(): array
    {
        if ($this->all === null) {
            $this->all = Setting::all()->keyBy('key')->map(function ($s) {
                return $s->value;
            })->toArray();
        }
        return $this->all;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->load();
        return $settings[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        Setting::set($key, $value);
        $this->all[$key] = $value;
    }

    public function getGroup(string $group): array
    {
        return Setting::where('group', $group)->get()->keyBy('key')->map->value->toArray();
    }

    public function getAllGrouped(): array
    {
        return Setting::all()->groupBy('group')->map(function ($items) {
            return $items->keyBy('key')->map(function ($item) {
                return [
                    'value' => $item->value,
                    'type' => $item->type,
                    'label' => $item->label,
                    'description' => $item->description,
                ];
            });
        })->toArray();
    }

    public function getGroups(): array
    {
        return [
            'general' => 'Umum',
            'seo' => 'SEO',
            'verification' => 'Verifikasi',
            'social' => 'Media Sosial',
            'contact' => 'Kontak',
            'appearance' => 'Tampilan',
        ];
    }
}
