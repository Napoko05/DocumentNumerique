<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = Hash::make('password123');

        // 👤 UTILISATEUR FINAL UNIQUEMENT
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'nom' => 'Utilisateur',
                'prenom' => 'Test',
                'password' => $password,
                'statut_compte' => 'actif',
            ]
        );
    }
}