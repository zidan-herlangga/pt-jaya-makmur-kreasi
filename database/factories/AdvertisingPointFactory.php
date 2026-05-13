<?php

namespace Database\Factories;

use App\Models\AdvertisingPoint;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisingPointFactory extends Factory
{
    protected $model = AdvertisingPoint::class;

    private static array $locations = [
        ['Jl. Jenderal Sudirman No. 1', 'Jakarta Pusat'],
        ['Jl. Gatot Subroto No. 2', 'Jakarta Selatan'],
        ['Jl. Ahmad Yani No. 3', 'Surabaya'],
        ['Jl. Diponegoro No. 4', 'Bandung'],
        ['Jl. MT Haryono No. 5', 'Medan'],
        ['Jl. Pemuda No. 6', 'Semarang'],
        ['Jl. Urip Sumoharjo No. 7', 'Makassar'],
        ['Jl. Veteran No. 8', 'Yogyakarta'],
        ['Jl. Teuku Umar No. 9', 'Denpasar'],
        ['Jl. Soekarno Hatta No. 10', 'Malang'],
        ['Jl. Asia Afrika No. 11', 'Palembang'],
        ['Jl. Sultan Hasanuddin No. 12', 'Makassar'],
        ['Jl. Rajawali No. 13', 'Surabaya'],
        ['Jl. Braga No. 14', 'Bandung'],
        ['Jl. Malioboro No. 15', 'Yogyakarta'],
    ];

    private static array $titles = [
        'Billboard Papan Utama', 'Neon Box Pusat Kota', 'Videotron Strategis',
        'Billboard Layar Lebar', 'Neon Box Tepi Jalan', 'Rooftop Sign Premium',
        'Papan Reklame Simpang Tiga', 'Billboard Jembatan Penyeberangan',
        'Neon Box Atas Gedung', 'Baliho Jalan Tol', 'Signage Gerbang Masuk',
        'Billboard Taman Kota', 'Papan Iklan Perempatan', 'Spanduk Raksasa',
        'Media Display Terminal', 'Baliho Layar Sentuh', 'Reklame Atas JPO',
    ];

    public function definition(): array
    {
        $location = fake()->randomElement(self::$locations);

        return [
            'category_id' => Category::factory(),
            'title' => fake()->randomElement(self::$titles) . ' - ' . fake()->city(),
            'location_name' => $location[0],
            'city' => $location[1],
            'lat' => fake()->latitude(-8, 6),
            'long' => fake()->longitude(95, 141),
            'orientation' => fake()->randomElement(['horizontal', 'vertical', 'rooftop']),
            'size_dimension' => fake()->randomElement(['4m x 6m', '5m x 10m', '8m x 12m', '3m x 8m', '10m x 20m']),
            'light_type' => fake()->randomElement(['LED', 'Neon', 'Frontlit', 'Backlit', 'None']),
            'price' => fake()->randomElement([5000000, 7500000, 10000000, 15000000, 20000000, 25000000, 35000000, 50000000]),
            'status' => fake()->randomElement(['available', 'available', 'available', 'booked', 'maintenance']),
            'thumbnail' => null,
            'gallery' => null,
            'description' => fake()->paragraph(3),
            'view_count' => fake()->numberBetween(10, 5000),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function booked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'booked',
        ]);
    }

    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'maintenance',
        ]);
    }
}
