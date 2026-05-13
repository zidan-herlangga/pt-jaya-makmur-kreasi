<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = fake()->unique()->randomElement([
            'Tips Memilih Lokasi Billboard yang Tepat',
            'Keuntungan Menggunakan Neon Box untuk Brand Anda',
            'Perbedaan Billboard dan Videotron',
            'Strategi Pemasaran dengan Media Luar Ruang',
            'Tren Reklame Digital di Tahun 2026',
            'Panduan Lengkap Sewa Baliho untuk Bisnis',
            'Mengapa Outdoor Advertising Masih Efektif?',
            'Cara Mengukur ROI Iklan Billboard',
            'Regulasi Pemasangan Reklame di Indonesia',
            'Inspirasi Desain Billboard yang Menarik',
            'Neon Box vs LED Sign: Mana yang Lebih Baik?',
            'Tips Negosiasi Harga Sewa Billboard',
            'Pemasangan Iklan di Titik Strategis',
            'Branding Lokal vs Global: Strategi Outdoor',
            'Mengoptimalkan Anggaran Iklan Luar Ruang',
        ]);

        return [
            'author_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'content_body' => fake()->paragraphs(fake()->numberBetween(3, 8), true),
            'featured_image' => null,
            'status' => 'published',
            'view_count' => fake()->numberBetween(50, 3000),
            'published_at' => fake()->dateTimeBetween('-3 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'archived',
        ]);
    }
}
