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
            SPÉCIALITÉS DE FORMATION
        </span>

        <h1>
            {{ $programme->icon ?? '🎓' }}
            {{ $programme->name }}
        </h1>

        <p>
            {{ $programme->description
                ?? 'Choisissez votre spécialité de formation.' }}
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
                href="{{ route('vitrine.professionnel.ens.programmes', [
                    'formationSlug' => $formation->slug
                ]) }}"
                class="professionnel-back"
                aria-label="Retour aux programmes"
            >
                <i class="bi bi-arrow-left"></i>

                <span>Retour aux programmes</span>
            </a>

        </div>


        {{-- =================================================
             TITRE
        ================================================== --}}

        <div class="professionnel-section-heading">

            <div>

                <span class="professionnel-section-kicker">
                    SPÉCIALITÉS
                </span>

                <h2>
                    Choisissez votre spécialité
                </h2>

            </div>

            <span class="professionnel-count">

                {{ $specialites->count() }}

                spécialité{{ $specialites->count() > 1 ? 's' : '' }}

            </span>

        </div>


        @if($specialites->isNotEmpty())

            {{-- =================================================
                 DESKTOP GRID
            ================================================== --}}

            <div class="professionnel-grid">

                @foreach($specialites as $specialite)

                    <a
                        href="{{ route('vitrine.professionnel.ens.niveaux', [
                            'formationSlug' => $formation->slug,
                            'programmeSlug' => $programme->slug,
                            'specialiteSlug' => $specialite->slug
                        ]) }}"
                        class="professionnel-card"
                    >

                        <div class="professionnel-card-top">

                            <div class="professionnel-icon">
                                {{ $specialite->icon ?? '📚' }}
                            </div>

                            <div class="professionnel-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                        </div>


                        <div class="professionnel-card-body">

                            <h3>
                                {{ $specialite->name }}
                            </h3>

                            <p>
                                <i class="bi bi-bookmark-fill"></i>

                                Spécialité de formation
                            </p>

                        </div>


                        <div class="professionnel-card-footer">

                            <span>
                                Voir les niveaux
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
                id="ensSpecialitesCarousel"
                class="carousel slide professionnel-carousel"
                data-bs-ride="false"
            >

                <div class="carousel-inner">

                    @foreach($specialites as $index => $specialite)

                        <div
                            class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        >

                            <div class="professionnel-mobile-card">

                                <a
                                    href="{{ route('vitrine.professionnel.ens.niveaux', [
                                        'formationSlug' => $formation->slug,
                                        'programmeSlug' => $programme->slug,
                                        'specialiteSlug' => $specialite->slug
                                    ]) }}"
                                    class="professionnel-card"
                                >

                                    <div class="professionnel-card-top">

                                        <div class="professionnel-icon">
                                            {{ $specialite->icon ?? '📚' }}
                                        </div>

                                        <div class="professionnel-arrow">
                                            <i class="bi bi-arrow-right"></i>
                                        </div>

                                    </div>


                                    <div class="professionnel-card-body">

                                        <h3>
                                            {{ $specialite->name }}
                                        </h3>

                                        <p>
                                            <i class="bi bi-bookmark-fill"></i>

                                            Spécialité de formation
                                        </p>

                                    </div>


                                    <div class="professionnel-card-footer">

                                        <span>
                                            Voir les niveaux
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

                @if($specialites->count() > 1)

                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#ensSpecialitesCarousel"
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
                        data-bs-target="#ensSpecialitesCarousel"
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
                 ÉTAT VIDE
            ================================================== --}}

            <div class="professionnel-empty">

                <div class="professionnel-empty-icon">
                    <i class="bi bi-folder-x"></i>
                </div>

                <h3>
                    Aucune spécialité disponible
                </h3>

                <p>
                    Aucune spécialité n'est actuellement disponible
                    pour ce programme.
                </p>

            </div>

        @endif

    </div>

</section>

</div>

@endsection
