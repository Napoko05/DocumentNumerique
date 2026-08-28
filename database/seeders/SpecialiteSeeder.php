<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Program;
use App\Models\Specialite;
use App\Models\Formation;

class SpecialiteSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ENS
        |--------------------------------------------------------------------------
        |
        | ENS
        | ↓
        | Programme
        | ↓
        | Spécialité
        |
        */

        $specialitesEns = [
            'CAPES' => [
                'Mathématiques',
                'Physique-Chimie',
                'Anglais',
                'Français',
                'Philosophie',
                'Histoire-Géographie',
            ],

            'CAPCEG' => [
                'Français-Anglais',
                'Mathématiques-PC',
                'Mathématiques-SVT',
            ],

            'INSPECTORAT' => [
                'Primaire',
                'Secondaire',
            ],
        ];

        foreach ($specialitesEns as $programName => $items) {
            $program = Program::where(
                'slug',
                Str::slug($programName)
            )->first();

            if (!$program) {
                continue;
            }

            foreach ($items as $item) {
                Specialite::updateOrCreate(
                    [
                        'program_id' => $program->id,
                        'slug' => Str::slug($item),
                    ],
                    [
                        'formation_id' => null,
                        'name' => $item,
                        'description' => null,
                        'is_active' => true,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ENSP
        |--------------------------------------------------------------------------
        |
        | ENSP
        | ↓
        | Spécialité
        | ↓
        | Niveau
        |
        */

        $ensp = Formation::where(
            'slug',
            'ensp'
        )->first();

        if ($ensp) {
            $specialitesEnsp = [
                'Infirmier',
                'Sage-femme / Maïeuticien',
                'Technologiste biomédical',
            ];

            foreach ($specialitesEnsp as $item) {
                Specialite::updateOrCreate(
                    [
                        'formation_id' => $ensp->id,
                        'program_id' => null,
                        'slug' => Str::slug($item),
                    ],
                    [
                        'name' => $item,
                        'description' => null,
                        'is_active' => true,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | IDS
        |--------------------------------------------------------------------------
        |
        | IDS
        | ↓
        | Spécialité
        | ↓
        | Niveau L1 → L3
        |
        */

        $ids = Formation::where(
            'slug',
            'ids'
        )->first();

        if ($ids) {
            $specialitesIds = [
                'Mathématique-Physique-Chimie',
                'Mathématique-SVT',
                'EPS',
            ];

            foreach ($specialitesIds as $item) {
                Specialite::updateOrCreate(
                    [
                        'formation_id' => $ids->id,
                        'program_id' => null,
                        'slug' => Str::slug($item),
                    ],
                    [
                        'name' => $item,
                        'description' => null,
                        'is_active' => true,
                    ]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | UIT
        |--------------------------------------------------------------------------
        |
        | UIT
        | ↓
        | Spécialité
        | ↓
        | Niveau L1 → L3
        |
        */

        $uit = Formation::where(
            'slug',
            'uit'
        )->first();

        if ($uit) {
            $specialitesUit = [
                'BTP',
                'Électricité & Froid & Climatisation',
                'Marketing Gestion & Comptabilité',
            ];

            foreach ($specialitesUit as $item) {
                Specialite::updateOrCreate(
                    [
                        'formation_id' => $uit->id,
                        'program_id' => null,
                        'slug' => Str::slug($item),
                    ],
                    [
                        'name' => $item,
                        'description' => null,
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}