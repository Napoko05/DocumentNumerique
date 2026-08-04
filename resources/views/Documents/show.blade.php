@extends('layouts.journalist_app')

@section('title', $document->title)

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 py-10 px-4 sm:px-6 lg:px-8">

<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="bg-blue-600 rounded-2xl py-8 px-6 mb-8 shadow-lg">

        <h1 class="text-center text-white text-3xl md:text-4xl font-bold">

            {{ $document->title }}

        </h1>

        <p class="text-center text-blue-100 mt-3">

            Détails complets du document

        </p>

    </div>


    <!-- CARD -->
    <div class="bg-white shadow-xl rounded-2xl border border-blue-100 overflow-hidden">

        <div class="p-6 md:p-8 space-y-8">


            <!-- INFORMATIONS -->
            <div>

                <h2 class="text-xl font-bold text-blue-700 mb-5">

                    📚 Informations académiques

                </h2>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    <!-- FORMATION -->
                    <div class="bg-blue-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700">

                            🎓 Formation

                        </p>

                        <p class="text-gray-700 mt-1">

                            {{ $document->formation?->name ?? 'Non renseignée' }}

                        </p>

                    </div>


                    <!-- FILIERE -->
                    <div class="bg-blue-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700">

                            🏛️ Filière

                        </p>

                        <p class="text-gray-700 mt-1">

                            {{ $document->filiere?->name ?? 'Non renseignée' }}

                        </p>

                    </div>


                    <!-- NIVEAU -->
                    <div class="bg-blue-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700">

                            🎓 Niveau / Classe

                        </p>

                        <p class="text-gray-700 mt-1">

                            {{ $document->level?->name ?? 'Non renseigné' }}

                        </p>

                    </div>


                    <!-- MATIERE / MODULE -->
                    <div class="bg-blue-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700">

                            📖 Matière / Module

                        </p>

                        <p class="text-gray-700 mt-1">

                            {{ $document->subject?->name ?? 'Non renseigné' }}

                        </p>

                    </div>


                    <!-- TYPE DOCUMENT -->
                    <div class="bg-blue-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700">

                            📄 Type de document

                        </p>

                        <p class="text-gray-700 mt-1">

                            {{ $document->documentType?->name ?? 'Non renseigné' }}

                        </p>

                    </div>


                    <!-- VUES -->
                    <div class="bg-blue-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700">

                            👁️ Nombre de vues

                        </p>

                        <p class="text-gray-700 mt-1">

                            {{ $document->views ?? 0 }}

                        </p>

                    </div>

                </div>

            </div>


            <hr class="border-blue-100">


            <!-- ACCES -->
            <div>

                <h2 class="text-xl font-bold text-blue-700 mb-5">

                    🔐 Accès au document

                </h2>


                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                    <!-- TYPE ACCES -->
                    <div class="bg-gray-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700 mb-2">

                            Type d'accès

                        </p>


                        @if($document->access_type === 'free')

                            <span class="inline-flex px-4 py-2
                                         text-sm font-semibold
                                         rounded-full
                                         bg-green-100
                                         text-green-700">

                                🟢 Gratuit

                            </span>

                        @else

                            <span class="inline-flex px-4 py-2
                                         text-sm font-semibold
                                         rounded-full
                                         bg-orange-100
                                         text-orange-700">

                                🟠 Premium

                            </span>

                        @endif

                    </div>


                    <!-- PRIX -->
                    <div class="bg-gray-50 rounded-xl p-4">

                        <p class="text-sm font-semibold text-blue-700">

                            💰 Prix

                        </p>


                        @if(
                            $document->access_type === 'premium'
                            && $document->price
                        )

                            <p class="text-lg font-bold
                                      text-orange-600 mt-2">

                                {{ number_format(
                                    (float) $document->price,
                                    0,
                                    ',',
                                    ' '
                                ) }}

                                FCFA

                            </p>

                        @else

                            <p class="text-gray-500 mt-2">

                                Gratuit

                            </p>

                        @endif

                    </div>

                </div>

            </div>


            <hr class="border-blue-100">


            <!-- STATUT -->
            <div>

                <h2 class="text-xl font-bold text-blue-700 mb-4">

                    📌 Statut

                </h2>


                @if($document->status === 'published')

                    <span class="inline-flex px-4 py-2
                                 rounded-full
                                 bg-green-100
                                 text-green-700
                                 font-semibold">

                        ✓ Publié

                    </span>

                @elseif($document->status === 'pending')

                    <span class="inline-flex px-4 py-2
                                 rounded-full
                                 bg-yellow-100
                                 text-yellow-700
                                 font-semibold">

                        ⏳ En attente de validation

                    </span>

                @elseif($document->status === 'rejected')

                    <span class="inline-flex px-4 py-2
                                 rounded-full
                                 bg-red-100
                                 text-red-700
                                 font-semibold">

                        ✕ Rejeté

                    </span>

                @else

                    <span class="inline-flex px-4 py-2
                                 rounded-full
                                 bg-gray-100
                                 text-gray-600
                                 font-semibold">

                        📝 Brouillon

                    </span>

                @endif

            </div>


            <hr class="border-blue-100">


            <!-- DESCRIPTION -->
            <div>

                <h2 class="text-xl font-bold text-blue-700 mb-4">

                    📄 Description

                </h2>


                @if($document->description)

                    <div class="bg-gray-50
                                rounded-xl
                                p-5
                                text-gray-700
                                leading-relaxed
                                whitespace-pre-line">

                        {{ $document->description }}

                    </div>

                @else

                    <p class="text-gray-400 italic">

                        Aucune description n'a été ajoutée.

                    </p>

                @endif

            </div>


            <!-- FICHIER -->
            @if($document->file_path)

                <hr class="border-blue-100">


                <div>

                    <h2 class="text-xl font-bold text-blue-700 mb-4">

                        📎 Fichier

                    </h2>


                    <div class="flex flex-col sm:flex-row
                                sm:items-center
                                sm:justify-between
                                gap-4
                                bg-blue-50
                                rounded-xl
                                p-5">

                        <div>

                            <p class="font-semibold text-gray-700">

                                Document joint

                            </p>


                            @if($document->file_extension)

                                <p class="text-sm text-gray-500 mt-1">

                                    Format :

                                    {{ strtoupper(
                                        $document->file_extension
                                    ) }}

                                </p>

                            @endif

                        </div>


                        <a href="{{ asset(
                            'storage/' . $document->file_path
                        ) }}"

                           target="_blank"

                           class="inline-flex
                                  justify-center
                                  px-5 py-3
                                  bg-blue-600
                                  hover:bg-blue-700
                                  text-white
                                  font-semibold
                                  rounded-xl
                                  transition">

                            👁️ Ouvrir le fichier

                        </a>

                    </div>

                </div>

            @endif


            <hr class="border-blue-100">


            <!-- ACTIONS -->
            <div class="flex flex-col sm:flex-row gap-4 pt-2">


                <!-- MODIFIER -->
                <a href="{{ route(
                    'journaliste.documents.edit',
                    $document
                ) }}"

                   class="px-6 py-3
                          bg-blue-600
                          hover:bg-blue-700
                          text-white
                          font-semibold
                          rounded-xl
                          shadow-md
                          transition
                          text-center">

                    ✏️ Modifier

                </a>


                <!-- RETOUR -->
                <a href="{{ route(
                    'journaliste.documents.index'
                ) }}"

                   class="px-6 py-3
                          bg-gray-200
                          hover:bg-gray-300
                          text-gray-800
                          font-semibold
                          rounded-xl
                          text-center
                          transition">

                    ← Retour à mes documents

                </a>

            </div>

        </div>

    </div>

</div>
</div>

@endsection
