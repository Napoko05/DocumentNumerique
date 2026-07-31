<?php

namespace Database\Seeders;

use App\Models\AcademicDomain;
use App\Models\Filiere;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FiliereSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SCIENCES EXACTES ET TECHNOLOGIES
        |--------------------------------------------------------------------------
        */

        $this->createFilieres(
            'sciences-exactes',
            [
                'Informatique',
                'Génie Informatique',
                'Génie Logiciel',
                'Génie Civil',
                'Génie Électrique',
                'Génie Mécanique',
                'Mathématiques',
                'Physique',
                'Chimie',
                'Biologie',
                'Statistiques',
                'Géologie',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | SCIENCES SOCIALES
        |--------------------------------------------------------------------------
        */

        $this->createFilieres(
            'sciences-sociales',
            [
                'Droit',
                'Économie',
                'Gestion',
                'Comptabilité',
                'Finance',
                'Marketing',
                'Banque et Assurance',
                'Ressources Humaines',
                'Sociologie',
                'Psychologie',
                'Science Politique',
                'Histoire',
                'Géographie',
            ]
        );


        /*
        |--------------------------------------------------------------------------
        | SCIENCES DU LANGAGE
        |--------------------------------------------------------------------------
        */

        $this->createFilieres(
            'sciences des langues',
            [
                'Français',
                'Anglais',
                'Allemand',
                'Espagnol',
                'Arabe',
                'Linguistique',
                'Communication',
                'Journalisme',
                'Traduction',
                'Lettres Modernes',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CRÉATION DES FILIÈRES D'UN DOMAINE
    |--------------------------------------------------------------------------
    */

    private function createFilieres(
        string $domaineSlug,
        array $filieres
    ): void {

        $domaine = AcademicDomain::where(
            'slug',
            $domaineSlug
        )->first();


        if (!$domaine) {

            return;

        }


        foreach ($filieres as $nom) {

            Filiere::updateOrCreate(

                [
                    'academic_domain_id' => $domaine->id,
                    'slug' => Str::slug($nom),
                ],

                [
                    'name' => $nom,
                    'description' => null,
                    'icon' => '📚',
                    'is_active' => true,
                ]

            );

        }

    }
}
