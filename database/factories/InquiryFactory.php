<?php

namespace Database\Factories;

use App\Models\AdvertisingPoint;
use App\Models\Inquiry;
use Illuminate\Database\Eloquent\Factories\Factory;

class InquiryFactory extends Factory
{
    protected $model = Inquiry::class;

    public function definition(): array
    {
        return [
            'product_id' => AdvertisingPoint::factory(),
            'sender_name' => fake()->name(),
            'sender_email' => fake()->safeEmail(),
            'sender_phone' => fake()->phoneNumber(),
            'company_name' => fake()->randomElement([
                fake()->company(), null, null,
            ]),
            'message' => fake()->paragraph(fake()->numberBetween(1, 3)),
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'status' => 'pending',
        ];
    }

    public function processed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'processed',
            'handled_at' => now(),
        ]);
    }

    public function spam(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'spam',
            'honeypot_field' => 'bot',
        ]);
    }

    public function withoutProduct(): static
    {
        return $this->state(fn (array $attributes) => [
            'product_id' => null,
        ]);
    }
}
