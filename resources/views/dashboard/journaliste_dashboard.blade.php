@extends('layouts.journalist_app')

@section('page-title', 'Tableau de bord Journaliste')

@section('content')

<div class="space-y-6">

    {{-- ============================================================
        STATISTIQUES
    ============================================================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Documents</p>
                    <h3 class="text-3xl font-bold text-slate-800">
                        {{ $totalDocuments }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    📚
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Documents gratuits</p>
                    <h3 class="text-3xl font-bold text-emerald-600">
                        {{ $totalFree }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    🆓
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Documents premium</p>
                    <h3 class="text-3xl font-bold text-orange-600">
                        {{ $totalPremium }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                    💎
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total vues</p>
                    <h3 class="text-3xl font-bold text-violet-600">
                        {{ $totalViews }}
                    </h3>
                </div>

                <div class="w-12 h-12 rounded-xl bg-violet-100 flex items-center justify-center">
                    👁️
                </div>
            </div>
        </div>

    </div>

    {{-- ============================================================
        ACTIONS RAPIDES
    ============================================================= --}}
    <div class="grid md:grid-cols-4 gap-4">

        <a href="{{ route('journaliste.documents.create') }}"
            class="bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-md transition">

            <div class="text-3xl mb-3">➕</div>
            <h3 class="font-semibold">Publier</h3>
            <p class="text-sm text-slate-500">
                Ajouter un nouveau document
            </p>

        </a>

        <a href="{{ route('journaliste.documents.index') }}"
            class="bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-md transition">

            <div class="text-3xl mb-3">📄</div>
            <h3 class="font-semibold">Mes documents</h3>
            <p class="text-sm text-slate-500">
                Gérer les publications
            </p>

        </a>

        <a href="#"
            class="bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-md transition">

            <div class="text-3xl mb-3">📊</div>
            <h3 class="font-semibold">Statistiques</h3>
            <p class="text-sm text-slate-500">
                Consulter les performances
            </p>

        </a>

        <a href="#"
            class="bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-md transition">

            <div class="text-3xl mb-3">💰</div>
            <h3 class="font-semibold">Paiements</h3>
            <p class="text-sm text-slate-500">
                Revenus et transactions
            </p>

        </a>

    </div>

    {{-- ============================================================
        DOCUMENTS
    ============================================================= --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-6 py-5 border-b flex items-center justify-between">

            <h2 class="font-bold text-lg">
                Mes documents récents
            </h2>

            <a href="{{ route('journaliste.documents.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm">

                Nouveau document

            </a>

        </div>

        @if($documents->isEmpty())

        <div class="text-center py-16">

            <div class="text-6xl mb-4">
                📚
            </div>

            <h3 class="font-semibold text-lg">
                Aucun document publié
            </h3>

            <p class="text-slate-500 mt-2">
                Commencez par publier votre premier document.
            </p>

        </div>

        @else

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="text-left px-6 py-4">Titre</th>
                        <th class="text-left px-4 py-4">Catégorie</th>
                        <th class="text-left px-4 py-4">Niveau</th>
                        <th class="text-left px-4 py-4">Accès</th>
                        <th class="text-center px-4 py-4">Vues</th>
                        <th class="text-center px-6 py-4">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($documents as $doc)

                    <tr class="border-t hover:bg-slate-50">

                        <td class="px-6 py-4">

                            <div class="font-semibold text-slate-800">
                                {{ $doc->title }}
                            </div>

                        </td>

                        <td class="px-4 py-4">
                            {{ $doc->category }}
                        </td>

                        <td class="px-4 py-4">
                            {{ $doc->level }}
                        </td>

                        <td class="px-4 py-4">

                            @if($doc->access_type == 'premium')

                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-semibold">
                                Premium
                            </span>

                            @else

                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                                Gratuit
                            </span>

                            @endif

                        </td>

                        <td class="px-4 py-4 text-center font-semibold">
                            {{ $doc->views }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <a href="{{ route('documents.show',$doc) }}"
                                    class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs">

                                    Voir

                                </a>

                                <a href="{{ route('journaliste.documents.edit',$doc) }}"
                                    class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs">

                                    Modifier

                                </a>

                                <form action="{{ route('journaliste.documents.destroy',$doc) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('Supprimer ce document ?')"
                                        class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs">

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