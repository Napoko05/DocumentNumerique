@extends('layouts.app')

@section('content')

<section class="bg-slate-50 min-h-screen py-12">

    <div class="max-w-7xl mx-auto px-4">

        <div class="text-center mb-10">

            <h1 class="text-4xl font-bold text-slate-800">
                Bibliothèque numérique
            </h1>

            <p class="text-slate-500 mt-3">
                Consultez nos ressources scientifiques
            </p>

        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

            @forelse($documents as $document)

                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-lg transition">

                    @if($document->cover_image)

                        <img
                            src="{{ asset('storage/'.$document->cover_image) }}"
                            class="h-64 w-full object-cover">

                    @else

                        <div class="h-64 bg-slate-200 flex items-center justify-center">

                            <svg class="w-20 h-20 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 8h10M7 12h6m-6 4h10M5 4h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z"/>

                            </svg>

                        </div>

                    @endif

                    <div class="p-5">

                        <h3 class="font-bold text-lg mb-2">
                            {{ $document->title }}
                        </h3>

                        <p class="text-slate-500 text-sm mb-4">
                            {{ Str::limit($document->description,100) }}
                        </p>

                        <div class="flex justify-between items-center mb-4">

                            @if($document->access_type == 'premium')

                                <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full">
                                    Premium
                                </span>

                            @else

                                <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">
                                    Gratuit
                                </span>

                            @endif

                            <span class="text-slate-500 text-sm">
                                {{ $document->views }} vues
                            </span>

                        </div>

                        @if($document->access_type == 'premium')

                            <div class="font-bold text-orange-600 mb-4">

                                {{ number_format($document->price,0,' ',' ') }}
                                FCFA

                            </div>

                        @endif

                        <a href="{{ route('documents.show',$document) }}"
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl">

                            Voir le document

                        </a>

                    </div>

                </div>

            @empty

                <div class="col-span-full text-center py-20">

                    <h2 class="text-xl text-slate-500">
                        Aucun document disponible
                    </h2>

                </div>

            @endforelse

        </div>

        <div class="mt-10">

            {{ $documents->links() }}

        </div>

    </div>

</section>

@endsection