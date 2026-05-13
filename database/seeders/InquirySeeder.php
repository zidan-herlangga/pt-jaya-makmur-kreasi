<?php

namespace Database\Seeders;

use App\Models\AdvertisingPoint;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Database\Seeder;

class InquirySeeder extends Seeder
{
    public function run(): void
    {
        $points = AdvertisingPoint::pluck('id');

        if ($points->isEmpty()) {
            $this->command->warn('No advertising points found. Run AdvertisingPointSeeder first.');
            return;
        }

        $inquiries = [
            [
                'sender_name' => 'Budi Santoso',
                'sender_email' => 'budi@contoh.com',
                'sender_phone' => '081234567890',
                'company_name' => 'PT Maju Jaya',
                'message' => 'Selamat siang, saya tertarik dengan billboard di Jl. Sudirman. Apakah masih tersedia? Saya ingin menyewa untuk 6 bulan. Mohon info harga dan prosedur sewanya. Terima kasih.',
                'status' => 'pending',
            ],
            [
                'sender_name' => 'Siti Rahmawati',
                'sender_email' => 'siti@contoh.com',
                'sender_phone' => '081298765432',
                'company_name' => 'CV Kreatif Mandiri',
                'message' => 'Halo, kami ingin memasang neon box untuk toko kami di Bandung. Ada rekomendasi lokasi yang strategis? Kami butuh ukuran sekitar 2x4 meter. Mohon diinfo.',
                'status' => 'pending',
            ],
            [
                'sender_name' => 'Ahmad Hidayat',
                'sender_email' => 'ahmad@contoh.com',
                'sender_phone' => '087812345678',
                'company_name' => null,
                'message' => 'Mau tanya dong, untuk videotron di Surabaya, bisa untuk jadwal berapa lama minimal? Terus berapa biaya sewa per minggu? Makasih.',
                'status' => 'pending',
            ],
            [
                'sender_name' => 'Dewi Lestari',
                'sender_email' => 'dewi@contoh.com',
                'sender_phone' => '085612345678',
                'company_name' => 'PT Sejahtera Abadi',
                'message' => 'Kami berminat untuk menyewa rooftop sign di Makassar. Ada beberapa lokasi yang kami incar. Bisa dibantu untuk survey lokasi dan nego harga? Kami siap meeting minggu depan.',
                'status' => 'processed',
            ],
            [
                'sender_name' => 'Rudi Hermawan',
                'sender_email' => 'rudi@contoh.com',
                'sender_phone' => '082134567890',
                'company_name' => 'Toko Elektronik Rudi',
                'message' => 'Mau pesan baliho untuk promo tahun baru di Malang. Kira-kira berapa biaya sewa 1 bulan termasuk cetak? Lokasi di Jl. Soekarno Hatta.',
                'status' => 'pending',
            ],
            [
                'sender_name' => 'Rina Fitriani',
                'sender_email' => 'rina@contoh.com',
                'sender_phone' => '081378945612',
                'company_name' => 'PT Fashion Trendy',
                'message' => 'Kami mencari billboard di Yogyakarta untuk launching brand fashion baru. Target kami remaja dan dewasa muda. Ada rekomendasi lokasi yang cocok? Budget kami sekitar 15 juta per bulan.',
                'status' => 'pending',
            ],
            [
                'sender_name' => 'Hendra Gunawan',
                'sender_email' => 'hendra@contoh.com',
                'sender_phone' => '081567890123',
                'company_name' => 'CV Berkah Abadi',
                'message' => 'Selamat pagi, saya ingin tanya-tanya soal signage untuk kantor baru kami di Medan. Ukuran sekitar 3x5 meter. Mohon dikirimi katalog produk dan price list-nya ya. Terima kasih.',
                'status' => 'processed',
            ],
            [
                'sender_name' => 'Spammer Bot',
                'sender_email' => 'spam@example.com',
                'sender_phone' => null,
                'company_name' => null,
                'message' => 'Buy cheap followers! Visit our website for more details. We offer the best prices!',
                'status' => 'spam',
                'honeypot_field' => 'filled_by_bot',
            ],
        ];

        foreach ($inquiries as $index => $data) {
            $inquiryData = [
                'product_id' => $data['status'] !== 'spam' ? $points->random() : null,
                'sender_name' => $data['sender_name'],
                'sender_email' => $data['sender_email'],
                'sender_phone' => $data['sender_phone'],
                'company_name' => $data['company_name'],
                'message' => $data['message'],
                'status' => $data['status'],
                'ip_address' => fake()->ipv4(),
                'user_agent' => fake()->userAgent(),
            ];

            if (isset($data['honeypot_field'])) {
                $inquiryData['honeypot_field'] = $data['honeypot_field'];
            }

            if ($data['status'] === 'processed') {
                $admin = User::first();
                $inquiryData['handled_by'] = $admin?->id;
                $inquiryData['handled_at'] = now()->subDays(fake()->numberBetween(1, 10));
                $inquiryData['admin_notes'] = 'Sudah dihubungi via telepon. Customer akan follow up minggu depan.';
            }

            Inquiry::create($inquiryData);
        }
    }
}
