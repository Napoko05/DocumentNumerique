@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">
    <!-- CONTENEUR -->

    <div class="max-w-6xl mx-auto">

        <!-- BOUTON RETOUR -->

     <div class="max-w-6xl mx-auto mt-8">

    <a href="{{ route('vitrine.professionnel.niveaux',['formationSlug' => $formation->slug]) }}"
       class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">
        ← Retour aux formations
    </a>

</div>

        <!-- HEADER -->

        <div class="text-center mb-12">


            <div class="text-6xl mb-4">

                📚

            </div>


            <h1 class="text-3xl font-extrabold text-gray-800">

                Types de documents

            </h1>


            <p class="text-gray-600 mt-3">


                <span class="font-semibold">

                    {{ $formation->name }}

                </span>


                <span class="mx-2">

                    •

                </span>


                <span>

                    {{ $niveau->name }}

                </span>


            </p>


            <p class="text-gray-500 mt-2">

                Choisissez le type de document.

            </p>


        </div>


        <!-- TYPES DE DOCUMENTS -->

        <div class="grid grid-cols-2
                md:grid-cols-3
                lg:grid-cols-6
                gap-6">

            @forelse($types as $type)

            <a href="{{ route('vitrine.professionnel.documents', [

                'formationSlug' => $formation->slug,

                'niveauSlug' => $niveau->slug,

                'typeSlug' => $type->slug

            ]) }}"

                class="group
                   bg-white
                   rounded-2xl
                   shadow-md
                   hover:shadow-xl
                   transition-all
                   duration-300
                   p-6
                   border
                   border-gray-100
                   hover:border-green-500
                   hover:-translate-y-1
                   text-center">


                <!-- ICÔNE -->

                <div class="text-5xl
                            group-hover:scale-110
                            transition">


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


                    @case('fiches-de-revision')

                    📑

                    @break


                    @case('rapports')

                    📘

                    @break


                    @case('memoires')

                    📕

                    @break


                    @case('sujets')

                    🎯

                    @break

                    @default

                    📁

                    @endswitch

                </div>


                <!-- NOM -->

                <div class="mt-4
                            font-bold
                            text-gray-800
                            group-hover:text-green-600">


                    {{ $type->name }}


                </div>


                <!-- TEXTE -->

                <p class="text-xs text-gray-500 mt-2">

                    Voir les documents

                </p>
            </a>

            @empty
            <div class="col-span-full
                        bg-white
                        rounded-2xl
                        p-12
                        text-center
                        shadow-sm">


                <div class="text-5xl mb-4">

                    📂

                </div>


                <h3 class="font-bold text-gray-700">

                    Aucun type de document disponible

                </h3>


                <p class="text-gray-500 mt-2">

                    Aucun type de document n'a encore été ajouté.

                </p>


            </div>


            @endforelse


        </div>

    </div>
</div>


@endsection