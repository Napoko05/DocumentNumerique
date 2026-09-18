@extends('layouts.app')

@section('title', $subject->name)

@section('content')

<div class="superieur-page">

{{-- HERO --}}
<section class="superieur-hero">
    <div class="container">

        <span class="superieur-badge">
            <i class="bi bi-book-fill"></i>
            Matière
        </span>

        <h1>
            {{ $subject->name }}
        </h1>

        <p>
            {{ $domaine->name }}
            •
            {{ $filiere->name }}
            •
            {{ $niveau->name }}
        </p>

    </div>
</section>


{{-- CONTENU --}}
<section class="superieur-content">
    <div class="container">

        {{-- RETOUR --}}
        <div class="superieur-back-wrapper">

            <a
                href="{{ route(
                    'vitrine.superieur.modules',
                    [
                        'domaineSlug' => $domaine->slug,
                        'filiereSlug' => $filiere->slug,
                        'niveauSlug' => $niveau->slug
                    ]
                ) }}"
                class="superieur-back"
                aria-label="Retour aux modules"
            >
                <i class="bi bi-arrow-left"></i>
                <span>Retour aux modules</span>
            </a>

        </div>


        {{-- EN-TÊTE --}}
        <div class="section-heading">

            <div>

                <span class="section-kicker">
                    Ressources pédagogiques
                </span>

                <h2>
                    Documents disponibles
                </h2>

            </div>

            <span class="class-count">
                {{ $documents->count() }}
                document{{ $documents->count() > 1 ? 's' : '' }}
            </span>

        </div>


        @if($documents->isNotEmpty())

            {{-- GRILLE --}}
            <div class="superieur-grid">

                @foreach($documents as $document)

                    <article class="superieur-card document-card">

                        <div class="superieur-card-top">

                            <div class="superieur-icon">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </div>

                            <span class="superieur-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </div>


                        <div class="superieur-card-body">

                            <h3>
                                {{ $document->title }}
                            </h3>

                            @if($document->access_type === 'premium')

                                <p>
                                    <i class="bi bi-lock-fill"></i>
                                    {{ number_format((float) $document->price, 0, ',', ' ') }}
                                    FCFA
                                </p>

                            @else

                                <p>
                                    <i class="bi bi-unlock-fill"></i>
                                    Gratuit
                                </p>

                            @endif

                            @if(!empty($document->description))

                                <p class="superieur-description">
                                    {{ $document->description }}
                                </p>

                            @endif

                        </div>


                        {{-- ACTIONS --}}
                        <div class="document-actions">

                            @if($document->access_type === 'premium')

                                {{-- PREMIUM : PAIEMENT --}}
                                <a
                                    href="{{ route(
                                        'payments.create',
                                        ['document' => $document->id]
                                    ) }}"
                                    class="btn-document-download"
                                >
                                    <i class="bi bi-credit-card"></i>
                                    Payer
                                </a>

                            @else

                                {{-- GRATUIT : VOIR --}}
                                <a
                                    href="{{ route(
                                        'documents.read',
                                        $document
                                    ) }}"
                                    target="_blank"
                                    class="btn-document-view"
                                >
                                    <i class="bi bi-eye"></i>
                                    Voir
                                </a>

                                {{-- GRATUIT : TÉLÉCHARGER --}}
                                <a
                                    href="{{ route(
                                        'documents.download',
                                        $document
                                    ) }}"
                                    class="btn-document-download"
                                >
                                    <i class="bi bi-download"></i>
                                    Télécharger
                                </a>

                            @endif

                        </div>

                    </article>

                @endforeach

            </div>


            {{-- CAROUSEL MOBILE --}}
            <div
                id="superieurDocumentsCarousel"
                class="carousel slide superieur-carousel"
                data-bs-ride="false"
            >

                <div class="carousel-inner">

                    @foreach($documents as $index => $document)

                        <div
                            class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        >

                            <div class="superieur-carousel-item">

                                <article class="superieur-card superieur-mobile-card">

                                    <div class="superieur-card-top">

                                        <div class="superieur-icon">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </div>

                                        <span class="superieur-arrow">
                                            <i class="bi bi-arrow-up-right"></i>
                                        </span>

                                    </div>


                                    <div class="superieur-card-body">

                                        <h3>
                                            {{ $document->title }}
                                        </h3>

                                        @if($document->access_type === 'premium')

                                            <p>
                                                <i class="bi bi-lock-fill"></i>
                                                {{ number_format((float) $document->price, 0, ',', ' ') }}
                                                FCFA
                                            </p>

                                        @else

                                            <p>
                                                <i class="bi bi-unlock-fill"></i>
                                                Gratuit
                                            </p>

                                        @endif

                                        @if(!empty($document->description))

                                            <p class="superieur-description">
                                                {{ $document->description }}
                                            </p>

                                        @endif

                                    </div>


                                    {{-- ACTIONS --}}
                                    <div class="document-actions">

                                        @if($document->access_type === 'premium')

                                            {{-- PREMIUM : PAIEMENT --}}
                                            <a
                                                href="{{ route(
                                                    'payments.create',
                                                    ['document' => $document->id]
                                                ) }}"
                                                class="btn-document-download"
                                            >
                                                <i class="bi bi-credit-card"></i>
                                                Payer
                                            </a>

                                        @else

                                            {{-- GRATUIT : VOIR --}}
                                            <a
                                                href="{{ route(
                                                    'documents.read',
                                                    $document
                                                ) }}"
                                                target="_blank"
                                                class="btn-document-view"
                                            >
                                                <i class="bi bi-eye"></i>
                                                Voir
                                            </a>

                                            {{-- GRATUIT : TÉLÉCHARGER --}}
                                            <a
                                                href="{{ route(
                                                    'documents.download',
                                                    $document
                                                ) }}"
                                                class="btn-document-download"
                                            >
                                                <i class="bi bi-download"></i>
                                                Télécharger
                                            </a>

                                        @endif

                                    </div>

                                </article>

                            </div>

                        </div>

                    @endforeach

                </div>


                @if($documents->count() > 1)

                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#superieurDocumentsCarousel"
                        data-bs-slide="prev"
                    >
                        <span
                            class="carousel-control-prev-icon"
                            aria-hidden="true"
                        ></span>

                        <span class="visually-hidden">
                            Précédent
                        </span>
                    </button>


                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#superieurDocumentsCarousel"
                        data-bs-slide="next"
                    >
                        <span
                            class="carousel-control-next-icon"
                            aria-hidden="true"
                        ></span>

                        <span class="visually-hidden">
                            Suivant
                        </span>
                    </button>

                @endif

            </div>


        @else

            {{-- ÉTAT VIDE --}}
            <div class="superieur-empty">

                <div class="superieur-empty-icon">
                    <i class="bi bi-file-earmark-x"></i>
                </div>

                <h3>
                    Aucun document disponible
                </h3>

            </div>

        @endif

    </div>
</section>

</div>

@endsection
