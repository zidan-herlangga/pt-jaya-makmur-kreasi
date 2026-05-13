<?php

namespace Database\Seeders;

use App\Models\AdvertisingPoint;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AdvertisingPointSeeder extends Seeder
{
    public function run(): void
    {
        $productCategories = Category::byType('product')->pluck('id');

        if ($productCategories->isEmpty()) {
            $this->command->warn('No product categories found. Run CategorySeeder first.');
            return;
        }

        $points = [
            [
                'title' => 'Billboard Sudirman Thamrin',
                'location_name' => 'Jl. Jenderal Sudirman Kav. 1',
                'city' => 'Jakarta Pusat',
                'category_index' => 0,
                'orientation' => 'horizontal',
                'size_dimension' => '8m x 12m',
                'light_type' => 'LED',
                'price' => 50000000,
                'description' => 'Billboard premium di kawasan bisnis utama Jakarta. Visibilitas tinggi dengan lalu lintas kendaraan lebih dari 100.000 per hari. Cocok untuk brand besar yang ingin membangun brand awareness di ibukota.',
                // Gambar gedung pencakar langit dan lalu lintas Jakarta
                'thumbnail' => 'https://images.unsplash.com/photo-1555899434-94d1368aa5af?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Neon Box Gatot Subroto',
                'location_name' => 'Jl. Gatot Subroto No. 50',
                'city' => 'Jakarta Selatan',
                'category_index' => 1,
                'orientation' => 'vertical',
                'size_dimension' => '3m x 8m',
                'light_type' => 'Neon',
                'price' => 25000000,
                'description' => 'Neon box strategis di jalur utama menuju pusat pemerintahan dan perkantoran. Pencahayaan neon yang menarik perhatian di malam hari.',
                // Gambar lampu kota malam hari
                'thumbnail' => 'https://images.unsplash.com/photo-1555680202-c86f0e12f086?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Videotron Tunjungan Plaza',
                'location_name' => 'Jl. Tunjungan No. 1',
                'city' => 'Surabaya',
                'category_index' => 2,
                'orientation' => 'horizontal',
                'size_dimension' => '10m x 20m',
                'light_type' => 'LED',
                'price' => 75000000,
                'description' => 'Videotron LED full color di pusat perbelanjaan terbesar di Surabaya. Tayangan iklan bergerak dengan durasi 15-30 detik per slot.',
                // Gambar layar LED / mal modern
                'thumbnail' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Baliho Asia Afrika',
                'location_name' => 'Jl. Asia Afrika No. 8',
                'city' => 'Bandung',
                'category_index' => 3,
                'orientation' => 'horizontal',
                'size_dimension' => '5m x 10m',
                'light_type' => 'Frontlit',
                'price' => 15000000,
                'description' => 'Baliho strategis di pusat kota Bandung. Area dengan trafik pejalan kaki dan kendaraan yang tinggi, dekat dengan Alun-alun Bandung.',
                // Gambar jalan raya kota yang sibuk
                'thumbnail' => 'https://images.unsplash.com/photo-1515162816999-a0c47dc192f7?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Signage Gerbang Kota Medan',
                'location_name' => 'Jl. Imam Bonjol No. 10',
                'city' => 'Medan',
                'category_index' => 4,
                'orientation' => 'horizontal',
                'size_dimension' => '4m x 6m',
                'light_type' => 'Backlit',
                'price' => 10000000,
                'description' => 'Signage identitas usaha di gerbang masuk kawasan bisnis Medan. Cocok untuk perusahaan yang ingin memperkuat brand identity.',
                // Gambar signage gedung / toko
                'thumbnail' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Rooftop Sign Makassar',
                'location_name' => 'Jl. Urip Sumoharjo No. 20',
                'city' => 'Makassar',
                'category_index' => 5,
                'orientation' => 'rooftop',
                'size_dimension' => '6m x 8m',
                'light_type' => 'LED',
                'price' => 20000000,
                'description' => 'Reklame rooftop di gedung tertinggi di Makassar. Visibilitas dari radius 1 km. Cocok untuk brand yang ingin mendominasi langit kota Makassar.',
                // Gambar kota dari atas (aerial view)
                'thumbnail' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Billboard Malioboro',
                'location_name' => 'Jl. Malioboro No. 25',
                'city' => 'Yogyakarta',
                'category_index' => 0,
                'orientation' => 'horizontal',
                'size_dimension' => '4m x 8m',
                'light_type' => 'LED',
                'price' => 12000000,
                'description' => 'Billboard di kawasan wisata Malioboro. Dilihat oleh ribuan wisatawan setiap hari. Lokasi prime dengan exposure maksimal.',
                // Gambar area wisata ramai / jalan pedestrian
                'thumbnail' => 'https://images.unsplash.com/photo-1596176530529-78163a4f7af2?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Neon Box Kuta',
                'location_name' => 'Jl. Legian No. 15',
                'city' => 'Denpasar',
                'category_index' => 1,
                'orientation' => 'vertical',
                'size_dimension' => '2m x 6m',
                'light_type' => 'Neon',
                'price' => 18000000,
                'description' => 'Neon box di kawasan wisata Kuta. Target utama wisatawan domestik dan mancanegara. Pencahayaan neon yang ikonik.',
                // Gambar suasana pantai malam hari / neon
                'thumbnail' => 'https://images.unsplash.com/photo-1514214246283-d427a95c5d2f?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Videotron Simpang Lima',
                'location_name' => 'Jl. Pahlawan No. 5',
                'city' => 'Semarang',
                'category_index' => 2,
                'orientation' => 'horizontal',
                'size_dimension' => '8m x 16m',
                'light_type' => 'LED',
                'price' => 35000000,
                'description' => 'Videotron di Simpang Lima, pusat keramaian Kota Semarang. Layar LED berkualitas tinggi dengan resolusi full HD.',
                // Gambar persimpangan jalan raya besar
                'thumbnail' => 'https://images.unsplash.com/photo-1475274047050-1d0c0975c63e?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Billboard Ahmad Yani',
                'location_name' => 'Jl. Ahmad Yani No. 100',
                'city' => 'Surabaya',
                'category_index' => 0,
                'orientation' => 'horizontal',
                'size_dimension' => '5m x 10m',
                'light_type' => 'Frontlit',
                'price' => 22000000,
                'description' => 'Billboard di jalur utama Surabaya. Lalu lintas kendaraan 80.000 per hari. Harga kompetitif dengan exposure maksimal.',
                // Gambar jalan raya dengan tiang reklame di pinggir
                'thumbnail' => 'https://images.unsplash.com/photo-1565616228879-ea9e343c6d5f?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Baliho Soekarno Hatta',
                'location_name' => 'Jl. Soekarno Hatta No. 50',
                'city' => 'Malang',
                'category_index' => 3,
                'orientation' => 'horizontal',
                'size_dimension' => '4m x 6m',
                'light_type' => 'Frontlit',
                'price' => 8000000,
                'description' => 'Baliho di jalan protokol Malang. Cocok untuk promosi produk dan event di Kota Malang dan sekitarnya.',
                // Gambar jalan protokol / papan iklan kosong
                'thumbnail' => 'https://images.unsplash.com/photo-1548498431-6c32361436c8?q=80&w=1000&auto=format&fit=crop',
            ],
            [
                'title' => 'Rooftop Palembang Icon',
                'location_name' => 'Jl. Sudirman No. 1',
                'city' => 'Palembang',
                'category_index' => 5,
                'orientation' => 'rooftop',
                'size_dimension' => '8m x 10m',
                'light_type' => 'LED',
                'price' => 15000000,
                'description' => 'Rooftop sign di landmark kota Palembang. Tampak dari Jembatan Ampera dan area sekitarnya. Branding maksimal untuk pasar Sumatera Selatan.',
                // Gambar landmark kota atau gedung tinggi
                'thumbnail' => 'https://images.unsplash.com/photo-1496442226666-8d4a0e62e6e9?q=80&w=1000&auto=format&fit=crop',
            ],
        ];

        foreach ($points as $index => $pointData) {
            $categoryId = $productCategories[$pointData['category_index'] % $productCategories->count()];

            AdvertisingPoint::firstOrCreate(
                ['slug' => str($pointData['title'])->slug()],
                [
                    'category_id' => $categoryId,
                    'title' => $pointData['title'],
                    'location_name' => $pointData['location_name'],
                    'city' => $pointData['city'],
                    'orientation' => $pointData['orientation'],
                    'size_dimension' => $pointData['size_dimension'],
                    'light_type' => $pointData['light_type'],
                    'price' => $pointData['price'],
                    'status' => $index < 8 ? 'available' : ($index === 8 ? 'booked' : 'maintenance'),
                    'description' => $pointData['description'],
                    'thumbnail' => $pointData['thumbnail'], // Menambahkan thumbnail ke database
                    'view_count' => fake()->numberBetween(50, 5000),
                    'published_at' => now()->subDays(fake()->numberBetween(1, 180)),
                ]
            );
        }
    }
}