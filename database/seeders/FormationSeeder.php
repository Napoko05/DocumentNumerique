<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Formation;
use App\Models\TeachingCategory;

class FormationSeeder extends Seeder
{
    public function run(): void
    {


        /*
        |--------------------------------------------------------------------------
        | SECONDAIRE
        |--------------------------------------------------------------------------
        */


        $secondaire = TeachingCategory::where(
            'slug',
            'secondaire'
        )->firstOrFail();



        $formationsSecondaire = [

            [
                'name'=>'Secondaire Général',
                'slug'=>'secondaire-general',
                'description'=>'Enseignement secondaire général.',
                'icon'=>'🏫',
            ],

            [
                'name'=>'Secondaire Technique',
                'slug'=>'secondaire-technique',
                'description'=>'Enseignement secondaire technique.',
                'icon'=>'🛠️',
            ],

        ];



        foreach($formationsSecondaire as $item)
        {

            Formation::updateOrCreate(

                [
                    'teaching_category_id'=>$secondaire->id,
                    'slug'=>$item['slug'],
                ],

                [

                    'name'=>$item['name'],

                    'description'=>$item['description'],

                    'icon'=>$item['icon'],

                    'is_active'=>true,

                ]

            );

        }




        /*
        |--------------------------------------------------------------------------
        | PROFESSIONNEL
        |--------------------------------------------------------------------------
        */


        $professionnel = TeachingCategory::where(
            'slug',
            'professionnel'
        )->firstOrFail();



        $formationsProfessionnelles = [

            [
                'name'=>'ENS',
                'slug'=>'ens',
                'description'=>'École Normale Supérieure.',
                'icon'=>'👨‍🏫',
            ],

            [
                'name'=>'ENSP',
                'slug'=>'ensp',
                'description'=>'École Nationale de Santé Publique.',
                'icon'=>'🏥',
            ],

            [
                'name'=>'ENEP',
                'slug'=>'enep',
                'description'=>'École Nationale des Enseignants du Primaire.',
                'icon'=>'📖',
            ],

            [
                'name'=>'IDS',
                'slug'=>'ids',
                'description'=>'Institut des Sciences.',
                'icon'=>'🧪',
            ],

            [
                'name'=>'ATE',
                'slug'=>'ate',
                'description'=>'Autre formation professionnelle.',
                'icon'=>'⚙️',
            ],

        ];




        foreach($formationsProfessionnelles as $item)
        {

            Formation::updateOrCreate(

                [
                    'teaching_category_id'=>$professionnel->id,
                    'slug'=>$item['slug'],
                ],

                [

                    'name'=>$item['name'],

                    'description'=>$item['description'],

                    'icon'=>$item['icon'],

                    'is_active'=>true,

                ]

            );

        }


    }
}