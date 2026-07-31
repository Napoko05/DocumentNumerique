@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">
        <h1 class="text-3xl font-extrabold text-gray-800">

            📖 Types de documents

        </h1>
        <p class="text-gray-600 mt-2">

            <span class="font-semibold">
                {{ $filiere->name }}
            </span>

            •
            <span>
                {{ $niveau->name }}
            </span>

        </p>
        <p class="text-gray-500 mt-2">

            Choisissez le type de document.

        </p>
    </div>
    <!-- TYPES DE DOCUMENTS -->
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">

        @foreach($types as $type)

        <a href="{{ route('vitrine.superieur.documents', [

    'domaineSlug' => $domaine->slug,
    'filiereSlug' => $filiere->slug,
    'niveauSlug' => $niveau->slug,
    'typeSlug'   => $type->slug

]) }}"
            class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border hover:border-blue-500 text-center">

            <div class="text-5xl">

                @switch($type->slug)

                @case('cours')
                📚
                @break

                @case('travaux-diriges-td')
                📝
                @break

                @case('travaux-pratiques-tp')
                🧪
                @break

                @case('examens')
                📄
                @break

                @case('corriges')
                ✅
                @break

                @case('fiches-de-revision')
                📑
                @break

                @default
                📁

                @endswitch
            </div>

            <div class="mt-4 font-bold text-gray-800">

                {{ $type->name }}

            </div>

            @if(isset($type->documents_count))

            <div class="text-sm text-blue-500 mt-2">

                {{ $type->documents_count }} documents

            </div>

            @endif
        </a>
        @endforeach
    </div>
</div>

<!-- BOUTON RETOUR -->
<div class="max-w-6xl mx-auto mb-8">

    <a href="{{ route('vitrine.superieur.filieres', [

        'domaineSlug' => $domaine->slug

    ]) }}"
    class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

        ← Retour aux filières

    </a>

</div>

@endsection