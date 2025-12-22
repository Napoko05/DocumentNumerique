<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $password = bcrypt('password123');

        // ADMIN
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin System',
                'password' => $password,
            ]
        );
        $admin->syncRoles(['admin']);

        // JOURNALISTE
        $journalist = User::firstOrCreate(
            ['email' => 'journalist@example.com'],
            [
                'name' => 'Journaliste',
                'password' => $password,
            ]
        );
        $journalist->syncRoles(['journalist']);

        // UTILISATEUR
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Utilisateur',
                'password' => $password,
            ]
        );
        $user->syncRoles(['user']);
    }
}
