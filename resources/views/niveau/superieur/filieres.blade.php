@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">
            🎓 {{ $domaine->name }}
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre filière pour accéder aux ressources pédagogiques.
        </p>

    </div>

    <!-- FILIÈRES -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($filieres as $filiere)

        <a href="{{ route('vitrine.superieur.niveaux', [
            'domaineSlug' => $domaine->slug,
            'filiereSlug' => $filiere->slug
        ]) }}"
            class="group bg-white rounded-2xl shadow-md
            hover:shadow-xl transition-all duration-300
            p-8 border border-gray-100
            hover:border-blue-500
            hover:-translate-y-1">

            <!-- ICÔNE -->
            <div class="text-5xl text-center
                group-hover:scale-110
                transition duration-300">

                @switch($filiere->slug)

                @case('informatique')
                💻
                @break

                @case('mathematiques')
                📐
                @break

                @case('physique')
                ⚛️
                @break

                @case('chimie')
                🧪
                @break

                @case('droit')
                ⚖️
                @break

                @case('gestion')
                💼
                @break

                @case('economie')
                📈
                @break

                @case('lettres')
                📚
                @break

                @case('anglais')
                🇬🇧
                @break

                @default
                🎓

                @endswitch

            </div>
            <!-- INFORMATIONS -->
            <div class="mt-5 text-center">

                <h3 class="font-bold text-gray-800
                    group-hover:text-blue-600
                    text-lg">

                    {{ $filiere->name }}

                </h3>
                <p class="text-sm text-gray-500 mt-2">

                    Consulter les cours, TD,
                    examens et corrigés

                </p>
                @if(isset($filiere->documents_count))

                <p class="text-xs text-blue-500 mt-3">

                    {{ $filiere->documents_count }}
                    document(s) disponible(s)

                </p>

                @endif

            </div>

        </a>

        @empty

        <!-- AUCUNE FILIÈRE -->
        <div class="col-span-full
            bg-white rounded-2xl
            shadow-md p-10 text-center">

            <div class="text-5xl mb-4">
                📂
            </div>

            <h3 class="text-xl font-bold text-gray-700">

                Aucune filière disponible

            </h3>

            <p class="text-gray-500 mt-2">

                Aucune filière active n'est encore
                enregistrée pour ce domaine académique.

            </p>

        </div>

        @endforelse

    </div>

</div>

<!-- BOUTON RETOUR -->
<div class="max-w-6xl mx-auto mb-8">

    <a href="{{ route('vitrine.superieur.domaines') }}"
        class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

        ← Retour aux domaines

    </a>

</div>

@endsection