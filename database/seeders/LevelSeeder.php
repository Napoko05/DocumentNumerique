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
        |
        | Catégorie
        |    ↓
        | Formation
        |    ↓
        | Niveau
        |    ↓
        | Matière
        |
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
        |
        | Catégorie
        |    ↓
        | Formation
        |    ↓
        | Niveau
        |    ↓
        | Matière / Module
        |
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
        |
        | Catégorie
        |    ↓
        | Domaine académique
        |    ↓
        | Filière
        |    ↓
        | Niveau
        |    ↓
        | Matière / Module
        |
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
        | PROFESSIONNEL — ENSP / ENEP / ATE
        |--------------------------------------------------------------------------
        |
        | Formation
        |    ↓
        | Niveau
        |    ↓
        | Matière / Module
        |
        */

        $formationsPro = Formation::whereIn(
            'slug',
            [
                'ensp',
                'enep',
                'ate',
            ]
        )->get();

        foreach ($formationsPro as $formation) {

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
                [
                    'name' => '3ème année',
                    'slug' => 'troisieme-annee',
                    'order' => 3,
                ],
            ];

            foreach ($levels as $level) {

                Level::updateOrCreate(
                    [
                        'formation_id' => $formation->id,
                        'filiere_id' => null,
                        'specialite_id' => null,
                        'slug' => $level['slug'],
                    ],
                    [
                        'formation_id' => $formation->id,
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
        | PROFESSIONNEL — IDS
        |--------------------------------------------------------------------------
        |
        | Formation
        |    ↓
        | Spécialité
        |    ↓
        | Niveau
        |    ↓
        | Matière / Module
        |
        */

        $ids = Formation::where(
            'slug',
            'ids'
        )->first();

        if ($ids) {

            $specialitesIds = Specialite::whereHas(
                'formation',
                function ($query) use ($ids) {
                    $query->where('id', $ids->id);
                }
            )->get();

            foreach ($specialitesIds as $specialite) {

                $this->createSpecialiteLevels(
                    $ids,
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
        | PROFESSIONNEL — ENS
        |--------------------------------------------------------------------------
        |
        | Formation
        |    ↓
        | Programme
        |    ↓
        | Spécialité
        |    ↓
        | Niveau
        |    ↓
        | Matière / Module
        |
        | IMPORTANT :
        | levels NE possède PAS de program_id.
        |
        | Le niveau est donc rattaché à :
        | formation_id + specialite_id
        |
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


    /*
    |--------------------------------------------------------------------------
    | CRÉER LES NIVEAUX D'UNE SPÉCIALITÉ
    |--------------------------------------------------------------------------
    */

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