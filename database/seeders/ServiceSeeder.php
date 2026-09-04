<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Seed the application's services.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Box Braids',
                'description' => 'Nattes classiques et intemporelles, réalisées avec de la extension de votre choix, pour un résultat élégant qui dure plusieurs semaines.',
                'duration_minutes' => 240,
                'price_from' => 90.00,
                'image_path' => 'images/braids8.jpg',
            ],
            [
                'name' => 'Knotless Braids',
                'description' => 'Tresses sans nœuds à la racine pour un confort optimal et un rendu naturel, idéales pour préserver le cuir chevelu.',
                'duration_minutes' => 270,
                'price_from' => 110.00,
                'image_path' => 'images/braids9.jpg',
            ],
            [
                'name' => 'Vanilles (Twists)',
                'description' => 'Torsades soignées, légères et élégantes, parfaites pour un style naturel au quotidien.',
                'duration_minutes' => 180,
                'price_from' => 80.00,
                'image_path' => 'images/braids7.jpg',
            ],
            [
                'name' => 'Cornrows / Plaquées',
                'description' => 'Tresses collées au cuir chevelu, en motifs libres ou personnalisés, pour un look net et soigné.',
                'duration_minutes' => 120,
                'price_from' => 50.00,
                'image_path' => 'images/braids4.jpg',
            ],
            [
                'name' => 'Tresses avec Extensions Colorées',
                'description' => 'Ajoutez de la couleur à vos tresses avec des mèches synthétiques de qualité, dans le ton de votre choix.',
                'duration_minutes' => 240,
                'price_from' => 100.00,
                'image_path' => 'images/braids20.jpg',
            ],
            [
                'name' => 'Locks / Faux Locs',
                'description' => 'Fausses locks légères et texturées pour un style bohème et affirmé, sans engagement long terme.',
                'duration_minutes' => 300,
                'price_from' => 130.00,
                'image_path' => 'images/braids5.jpg',
            ],
            [
                'name' => 'Coiffure Enfant',
                'description' => 'Tresses douces et adaptées pour les petites princesses, dans une ambiance calme et bienveillante.',
                'duration_minutes' => 90,
                'price_from' => 35.00,
                'image_path' => 'images/braids13.jpg',
            ],
            [
                'name' => 'Soin & Démêlage',
                'description' => 'Soin capillaire en profondeur et démêlage en douceur avant toute prestation de tresses.',
                'duration_minutes' => 60,
                'price_from' => 25.00,
                'image_path' => 'images/braids6.jpg',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::updateOrCreate(
                ['slug' => Str::slug($service['name'])],
                [
                    'name' => $service['name'],
                    'description' => $service['description'],
                    'duration_minutes' => $service['duration_minutes'],
                    'price_from' => $service['price_from'],
                    'image_path' => $service['image_path'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
