<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrainingSeeder extends Seeder
{
    /**
     * Seed the application's trainings.
     */
    public function run(): void
    {
        $trainings = [
            [
                'name' => 'Initiation aux tresses',
                'description' => 'Découvrez les bases du tressage africain : sections, cornrows simples et plaquages, dans une ambiance conviviale et pédagogique.',
                'level' => 'Débutant',
                'duration_minutes' => 360,
                'price_from' => 150.00,
                'image_path' => 'images/training2.jpg',
            ],
            [
                'name' => 'Perfectionnement Box Braids & Knotless',
                'description' => 'Techniques avancées de pose de mèches, gestion de la tension et finitions soignées pour des box braids et knotless braids impeccables.',
                'level' => 'Intermédiaire',
                'duration_minutes' => 720,
                'price_from' => 280.00,
                'image_path' => 'images/training1.jpg',
            ],
            [
                'name' => 'Formation professionnelle complète',
                'description' => 'Un parcours complet pour devenir tresseuse professionnelle : toutes les techniques, hygiène et matériel, relation client et gestion d\'un salon.',
                'level' => 'Tous niveaux',
                'duration_minutes' => 1800,
                'price_from' => 650.00,
                'image_path' => 'images/trainer.jpg',
            ],
        ];

        foreach ($trainings as $index => $training) {
            Training::updateOrCreate(
                ['slug' => Str::slug($training['name'])],
                [
                    'name' => $training['name'],
                    'description' => $training['description'],
                    'level' => $training['level'],
                    'duration_minutes' => $training['duration_minutes'],
                    'price_from' => $training['price_from'],
                    'image_path' => $training['image_path'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
