<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $settings = [
            ['appearance', 'home_banner_1', '', 'image', 'Banner Home 1', 'Gambar banner halaman utama (1920x600 px)'],
            ['appearance', 'home_banner_2', '', 'image', 'Banner Home 2', 'Gambar banner halaman utama (1920x600 px)'],
            ['appearance', 'home_banner_3', '', 'image', 'Banner Home 3', 'Gambar banner halaman utama (1920x600 px)'],
            ['appearance', 'about_banner_1', '', 'image', 'Banner Tentang 1', 'Gambar banner halaman tentang (1920x400 px)'],
            ['appearance', 'about_banner_2', '', 'image', 'Banner Tentang 2', 'Gambar banner halaman tentang (1920x400 px)'],
        ];

        $data = [];
        foreach ($settings as $s) {
            $data[] = [
                'group' => $s[0],
                'key' => $s[1],
                'value' => $s[2],
                'type' => $s[3],
                'label' => $s[4],
                'description' => $s[5],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('settings')->insert($data);
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', [
            'home_banner_1', 'home_banner_2', 'home_banner_3',
            'about_banner_1', 'about_banner_2',
        ])->delete();
    }
};
