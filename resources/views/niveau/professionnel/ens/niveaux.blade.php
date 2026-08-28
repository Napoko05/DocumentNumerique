@extends('layouts.app')

@section('content')

<div class="formation-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="formation-hero">

        <div class="container">

            <div class="formation-badge">
                <i class="bi bi-mortarboard-fill"></i>
                NIVEAUX DE FORMATION
            </div>

            <div class="formation-icon">
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

    <section class="formation-content">

        <div class="container">

            {{-- =================================================
                 FIL D'ARIANE
            ================================================== --}}

            <div class="formation-breadcrumb">

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

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        NIVEAUX
                    </span>

                    <h2>
                        Choisissez votre niveau
                    </h2>

                </div>

                <span class="class-count">

                    {{ $niveaux->count() }}

                    niveau{{ $niveaux->count() > 1 ? 'x' : '' }}

                </span>

            </div>

            {{-- =================================================
                 NIVEAUX
            ================================================== --}}

            @if($niveaux->isNotEmpty())

                <div class="classes-grid">

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
                            class="class-card"
                        >

                            {{-- CARD TOP --}}

                            <div class="class-card-top">

                                <div class="class-icon">
                                    {{ $niveau->icon ?? '📘' }}
                                </div>

                                <div class="class-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>

                            {{-- CARD BODY --}}

                            <div class="class-card-body">

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

                            <div class="class-card-footer">

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
                    class="carousel slide classes-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($niveaux as $index => $niveau)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <div class="mobile-class-card">

                                    <a
                                        href="{{ route(
                                            'vitrine.professionnel.ens.modules',
                                            [
                                                'programmeSlug' => $programme->slug,
                                                'specialiteSlug' => $specialite->slug,
                                                'niveauSlug' => $niveau->slug
                                            ]
                                        ) }}"
                                        class="class-card"
                                    >

                                        <div class="class-card-top">

                                            <div class="class-icon">
                                                {{ $niveau->icon ?? '📘' }}
                                            </div>

                                            <div class="class-arrow">
                                                <i class="bi bi-arrow-right"></i>
                                            </div>

                                        </div>

                                        <div class="class-card-body">

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

                                        <div class="class-card-footer">

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

                <div class="empty-state">

                    <div class="empty-icon">
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

            {{-- =================================================
                 RETOUR
            ================================================== --}}

            <div class="doc-type-back-container">

                <a
                    href="{{ route(
                        'vitrine.professionnel.ens.specialites',
                        [
                            'programmeSlug' => $programme->slug
                        ]
                    ) }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux spécialités

                </a>

            </div>

        </div>

    </section>

</div>

@endsection