<?php

namespace Database\Seeders;

use App\Models\ServiceCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Seed provisional service categories.
     *
     * These names are placeholders so the catalogue has a working structure;
     * the final category names will be provided by the salon owner and can
     * be renamed, reordered, or replaced at any time from /admin/prestations/categories.
     */
    public function run(): void
    {
        $categories = [
            'Tresses collées',
            'Braids',
            'Styles bohèmes/bouclés',
            'Crochet Braids',
            'Vanilles',
            'Enfants',
            'Soins',
        ];

        foreach ($categories as $index => $name) {
            ServiceCategory::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
