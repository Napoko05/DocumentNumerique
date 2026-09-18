@extends('layouts.app')

@section('title', $formation->name . ' - ' . $specialite->name)

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
                {{ $specialite->name }}
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
                        'vitrine.professionnel.specialites',
                        [
                            'formationSlug' => $formation->slug
                        ]
                    ) }}"
                    class="professionnel-back"
                    aria-label="Retour aux spécialités"
                >

                    <i class="bi bi-arrow-left"></i>

                    <span>
                        Retour aux spécialités
                    </span>

                </a>

            </div>


            {{-- =================================================
                 EN-TÊTE
            ================================================== --}}
            <div class="professionnel-section-heading">

                <div>

                    <span class="professionnel-section-kicker">
                        NIVEAUX DE FORMATION
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
                     GRID DESKTOP / TABLETTE
                ================================================== --}}
                <div class="professionnel-grid">

                    @foreach($niveaux as $niveau)

                        <a
                            href="{{ route(
                                'vitrine.professionnel.specialite.modules',
                                [
                                    'formationSlug' => $formation->slug,
                                    'specialiteSlug' => $specialite->slug,
                                    'niveauSlug' => $niveau->slug
                                ]
                            ) }}"
                            class="professionnel-card"
                        >

                            {{-- CARD TOP --}}
                            <div class="professionnel-card-top">

                                <div class="professionnel-icon">
                                    {{ $niveau->icon ?? '📚' }}
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
                                    <i class="bi bi-mortarboard-fill"></i>
                                    Niveau de formation
                                </p>

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
                     CAROUSEL MOBILE
                ================================================== --}}
                <div
                    id="professionnelNiveauxCarousel"
                    class="carousel slide professionnel-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($niveaux as $index => $niveau)

                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                                <div class="professionnel-carousel-item">

                                    <a
                                        href="{{ route(
                                            'vitrine.professionnel.specialite.modules',
                                            [
                                                'formationSlug' => $formation->slug,
                                                'specialiteSlug' => $specialite->slug,
                                                'niveauSlug' => $niveau->slug
                                            ]
                                        ) }}"
                                        class="professionnel-card professionnel-mobile-card"
                                    >

                                        {{-- CARD TOP --}}
                                        <div class="professionnel-card-top">

                                            <div class="professionnel-icon">
                                                {{ $niveau->icon ?? '📚' }}
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
                                                <i class="bi bi-mortarboard-fill"></i>
                                                Niveau de formation
                                            </p>

                                        </div>


                                        {{-- CARD FOOTER --}}
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


                    @if($niveaux->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#professionnelNiveauxCarousel"
                            data-bs-slide="prev"
                            aria-label="Niveau précédent"
                        >

                            <span
                                class="carousel-control-prev-icon"
                                aria-hidden="true"
                            ></span>

                        </button>

                        <button
                            class="carousel-control-next"
                            type="button"
                            data-bs-target="#professionnelNiveauxCarousel"
                            data-bs-slide="next"
                            aria-label="Niveau suivant"
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
                     ÉTAT VIDE
                ================================================== --}}
                <div class="professionnel-empty">

                    <div class="professionnel-empty-icon">

                        <i class="bi bi-folder-x"></i>

                    </div>

                    <h3>
                        Aucun niveau disponible
                    </h3>

                    <p>
                        Aucun niveau n'est actuellement enregistré
                        pour cette spécialité.
                    </p>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection
