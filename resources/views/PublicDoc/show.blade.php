@extends('layouts.app')

@section('content')

@php
$isPaid = false;


if (auth()->check()) {
    $isPaid = \App\Models\Payment::where('user_id', auth()->id())
        ->where('document_id', $document->id)
        ->where('status', 'paid')
        ->exists();
}


@endphp

<section class="public-document-page">


<div class="public-document-container">

    {{-- Breadcrumb --}}
    <nav class="public-document-breadcrumb" aria-label="Fil d'Ariane">
        <a href="{{ route('home') }}">
            Accueil
        </a>

        <span>/</span>

        <a href="{{ route('documents.index') }}">
            Documents
        </a>

        <span>/</span>

        <span>
            {{ $document->title }}
        </span>
    </nav>


    {{-- Contenu principal --}}
    <div class="public-document-layout">

        {{-- =========================
             COUVERTURE
        ========================== --}}
        <aside class="public-document-cover-card">

            <div class="public-document-cover">

                @if($document->cover_image)

                    <img
                        src="{{ asset('storage/'.$document->cover_image) }}"
                        alt="{{ $document->title }}">

                @else

                    <div class="public-document-cover-placeholder">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                @endif

            </div>

        </aside>


        {{-- =========================
             INFORMATIONS
        ========================== --}}
        <main class="public-document-content">

            {{-- Badges --}}
            <div class="public-document-badges">

                @if($document->category)
                    <span class="public-document-badge public-document-badge-category">
                        <i class="bi bi-folder2-open"></i>
                        {{ $document->category }}
                    </span>
                @endif

                @if($document->access_type === 'free')

                    <span class="public-document-badge public-document-badge-free">
                        <i class="bi bi-unlock"></i>
                        Gratuit
                    </span>

                @else

                    <span class="public-document-badge public-document-badge-premium">
                        <i class="bi bi-star-fill"></i>
                        Premium
                    </span>

                @endif

            </div>


            {{-- Titre --}}
            <h1 class="public-document-title">
                {{ $document->title }}
            </h1>


            {{-- Description --}}
            @if($document->description)

                <div class="public-document-description">
                    {{ $document->description }}
                </div>

            @endif


            {{-- Informations essentielles --}}
            <div class="public-document-info">

                @if($document->level?->name)

                    <div class="public-document-info-item">
                        <span class="public-document-info-label">
                            <i class="bi bi-mortarboard-fill"></i>
                            Niveau
                        </span>

                        <strong>
                            {{ $document->level->name }}
                        </strong>
                    </div>

                @endif


                @if($document->cycle)

                    <div class="public-document-info-item">
                        <span class="public-document-info-label">
                            <i class="bi bi-diagram-3-fill"></i>
                            Cycle
                        </span>

                        <strong>
                            {{ $document->cycle }}
                        </strong>
                    </div>

                @endif


                <div class="public-document-info-item">
                    <span class="public-document-info-label">
                        <i class="bi bi-eye-fill"></i>
                        Vues
                    </span>

                    <strong>
                        {{ number_format($document->views ?? 0) }}
                    </strong>
                </div>


                <div class="public-document-info-item">
                    <span class="public-document-info-label">
                        <i class="bi bi-tag-fill"></i>
                        Accès
                    </span>

                    <strong>
                        @if($document->access_type === 'free')
                            Gratuit
                        @else
                            {{ number_format((float) $document->price, 0, ' ', ' ') }} FCFA
                        @endif
                    </strong>
                </div>

            </div>


            {{-- =========================
                 ACCÈS AU DOCUMENT
            ========================== --}}
            <div class="public-document-access">

                {{-- DOCUMENT GRATUIT --}}
                @if($document->access_type === 'free')

                    <div class="public-document-access-header public-document-access-header-free">

                        <div class="public-document-access-icon">
                            <i class="bi bi-unlock-fill"></i>
                        </div>

                        <div>
                            <h2>Document accessible</h2>
                            <p>
                                Ce document est disponible gratuitement.
                            </p>
                        </div>

                    </div>


                    <div class="public-document-actions">

                        <a
                            href="{{ route('documents.read', $document) }}"
                            target="_blank"
                            class="public-document-button public-document-button-read"
                        >
                            <i class="bi bi-book"></i>
                            <span>Lire le document</span>
                        </a>


                        <a
                            href="{{ route('documents.download', $document) }}"
                            class="public-document-button public-document-button-download"
                        >
                            <i class="bi bi-download"></i>
                            <span>Télécharger</span>
                        </a>

                    </div>


                {{-- DOCUMENT PREMIUM --}}
                @elseif($isPaid)

                    <div class="public-document-access-header public-document-access-header-paid">

                        <div class="public-document-access-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <div>
                            <h2>Paiement validé</h2>
                            <p>
                                Vous avez maintenant accès à ce document.
                            </p>
                        </div>

                    </div>


                    <div class="public-document-actions">

                        <a
                            href="{{ route('documents.read', $document) }}"
                            target="_blank"
                            class="public-document-button public-document-button-read"
                        >
                            <i class="bi bi-book"></i>
                            <span>Ouvrir le document</span>
                        </a>


                        <a
                            href="{{ route('documents.download', $document) }}"
                            class="public-document-button public-document-button-download"
                        >
                            <i class="bi bi-download"></i>
                            <span>Télécharger</span>
                        </a>

                    </div>


                {{-- DOCUMENT PREMIUM NON PAYÉ --}}
                @else

                    <div class="public-document-access-header public-document-access-header-premium">

                        <div class="public-document-access-icon">
                            <i class="bi bi-lock-fill"></i>
                        </div>

                        <div>
                            <h2>Accès Premium</h2>
                            <p>
                                Le paiement est nécessaire pour accéder à ce document.
                            </p>
                        </div>

                    </div>


                    <div class="public-document-price">

                        <span>Prix du document</span>

                        <strong>
                            {{ number_format((float) $document->price, 0, ' ', ' ') }}
                            FCFA
                        </strong>

                    </div>


                    <div class="public-document-payment-info">

                        <h3>
                            <i class="bi bi-shield-check"></i>
                            Accès après paiement
                        </h3>

                        <p>
                            Après validation du paiement, vous pourrez lire le document
                            et le télécharger depuis cette page.
                        </p>

                    </div>


                    <div class="public-document-actions">

                        @auth

                            <a
                                href="{{ route('payments.create', $document) }}"
                                class="public-document-button public-document-button-payment"
                            >
                                <i class="bi bi-credit-card"></i>
                                <span>Procéder au paiement</span>
                            </a>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="public-document-button public-document-button-login"
                            >
                                <i class="bi bi-box-arrow-in-right"></i>
                                <span>Se connecter pour payer</span>
                            </a>

                        @endauth

                    </div>

                @endif

            </div>


            {{-- Retour --}}
            <div class="public-document-back">

                <a href="{{ route('documents.index') }}">
                    <i class="bi bi-arrow-left"></i>
                    Retour aux documents
                </a>

            </div>

        </main>

    </div>

</div>

</section>

@endsection
