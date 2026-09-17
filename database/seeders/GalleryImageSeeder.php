<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use Illuminate\Database\Seeder;

class GalleryImageSeeder extends Seeder
{
    /**
     * Seed the application's gallery images.
     */
    public function run(): void
    {
        $images = [
            ['images/braids8.jpg', 'Box Braids'],
            ['images/braids9.jpg', 'Knotless Braids'],
            ['images/braids7.jpg', 'Vanilles / Twists'],
            ['images/braids4.jpg', 'Cornrows'],
            ['images/braids20.jpg', 'Extensions colorées'],
            ['images/braids5.jpg', 'Faux Locs'],
            ['images/braids13.jpg', 'Coiffure Enfant'],
            ['images/braids6.jpg', 'Soin & Démêlage'],
            ['images/braids.jpg', 'Coiffure Enfant'],
            ['images/braids2.jpg', 'Cheveux naturels'],
            ['images/braids3.jpg', 'Box Braids'],
            ['images/braids10.jpg', 'Coiffure Enfant'],
            ['images/braids11.jpg', 'Coiffure Enfant'],
            ['images/braids12.jpg', 'Coiffure Enfant'],
            ['images/braids14.jpg', 'Coiffure Enfant'],
            ['images/braids15.jpg', 'Vanilles / Twists'],
            ['images/braids17.jpg', 'Coiffure Enfant'],
            ['images/braids19.jpg', 'Cornrows'],
            ['images/braids21.jpg', 'Extensions colorées'],
            ['images/braids23.jpg', 'Extensions colorées'],
            ['images/braids24.jpg', 'Extensions colorées'],
            ['images/braids25.jpg', 'Cornrows'],
            ['images/braids26.jpg', 'Cornrows'],
            ['images/braids27.jpg', 'Box Braids'],
        ];

        foreach ($images as $index => [$path, $label]) {
            GalleryImage::updateOrCreate(
                ['image_path' => $path],
                [
                    'label' => $label,
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
