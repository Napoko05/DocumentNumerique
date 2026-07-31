<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Subject;
use App\Models\Level;
use App\Models\Formation;
use App\Models\Filiere;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {

        /*
        |--------------------------------------------------------------------------
        | SECONDAIRE GENERAL
        |--------------------------------------------------------------------------
        */
        $formationGeneral = Formation::where(
            'slug',
            'secondaire-general'
        )->first();

        if ($formationGeneral) {

            $levelsGeneral = Level::where(
                'formation_id',
                $formationGeneral->id
            )
                ->where('is_active', true)
                ->get();

            foreach ($levelsGeneral as $level) {
                $subjects = match ($level->slug) {

                    '6eme',
                    '5eme',
                    '4eme',
                    '3eme'
                    => [

                        'Mathématiques',
                        'Français',
                        'Anglais',
                        'Histoire-Géographie',
                        'SVT',
                        'Physique-Chimie',
                        'EPS'

                    ],



                    '2nde'
                    => [

                        'Mathématiques',
                        'Français',
                        'Anglais',
                        'Histoire-Géographie',
                        'SVT',
                        'Physique-Chimie'

                    ],
                    '1ere',
                    'terminale'
                    => [

                        'Mathématiques',
                        'Français',
                        'Anglais',
                        'Histoire-Géographie',
                        'Philosophie',
                        'SVT',
                        'Physique-Chimie'

                    ],


                    default => []
                };
                $this->createSubjects(
                    $level,
                    $subjects
                );
            }
        }
        /*
        |--------------------------------------------------------------------------
        | SECONDAIRE TECHNIQUE
        |--------------------------------------------------------------------------
        */
        $formationTechnique = Formation::where(
            'slug',
            'secondaire-technique'
        )->first();

        if ($formationTechnique) {

            $levelsTechnique = Level::where(
                'formation_id',
                $formationTechnique->id
            )
                ->where('is_active', true)
                ->get();

            foreach ($levelsTechnique as $level) {
                $this->createSubjects(
                    $level,
                    [

                        'Mathématiques',
                        'Français',
                        'Anglais',
                        'Technologie',
                        'Dessin Technique',
                        'Électricité',
                        'Électronique',
                        'Informatique',
                        'Automatique',
                        'Mécanique',
                        'Construction',
                        'Économie',
                        'Gestion',
                        'Comptabilité'

                    ]
                );
            }
        }
        /*
        |--------------------------------------------------------------------------
        | SUPERIEUR
        |--------------------------------------------------------------------------
        |
        | Domaine académique
        |        ↓
        | Filière
        |        ↓
        | Niveau
        |        ↓
        | Matière
        |
        */
        $filieres = Filiere::where(
            'is_active',
            true
        )
            ->get();

        foreach ($filieres as $filiere) {
            foreach ($filiere->levels as $level) {
                $this->createSubjects(

                    $level,

                    [

                        'Cours magistral',
                        'Travaux dirigés',
                        'Travaux pratiques',
                        'Projet',
                        'Examen'
                    ]

                );
            }
        }
        /*
        |--------------------------------------------------------------------------
        | ENS
        |--------------------------------------------------------------------------
        */
        $ens = Formation::where(
            'slug',
            'ens'
        )->first();
        if ($ens) {
            foreach ($ens->programs as $program) {
                foreach ($program->specialites as $specialite) {
                    foreach ($specialite->levels as $level) {
                        $this->createSubjects(

                            $level,

                            [
                                'Cours magistral',
                                'Travaux dirigés',
                                'Travaux pratiques',
                                'Stage',
                                'Mémoire'
                            ]
                        );
                    }
                }
            }
        }
    }
    /*
    |--------------------------------------------------------------------------
    | CREATION DES MATIERES
    |--------------------------------------------------------------------------
    */
    private function createSubjects(
        Level $level,
        array $subjects
    ): void {
        foreach ($subjects as $subject) {
            Subject::updateOrCreate(

                [
                    'level_id' => $level->id,

                    'slug' => Str::slug($subject),

                ],
                [

                    'name' => $subject,

                    'is_active' => true,

                ]
            );
        }
    }
}
