@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-800">
            👨‍🏫 Enseignement Professionnel
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre établissement de formation.
        </p>
    </div>

    <!-- ECOLES -->
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @php

        $ecoles = [

            [
                'name' => 'ENS',
                'title' => 'École Normale Supérieure',
                'icon' => '🎓',
            ],

            [
                'name' => 'ENEP',
                'title' => 'École Nationale des Enseignants du Primaire',
                'icon' => '🍎',
            ],

            [
                'name' => 'ENSP',
                'title' => 'École Nationale de Santé Publique',
                'icon' => '🏥',
            ],

            [
                'name' => 'IDS',
                'title' => 'Institut des Sciences',
                'icon' => '📐',
            ],

        ];

        @endphp

        @foreach($ecoles as $ecole)

        <a href="{{ route('vitrine.classes_prof', $ecole['name']) }}"
           class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 hover:border-green-500 hover:-translate-y-1">

            <div class="text-6xl text-center group-hover:scale-110 transition">
                {{ $ecole['icon'] }}
            </div>

            <div class="mt-5 text-center">

                <h3 class="font-bold text-lg text-gray-800 group-hover:text-green-600">
                    {{ $ecole['name'] }}
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    {{ $ecole['title'] }}
                </p>

            </div>

        </a>

        @endforeach

    </div>

</div>
<!-- BOUTON RETOUR -->
<div class="max-w-6xl mx-auto mb-8">

    <a href="{{ route('vitrine.superieur.type_doc', [
        'domaineSlug' => $domaine->slug,
        'filiereSlug' => $filiere->slug,
        'niveauSlug' => $niveau->slug
    ]) }}"
    class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

        ← Retour 

    </a>

</div>
@endsection