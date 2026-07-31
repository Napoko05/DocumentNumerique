@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">


        <h1 class="text-3xl font-extrabold text-gray-800">

            📄 {{ $type->name }}

        </h1>



        <p class="text-gray-500 mt-2">

            Filière :
            <span class="font-semibold">
                {{ $filiere->name }}
            </span>

            •

            Niveau :
            <span class="font-semibold">
                {{ $niveau->name }}
            </span>

        </p>


    </div>




    <!-- DOCUMENTS GRID -->
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6">



        @forelse($documents as $document)



        <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition p-6 border">



            <div class="flex items-center justify-between">


                <h3 class="font-bold text-gray-800">

                    {{ $document->title }}

                </h3>



                <span class="text-blue-500 text-xl">

                    📄

                </span>


            </div>




            <p class="text-sm text-gray-500 mt-3">


                {{ Str::limit(
                    $document->description ?? 'Ressource pédagogique disponible',
                    80
                ) }}


            </p>



            <button class="mt-5 w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 rounded-xl hover:opacity-90 transition">

                📖 Ouvrir

            </button>



        </div>



        @empty


        <div class="col-span-full text-center text-gray-500">

            Aucun document disponible pour cette catégorie.

        </div>


        @endforelse



    </div>



    <!-- PAGINATION -->

    <div class="max-w-6xl mx-auto mt-8">

        {{ $documents->links() }}

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

        ← Retour aux types de documents

    </a>

</div>

@endsection