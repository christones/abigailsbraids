<?php

namespace Database\Factories;

use App\Models\Training;
use App\Models\TrainingRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrainingRegistration>
 */
class TrainingRegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'training_id' => Training::factory(),
            'candidate_name' => fake()->name(),
            'candidate_email' => fake()->safeEmail(),
            'candidate_phone' => fake()->phoneNumber(),
            'preferred_date' => fake()->dateTimeBetween('+1 day', '+2 months')->format('Y-m-d'),
            'experience_level' => fake()->randomElement(['Débutante', 'Intermédiaire', 'Confirmée']),
            'message' => fake()->optional()->sentence(),
            'status' => TrainingRegistration::STATUS_PENDING,
        ];
    }
}
