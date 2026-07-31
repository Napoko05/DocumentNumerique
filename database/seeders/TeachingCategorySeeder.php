<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeachingCategory;

class TeachingCategorySeeder extends Seeder
{
    public function run(): void
    {

        $categories = [

            [
                'slug' => 'secondaire',
                'name' => 'Enseignement Secondaire',
                'description' => 'Enseignement secondaire général et technique de la 6ème à la Terminale.',
                'icon' => '🏫',
            ],


            [
                'slug' => 'superieur',
                'name' => 'Enseignement Supérieur',
                'description' => 'Formations universitaires avec domaines académiques, formations et filières.',
                'icon' => '🎓',
            ],


            [
                'slug' => 'professionnel',
                'name' => 'Enseignement Professionnel',
                'description' => 'Écoles et instituts professionnels : ENS, ENSP, ENEP, IDS, ATE et autres formations.',
                'icon' => '⚙️',
            ],


        ];



        foreach ($categories as $category)
        {

            TeachingCategory::updateOrCreate(

                [
                    'slug' => $category['slug']
                ],

                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'icon' => $category['icon'],
                    'is_active' => true,
                ]

            );

        }

    }
}