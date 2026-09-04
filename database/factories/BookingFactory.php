<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'client_name' => fake()->name('female'),
            'client_email' => fake()->safeEmail(),
            'client_phone' => fake()->phoneNumber(),
            'preferred_date' => fake()->dateTimeBetween('+1 day', '+3 weeks')->format('Y-m-d'),
            'preferred_time' => fake()->randomElement(['09:00', '10:30', '13:00', '14:30', '16:00']),
            'hair_length' => fake()->randomElement(['Courts', 'Mi-longs', 'Longs', 'Très longs']),
            'notes' => fake()->optional()->sentence(),
            'status' => Booking::STATUS_PENDING,
        ];
    }
}
