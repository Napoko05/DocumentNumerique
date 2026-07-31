@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">


        <h1 class="text-3xl font-extrabold text-gray-800">

            📚 Types de documents

        </h1>


        <p class="text-gray-600 mt-3">

            <span class="font-semibold">
                {{ $specialite->name }}
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




    <!-- TYPES DOCUMENTS -->

    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">



        @foreach($types as $type)



        <a href="{{ route('vitrine.ens.documents',[

                'formationSlug'=>$formation->slug,

                'programmeSlug'=>$programme->slug,

                'specialiteSlug'=>$specialite->slug,

                'niveauSlug'=>$niveau->slug,
                'formation'=>$formation->slug,

                'programme'=>$programme->slug,

                'specialite'=>$specialite->slug,

                'niveau'=>$niveau->slug,

                'typeSlug'=>$type->slug

            ]) }}"


            class="bg-white rounded-2xl shadow-md hover:shadow-xl
        transition-all duration-300
        p-6 border hover:border-green-500 text-center">



            <div class="text-5xl">

                @switch($type->slug)

                @case('cours')
                📚
                @break

                @case('td')
                📝
                @break

                @case('tp')
                🧪
                @break

                @case('examens')
                📄
                @break

                @case('corriges')
                ✅
                @break

                @case('memoires')
                📕

                @break

                @default
                📁

                @endswitch


            </div>



            <div class="mt-4 font-bold text-gray-800">

                {{ $type->name }}

            </div>

        </a>

        @endforeach

    </div>
</div>
<!-- BOUTON RETOUR -->
<div class="max-w-6xl mx-auto mb-8">

    <a href="{{ route('vitrine.ens.niveaux', [
        'formation'=>$formation->slug,

                'programmeSlug'=>$programme->slug,

                'specialiteSlug'=>$specialite->slug,

                'niveauSlug'=>$niveau->slug,

        
    ]) }}"
    class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

        ← Retour

    </a>

</div>
@endsection