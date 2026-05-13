<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group')->default('general');
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('label')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        $now = now();
        $settings = [
            ['general', 'site_name', 'PT. Jaya Makmur', 'text', 'Nama Situs', 'Nama website / perusahaan'],
            ['general', 'site_description', 'Solusi Reklame Profesional & Billboard Terbaik', 'text', 'Deskripsi Situs', 'Deskripsi singkat website'],
            ['general', 'site_url', url('/'), 'text', 'URL Situs', 'URL utama website'],
            ['general', 'site_language', 'id', 'text', 'Bahasa', 'Kode bahasa situs'],
            ['general', 'admin_email', 'admin@jayamakmur.com', 'text', 'Email Admin', 'Email untuk notifikasi admin'],

            ['seo', 'meta_title', 'PT. Jaya Makmur - Solusi Reklame Profesional', 'text', 'Meta Title Default', 'Judul default untuk SEO'],
            ['seo', 'meta_description', 'PT. Jaya Makmur - Jasa reklame profesional untuk branding bisnis Anda.', 'text', 'Meta Description Default', 'Deskripsi default untuk SEO'],
            ['seo', 'meta_keywords', 'reklame, billboard, jasa reklame, iklan luar ruang', 'text', 'Meta Keywords', 'Keyword default untuk SEO'],
            ['seo', 'og_image', '', 'image', 'OG Image Default', 'Gambar default untuk social media分享'],

            ['social', 'facebook_url', '#', 'text', 'Facebook', 'URL Facebook'],
            ['social', 'instagram_url', '#', 'text', 'Instagram', 'URL Instagram'],
            ['social', 'linkedin_url', '#', 'text', 'LinkedIn', 'URL LinkedIn'],
            ['social', 'whatsapp_number', '6281234567890', 'text', 'Nomor WhatsApp', 'Format: 628xxx tanpa + atau spasi'],
            ['social', 'whatsapp_text', 'Halo saya tertarik dengan layanan reklame', 'text', 'Pesan WhatsApp', 'Pesan default untuk tombol WhatsApp'],

            ['contact', 'address', 'Jl. Sudirman No. 123, Jakarta Pusat', 'text', 'Alamat', 'Alamat perusahaan'],
            ['contact', 'phone', '+62 812-3456-7890', 'text', 'Telepon', 'Nomor telepon perusahaan'],
            ['contact', 'email', 'info@jayamakmur.com', 'text', 'Email', 'Email kontak perusahaan'],

            ['appearance', 'favicon', '', 'image', 'Favicon', 'Icon tab browser (32x32 px)'],
            ['appearance', 'logo', '', 'image', 'Logo', 'Logo website'],
            ['appearance', 'primary_color', '#16a34a', 'text', 'Warna Utama', 'Warna primer tema (hex)'],
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
        Schema::dropIfExists('settings');
    }
};
