<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Créer un utilisateur de test
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Créer quelques produits
        \App\Models\Product::create([
            'nom' => 'Smartphone X',
            'description' => 'Dernier modèle avec 5G',
            'prix' => 999.99,
            'quantite_stock' => 50
        ]);

        \App\Models\Product::create([
            'nom' => 'Casque Audio',
            'description' => 'Réduction de bruit active',
            'prix' => 199.50,
            'quantite_stock' => 100
        ]);
        
        \App\Models\Product::create([
            'nom' => 'Clavier Mécanique',
            'description' => 'Switchs bleus clicky',
            'prix' => 89.99,
            'quantite_stock' => 30
        ]);
    }
}
