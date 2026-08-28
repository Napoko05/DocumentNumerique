<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;
use App\Models\Formation;
use App\Models\Filiere;
use App\Models\Specialite;

class LevelSeeder extends Seeder
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

            $levels = [
                [
                    'name' => '6ème',
                    'slug' => '6eme',
                    'order' => 1,
                ],
                [
                    'name' => '5ème',
                    'slug' => '5eme',
                    'order' => 2,
                ],
                [
                    'name' => '4ème',
                    'slug' => '4eme',
                    'order' => 3,
                ],
                [
                    'name' => '3ème',
                    'slug' => '3eme',
                    'order' => 4,
                ],
                [
                    'name' => '2nde',
                    'slug' => '2nde',
                    'order' => 5,
                ],
                [
                    'name' => '1ère',
                    'slug' => '1ere',
                    'order' => 6,
                ],
                [
                    'name' => 'Terminale',
                    'slug' => 'terminale',
                    'order' => 7,
                ],
            ];

            foreach ($levels as $level) {
                Level::updateOrCreate(
                    [
                        'formation_id' => $formationGeneral->id,
                        'filiere_id' => null,
                        'specialite_id' => null,
                        'slug' => $level['slug'],
                    ],
                    [
                        'formation_id' => $formationGeneral->id,
                        'filiere_id' => null,
                        'specialite_id' => null,
                        'name' => $level['name'],
                        'order' => $level['order'],
                        'is_active' => true,
                    ]
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

            $levels = [
                [
                    'name' => '1ère année',
                    'slug' => '1ere-annee-technique',
                    'order' => 1,
                ],
                [
                    'name' => '2ème année',
                    'slug' => '2eme-annee-technique',
                    'order' => 2,
                ],
                [
                    'name' => '3ème année',
                    'slug' => '3eme-annee-technique',
                    'order' => 3,
                ],
            ];

            foreach ($levels as $level) {
                Level::updateOrCreate(
                    [
                        'formation_id' => $formationTechnique->id,
                        'filiere_id' => null,
                        'specialite_id' => null,
                        'slug' => $level['slug'],
                    ],
                    [
                        'formation_id' => $formationTechnique->id,
                        'filiere_id' => null,
                        'specialite_id' => null,
                        'name' => $level['name'],
                        'order' => $level['order'],
                        'is_active' => true,
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

            $levels = [
                [
                    'name' => 'Licence 1',
                    'slug' => 'licence-1',
                    'order' => 1,
                ],
                [
                    'name' => 'Licence 2',
                    'slug' => 'licence-2',
                    'order' => 2,
                ],
                [
                    'name' => 'Licence 3',
                    'slug' => 'licence-3',
                    'order' => 3,
                ],
                [
                    'name' => 'Master 1',
                    'slug' => 'master-1',
                    'order' => 4,
                ],
                [
                    'name' => 'Master 2',
                    'slug' => 'master-2',
                    'order' => 5,
                ],
            ];

            foreach ($levels as $level) {
                Level::updateOrCreate(
                    [
                        'filiere_id' => $filiere->id,
                        'formation_id' => null,
                        'specialite_id' => null,
                        'slug' => $level['slug'],
                    ],
                    [
                        'formation_id' => null,
                        'filiere_id' => $filiere->id,
                        'specialite_id' => null,
                        'name' => $level['name'],
                        'order' => $level['order'],
                        'is_active' => true,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL — ENEP
        |--------------------------------------------------------------------------
        |
        | ENEP
        | ↓
        | Niveau
        | ↓
        | Module
        |
        | Pas de 3ème année.
        |--------------------------------------------------------------------------
        */

        $enep = Formation::where(
            'slug',
            'enep'
        )->first();

        if ($enep) {

            $levels = [
                [
                    'name' => '1ère année',
                    'slug' => 'premiere-annee',
                    'order' => 1,
                ],
                [
                    'name' => '2ème année',
                    'slug' => 'deuxieme-annee',
                    'order' => 2,
                ],
            ];

            foreach ($levels as $level) {

                Level::updateOrCreate(
                    [
                        'formation_id' => $enep->id,
                        'filiere_id' => null,
                        'specialite_id' => null,
                        'slug' => $level['slug'],
                    ],
                    [
                        'formation_id' => $enep->id,
                        'filiere_id' => null,
                        'specialite_id' => null,
                        'name' => $level['name'],
                        'order' => $level['order'],
                        'is_active' => true,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL — ENSP
        |--------------------------------------------------------------------------
        |
        | ENSP
        | ↓
        | Spécialité
        | ↓
        | Niveau
        | ↓
        | Module
        |
        |--------------------------------------------------------------------------
        */

        $ensp = Formation::where(
            'slug',
            'ensp'
        )->first();

        if ($ensp) {

            $specialitesEnsp = Specialite::where(
                'formation_id',
                $ensp->id
            )
                ->where('is_active', true)
                ->get();

            foreach ($specialitesEnsp as $specialite) {

                $this->createSpecialiteLevels(
                    $ensp,
                    $specialite,
                    [
                        [
                            'name' => '1ère année',
                            'slug' => 'premiere-annee',
                            'order' => 1,
                        ],
                        [
                            'name' => '2ème année',
                            'slug' => 'deuxieme-annee',
                            'order' => 2,
                        ],
                        [
                            'name' => '3ème année',
                            'slug' => 'troisieme-annee',
                            'order' => 3,
                        ],
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL — IDS
        |--------------------------------------------------------------------------
        |
        | IDS
        | ↓
        | Spécialité
        | ↓
        | Niveau
        | ↓
        | Module
        |
        |--------------------------------------------------------------------------
        */

        $ids = Formation::where(
            'slug',
            'ids'
        )->first();

        if ($ids) {

            $specialitesIds = Specialite::where(
                'formation_id',
                $ids->id
            )
                ->where('is_active', true)
                ->get();

            foreach ($specialitesIds as $specialite) {

                $this->createSpecialiteLevels(
                    $ids,
                    $specialite,
                    [
                        [
                            'name' => 'Licence 1',
                            'slug' => 'licence-1',
                            'order' => 1,
                        ],
                        [
                            'name' => 'Licence 2',
                            'slug' => 'licence-2',
                            'order' => 2,
                        ],
                        [
                            'name' => 'Licence 3',
                            'slug' => 'licence-3',
                            'order' => 3,
                        ],
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL — UIT
        |--------------------------------------------------------------------------
        |
        | UIT
        | ↓
        | Spécialité
        | ↓
        | Niveau
        | ↓
        | Module
        |
        |--------------------------------------------------------------------------
        */

        $uit = Formation::where(
            'slug',
            'uit'
        )->first();

        if ($uit) {

            $specialitesUit = Specialite::where(
                'formation_id',
                $uit->id
            )
                ->where('is_active', true)
                ->get();

            foreach ($specialitesUit as $specialite) {

                $this->createSpecialiteLevels(
                    $uit,
                    $specialite,
                    [
                        [
                            'name' => 'Licence 1',
                            'slug' => 'licence-1',
                            'order' => 1,
                        ],
                        [
                            'name' => 'Licence 2',
                            'slug' => 'licence-2',
                            'order' => 2,
                        ],
                        [
                            'name' => 'Licence 3',
                            'slug' => 'licence-3',
                            'order' => 3,
                        ],
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL — ENS
        |--------------------------------------------------------------------------
        |
        | ENS
        | ↓
        | Programme
        | ↓
        | Spécialité
        | ↓
        | Niveau
        | ↓
        | Module
        |
        | NE PAS MODIFIER
        |--------------------------------------------------------------------------
        */

        $ens = Formation::where(
            'slug',
            'ens'
        )->first();

        if ($ens) {

            $specialitesEns = Specialite::whereHas(
                'program',
                function ($query) use ($ens) {
                    $query->where(
                        'formation_id',
                        $ens->id
                    );
                }
            )->get();

            foreach ($specialitesEns as $specialite) {

                $this->createSpecialiteLevels(
                    $ens,
                    $specialite,
                    [
                        [
                            'name' => '1ère année',
                            'slug' => 'premiere-annee',
                            'order' => 1,
                        ],
                        [
                            'name' => '2ème année',
                            'slug' => 'deuxieme-annee',
                            'order' => 2,
                        ],
                    ]
                );
            }
        }
    }

    private function createSpecialiteLevels(
        Formation $formation,
        Specialite $specialite,
        array $levels
    ): void {

        foreach ($levels as $level) {

            Level::updateOrCreate(
                [
                    'formation_id' => $formation->id,
                    'filiere_id' => null,
                    'specialite_id' => $specialite->id,
                    'slug' => $level['slug'],
                ],
                [
                    'formation_id' => $formation->id,
                    'filiere_id' => null,
                    'specialite_id' => $specialite->id,
                    'name' => $level['name'],
                    'order' => $level['order'],
                    'is_active' => true,
                ]
            );
        }
    }
}