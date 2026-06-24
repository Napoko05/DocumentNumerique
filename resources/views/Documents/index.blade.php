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
                <p class="text-gray-500">
                    Gérez et suivez tous vos documents publiés
                </p>
            </div>

            <a href="{{ route('journaliste.documents.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow-md transition">
                ➕ Nouveau document
            </a>

        </div>

        <!-- SUCCESS -->
        @if(session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-100 text-green-700 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- CARD -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-gray-200">

                    <!-- HEADER TABLE -->
                    <thead class="bg-gray-100">
                        <tr class="text-left text-gray-600 text-sm uppercase tracking-wider">

                            <th class="px-6 py-4">Titre</th>
                            <th class="px-6 py-4">Catégorie</th>
                            <th class="px-6 py-4">Niveau</th>
                            <th class="px-6 py-4">Accès</th>
                            <th class="px-6 py-4">Prix</th>
                            <th class="px-6 py-4">Vues</th>

                            <!-- ACTION ELARGIE -->
                            <th class="px-6 py-4 w-[280px]">
                                Actions
                            </th>

                        </tr>
                    </thead>

                    <!-- BODY -->
                    <tbody class="divide-y divide-gray-100">

                        @forelse($documents as $document)

                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-6 py-4 font-medium text-gray-800">
                                    {{ $document->title }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $document->category }}
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    {{ $document->level }}
                                </td>

                                <td class="px-6 py-4">

                                    @if($document->access_type == 'free')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                            Gratuit
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-700">
                                            Premium
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    @if($document->access_type == 'premium')
                                        {{ number_format($document->price) }} FCFA
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    👁 {{ $document->views }}
                                </td>

                                <!-- ACTIONS -->
                                <td class="px-6 py-4">

                                    <div class="flex flex-wrap gap-2">

                                        <a href="{{ route('journaliste.documents.show',$document) }}"
                                           class="px-3 py-2 text-sm rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition">
                                            Voir
                                        </a>

                                        <a href="{{ route('journaliste.documents.edit',$document) }}"
                                           class="px-3 py-2 text-sm rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition">
                                            Modifier
                                        </a>

                                        <form action="{{ route('journaliste.documents.destroy',$document) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Supprimer ce document ?')"
                                                    class="px-3 py-2 text-sm rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition">
                                                Supprimer
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="text-center py-10 text-gray-500">
                                    Aucun document publié
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <!-- PAGINATION -->
        <div class="mt-6">
            {{ $documents->links() }}
        </div>

    </div>
</div>

@endsection