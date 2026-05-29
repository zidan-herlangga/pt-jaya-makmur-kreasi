<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscriber;
use Illuminate\Database\Seeder;

class NewsletterSubscriberSeeder extends Seeder
{
    public function run(): void
    {
        $subscribers = [
            ['email' => 'budi@contoh.com'],
            ['email' => 'siti@contoh.com'],
            ['email' => 'ahmad@contoh.com'],
            ['email' => 'dewi@contoh.com'],
            ['email' => 'rudi@contoh.com'],
            ['email' => 'rina@contoh.com'],
            ['email' => 'hendra@contoh.com'],
            ['email' => 'info@jayamakmur.com'],
            ['email' => 'marketing@contoh.com'],
            ['email' => 'promosi@contoh.com'],
        ];

        foreach ($subscribers as $i => $data) {
            NewsletterSubscriber::firstOrCreate(
                ['email' => $data['email']],
                [
                    'subscribed_at' => now()->subDays(fake()->numberBetween(1, 180)),
                ]
            );
        }

        $this->command->info('Newsletter subscribers seeded successfully.');
    }
}
