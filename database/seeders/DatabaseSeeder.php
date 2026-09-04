<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Compte administrateur pour gérer les réservations depuis /admin.
        // Définissez ADMIN_EMAIL / ADMIN_PASSWORD dans .env avant de déployer en
        // production, ou changez le mot de passe une fois connecté(e).
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@abigailsbraids.fr')],
            [
                'name' => 'Abigail',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            ServiceSeeder::class,
        ]);
    }
}
