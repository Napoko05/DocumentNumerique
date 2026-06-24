@extends('layouts.journalist_app')

@section('title', $document->title)

@section('content')

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-100 py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-4xl mx-auto">

        <!-- HEADER -->
       <!-- HEADER FULL WIDTH -->
<div class="w-full bg-blue-600 py-6 mb-10 shadow-md">

    <h1 class="text-center text-white text-3xl md:text-4xl font-bold">
        {{ $document->title }}
    </h1>

    <p class="text-center text-blue-100 mt-2">
        Détails complets du document
    </p>

</div>

        <!-- CARD -->
        <div class="bg-white shadow-xl rounded-2xl border border-blue-100 overflow-hidden">

            <div class="p-8 space-y-6">

                <!-- INFOS -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700">

                    <p>
                        <span class="font-semibold text-blue-700">📁 Catégorie :</span>
                        {{ $document->category }}
                    </p>

                    <p>
                        <span class="font-semibold text-blue-700">🎓 Niveau :</span>
                        {{ $document->level }}
                    </p>

                    <p>
                        <span class="font-semibold text-blue-700">🔄 Cycle :</span>
                        {{ $document->cycle }}
                    </p>

                    <p>
                        <span class="font-semibold text-blue-700">👁 Vues :</span>
                        {{ $document->views }}
                    </p>

                    <p>
                        <span class="font-semibold text-blue-700">🔐 Type :</span>

                        @if($document->access_type == 'free')
                        <span class="ml-2 px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">
                            Gratuit
                        </span>
                        @else
                        <span class="ml-2 px-3 py-1 text-xs rounded-full bg-orange-100 text-orange-700">
                            Premium
                        </span>
                        @endif

                    </p>

                    @if($document->access_type == 'premium')
                    <p>
                        <span class="font-semibold text-blue-700">💰 Prix :</span>
                        {{ number_format($document->price) }} FCFA
                    </p>
                    @endif

                </div>

                <hr class="border-blue-100">

                <!-- DESCRIPTION -->
                <div>
                    <h2 class="text-xl font-bold text-blue-700 mb-3">
                        📄 Description
                    </h2>

                    <p class="text-gray-700 leading-relaxed">
                        {{ $document->description }}
                    </p>
                </div>

                <hr class="border-blue-100">

                <!-- ACTIONS -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">

                    <a href="{{ route('journaliste.documents.edit',$document) }}"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md transition text-center">
                        ✏️ Modifier
                    </a>

                    <a href="{{ route('journaliste.documents.index') }}"
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-xl text-center transition">
                        ← Retour
                    </a>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection