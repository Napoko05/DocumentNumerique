
@extends('layouts.app')

@section('title', 'Formations professionnelles')

@section('content')

<div class="professionnel-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}
    <section class="professionnel-hero">

        <div class="container">

            <span class="professionnel-badge">
                <i class="bi bi-mortarboard-fill"></i>
                Enseignement professionnel
            </span>

            <h1>
                Formations professionnelles
            </h1>

            <p>
                Explorez les formations, spécialités, niveaux et ressources
                pédagogiques disponibles sur Scientia.
            </p>

        </div>

    </section>


    {{-- =========================================================
         CONTENT
    ========================================================== --}}
    <main class="professionnel-content">

        <div class="container">

            @if($formations->isNotEmpty())

                {{-- =================================================
                     EN-TÊTE
                ================================================== --}}
                <div class="section-heading">

                    <div>

                        <span class="section-kicker">
                            NOS FORMATIONS
                        </span>

                        <h2>
                            Choisissez votre établissement
                        </h2>

                        <p>
                            {{ $formations->count() }}
                            formation{{ $formations->count() > 1 ? 's' : '' }}
                            professionnelle disponible{{ $formations->count() > 1 ? 's' : '' }}.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                     GRILLE
                ================================================== --}}
                <div class="professionnel-grid">

                    @foreach($formations as $formation)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | DÉTERMINATION DE LA PROCHAINE ÉTAPE
                            |--------------------------------------------------------------------------
                            */

                            if ($formation->slug === 'ens') {

                                // ENS : Formation → Programme
                                $formationUrl = route(
                                    'vitrine.professionnel.ens.programmes'
                                );

                                $icon = 'bi-mortarboard-fill';

                                $nextLabel = 'Voir les programmes';

                            } elseif ($formation->slug === 'enep') {

                                // ENEP : Formation → Niveau
                                $formationUrl = route(
                                    'vitrine.professionnel.formation.niveaux',
                                    [
                                        'formationSlug' => $formation->slug
                                    ]
                                );

                                $icon = 'bi-person-workspace';

                                $nextLabel = 'Voir les niveaux';

                            } elseif (in_array($formation->slug, ['ids', 'uit', 'ensp'])) {

                                // IDS / UIT / ENSP : Formation → Spécialité
                                $formationUrl = route(
                                    'vitrine.professionnel.specialites',
                                    [
                                        'formationSlug' => $formation->slug
                                    ]
                                );

                                $icon = 'bi-building';

                                $nextLabel = 'Voir les spécialités';

                            } else {

                                /*
                                |--------------------------------------------------------------------------
                                | SÉCURITÉ
                                |--------------------------------------------------------------------------
                                | Une formation ajoutée en base mais qui n'a pas
                                | encore de parcours spécifique n'est pas cliquable
                                | vers une mauvaise route.
                                */

                                $formationUrl = null;

                                $icon = 'bi-mortarboard';

                                $nextLabel = 'Formation disponible';

                            }

                        @endphp


                        @if($formationUrl)

                            <a
                                href="{{ $formationUrl }}"
                                class="professionnel-card"
                            >

                        @else

                            <div class="professionnel-card">

                        @endif


                                {{-- =====================================
                                     CARD TOP
                                ====================================== --}}
                                <div class="professionnel-card-top">

                                    <div class="professionnel-icon">

                                        <i class="bi {{ $icon }}"></i>

                                    </div>

                                    <div class="professionnel-arrow">

                                        <i class="bi bi-arrow-right"></i>

                                    </div>

                                </div>


                                {{-- =====================================
                                     CARD BODY
                                ====================================== --}}
                                <div class="professionnel-card-body">

                                    <h3>
                                        {{ $formation->name }}
                                    </h3>

                                    <p>

                                        <i class="bi bi-diagram-3"></i>

                                        @if($formation->slug === 'ens')

                                            Formation → Programme

                                        @elseif($formation->slug === 'enep')

                                            Formation → Niveau

                                        @elseif(in_array($formation->slug, ['ids', 'uit', 'ensp']))

                                            Formation → Spécialité

                                        @else

                                            Formation professionnelle

                                        @endif

                                    </p>

                                </div>


                                {{-- =====================================
                                     CARD FOOTER
                                ====================================== --}}
                                <div class="professionnel-card-footer">

                                    <span>
                                        {{ $nextLabel }}
                                    </span>

                                    <i class="bi bi-arrow-right"></i>

                                </div>


                        @if($formationUrl)

                            </a>

                        @else

                            </div>

                        @endif

                    @endforeach

                </div>


                {{-- =================================================
                     MOBILE CAROUSEL
                ================================================== --}}
                <div
                    id="professionnelCarousel"
                    class="carousel slide professionnel-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($formations as $key => $formation)

                            @php

                                if ($formation->slug === 'ens') {

                                    $formationUrl = route(
                                        'vitrine.professionnel.ens.programmes'
                                    );

                                    $icon = 'bi-mortarboard-fill';

                                    $nextLabel = 'Voir les programmes';

                                    $description = 'Formation → Programme';

                                } elseif ($formation->slug === 'enep') {

                                    $formationUrl = route(
                                        'vitrine.professionnel.formation.niveaux',
                                        [
                                            'formationSlug' => $formation->slug
                                        ]
                                    );

                                    $icon = 'bi-person-workspace';

                                    $nextLabel = 'Voir les niveaux';

                                    $description = 'Formation → Niveau';

                                } elseif (in_array($formation->slug, ['ids', 'uit', 'ensp'])) {

                                    $formationUrl = route(
                                        'vitrine.professionnel.specialites',
                                        [
                                            'formationSlug' => $formation->slug
                                        ]
                                    );

                                    $icon = 'bi-building';

                                    $nextLabel = 'Voir les spécialités';

                                    $description = 'Formation → Spécialité';

                                } else {

                                    $formationUrl = null;

                                    $icon = 'bi-mortarboard';

                                    $nextLabel = 'Formation disponible';

                                    $description = 'Formation professionnelle';

                                }

                            @endphp


                            <div
                                class="carousel-item {{ $key === 0 ? 'active' : '' }}"
                            >

                                <div class="professionnel-carousel-item">

                                    @if($formationUrl)

                                        <a
                                            href="{{ $formationUrl }}"
                                            class="professionnel-card professionnel-mobile-card"
                                        >

                                    @else

                                        <div class="professionnel-card professionnel-mobile-card">

                                    @endif


                                            <div class="professionnel-card-top">

                                                <div class="professionnel-icon">

                                                    <i class="bi {{ $icon }}"></i>

                                                </div>

                                                <div class="professionnel-arrow">

                                                    <i class="bi bi-arrow-right"></i>

                                                </div>

                                            </div>


                                            <div class="professionnel-card-body">

                                                <h3>
                                                    {{ $formation->name }}
                                                </h3>

                                                <p>

                                                    <i class="bi bi-diagram-3"></i>

                                                    {{ $description }}

                                                </p>

                                            </div>


                                            <div class="professionnel-card-footer">

                                                <span>
                                                    {{ $nextLabel }}
                                                </span>

                                                <i class="bi bi-arrow-right"></i>

                                            </div>


                                    @if($formationUrl)

                                        </a>

                                    @else

                                        </div>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if($formations->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#professionnelCarousel"
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
                            data-bs-target="#professionnelCarousel"
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

                {{-- =================================================
                     EMPTY STATE
                ================================================== --}}
                <div class="professionnel-empty">

                    <div class="professionnel-empty-icon">

                        <i class="bi bi-folder2-open"></i>

                    </div>

                    <h3>
                        Aucune formation disponible
                    </h3>

                    <p>
                        Aucune formation professionnelle active n'est
                        actuellement disponible.
                    </p>

                </div>

            @endif

        </div>

    </main>

</div>

@endsection
