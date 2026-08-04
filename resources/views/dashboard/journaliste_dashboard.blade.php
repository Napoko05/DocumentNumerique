@extends('layouts.journalist_app')

@section('page-title', 'Tableau de bord Journaliste')

@section('content')

<div class="space-y-6">

{{-- ============================================================
    STATISTIQUES PRINCIPALES
============================================================= --}}

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

    {{-- TOTAL DOCUMENTS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Documents
                </p>

                <h3 class="text-3xl font-bold text-slate-800">

                    {{ $totalDocuments }}

                </h3>

            </div>

            <div class="w-12 h-12 rounded-xl bg-blue-100
                        flex items-center justify-center text-2xl">

                📚

            </div>

        </div>

    </div>


    {{-- DOCUMENTS GRATUITS --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Documents gratuits
                </p>

                <h3 class="text-3xl font-bold text-emerald-600">

                    {{ $freeDocuments }}

                </h3>

            </div>

            <div class="w-12 h-12 rounded-xl bg-emerald-100
                        flex items-center justify-center text-2xl">

                🆓

            </div>

        </div>

    </div>


    {{-- DOCUMENTS PREMIUM --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Documents premium
                </p>

                <h3 class="text-3xl font-bold text-orange-600">

                    {{ $premiumDocuments }}

                </h3>

            </div>

            <div class="w-12 h-12 rounded-xl bg-orange-100
                        flex items-center justify-center text-2xl">

                💎

            </div>

        </div>

    </div>


    {{-- TOTAL VUES --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-slate-500">
                    Total des vues
                </p>

                <h3 class="text-3xl font-bold text-violet-600">

                    {{ number_format($totalViews, 0, ',', ' ') }}

                </h3>

            </div>

            <div class="w-12 h-12 rounded-xl bg-violet-100
                        flex items-center justify-center text-2xl">

                👁️

            </div>

        </div>

    </div>

</div>


{{-- ============================================================
    STATUTS DES DOCUMENTS
============================================================= --}}

<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

    {{-- PUBLIÉS --}}
    <div class="bg-green-50 border border-green-200
                rounded-2xl p-5">

        <p class="text-sm font-medium text-green-700">

            ✓ Publiés

        </p>

        <p class="text-2xl font-bold text-green-800 mt-2">

            {{ $publishedDocuments }}

        </p>

    </div>


    {{-- EN ATTENTE --}}
    <div class="bg-yellow-50 border border-yellow-200
                rounded-2xl p-5">

        <p class="text-sm font-medium text-yellow-700">

            ⏳ En attente

        </p>

        <p class="text-2xl font-bold text-yellow-800 mt-2">

            {{ $pendingDocuments }}

        </p>

    </div>


    {{-- BROUILLONS --}}
    <div class="bg-slate-50 border border-slate-200
                rounded-2xl p-5">

        <p class="text-sm font-medium text-slate-600">

            📝 Brouillons

        </p>

        <p class="text-2xl font-bold text-slate-800 mt-2">

            {{ $draftDocuments }}

        </p>

    </div>


    {{-- REJETÉS --}}
    <div class="bg-red-50 border border-red-200
                rounded-2xl p-5">

        <p class="text-sm font-medium text-red-700">

            ✕ Rejetés

        </p>

        <p class="text-2xl font-bold text-red-800 mt-2">

            {{ $rejectedDocuments }}

        </p>

    </div>

</div>


{{-- ============================================================
    ACTIONS RAPIDES
============================================================= --}}

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">


    {{-- AJOUTER --}}
    <a href="{{ route('journaliste.documents.create') }}"
       class="bg-white border border-slate-200 rounded-2xl
              p-5 hover:shadow-md hover:border-blue-300
              transition">

        <div class="text-3xl mb-3">

            ➕

        </div>

        <h3 class="font-semibold text-slate-800">

            Nouveau document

        </h3>

        <p class="text-sm text-slate-500 mt-1">

            Ajouter un nouveau document

        </p>

    </a>


    {{-- MES DOCUMENTS --}}
    <a href="{{ route('journaliste.documents.index') }}"
       class="bg-white border border-slate-200 rounded-2xl
              p-5 hover:shadow-md hover:border-blue-300
              transition">

        <div class="text-3xl mb-3">

            📄

        </div>

        <h3 class="font-semibold text-slate-800">

            Mes documents

        </h3>

        <p class="text-sm text-slate-500 mt-1">

            Gérer mes publications

        </p>

    </a>


    {{-- UTILISATEURS --}}
    <a href="{{ route('journaliste.users') }}"
       class="bg-white border border-slate-200 rounded-2xl
              p-5 hover:shadow-md hover:border-blue-300
              transition">

        <div class="text-3xl mb-3">

            👥

        </div>

        <h3 class="font-semibold text-slate-800">

            Utilisateurs

        </h3>

        <p class="text-sm text-slate-500 mt-1">

            Consulter les utilisateurs

        </p>

    </a>


    {{-- TÉLÉCHARGEMENTS --}}
    <div class="bg-white border border-slate-200
                rounded-2xl p-5">

        <div class="text-3xl mb-3">

            ⬇️

        </div>

        <h3 class="font-semibold text-slate-800">

            Téléchargements

        </h3>

        <p class="text-2xl font-bold text-blue-600 mt-2">

            {{ number_format(
                $totalDownloads,
                0,
                ',',
                ' '
            ) }}

        </p>

    </div>

</div>


{{-- ============================================================
    DOCUMENTS RÉCENTS
============================================================= --}}

<div class="bg-white rounded-2xl border border-slate-200
            shadow-sm overflow-hidden">


    {{-- HEADER --}}
    <div class="px-6 py-5 border-b border-slate-200
                flex flex-col sm:flex-row
                sm:items-center
                sm:justify-between gap-4">

        <div>

            <h2 class="font-bold text-lg text-slate-800">

                Mes documents récents

            </h2>

            <p class="text-sm text-slate-500">

                Les 10 derniers documents ajoutés

            </p>

        </div>


        <a href="{{ route('journaliste.documents.create') }}"
           class="bg-blue-600 hover:bg-blue-700
                  text-white px-4 py-2
                  rounded-xl text-sm
                  text-center transition">

            ➕ Nouveau document

        </a>

    </div>


    {{-- AUCUN DOCUMENT --}}
    @if($documents->isEmpty())

        <div class="text-center py-16">

            <div class="text-6xl mb-4">

                📚

            </div>

            <h3 class="font-semibold text-lg text-slate-800">

                Aucun document

            </h3>

            <p class="text-slate-500 mt-2">

                Commencez par ajouter votre premier document.

            </p>

        </div>


    {{-- TABLEAU --}}
    @else

        <div class="overflow-x-auto">

            <table class="min-w-full">


                {{-- EN-TÊTE --}}
                <thead class="bg-slate-50">

                    <tr class="text-left text-xs
                               font-semibold
                               uppercase
                               tracking-wider
                               text-slate-500">

                        <th class="px-6 py-4">

                            Titre

                        </th>

                        <th class="px-4 py-4">

                            Formation / Filière

                        </th>

                        <th class="px-4 py-4">

                            Niveau / Module

                        </th>

                        <th class="px-4 py-4">

                            Accès

                        </th>

                        <th class="px-4 py-4">

                            Statut

                        </th>

                        <th class="px-4 py-4 text-center">

                            Vues

                        </th>

                        <th class="px-6 py-4 text-center">

                            Actions

                        </th>

                    </tr>

                </thead>


                {{-- CORPS --}}
                <tbody class="divide-y divide-slate-100">


                    @foreach($documents as $doc)

                        <tr class="hover:bg-slate-50 transition">


                            {{-- TITRE --}}
                            <td class="px-6 py-4">

                                <p class="font-semibold
                                          text-slate-800">

                                    {{ $doc->title }}

                                </p>

                                <p class="text-xs
                                          text-slate-400 mt-1">

                                    {{ $doc->documentType?->name
                                        ?? 'Type non renseigné' }}

                                </p>

                            </td>


                            {{-- FORMATION / FILIÈRE --}}
                            <td class="px-4 py-4">

                                <p class="text-sm
                                          text-slate-700">

                                    {{ $doc->formation?->name
                                        ?? '—' }}

                                </p>

                                <p class="text-xs
                                          text-slate-500 mt-1">

                                    {{ $doc->filiere?->name
                                        ?? 'Aucune filière' }}

                                </p>

                            </td>


                            {{-- NIVEAU / MODULE --}}
                            <td class="px-4 py-4">

                                <p class="text-sm
                                          text-slate-700">

                                    {{ $doc->level?->name
                                        ?? '—' }}

                                </p>

                                <p class="text-xs
                                          text-slate-500 mt-1">

                                    {{ $doc->subject?->name
                                        ?? 'Aucun module' }}

                                </p>

                            </td>


                            {{-- ACCÈS --}}
                            <td class="px-4 py-4">

                                @if(
                                    $doc->access_type
                                    === 'premium'
                                )

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 bg-orange-100
                                                 text-orange-700
                                                 rounded-full
                                                 text-xs
                                                 font-semibold">

                                        💎 Premium

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 bg-emerald-100
                                                 text-emerald-700
                                                 rounded-full
                                                 text-xs
                                                 font-semibold">

                                        🆓 Gratuit

                                    </span>

                                @endif

                            </td>


                            {{-- STATUT --}}
                            <td class="px-4 py-4">

                                @if(
                                    $doc->status
                                    === 'published'
                                )

                                    <span class="text-xs
                                                 font-semibold
                                                 text-green-700">

                                        ✓ Publié

                                    </span>

                                @elseif(
                                    $doc->status
                                    === 'pending'
                                )

                                    <span class="text-xs
                                                 font-semibold
                                                 text-yellow-700">

                                        ⏳ En attente

                                    </span>

                                @elseif(
                                    $doc->status
                                    === 'rejected'
                                )

                                    <span class="text-xs
                                                 font-semibold
                                                 text-red-700">

                                        ✕ Rejeté

                                    </span>

                                @else

                                    <span class="text-xs
                                                 font-semibold
                                                 text-slate-500">

                                        📝 Brouillon

                                    </span>

                                @endif

                            </td>


                            {{-- VUES --}}
                            <td class="px-4 py-4
                                       text-center
                                       font-semibold
                                       text-slate-700">

                                👁️ {{ $doc->views ?? 0 }}

                            </td>


                            {{-- ACTIONS --}}
                            <td class="px-6 py-4">

                                <div class="flex
                                            justify-center
                                            flex-wrap
                                            gap-2">


                                    {{-- VOIR --}}
                                    <a href="{{ route(
                                        'journaliste.documents.show',
                                        $doc
                                    ) }}"

                                       class="px-3 py-2
                                              bg-blue-100
                                              hover:bg-blue-200
                                              text-blue-700
                                              rounded-lg
                                              text-xs
                                              font-semibold
                                              transition">

                                        Voir

                                    </a>


                                    {{-- MODIFIER --}}
                                    <a href="{{ route(
                                        'journaliste.documents.edit',
                                        $doc
                                    ) }}"

                                       class="px-3 py-2
                                              bg-amber-100
                                              hover:bg-amber-200
                                              text-amber-700
                                              rounded-lg
                                              text-xs
                                              font-semibold
                                              transition">

                                        Modifier

                                    </a>


                                    {{-- SUPPRIMER --}}
                                    <form action="{{ route(
                                        'journaliste.documents.destroy',
                                        $doc
                                    ) }}"

                                          method="POST">

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"

                                            onclick="
                                                return confirm(
                                                    'Supprimer ce document ?'
                                                );
                                            "

                                            class="px-3 py-2
                                                   bg-red-100
                                                   hover:bg-red-200
                                                   text-red-700
                                                   rounded-lg
                                                   text-xs
                                                   font-semibold
                                                   transition">

                                            Supprimer

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>
</div>

@endsection
