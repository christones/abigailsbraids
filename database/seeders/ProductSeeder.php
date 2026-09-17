<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's products.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Huile capillaire nourrissante',
                'description' => 'Mélange d\'huiles naturelles pour hydrater le cuir chevelu et fortifier les longueurs entre deux coiffures.',
                'price' => 14.90,
                'stock_quantity' => 20,
            ],
            [
                'name' => 'Spray démêlant',
                'description' => 'Facilite le démêlage en douceur, réduit la casse et laisse un fini brillant sans alourdir.',
                'price' => 11.50,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'Mousse coiffante boucles',
                'description' => 'Définit et discipline les boucles naturelles tout en préservant leur légèreté.',
                'price' => 13.00,
                'stock_quantity' => 15,
            ],
            [
                'name' => 'Bonnet en satin',
                'description' => 'Protège les coiffures la nuit, réduit les frottements et préserve l\'hydratation des cheveux.',
                'price' => 9.90,
                'stock_quantity' => 30,
            ],
        ];

        foreach ($products as $index => $product) {
            Product::updateOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock_quantity' => $product['stock_quantity'],
                    'sort_order' => $index,
                    'is_active' => true,
                ]
            );
        }
    }
}
