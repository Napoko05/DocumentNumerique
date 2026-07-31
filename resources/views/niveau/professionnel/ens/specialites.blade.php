@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">
            {{ $formation->icon }} {{ $formation->name }}
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre programme de formation.
        </p>

    </div>

    @php

    $programs = [];

    /*
    |--------------------------------------------------------------------------
    | ENS
    |--------------------------------------------------------------------------
    */
    if ($formation->slug == 'ens') {

        $programs = [

            [
                'name' => 'CAPES',
                'slug' => 'capes',
                'icon' => '🎓',
                'desc' => 'Certificat d’Aptitude au Professorat de l’Enseignement Secondaire'
            ],

            [
                'name' => 'CAPCEG',
                'slug' => 'capceg',
                'icon' => '📚',
                'desc' => 'Certificat d’Aptitude au Professorat des Collèges d’Enseignement Général'
            ],

            [
                'name' => 'Inspectorat',
                'slug' => 'inspectorat',
                'icon' => '📝',
                'desc' => 'Formation des inspecteurs'
            ],

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | ENSP
    |--------------------------------------------------------------------------
    */
    elseif ($formation->slug == 'ensp') {

        $programs = [

            [
                'name' => 'Formation Professionnelle',
                'slug' => 'formation-professionnelle',
                'icon' => '🏥',
                'desc' => 'Formation professionnelle de santé'
            ]

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | IDS
    |--------------------------------------------------------------------------
    */
    elseif ($formation->slug == 'ids') {

        $programs = [

            [
                'name' => 'Maths-PC',
                'slug' => 'maths-pc',
                'icon' => '📐',
                'desc' => 'Mathématiques - Physique Chimie'
            ],

            [
                'name' => 'Maths-SVT',
                'slug' => 'maths-svt',
                'icon' => '🧬',
                'desc' => 'Mathématiques - Sciences de la Vie et de la Terre'
            ],

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | ENEP
    |--------------------------------------------------------------------------
    */
    elseif ($formation->slug == 'enep') {

        $programs = [

            [
                'name' => 'Formation des Instituteurs',
                'slug' => 'instituteurs',
                'icon' => '👨‍🏫',
                'desc' => 'Formation des enseignants du primaire'
            ]

        ];

    }

    /*
    |--------------------------------------------------------------------------
    | ATE
    |--------------------------------------------------------------------------
    */
    elseif ($formation->slug == 'ate') {

        $programs = [

            [
                'name' => 'ATE',
                'slug' => 'ate',
                'icon' => '⚙️',
                'desc' => 'Autres formations professionnelles'
            ]

        ];

    }

    @endphp


    <!-- PROGRAMMES -->

    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($specialites as $specialite)

            <a href="{{ route('vitrine.ens.niveaux', [
                'formationSlug' => $formation->slug,
                'programmeSlug' => $programme->slug,
                'specialiteSlug' => $specialite->slug,
            ]) }}"
            class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 hover:border-green-500 hover:-translate-y-1">

                <div class="text-6xl text-center group-hover:scale-110 transition">
                    {{ $specialite['icon'] }}
                </div>

                <div class="mt-5 text-center">

                    <h2 class="font-bold text-gray-800 text-lg group-hover:text-green-600">
                        {{ $specialite['name'] }}
                    </h2>

                    <p class="text-sm text-gray-500 mt-3">
                        {{ $specialite['desc'] }}
                    </p>

                </div>

            </a>

        @empty

            <div class="col-span-full bg-white rounded-2xl shadow-sm p-10 text-center">

                <div class="text-5xl mb-4">
                    📚
                </div>

                <h2 class="text-xl font-bold text-gray-700">
                    Aucun specialités disponible
                </h2>

                <p class="text-gray-500 mt-2">
                    Aucun specialité n'est disponible pour cette formation.
                </p>

            </div>

        @endforelse

    </div>

    <!-- BOUTON RETOUR -->

    <div class="max-w-6xl mx-auto mt-10">

        <a href="{{ route('vitrine.ens.programmes', [
            'formationSlug' => $formation->slug,
            'programmeSlug' => $programme->slug,
           
        ]) }}"
        class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

            ← Retour

        </a>

    </div>

</div>

@endsection