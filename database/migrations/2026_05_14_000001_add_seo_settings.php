<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();
        $settings = [
            ['verification', 'google_verification', '', 'text', 'Google Site Verification', 'Kode verifikasi Google Search Console (hanya kode, tanpa meta tag)'],
            ['verification', 'bing_verification', '', 'text', 'Bing Webmaster Verification', 'Kode verifikasi Bing Webmaster Tools'],
            ['verification', 'yandex_verification', '', 'text', 'Yandex Webmaster Verification', 'Kode verifikasi Yandex Webmaster'],
            ['verification', 'baidu_verification', '', 'text', 'Baidu Verification', 'Kode verifikasi Baidu'],
            ['verification', 'google_analytics_id', '', 'text', 'Google Analytics ID', 'ID Google Analytics (format: G-XXXXXXXXXX atau UA-XXXXX-X)'],
            ['verification', 'google_tag_manager', '', 'text', 'Google Tag Manager ID', 'ID Google Tag Manager (format: GTM-XXXXXXX)'],
            ['seo', 'meta_robots', 'index, follow', 'text', 'Meta Robots Default', 'Default robots meta directive (index, follow / noindex, nofollow)'],
            ['seo', 'facebook_page_id', '', 'text', 'Facebook Page ID', 'ID halaman Facebook untuk Facebook Verification'],
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
            'google_verification',
            'bing_verification',
            'yandex_verification',
            'baidu_verification',
            'google_analytics_id',
            'google_tag_manager',
            'meta_robots',
            'facebook_page_id',
        ])->delete();
    }
};
