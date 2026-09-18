@extends('layouts.app')

@section('title', $domaine->name . ' — Filières')

@section('content')

<div class="superieur-page">

    {{-- HERO --}}
    <section class="superieur-hero">
        <div class="container">

            <span class="superieur-badge">
                <i class="bi bi-diagram-3-fill"></i>
                Filières
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


    {{-- CONTENU --}}
    <section class="superieur-content">
        <div class="container">

            {{-- RETOUR --}}
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


            {{-- EN-TÊTE --}}
            <div class="section-heading">

                <div>
                    <span class="section-kicker">
                        Parcours académique
                    </span>

                    <h2>
                        Choisissez une filière
                    </h2>
                </div>

                <span class="class-count">
                    {{ $filieres->count() }}
                    filière{{ $filieres->count() > 1 ? 's' : '' }}
                </span>

            </div>


            @if($filieres->isNotEmpty())

                {{-- GRILLE --}}
                <div class="superieur-grid">

                    @foreach($filieres as $filiere)

                        <a
                            href="{{ route(
                                'vitrine.superieur.niveaux',
                                [
                                    'domaineSlug' => $domaine->slug,
                                    'filiereSlug' => $filiere->slug
                                ]
                            ) }}"
                            class="superieur-card"
                        >

                            <div class="superieur-card-top">

                                <div class="superieur-icon">
                                    @if(!empty($filiere->icon))
                                        {{ $filiere->icon }}
                                    @else
                                        <i class="bi bi-diagram-3-fill"></i>
                                    @endif
                                </div>

                                <span class="superieur-arrow">
                                    <i class="bi bi-arrow-up-right"></i>
                                </span>

                            </div>


                            <div class="superieur-card-body">

                                <h3>
                                    {{ $filiere->name }}
                                </h3>

                                @if(!empty($filiere->description))
                                    <p>
                                        <i class="bi bi-info-circle-fill"></i>
                                        {{ $filiere->description }}
                                    </p>
                                @endif

                            </div>


                            <div class="superieur-card-footer">

                                <span>
                                    Voir les niveaux
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- CAROUSEL MOBILE --}}
                <div
                    id="superieurFilieresCarousel"
                    class="carousel slide superieur-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($filieres as $index => $filiere)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <div class="superieur-carousel-item">

                                    <a
                                        href="{{ route(
                                            'vitrine.superieur.niveaux',
                                            [
                                                'domaineSlug' => $domaine->slug,
                                                'filiereSlug' => $filiere->slug
                                            ]
                                        ) }}"
                                        class="superieur-card superieur-mobile-card"
                                    >

                                        <div class="superieur-card-top">

                                            <div class="superieur-icon">
                                                @if(!empty($filiere->icon))
                                                    {{ $filiere->icon }}
                                                @else
                                                    <i class="bi bi-diagram-3-fill"></i>
                                                @endif
                                            </div>

                                            <span class="superieur-arrow">
                                                <i class="bi bi-arrow-up-right"></i>
                                            </span>

                                        </div>


                                        <div class="superieur-card-body">

                                            <h3>
                                                {{ $filiere->name }}
                                            </h3>

                                            @if(!empty($filiere->description))
                                                <p>
                                                    <i class="bi bi-info-circle-fill"></i>
                                                    {{ $filiere->description }}
                                                </p>
                                            @endif

                                        </div>


                                        <div class="superieur-card-footer">

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


                    @if($filieres->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#superieurFilieresCarousel"
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
                            data-bs-target="#superieurFilieresCarousel"
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
                        <i class="bi bi-folder-x"></i>
                    </div>

                    <h3>
                        Aucune filière disponible
                    </h3>

                </div>

            @endif

        </div>
    </section>

</div>

@endsection
