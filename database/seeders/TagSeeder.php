<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {

        $tags = [

            'Cours',
            'Exercice',
            'Correction',
            'Sujet examen',

            'BAC',
            'BEPC',

            'TD',
            'TP',

            'Mémoire',
            'Thèse',

            'Recherche',

            'Université',

            'Concours',

        ];



        foreach ($tags as $tag) {


            Tag::updateOrCreate(

                [

                    'slug' => Str::slug($tag),

                ],


                [

                    'name' => $tag,

                    'is_active' => true,

                ]

            );


        }

    }
}