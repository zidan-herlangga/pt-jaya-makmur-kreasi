<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Product categories
            ['name' => 'Billboard', 'type' => 'product', 'icon' => '📋', 'description' => 'Papan reklame berukuran besar di lokasi strategis', 'sort_order' => 1],
            ['name' => 'Neon Box', 'type' => 'product', 'icon' => '💡', 'description' => 'Reklame dengan pencahayaan neon atau LED', 'sort_order' => 2],
            ['name' => 'Videotron', 'type' => 'product', 'icon' => '🖥️', 'description' => 'Layar digital untuk iklan bergerak', 'sort_order' => 3],
            ['name' => 'Baliho', 'type' => 'product', 'icon' => '🪧', 'description' => 'Media reklame ukuran besar temporer', 'sort_order' => 4],
            ['name' => 'Signage', 'type' => 'product', 'icon' => '🏪', 'description' => 'Papan petunjuk dan identitas usaha', 'sort_order' => 5],
            ['name' => 'Rooftop', 'type' => 'product', 'icon' => '🏢', 'description' => 'Reklame di atas gedung', 'sort_order' => 6],
            ['name' => 'Media Lainnya', 'type' => 'product', 'icon' => '📺', 'description' => 'Media reklame luar ruang lainnya', 'sort_order' => 7],

            // Post categories
            ['name' => 'Tips & Trik', 'type' => 'post', 'icon' => '💡', 'description' => 'Tips seputar reklame dan pemasaran', 'sort_order' => 1],
            ['name' => 'Berita Industri', 'type' => 'post', 'icon' => '📰', 'description' => 'Berita terbaru dunia advertising', 'sort_order' => 2],
            ['name' => 'Inspirasi', 'type' => 'post', 'icon' => '✨', 'description' => 'Inspirasi desain dan strategi', 'sort_order' => 3],
            ['name' => 'Panduan', 'type' => 'post', 'icon' => '📖', 'description' => 'Panduan lengkap sewa reklame', 'sort_order' => 4],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => str($category['name'])->slug()],
                $category
            );
        }
    }
}
