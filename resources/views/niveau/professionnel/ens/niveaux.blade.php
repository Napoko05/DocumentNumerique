@extends('layouts.app')

@section('content')

<div class="professionnel-page">

{{-- =========================================================
     HERO
========================================================== --}}

<section class="professionnel-hero">

    <div class="container">

        <span class="professionnel-badge">
            <i class="bi bi-mortarboard-fill"></i>
            NIVEAUX DE FORMATION
        </span>

        <div class="professionnel-hero-icon">
            {{ $specialite->icon ?? '📚' }}
        </div>

        <h1>
            {{ $specialite->name }}
        </h1>

        <p>
            {{ $specialite->description
                ?? 'Choisissez votre niveau de formation.' }}
        </p>

    </div>

</section>


{{-- =========================================================
     CONTENU
========================================================== --}}

<section class="professionnel-content">

    <div class="container">

        {{-- =================================================
             RETOUR
        ================================================== --}}

        <div class="professionnel-back-wrapper">

            <a
                href="{{ route(
                    'vitrine.professionnel.ens.specialites',
                    [
                        'programmeSlug' => $programme->slug
                    ]
                ) }}"
                class="professionnel-back"
                aria-label="Retour aux spécialités"
            >
                <i class="bi bi-arrow-left"></i>

                <span>Retour aux spécialités</span>
            </a>

        </div>


        {{-- =================================================
             FIL D'ARIANE
        ================================================== --}}

        <div class="professionnel-breadcrumb">

            <span>
                {{ $formation->name }}
            </span>

            <i class="bi bi-chevron-right"></i>

            <span>
                {{ $programme->name }}
            </span>

            <i class="bi bi-chevron-right"></i>

            <strong>
                {{ $specialite->name }}
            </strong>

        </div>


        {{-- =================================================
             EN-TÊTE
        ================================================== --}}

        <div class="professionnel-section-heading">

            <div>

                <span class="professionnel-section-kicker">
                    NIVEAUX
                </span>

                <h2>
                    Choisissez votre niveau
                </h2>

            </div>

            <span class="professionnel-count">

                {{ $niveaux->count() }}

                niveau{{ $niveaux->count() > 1 ? 'x' : '' }}

            </span>

        </div>


        {{-- =================================================
             NIVEAUX
        ================================================== --}}

        @if($niveaux->isNotEmpty())

            {{-- =================================================
                 DESKTOP
            ================================================== --}}

            <div class="professionnel-grid">

                @foreach($niveaux as $niveau)

                    <a
                        href="{{ route(
                            'vitrine.professionnel.ens.modules',
                            [
                                'programmeSlug' => $programme->slug,
                                'specialiteSlug' => $specialite->slug,
                                'niveauSlug' => $niveau->slug
                            ]
                        ) }}"
                        class="professionnel-card"
                    >

                        {{-- CARD TOP --}}

                        <div class="professionnel-card-top">

                            <div class="professionnel-icon">
                                {{ $niveau->icon ?? '📘' }}
                            </div>

                            <div class="professionnel-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                        </div>


                        {{-- CARD BODY --}}

                        <div class="professionnel-card-body">

                            <h3>
                                {{ $niveau->name }}
                            </h3>

                            <p>
                                <i class="bi bi-book-fill"></i>
                                Modules et matières
                            </p>

                            @if(isset($niveau->documents_count))

                                <small>

                                    {{ $niveau->documents_count }}

                                    document{{ $niveau->documents_count > 1 ? 's' : '' }}

                                </small>

                            @endif

                        </div>


                        {{-- CARD FOOTER --}}

                        <div class="professionnel-card-footer">

                            <span>
                                Voir les modules
                            </span>

                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </a>

                @endforeach

            </div>


            {{-- =================================================
                 MOBILE CAROUSEL
            ================================================== --}}

            <div
                id="ensNiveauxCarousel"
                class="carousel slide professionnel-carousel"
                data-bs-ride="false"
            >

                <div class="carousel-inner">

                    @foreach($niveaux as $index => $niveau)

                        <div
                            class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        >

                            <div class="professionnel-mobile-card">

                                <a
                                    href="{{ route(
                                        'vitrine.professionnel.ens.modules',
                                        [
                                            'programmeSlug' => $programme->slug,
                                            'specialiteSlug' => $specialite->slug,
                                            'niveauSlug' => $niveau->slug
                                        ]
                                    ) }}"
                                    class="professionnel-card"
                                >

                                    <div class="professionnel-card-top">

                                        <div class="professionnel-icon">
                                            {{ $niveau->icon ?? '📘' }}
                                        </div>

                                        <div class="professionnel-arrow">
                                            <i class="bi bi-arrow-right"></i>
                                        </div>

                                    </div>


                                    <div class="professionnel-card-body">

                                        <h3>
                                            {{ $niveau->name }}
                                        </h3>

                                        <p>
                                            <i class="bi bi-book-fill"></i>
                                            Modules et matières
                                        </p>

                                        @if(isset($niveau->documents_count))

                                            <small>

                                                {{ $niveau->documents_count }}

                                                document{{ $niveau->documents_count > 1 ? 's' : '' }}

                                            </small>

                                        @endif

                                    </div>


                                    <div class="professionnel-card-footer">

                                        <span>
                                            Voir les modules
                                        </span>

                                        <i class="bi bi-arrow-right"></i>

                                    </div>

                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>


                {{-- =================================================
                     CAROUSEL CONTROLS
                ================================================== --}}

                @if($niveaux->count() > 1)

                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#ensNiveauxCarousel"
                        data-bs-slide="prev"
                    >
                        <span class="carousel-control-prev-icon"></span>

                        <span class="visually-hidden">
                            Précédent
                        </span>
                    </button>


                    <button
                        class="carousel-control-next"
                        type="button"
                        data-bs-target="#ensNiveauxCarousel"
                        data-bs-slide="next"
                    >
                        <span class="carousel-control-next-icon"></span>

                        <span class="visually-hidden">
                            Suivant
                        </span>
                    </button>

                @endif

            </div>


        @else

            {{-- =================================================
                 EMPTY STATE
            ================================================== --}}

            <div class="professionnel-empty">

                <div class="professionnel-empty-icon">
                    <i class="bi bi-folder-x"></i>
                </div>

                <h3>
                    Aucun niveau disponible
                </h3>

                <p>
                    Aucun niveau n'est actuellement disponible
                    pour cette spécialité.
                </p>

            </div>

        @endif

    </div>

</section>

</div>

@endsection
