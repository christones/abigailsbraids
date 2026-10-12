<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Seed the shop's product categories with their cover pictures
     * (public/images/categories). Safe to run again: existing categories
     * (matched on their slug) keep their id, order and products, and only
     * get their picture/description filled in.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Coiffure & Tresses', 'description' => 'Mèches et indispensables pour réaliser vos tresses.'],
            ['name' => 'Formations professionnelles', 'description' => 'Kits et supports pour apprendre le tressage.'],
            ['name' => 'Perruques & Toppers', 'description' => 'Perruques et toppers naturels pour changer de style en un instant.'],
            ['name' => 'Postiches & Extensions', 'description' => 'Postiches et extensions pour plus de volume.'],
            ['name' => 'Maquillage & Beauté', 'description' => 'Maquillage et soins beauté pour compléter votre mise en beauté.'],
            ['name' => 'Accessoires & Entretien', 'description' => 'Brosses, huiles et bonnets en satin pour vos cheveux.'],
        ];

        foreach ($categories as $index => $data) {
            $slug = Str::slug($data['name']);

            $category = ProductCategory::firstOrNew(['slug' => $slug]);

            if (! $category->exists) {
                $category->fill([
                    'name' => $data['name'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]);
            }

            $category->image_path = "images/categories/{$slug}.jpg";
            $category->description = $category->description ?: $data['description'];
            $category->save();
        }
    }
}
