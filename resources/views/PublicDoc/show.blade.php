@extends('layouts.app')

@section('content')

@php
    $isPaid = false;

    if(auth()->check()){
        $isPaid = \App\Models\Payment::where('user_id', auth()->id())
            ->where('document_id', $document->id)
            ->where('status', 'paid')
            ->exists();
    }
@endphp

<section class="bg-slate-50 min-h-screen py-10">

    <div class="max-w-7xl mx-auto px-4">

        {{-- Breadcrumb --}}
        <div class="mb-6 text-sm text-slate-500">
            <a href="{{ route('home') }}" class="hover:text-blue-600">
                Accueil
            </a>
            /
            <a href="{{ route('documents.index') }}" class="hover:text-blue-600">
                Documents
            </a>
            /
            <span class="text-slate-700">
                {{ $document->title }}
            </span>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">

            {{-- Couverture --}}
            <div>

                <div class="bg-white rounded-3xl shadow-sm border overflow-hidden">

                    @if($document->cover_image)

                        <img
                            src="{{ asset('storage/'.$document->cover_image) }}"
                            class="w-full h-auto object-cover">

                    @else

                        <div class="h-[500px] flex items-center justify-center bg-slate-100">

                            <svg class="w-24 h-24 text-slate-400"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 6.253v11.494m-5.747-8.747h11.494"/>

                            </svg>

                        </div>

                    @endif

                </div>

            </div>

            {{-- Informations --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-3xl shadow-sm border p-8">

                    <div class="flex flex-wrap gap-3 mb-4">

                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            {{ $document->category }}
                        </span>

                        @if($document->access_type == 'free')

                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                Gratuit
                            </span>

                        @else

                            <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">
                                Premium
                            </span>

                        @endif

                    </div>

                    <h1 class="text-4xl font-bold text-slate-800 mb-4">
                        {{ $document->title }}
                    </h1>

                    <p class="text-slate-600 leading-relaxed mb-8">
                        {{ $document->description }}
                    </p>

                    <div class="grid md:grid-cols-4 gap-4 mb-8">

                        <div class="bg-slate-50 rounded-xl p-4">
                            <div class="text-slate-500 text-sm">
                                Niveau
                            </div>
                            <div class="font-semibold">
                                {{ $document->level }}
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-4">
                            <div class="text-slate-500 text-sm">
                                Cycle
                            </div>
                            <div class="font-semibold">
                                {{ $document->cycle ?? '-' }}
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-4">
                            <div class="text-slate-500 text-sm">
                                Vues
                            </div>
                            <div class="font-semibold">
                                {{ number_format($document->views) }}
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-4">
                            <div class="text-slate-500 text-sm">
                                Prix
                            </div>

                            @if($document->access_type == 'free')
                                <div class="font-bold text-green-600">
                                    Gratuit
                                </div>
                            @else
                                <div class="font-bold text-orange-600">
                                    {{ number_format($document->price,0,' ',' ') }} FCFA
                                </div>
                            @endif

                        </div>

                    </div>

                    {{-- DOCUMENT GRATUIT --}}
                    @if($document->access_type == 'free')

                        <div class="flex flex-wrap gap-4">

                            <a href="{{ route('documents.read',$document) }}"
                               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold">

                                Lire le document

                            </a>

                            <a href="{{ asset('storage/'.$document->file_path) }}"
                               download
                               class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-semibold">

                                Télécharger

                            </a>

                        </div>

                    {{-- DOCUMENT PREMIUM --}}
                    @else

                        {{-- Déjà payé --}}
                        @if($isPaid)

                            <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-6">

                                <div class="flex items-center gap-3">

                                    <svg class="w-8 h-8 text-green-600"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M5 13l4 4L19 7"/>

                                    </svg>

                                    <div>

                                        <h3 class="font-bold text-green-700">
                                            Paiement validé
                                        </h3>

                                        <p class="text-green-600">
                                            Vous avez accès au document.
                                        </p>

                                    </div>

                                </div>

                            </div>

                            <div class="flex flex-wrap gap-4">

                                <a href="{{ route('documents.read',$document) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-semibold">

                                    Lire le document

                                </a>

                                <a href="{{ asset('storage/'.$document->file_path) }}"
                                   download
                                   class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-semibold">

                                    Télécharger

                                </a>

                            </div>

                        @else

                            {{-- Non payé --}}
                            <div class="bg-orange-50 border border-orange-200 rounded-2xl p-8">

                                <h3 class="text-2xl font-bold text-orange-700 mb-4">
                                    Accès Premium
                                </h3>

                                <p class="text-slate-600 mb-6">
                                    Ce document est réservé aux utilisateurs ayant effectué un paiement.
                                </p>

                                <div class="bg-white rounded-xl border p-6 mb-6">

                                    <h4 class="font-bold text-lg mb-4">
                                        Modalités de paiement
                                    </h4>

                                    <ul class="space-y-3 text-slate-600">

                                        <li>📱 Orange Money</li>

                                        <li>📱 Moov Money</li>

                                        <li>📱 Telecel Money</li>

                                        <li>💳 Carte bancaire</li>

                                    </ul>

                                </div>

                                @auth

                                    <a href="{{ route('payments.create',$document) }}"
                                       class="inline-flex bg-orange-600 hover:bg-orange-700 text-white px-8 py-4 rounded-xl font-bold">

                                        Procéder au paiement

                                    </a>

                                @else

                                    <a href="{{ route('login') }}"
                                       class="inline-flex bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-bold">

                                        Connectez-vous pour payer

                                    </a>

                                @endauth

                            </div>

                        @endif

                    @endif

                </div>

            </div>

        </div>

    </div>

</section>

@endsection