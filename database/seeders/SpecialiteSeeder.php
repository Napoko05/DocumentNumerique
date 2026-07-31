<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Program;
use App\Models\Specialite;

class SpecialiteSeeder extends Seeder
{
    public function run(): void
    {

        $specialites = [

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

        foreach($specialites as $programName => $items)
        {

            $program = Program::where(
                'slug',
                Str::slug($programName)
            )->first();

            if(!$program)
            {
                continue;
            }
            foreach($items as $item)
            {

                Specialite::updateOrCreate(

                    [
                        'program_id' => $program->id,
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