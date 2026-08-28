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
        | SECONDAIRE GÉNÉRAL
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
                        'EPS',
                    ],

                    '2nde'
                    => [
                        'Mathématiques',
                        'Français',
                        'Anglais',
                        'Histoire-Géographie',
                        'SVT',
                        'Physique-Chimie',
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
                        'Physique-Chimie',
                    ],

                    default => [],
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
                        'Informatique',
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SUPÉRIEUR
        |--------------------------------------------------------------------------
        */

        $filieres = Filiere::where(
            'is_active',
            true
        )->get();

        foreach ($filieres as $filiere) {

            foreach ($filiere->levels as $level) {

                $this->createSubjects(
                    $level,
                    [
                        'Cours magistral',
                        'Travaux dirigés',
                        'Travaux pratiques',
                        'Projet',
                        'Examen',
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ENEP
        |--------------------------------------------------------------------------
        |
        | Quelques modules uniquement pour les tests.
        |--------------------------------------------------------------------------
        */

        $enep = Formation::where(
            'slug',
            'enep'
        )->first();

        if ($enep) {

            $levels = Level::where(
                'formation_id',
                $enep->id
            )
                ->whereNull('specialite_id')
                ->where('is_active', true)
                ->get();

            foreach ($levels as $level) {

                if ($level->slug === 'premiere-annee') {

                    $this->createSubjects(
                        $level,
                        [
                            'Pédagogie générale',
                            'Psychopédagogie',
                            'Français',
                            'Mathématiques',
                            'EPS',
                            'Informatique',
                        ]
                    );
                }

                if ($level->slug === 'deuxieme-annee') {

                    $this->createSubjects(
                        $level,
                        [
                            'Stage pratique',
                            'Mise en pratique pédagogique',
                            'Didactique des disciplines',
                            'Gestion de classe',
                            'Évaluation',
                        ]
                    );
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ENSP
        |--------------------------------------------------------------------------
        |
        | Quelques modules de test par spécialité et par niveau.
        |--------------------------------------------------------------------------
        */

        $ensp = Formation::where(
            'slug',
            'ensp'
        )->first();

        if ($ensp) {

            $levels = Level::where(
                'formation_id',
                $ensp->id
            )
                ->whereNotNull('specialite_id')
                ->where('is_active', true)
                ->get();

            foreach ($levels as $level) {

                $this->createSubjects(
                    $level,
                    [
                        'Cours théorique',
                        'Travaux pratiques',
                        'Stage',
                        'Évaluation',
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IDS
        |--------------------------------------------------------------------------
        |
        | Les mêmes modules pour les spécialités :
        |
        | Mathématique-Physique-Chimie
        | Mathématique-SVT
        | EPS
        |--------------------------------------------------------------------------
        */

        $ids = Formation::where(
            'slug',
            'ids'
        )->first();

        if ($ids) {

            $levels = Level::where(
                'formation_id',
                $ids->id
            )
                ->whereNotNull('specialite_id')
                ->where('is_active', true)
                ->get();

            foreach ($levels as $level) {

                $this->createSubjects(
                    $level,
                    [
                        'Cours',
                        'Travaux dirigés',
                        'Travaux pratiques',
                        'Devoir',
                        'Rapport',
                        'Annale',
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UIT
        |--------------------------------------------------------------------------
        |
        | BTP
        | Électricité & Froid & Climatisation
        | Marketing Gestion & Comptabilité
        |
        | L1 → L3
        |--------------------------------------------------------------------------
        */

        $uit = Formation::where(
            'slug',
            'uit'
        )->first();

        if ($uit) {

            $levels = Level::where(
                'formation_id',
                $uit->id
            )
                ->whereNotNull('specialite_id')
                ->where('is_active', true)
                ->get();

            foreach ($levels as $level) {

                $this->createSubjects(
                    $level,
                    [
                        'Cours',
                        'Travaux dirigés',
                        'Travaux pratiques',
                        'Devoir',
                        'Rapport',
                        'Annale',
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ENS
        |--------------------------------------------------------------------------
        |
        | NE PAS MODIFIER
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
                                'Mémoire',
                            ]
                        );
                    }
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CRÉATION DES MODULES
    |--------------------------------------------------------------------------
    */

    private function createSubjects(
        Level $level,
        array $subjects
    ): void {

        foreach ($subjects as $position => $subject) {

            Subject::updateOrCreate(
                [
                    'level_id' => $level->id,
                    'slug' => Str::slug($subject),
                ],
                [
                    'name' => $subject,
                    'position' => $position + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}