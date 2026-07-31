@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    <!-- CONTENEUR -->
    <div class="max-w-6xl mx-auto">


        <!-- BOUTON RETOUR -->

        <div class="mb-8">


            <a href="{{ route('vitrine.professionnel.formations') }}"
                class="inline-flex items-center gap-2
          bg-white text-gray-700
          px-5 py-3
          rounded-xl
          shadow-sm
          border border-gray-200
          hover:border-green-500
          hover:text-green-600
          hover:shadow-md
          transition">

                ← Retour aux formations

            </a>

        </div>

        <!-- HEADER -->

        <div class="text-center mb-12">


            <div class="text-6xl mb-4">

                {{ $formation->icon ?? '🎓' }}

            </div>


            <h1 class="text-4xl font-extrabold text-gray-800">

                {{ $formation->name }}

            </h1>


            @if($formation->description)

            <p class="text-gray-500 mt-3">

                {{ $formation->description }}

            </p>

            @endif


            <p class="text-gray-500 mt-2">

                Choisissez votre niveau d'étude.

            </p>


        </div>


        <!-- NIVEAUX -->

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">


            @forelse($niveaux as $niveau)

            <a href="{{ route('vitrine.professionnel.type_doc', [

        'formationSlug' => $formation->slug,

        'niveauSlug' => $niveau->slug

    ]) }}"

                class="group
                   bg-white
                   rounded-2xl
                   shadow-md
                   hover:shadow-xl
                   transition-all
                   duration-300
                   p-8
                   border
                   border-gray-100
                   hover:border-green-500
                   hover:-translate-y-1">
                <!-- ICÔNE -->
                <div class="text-5xl text-center
                            group-hover:scale-110
                            transition">
                    📘
                </div>
                <!-- INFORMATIONS -->
                <div class="mt-5 text-center">


                    <h3 class="font-bold text-gray-800
                               group-hover:text-green-600">

                        {{ $niveau->name }}

                    </h3>
                    <p class="text-sm text-gray-500 mt-2">

                        Accéder aux types de documents

                    </p>
                    @if(isset($niveau->documents_count))

                    <p class="text-xs text-green-600 mt-3">

                        {{ $niveau->documents_count }}

                        document{{ $niveau->documents_count > 1 ? 's' : '' }}

                    </p>

                    @endif
                </div>
            </a>
            @empty
            <!-- AUCUN NIVEAU -->
            <div class="col-span-full
                        bg-white
                        rounded-2xl
                        shadow-sm
                        p-12
                        text-center">


                <div class="text-5xl mb-4">

                    📚

                </div>


                <h3 class="font-bold text-gray-700">

                    Aucun niveau disponible

                </h3>


                <p class="text-gray-500 mt-2">

                    Aucun niveau n'a encore été ajouté
                    pour cette formation.

                </p>


            </div>


            @endforelse


        </div>


    </div>

</div>
@endsection