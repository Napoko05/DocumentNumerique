@extends('layouts.app')

@section('title', 'Paiement')

@section('content')

<section class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-slate-100 flex items-center justify-center px-4">

    <div class="w-full max-w-3xl">

        <!-- Card -->
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 rounded-3xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white">

                <h1 class="text-3xl font-bold">
                    Paiement du document
                </h1>

                <p class="text-blue-100 mt-2">
                    Finalisez votre accès pour consulter ce document
                </p>

            </div>

            <!-- Content -->
            <div class="p-8 space-y-6">

                <!-- Title -->
                <div>
                    <h2 class="text-2xl font-bold text-slate-800">
                        {{ $document->title }}
                    </h2>

                    <p class="text-slate-500 mt-2 leading-relaxed">
                        {{ $document->description }}
                    </p>
                </div>

                <!-- Price box -->
                <div class="bg-slate-50 border rounded-2xl p-6 flex items-center justify-between">

                    <div>
                        <p class="text-slate-500 text-sm">
                            Prix du document
                        </p>

                        <p class="text-xs text-slate-400 mt-1">
                            Paiement unique sécurisé
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-3xl font-extrabold text-indigo-600">
                            {{ number_format($document->price,0,' ',' ') }}
                        </p>
                        <p class="text-sm text-slate-500">
                            FCFA
                        </p>
                    </div>

                </div>

                <!-- Alert -->
                @if($document->price == 0 || $document->access_type === 'gratuit')
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl">
                        Ce document est <b>gratuit</b>, vous pouvez y accéder directement.
                    </div>
                @endif

                <!-- Button -->
                <form action="{{ route('payments.store', $document) }}" method="POST">
                    @csrf

                    <button
                        type="submit"
                        class="w-full py-4 rounded-2xl text-white font-bold text-lg
                        bg-gradient-to-r from-orange-500 to-red-500
                        hover:from-orange-600 hover:to-red-600
                        shadow-lg hover:shadow-xl transition-all duration-300
                        active:scale-95">

                        Payer maintenant

                    </button>

                </form>

                <!-- Back -->
                <div class="text-center pt-4">
                    <a href="{{ route('documents.show', $document) }}"
                       class="text-slate-500 hover:text-slate-700 text-sm">
                        ← Retour au document
                    </a>
                </div>

            </div>

        </div>

    </div>

</section>

@endsection