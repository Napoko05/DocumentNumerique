@extends('layouts.app')

@section('content')

<div class="formation-page">

<section class="formation-hero">
    <div class="container">

        <span class="formation-badge">
            <i class="bi bi-file-earmark-text-fill"></i>
            DOCUMENT
        </span>

        <h1>
            {{ $document->title }}
        </h1>

        <p>
            {{ $formation->name }}

            @if(isset($specialite) && $specialite)
                • {{ $specialite->name }}
            @endif

            • {{ $niveau->name }}
            • {{ $documentType->name }}
        </p>

    </div>
</section>

<section class="formation-content">

    <div class="container">

        <div class="document-show-card">

            <div class="document-show-header">

                <div class="document-show-icon">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>

                <div>
                    <span class="section-kicker">
                        DOCUMENT PÉDAGOGIQUE
                    </span>

                    <h2>
                        {{ $document->title }}
                    </h2>
                </div>

            </div>

            @if($document->description)

                <div class="document-description">

                    <h3>
                        Description
                    </h3>

                    <p>
                        {{ $document->description }}
                    </p>

                </div>

            @endif

            <div class="document-meta">

                <div>
                    <i class="bi bi-building"></i>
                    <strong>Formation</strong>
                    <span>{{ $formation->name }}</span>
                </div>

                @if(isset($specialite) && $specialite)

                    <div>
                        <i class="bi bi-diagram-3"></i>
                        <strong>Spécialité</strong>
                        <span>{{ $specialite->name }}</span>
                    </div>

                @endif

                <div>
                    <i class="bi bi-mortarboard"></i>
                    <strong>Niveau</strong>
                    <span>{{ $niveau->name }}</span>
                </div>

                <div>
                    <i class="bi bi-folder"></i>
                    <strong>Type</strong>
                    <span>{{ $documentType->name }}</span>
                </div>

            </div>

            {{-- =========================================================
                 ACCÈS AU DOCUMENT
            ========================================================== --}}

            <div class="document-action">

                @if($document->isFree())

                    {{-- DOCUMENT GRATUIT --}}

                    @if($document->file_path)

                        <a
                            href="{{ route('vitrine.documents.file', $document) }}"
                            target="_blank"
                            class="document-view-btn"
                        >
                            <i class="bi bi-eye"></i>
                            Consulter le document
                        </a>

                    @endif

                @elseif($document->isPremium())

                    {{-- DOCUMENT PREMIUM --}}

                    @auth

                        @if($document->userHasAccess(auth()->id()))

                            {{-- UTILISATEUR AYANT DÉJÀ PAYÉ --}}

                            <div class="document-access-success">

                                <i class="bi bi-check-circle-fill"></i>

                                <div>
                                    <strong>
                                        Document accessible
                                    </strong>

                                    <span>
                                        Votre paiement a été confirmé.
                                    </span>
                                </div>

                            </div>

                            @if($document->file_path)

                                <a
                                    href="{{ route('vitrine.documents.file', $document) }}"
                                    target="_blank"
                                    class="document-view-btn"
                                >
                                    <i class="bi bi-eye"></i>
                                    Consulter le document
                                </a>

                            @endif

                        @else

                            {{-- DOCUMENT NON PAYÉ --}}

                            <div class="document-premium-box">

                                <div class="document-premium-icon">
                                    <i class="bi bi-lock-fill"></i>
                                </div>

                                <div class="document-premium-content">

                                    <span class="premium-label">
                                        DOCUMENT PREMIUM
                                    </span>

                                    <h3>
                                        Accès payant
                                    </h3>

                                    <p>
                                        Ce document est réservé aux utilisateurs
                                        ayant effectué le paiement.
                                    </p>

                                    <div class="document-price">
                                        {{ number_format($document->price, 0, ',', ' ') }}
                                        FCFA
                                    </div>

                                    <a
                                        href="{{ route('vitrine.documents.payment', $document) }}"
                                        class="document-payment-btn"
                                    >
                                        <i class="bi bi-credit-card"></i>
                                        Payer pour consulter
                                    </a>

                                </div>

                            </div>

                        @endif

                    @else

                        {{-- UTILISATEUR NON CONNECTÉ --}}

                        <div class="document-premium-box">

                            <div class="document-premium-icon">
                                <i class="bi bi-lock-fill"></i>
                            </div>

                            <div class="document-premium-content">

                                <span class="premium-label">
                                    DOCUMENT PREMIUM
                                </span>

                                <h3>
                                    Connexion requise
                                </h3>

                                <p>
                                    Vous devez être connecté pour acheter
                                    et consulter ce document.
                                </p>

                                <div class="document-price">
                                    {{ number_format($document->price, 0, ',', ' ') }}
                                    FCFA
                                </div>

                                <a
                                    href="{{ route('login') }}"
                                    class="document-payment-btn"
                                >
                                    <i class="bi bi-box-arrow-in-right"></i>
                                    Se connecter pour continuer
                                </a>

                            </div>

                        </div>

                    @endauth

                @endif

            </div>

        </div>

        <div class="doc-type-back-container">

            <a
                href="{{ route(
                    'vitrine.professionnel.specialite.documents',
                    [
                        'formationSlug' => $formation->slug,
                        'specialiteSlug' => $specialite->slug,
                        'niveauSlug' => $niveau->slug,
                        'moduleSlug' => $module->slug,
                        'typeSlug' => $documentType->slug
                    ]
                ) }}"
                class="doc-type-back-btn"
            >
                <i class="bi bi-arrow-left"></i>
                Retour aux documents
            </a>

        </div>

    </div>

</section>


</div>

@endsection
