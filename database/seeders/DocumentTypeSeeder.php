<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {

        $types = [

            [
                'name' => 'Cours',
                'icon' => '📚',
                'description' => 'Support de cours pédagogique.',
            ],

            [
                'name' => 'Exercices',
                'icon' => '📝',
                'description' => 'Exercices et travaux dirigés.',
            ],

            [
                'name' => 'Corrigés',
                'icon' => '✅',
                'description' => 'Solutions et corrections.',
            ],

            [
                'name' => 'Sujets d’examen',
                'icon' => '📄',
                'description' => 'Sujets d examens et évaluations.',
            ],

            [
                'name' => 'Annales',
                'icon' => '📖',
                'description' => 'Anciens sujets et examens.',
            ],

            [
                'name' => 'Travaux Pratiques',
                'icon' => '🔬',
                'description' => 'Documents liés aux travaux pratiques.',
            ],

            [
                'name' => 'Rapports',
                'icon' => '📑',
                'description' => 'Rapports académiques et professionnels.',
            ],

            [
                'name' => 'Mémoires',
                'icon' => '🎓',
                'description' => 'Mémoires de fin de cycle.',
            ],

            [
                'name' => 'Thèses',
                'icon' => '🏛️',
                'description' => 'Travaux de recherche doctorale.',
            ],

            [
                'name' => 'Articles scientifiques',
                'icon' => '📰',
                'description' => 'Articles et publications scientifiques.',
            ],

            [
                'name' => 'Fiches de révision',
                'icon' => '📌',
                'description' => 'Fiches synthétiques de révision.',
            ],

            [
                'name' => 'Concours',
                'icon' => '🏆',
                'description' => 'Documents de préparation aux concours.',
            ],

        ];

        foreach ($types as $type) {


            DocumentType::updateOrCreate(

                [
                    'slug' => Str::slug($type['name'])
                ],

                [

                    'name' => $type['name'],

                    'icon' => $type['icon'],

                    'description' => $type['description'],

                    'is_active' => true,

                ]

            );
        }
    }
}
