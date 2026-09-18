@extends('layouts.app')

@section('title', $domaine->name)

@section('content')

<div class="superieur-page">

    {{-- =====================================================
         HERO
         ===================================================== --}}
    <section class="superieur-hero">

        <div class="container">

            <span class="superieur-badge">
                <i class="bi bi-building-fill"></i>
                Formations supérieures
            </span>

            <h1>
                @if(!empty($domaine->icon))
                    {{ $domaine->icon }}
                @else
                    <i class="bi bi-mortarboard-fill"></i>
                @endif

                {{ $domaine->name }}
            </h1>

        </div>

    </section>


    {{-- =====================================================
         CONTENU
         ===================================================== --}}
    <section class="superieur-content">

        <div class="container">

            {{-- =================================================
                 RETOUR EN HAUT
                 ================================================= --}}
            <div class="superieur-back-wrapper">

                <a
                    href="{{ route('vitrine.superieur.domaines') }}"
                    class="superieur-back"
                    aria-label="Retour aux domaines"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Retour aux domaines</span>
                </a>

            </div>


            {{-- =================================================
                 EN-TÊTE
                 ================================================= --}}
            <div class="section-heading">

                <div>
                    <span class="section-kicker">
                        Formations
                    </span>

                    <h2>
                        Choisissez votre formation
                    </h2>
                </div>

                <span class="class-count">
                    {{ $formations->count() }}
                    formation{{ $formations->count() > 1 ? 's' : '' }}
                </span>

            </div>


            {{-- =================================================
                 FORMATIONS
                 ================================================= --}}
            @if($formations->isNotEmpty())

                <div class="superieur-grid">

                    @foreach($formations as $formation)

                        <a
                            href="{{ route(
                                'vitrine.superieur.filieres',
                                [
                                    'domaineSlug' => $domaine->slug,
                                    'formationSlug' => $formation->slug
                                ]
                            ) }}"
                            class="superieur-card"
                        >

                            <div class="superieur-card-top">

                                <div class="superieur-icon">

                                    @if(!empty($formation->icon))
                                        {{ $formation->icon }}
                                    @else
                                        <i class="bi bi-mortarboard-fill"></i>
                                    @endif

                                </div>

                                <span class="superieur-arrow">
                                    <i class="bi bi-arrow-up-right"></i>
                                </span>

                            </div>


                            <div class="superieur-card-body">

                                <h3>
                                    {{ $formation->name }}
                                </h3>

                                @if(!empty($formation->description))

                                    <p>
                                        <i class="bi bi-info-circle-fill"></i>
                                        {{ $formation->description }}
                                    </p>

                                @endif

                            </div>


                            <div class="superieur-card-footer">

                                <span>
                                    Voir les filières
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- =================================================
                     CAROUSEL MOBILE
                     ================================================= --}}
                <div
                    id="superieurFormationsCarousel"
                    class="carousel slide superieur-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($formations as $index => $formation)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <div class="superieur-carousel-item">

                                    <a
                                        href="{{ route(
                                            'vitrine.superieur.filieres',
                                            [
                                                'domaineSlug' => $domaine->slug,
                                                'formationSlug' => $formation->slug
                                            ]
                                        ) }}"
                                        class="superieur-card superieur-mobile-card"
                                    >

                                        <div class="superieur-card-top">

                                            <div class="superieur-icon">

                                                @if(!empty($formation->icon))
                                                    {{ $formation->icon }}
                                                @else
                                                    <i class="bi bi-mortarboard-fill"></i>
                                                @endif

                                            </div>

                                            <span class="superieur-arrow">
                                                <i class="bi bi-arrow-up-right"></i>
                                            </span>

                                        </div>


                                        <div class="superieur-card-body">

                                            <h3>
                                                {{ $formation->name }}
                                            </h3>

                                            @if(!empty($formation->description))

                                                <p>
                                                    <i class="bi bi-info-circle-fill"></i>
                                                    {{ $formation->description }}
                                                </p>

                                            @endif

                                        </div>


                                        <div class="superieur-card-footer">

                                            <span>
                                                Voir les filières
                                            </span>

                                            <i class="bi bi-arrow-right"></i>

                                        </div>

                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if($formations->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#superieurFormationsCarousel"
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
                            data-bs-target="#superieurFormationsCarousel"
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

                <div class="superieur-empty">

                    <div class="superieur-empty-icon">
                        <i class="bi bi-folder-x"></i>
                    </div>

                    <h3>
                        Aucune formation disponible
                    </h3>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection
