<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'level' => fake()->randomElement(['Débutant', 'Intermédiaire', 'Tous niveaux']),
            'duration_minutes' => fake()->randomElement([360, 720, 1800]),
            'price_from' => fake()->randomFloat(2, 100, 700),
            'image_path' => null,
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
