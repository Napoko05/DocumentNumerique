@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">
<div class="max-w-7xl mx-auto">


    <!-- BOUTON RETOUR -->

    <div class="mb-8">

        <a href="{{ route('vitrine.professionnel.type_doc', [
            'formationSlug' => $formation->slug,
            'niveauSlug'    => $niveau->slug
        ]) }}"
           class="inline-flex items-center gap-2
                  bg-white
                  text-gray-700
                  px-5 py-3
                  rounded-xl
                  border border-gray-200
                  shadow-sm
                  hover:border-green-500
                  hover:text-green-600
                  hover:shadow-md
                  transition">

            ← Retour aux types de documents

        </a>

    </div>


    <!-- HEADER -->

    <div class="text-center mb-12">


        <div class="text-6xl mb-4">

            📄

        </div>


        <h1 class="text-4xl font-extrabold text-gray-800">

            {{ $type->name }}

        </h1>


        <p class="text-gray-600 mt-4">


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

            Documents disponibles dans cette catégorie.

        </p>


    </div>


    <!-- DOCUMENTS -->

    <div class="grid grid-cols-1
                md:grid-cols-2
                lg:grid-cols-3
                gap-6">


        @forelse($documents as $document)


            <div class="bg-white
                        rounded-2xl
                        shadow-md
                        hover:shadow-xl
                        transition
                        duration-300
                        border
                        border-gray-100
                        overflow-hidden">


                <!-- ICÔNE -->

                <div class="bg-gradient-to-r
                            from-green-500
                            to-green-600
                            py-6
                            text-center">


                    <div class="text-6xl">

                        📄

                    </div>


                </div>


                <!-- INFORMATIONS -->

                <div class="p-6">


                    <h3 class="font-bold
                               text-xl
                               text-gray-800">


                        {{ $document->title }}


                    </h3>


                    <!-- DESCRIPTION -->

                    <p class="text-sm
                              text-gray-500
                              mt-3">


                        {{ Str::limit(
                            $document->description
                            ?? 'Ressource pédagogique disponible.',
                            120
                        ) }}


                    </p>


                    <!-- INFORMATIONS -->

                    <div class="mt-5
                                space-y-2
                                text-sm
                                text-gray-600">


                        <p>

                            <strong>Formation :</strong>

                            {{ $formation->name }}

                        </p>


                        <p>

                            <strong>Niveau :</strong>

                            {{ $niveau->name }}

                        </p>


                        <p>

                            <strong>Type :</strong>

                            {{ $type->name }}

                        </p>


                        @if($document->language)

                            <p>

                                <strong>Langue :</strong>

                                {{ $document->language }}

                            </p>

                        @endif


                        @if($document->file_type)

                            <p>

                                <strong>Format :</strong>

                                {{ strtoupper(
                                    $document->file_type
                                ) }}

                            </p>

                        @endif


                    </div>


                    <!-- BOUTONS -->

                    <div class="mt-6 flex gap-3">


                        <!-- LIRE -->

                        <a href="{{ asset(
                            'storage/' . $document->file_path
                        ) }}"
                           target="_blank"
                           class="flex-1
                                  py-3
                                  rounded-xl
                                  bg-blue-600
                                  text-white
                                  font-semibold
                                  text-center
                                  hover:bg-blue-700
                                  transition">


                            📖 Lire


                        </a>


                        <!-- TELECHARGER -->

                        <a href="{{ asset(
                            'storage/' . $document->file_path
                        ) }}"
                           download
                           class="flex-1
                                  py-3
                                  rounded-xl
                                  bg-green-600
                                  text-white
                                  font-semibold
                                  text-center
                                  hover:bg-green-700
                                  transition">


                            ⬇ Télécharger


                        </a>


                    </div>


                </div>


            </div>


        @empty


            <!-- AUCUN DOCUMENT -->

            <div class="col-span-full
                        bg-white
                        rounded-2xl
                        shadow-sm
                        p-14
                        text-center">


                <div class="text-6xl mb-5">

                    📂

                </div>


                <h3 class="text-xl
                           font-bold
                           text-gray-700">


                    Aucun document disponible


                </h3>


                <p class="text-gray-500 mt-3">


                    Aucun document n'a encore été publié pour :

                    <span class="font-semibold">

                        {{ $formation->name }}

                    </span>

                    •

                    <span class="font-semibold">

                        {{ $niveau->name }}

                    </span>

                    •

                    <span class="font-semibold">

                        {{ $type->name }}

                    </span>


                </p>


            </div>


        @endforelse


    </div>


    <!-- PAGINATION -->

    @if(method_exists($documents, 'links'))


        <div class="mt-10">


            {{ $documents->links() }}


        </div>


    @endif


</div>
</div>
<div class="max-w-6xl mx-auto mb-8">

    <a href="{{ route('vitrine.professionnel.type_doc', [
        'formationSlug' => $formation->slug,
        'niveauSlug' => $niveau->slug
    ]) }}"
    class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

        ← Retour

    </a>

</div>

@endsection
