@extends('layouts.journalist_app')

@section('title', 'Mes documents')

@section('content')

<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">

<div class="max-w-7xl mx-auto">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                📚 Mes documents
            </h1>

            <p class="text-gray-500 mt-1">
                Gérez et suivez tous vos documents
            </p>
        </div>

        <a href="{{ route('journaliste.documents.create') }}"
           class="inline-flex items-center justify-center gap-2
                  bg-blue-600 hover:bg-blue-700
                  text-white px-5 py-3
                  rounded-xl shadow-md transition">

            ➕ Nouveau document

        </a>

    </div>


    <!-- MESSAGE SUCCESS -->
    @if(session('success'))

        <div class="mb-6 p-4 rounded-xl
                    bg-green-100 text-green-700
                    border border-green-200">

            {{ session('success') }}

        </div>

    @endif


    <!-- MESSAGE ERROR -->
    @if(session('error'))

        <div class="mb-6 p-4 rounded-xl
                    bg-red-100 text-red-700
                    border border-red-200">

            {{ session('error') }}

        </div>

    @endif


    <!-- TABLE -->
    <div class="bg-white shadow-xl rounded-2xl
                overflow-hidden border border-gray-100">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <!-- HEADER -->
                <thead class="bg-gray-100">

                    <tr class="text-left text-gray-600
                               text-xs uppercase tracking-wider">

                        <th class="px-6 py-4">
                            Document
                        </th>

                        <th class="px-6 py-4">
                            Formation
                        </th>

                        <th class="px-6 py-4">
                            Filière
                        </th>

                        <th class="px-6 py-4">
                            Niveau
                        </th>

                        <th class="px-6 py-4">
                            Matière / Module
                        </th>

                        <th class="px-6 py-4">
                            Accès
                        </th>

                        <th class="px-6 py-4">
                            Prix
                        </th>

                        <th class="px-6 py-4">
                            Vues
                        </th>

                        <th class="px-6 py-4 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>


                <!-- BODY -->
                <tbody class="divide-y divide-gray-100">

                    @forelse($documents as $document)

                        <tr class="hover:bg-gray-50 transition">


                            <!-- TITRE -->
                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-800">

                                    {{ $document->title }}

                                </div>


                                <!-- TYPE DOCUMENT -->
                                @if($document->documentType)

                                    <div class="text-xs text-gray-400 mt-1">

                                        {{ $document->documentType->name }}

                                    </div>

                                @endif


                                <!-- STATUT -->
                                <div class="mt-2">

                                    @if($document->status === 'published')

                                        <span class="inline-flex px-2 py-1
                                                     text-xs font-semibold
                                                     rounded-full
                                                     bg-green-100
                                                     text-green-700">

                                            Publié

                                        </span>

                                    @elseif($document->status === 'pending')

                                        <span class="inline-flex px-2 py-1
                                                     text-xs font-semibold
                                                     rounded-full
                                                     bg-yellow-100
                                                     text-yellow-700">

                                            En attente

                                        </span>

                                    @elseif($document->status === 'rejected')

                                        <span class="inline-flex px-2 py-1
                                                     text-xs font-semibold
                                                     rounded-full
                                                     bg-red-100
                                                     text-red-700">

                                            Rejeté

                                        </span>

                                    @else

                                        <span class="inline-flex px-2 py-1
                                                     text-xs font-semibold
                                                     rounded-full
                                                     bg-gray-100
                                                     text-gray-600">

                                            Brouillon

                                        </span>

                                    @endif

                                </div>

                            </td>


                            <!-- FORMATION -->
                            <td class="px-6 py-4 text-sm text-gray-600">

                                {{ $document->formation?->name ?? '—' }}

                            </td>


                            <!-- FILIERE -->
                            <td class="px-6 py-4 text-sm text-gray-600">

                                {{ $document->filiere?->name ?? '—' }}

                            </td>


                            <!-- NIVEAU -->
                            <td class="px-6 py-4 text-sm text-gray-600">

                                {{ $document->level?->name ?? '—' }}

                            </td>


                            <!-- MATIERE / MODULE -->
                            <td class="px-6 py-4 text-sm text-gray-600">

                                {{ $document->subject?->name ?? '—' }}

                            </td>


                            <!-- ACCES -->
                            <td class="px-6 py-4">

                                @if($document->access_type === 'free')

                                    <span class="inline-flex px-3 py-1
                                                 text-xs font-semibold
                                                 rounded-full
                                                 bg-green-100
                                                 text-green-700">

                                        🟢 Gratuit

                                    </span>

                                @else

                                    <span class="inline-flex px-3 py-1
                                                 text-xs font-semibold
                                                 rounded-full
                                                 bg-orange-100
                                                 text-orange-700">

                                        🟠 Premium

                                    </span>

                                @endif

                            </td>


                            <!-- PRIX -->
                            <td class="px-6 py-4 text-sm text-gray-700">

                                @if(
                                    $document->access_type === 'premium'
                                    && $document->price
                                )

                                    {{ number_format(
                                        (float) $document->price,
                                        0,
                                        ',',
                                        ' '
                                    ) }}

                                    FCFA

                                @else

                                    <span class="text-gray-400">

                                        —

                                    </span>

                                @endif

                            </td>


                            <!-- VUES -->
                            <td class="px-6 py-4 text-sm text-gray-700">

                                👁️ {{ $document->views ?? 0 }}

                            </td>


                            <!-- ACTIONS -->
                            <td class="px-6 py-4">

                                <div class="flex flex-wrap
                                            justify-end gap-2">


                                    <!-- VOIR -->
                                    <a href="{{ route(
                                        'journaliste.documents.show',
                                        $document
                                    ) }}"

                                       class="px-3 py-2
                                              text-sm font-medium
                                              rounded-lg
                                              bg-blue-100
                                              text-blue-700
                                              hover:bg-blue-200
                                              transition">

                                        Voir

                                    </a>


                                    <!-- MODIFIER -->
                                    <a href="{{ route(
                                        'journaliste.documents.edit',
                                        $document
                                    ) }}"

                                       class="px-3 py-2
                                              text-sm font-medium
                                              rounded-lg
                                              bg-yellow-100
                                              text-yellow-700
                                              hover:bg-yellow-200
                                              transition">

                                        Modifier

                                    </a>


                                    <!-- SUPPRIMER -->
                                    <form action="{{ route(
                                        'journaliste.documents.destroy',
                                        $document
                                    ) }}"

                                          method="POST"

                                          onsubmit="
                                            return confirm(
                                                'Voulez-vous vraiment supprimer ce document ?'
                                            );
                                          ">

                                        @csrf

                                        @method('DELETE')


                                        <button type="submit"

                                                class="px-3 py-2
                                                       text-sm font-medium
                                                       rounded-lg
                                                       bg-red-100
                                                       text-red-700
                                                       hover:bg-red-200
                                                       transition">

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="text-center
                                       py-14 text-gray-500">

                                <div class="text-4xl mb-3">

                                    📂

                                </div>

                                <p class="font-medium">

                                    Aucun document trouvé

                                </p>

                                <p class="text-sm mt-1">

                                    Cliquez sur « Nouveau document »
                                    pour ajouter votre premier document.

                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <!-- PAGINATION -->
    @if($documents->hasPages())

        <div class="mt-6">

            {{ $documents->links() }}

        </div>

    @endif

</div>

</div>

@endsection
