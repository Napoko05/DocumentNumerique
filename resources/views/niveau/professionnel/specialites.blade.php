@extends('layouts.app')

@section('title', $formation->name)

@section('content')

<div class="professionnel-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="professionnel-hero">

        <div class="container">

            <span class="professionnel-badge">
                <i class="bi bi-mortarboard-fill"></i>
                FORMATION PROFESSIONNELLE
            </span>

            <h1>
                {{ $formation->icon ?? '🎓' }}
                {{ $formation->name }}
            </h1>

            <p>
                Choisissez votre spécialité de formation.
            </p>

        </div>

    </section>


    {{-- =========================================================
         CONTENT
    ========================================================== --}}
    <section class="professionnel-content">

        <div class="container">

            {{-- =================================================
                 BOUTON RETOUR
            ================================================== --}}
            <div class="professionnel-back-wrapper">

                <a
                    href="{{ route('vitrine.professionnel.formations') }}"
                    class="professionnel-back"
                    aria-label="Retour aux formations professionnelles"
                >
                    <i class="bi bi-arrow-left"></i>

                    <span>
                        Retour aux formations
                    </span>
                </a>

            </div>


            {{-- =================================================
                 EN-TÊTE DES SPÉCIALITÉS
            ================================================== --}}
            <div class="section-heading">

                <div>

                    <span class="professionnel-badge">
                        <i class="bi bi-diagram-3-fill"></i>
                        SPÉCIALITÉS
                    </span>

                    <h2>
                        Choisissez votre spécialité
                    </h2>

                </div>

                <span class="class-count">
                    {{ $specialites->count() }}
                    spécialité{{ $specialites->count() > 1 ? 's' : '' }}
                </span>

            </div>


            {{-- =================================================
                 SPÉCIALITÉS
            ================================================== --}}
            @if($specialites->isNotEmpty())

                {{-- =================================================
                     DESKTOP / TABLETTE
                ================================================== --}}
                <div class="professionnel-grid">

                    @foreach($specialites as $specialite)

                        <a
                            href="{{ route(
                                'vitrine.professionnel.specialite.niveaux',
                                [
                                    'formationSlug' => $formation->slug,
                                    'specialiteSlug' => $specialite->slug
                                ]
                            ) }}"
                            class="professionnel-card"
                        >

                            {{-- CARD TOP --}}
                            <div class="professionnel-card-top">

                                <div class="professionnel-icon">
                                    {{ $specialite->icon ?? '🎓' }}
                                </div>

                                <div class="professionnel-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>


                            {{-- CARD BODY --}}
                            <div class="professionnel-card-body">

                                <h3>
                                    {{ $specialite->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-mortarboard-fill"></i>
                                    <span>
                                        Spécialité de formation
                                    </span>
                                </p>

                            </div>


                            {{-- CARD FOOTER --}}
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
                     CAROUSEL MOBILE
                ================================================== --}}
                <div
                    id="professionnelMobileCarousel"
                    class="carousel slide professionnel-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($specialites as $index => $specialite)

                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                                <div class="professionnel-carousel-item">

                                    <a
                                        href="{{ route(
                                            'vitrine.professionnel.specialite.niveaux',
                                            [
                                                'formationSlug' => $formation->slug,
                                                'specialiteSlug' => $specialite->slug
                                            ]
                                        ) }}"
                                        class="professionnel-card professionnel-mobile-card"
                                    >

                                        {{-- CARD TOP --}}
                                        <div class="professionnel-card-top">

                                            <div class="professionnel-icon">
                                                {{ $specialite->icon ?? '🎓' }}
                                            </div>

                                            <div class="professionnel-arrow">
                                                <i class="bi bi-arrow-right"></i>
                                            </div>

                                        </div>


                                        {{-- CARD BODY --}}
                                        <div class="professionnel-card-body">

                                            <h3>
                                                {{ $specialite->name }}
                                            </h3>

                                            <p>
                                                <i class="bi bi-mortarboard-fill"></i>
                                                <span>
                                                    Spécialité de formation
                                                </span>
                                            </p>

                                        </div>


                                        {{-- CARD FOOTER --}}
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
                         CONTRÔLES CAROUSEL
                    ================================================== --}}
                    @if($specialites->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#professionnelMobileCarousel"
                            data-bs-slide="prev"
                            aria-label="Spécialité précédente"
                        >
                            <span
                                class="carousel-control-prev-icon"
                                aria-hidden="true"
                            ></span>
                        </button>

                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#professionnelMobileCarousel"
                            data-bs-slide="next"
                            aria-label="Spécialité suivante"
                        >
                            <span
                                class="carousel-control-next-icon"
                                aria-hidden="true"
                            ></span>
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
                        Aucune spécialité disponible
                    </h3>

                    <p>
                        Aucune spécialité n'est actuellement enregistrée
                        pour cette formation.
                    </p>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection