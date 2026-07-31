<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Formation;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        $ens = Formation::where('slug','ens')
            ->first();

        if(!$ens){
            return;
        }


        $programs = [

            'CAPES',

            'CAPCEG',

            'EPS',

            'INSPECTORAT',

        ];


        foreach($programs as $program){

            Program::updateOrCreate(

                [
                    'formation_id'=>$ens->id,
                    'slug'=>Str::slug($program),
                ],

                [
                    'name'=>$program,
                    'is_active'=>true,
                ]

            );

        }
    }
}