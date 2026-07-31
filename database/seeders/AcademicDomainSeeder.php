<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicDomain;

class AcademicDomainSeeder extends Seeder
{
    public function run(): void
    {

        $domains = [

            [
                'name' => 'Sciences exactes',
                'slug' => 'sciences-exactes',
                'description' => 'Formations scientifiques, informatiques, technologiques et d’ingénierie.',
                'icon' => 'bi-cpu',
                'position' => 1,
                'is_active' => true,
            ],


            [
                'name' => 'Sciences sociales',
                'slug' => 'sciences-sociales',
                'description' => 'Formations en sciences sociales, économie, gestion, droit et disciplines humaines.',
                'icon' => 'bi-people',
                'position' => 2,
                'is_active' => true,
            ],


            [
                'name' => 'sciences des langues',
                'slug' => 'sciences des langues',
                'description' => 'Formations en langues, lettres, communication et cultures.',
                'icon' => 'bi-translate',
                'position' => 3,
                'is_active' => true,
            ],

        ];


        foreach ($domains as $domain) {

            AcademicDomain::updateOrCreate(

                [
                    'slug' => $domain['slug']
                ],

                $domain

            );

        }

    }
}