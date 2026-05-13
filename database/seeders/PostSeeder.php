<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::first();
        $postCategories = Category::byType('post')->pluck('id');

        if (!$author || $postCategories->isEmpty()) {
            $this->command->warn('No author or post categories found. Run UserSeeder and CategorySeeder first.');
            return;
        }

        $posts = [
            [
                'title' => 'Tips Memilih Lokasi Billboard yang Tepat untuk Bisnis Anda',
                'content' => "Memilih lokasi billboard yang tepat adalah salah satu keputusan paling penting dalam strategi pemasaran outdoor. Berikut adalah tips yang perlu Anda perhatikan:\n\n1. **Analisis Lalu Lintas**\nPastikan lokasi billboard memiliki volume lalu lintas yang tinggi, baik kendaraan maupun pejalan kaki. Semakin banyak mata yang melihat, semakin efektif iklan Anda.\n\n2. **Target Audiens**\nSesuaikan lokasi dengan target pasar Anda. Misalnya, jika target Anda adalah profesional muda, pilih billboard di kawasan bisnis atau perkantoran.\n\n3. **Visibilitas**\nPastikan billboard tidak terhalang oleh pohon, bangunan, atau reklame lain. Jarak pandang minimal 50 meter sangat ideal.\n\n4. **Pencahayaan**\nBillboard dengan pencahayaan LED atau neon akan efektif 24 jam. Jangan remehkan exposure di malam hari.\n\n5. **Regulasi**\nPastikan billboard memiliki izin yang lengkap. Bekerjasamalah dengan penyedia jasa reklame profesional untuk mengurus perizinan.\n\nDengan mempertimbangkan faktor-faktor di atas, investasi billboard Anda akan memberikan ROI yang maksimal.",
                'category_index' => 0,
            ],
            [
                'title' => 'Keuntungan Menggunakan Neon Box untuk Brand Anda',
                'content' => "Neon box adalah media reklame yang menggunakan tabung gas neon atau lampu LED untuk menghasilkan efek cahaya yang menarik. Berikut adalah keuntungan menggunakan neon box:\n\n**Tahan Lama**\nNeon box modern dengan teknologi LED dapat bertahan hingga 50.000 jam atau sekitar 5-6 tahun penggunaan terus menerus.\n\n**Biaya Operasional Rendah**\nKonsumsi listrik LED sangat efisien, hanya sekitar 30-40% dari lampu neon konvensional.\n\n**Desain Fleksibel**\nNeon box dapat dibentuk dalam berbagai ukuran, warna, dan desain sesuai kebutuhan brand Anda.\n\n**Visibilitas 24 Jam**\nDengan pencahayaan yang terang, neon box tetap efektif di malam hari, memberikan exposure terus menerus.\n\n**Kesan Premium**\nNeon box memberikan kesan profesional dan premium yang meningkatkan brand image di mata konsumen.\n\nPilih neon box untuk solusi reklame yang elegan dan efektif untuk bisnis Anda.",
                'category_index' => 2,
            ],
            [
                'title' => 'Perbedaan Billboard, Baliho, dan Videotron',
                'content' => "Dalam dunia reklame outdoor, ada beberapa jenis media yang sering digunakan. Berikut perbedaannya:\n\n**Billboard**\n- Ukuran besar (4x6m hingga 10x20m)\n- Material vinyl atau kain\n- Dipasang secara permanen di struktur khusus\n- Untuk kampanye jangka panjang (3-12 bulan)\n\n**Baliho**\n- Ukuran besar, mirip billboard\n- Bersifat temporer\n- Pemasangan lebih sederhana\n- Untuk event atau promosi singkat (1-4 minggu)\n\n**Videotron**\n- Layar LED digital\n- Dapat menampilkan video bergerak\n- Konten dapat diubah kapan saja\n- Biaya lebih tinggi, tapi lebih interaktif\n\n**Neon Box**\n- Menggunakan pencahayaan internal\n- Ukuran bervariasi\n- Cocok untuk identitas brand\n- Efektif siang dan malam\n\nPilih media yang sesuai dengan kebutuhan kampanye dan anggaran Anda.",
                'category_index' => 3,
            ],
            [
                'title' => 'Strategi Pemasaran dengan Media Luar Ruang di Era Digital',
                'content' => "Di era digital, media luar ruang (Out-of-Home/OOH) justru semakin relevan. Berikut strategi yang bisa Anda terapkan:\n\n**1. Integrasi Digital**\nGunakan QR code atau NFC pada billboard untuk menghubungkan audiens ke landing page atau media sosial Anda.\n\n**2. Data-Driven**\nGunakan data lalu lintas dan demografi untuk memilih lokasi yang paling strategis.\n\n**3. Programmatic OOH**\nManfaatkan teknologi programmatic untuk mengelola jadwal tayang iklan videotron secara real-time.\n\n**4. Creative Content**\nBuat konten yang kreatif dan memorable. Iklan outdoor yang unik akan menjadi viral di media sosial.\n\n**5. Multi-Channel**\nKombinasikan OOH dengan kampanye digital untuk hasil maksimal. Contohnya, billboard + Instagram ads.\n\nMedia luar ruang tetap menjadi salah satu channel pemasaran paling efektif jika dikelola dengan strategi yang tepat.",
                'category_index' => 0,
            ],
            [
                'title' => 'Panduan Lengkap Sewa Billboard untuk Pemula',
                'content' => "Baru pertama kali menyewa billboard? Berikut panduan lengkapnya:\n\n**1. Tentukan Tujuan**\nApa tujuan Anda? Brand awareness, promosi produk, atau event? Tujuan akan menentukan lokasi dan durasi sewa.\n\n**2. Pilih Lokasi**\nSesuaikan dengan target audiens. Billboard di pusat kota lebih mahal tapi exposure lebih besar.\n\n**3. Tentukan Ukuran**\nUkuran standar: 4x6m, 5x10m, 8x12m. Semakin besar, semakin mahal.\n\n**4. Durasi Sewa**\nMinimal sewa biasanya 3 bulan. Semakin panjang durasi, biasanya ada diskon.\n\n**5. Biaya Produksi**\nSelain biaya sewa, ada biaya cetak/desain vinyl. Budgetkan Rp 1-3 juta untuk cetak.\n\n**6. Perizinan**\nPastikan billboard memiliki izin reklame. Penyedia jasa terpercaya akan mengurus ini.\n\n**7. Evaluasi**\nPantau performa billboard Anda. Hitung ROI berdasarkan peningkatan traffic, penjualan, atau brand awareness.\n\nDengan panduan ini, Anda siap memulai kampanye billboard pertama Anda!",
                'category_index' => 3,
            ],
            [
                'title' => 'Tren Reklame Digital di Tahun 2026',
                'content' => "Tahun 2026 membawa perubahan signifikan dalam industri reklame. Berikut tren yang perlu Anda ketahui:\n\n**1. DOOH (Digital Out-of-Home)**\nVideotron dan billboard digital semakin mendominasi. Konten dapat diubah secara real-time.\n\n**2. AI-Powered Advertising**\nKecerdasan buatan digunakan untuk menargetkan iklan berdasarkan waktu, cuaca, dan demografi.\n\n**3. Interactive Billboards**\nBillboard interaktif dengan layar sentuh dan sensor gerak yang melibatkan audiens.\n\n**4. Sustainability**\nMedia reklame ramah lingkungan dengan material daur ulang dan LED hemat energi.\n\n**5. Programmatic OOH**\nPembelian slot iklan secara otomatis melalui platform digital.\n\n**6. Hyperlocal Targeting**\nIklan yang ditargetkan secara spesifik berdasarkan lokasi geografis.\n\nTetap update dengan tren terbaru untuk memaksimalkan efektivitas kampanye reklame Anda.",
                'category_index' => 1,
            ],
        ];

        foreach ($posts as $postData) {
            $categoryId = $postCategories[$postData['category_index'] % $postCategories->count()];

            Post::firstOrCreate(
                ['slug' => str($postData['title'])->slug()],
                [
                    'author_id' => $author->id,
                    'category_id' => $categoryId,
                    'title' => $postData['title'],
                    'content_body' => $postData['content'],
                    'status' => 'published',
                    'view_count' => fake()->numberBetween(100, 3000),
                    'published_at' => now()->subDays(fake()->numberBetween(1, 90)),
                ]
            );
        }
    }
}
