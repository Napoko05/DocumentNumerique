@extends('layouts.app')

@section('title', $filiere->name . ' — Niveaux')

@section('content')

<div class="superieur-page">

{{-- HERO --}}
<section class="superieur-hero">
    <div class="container">

        <span class="superieur-badge">
            <i class="bi bi-layers-fill"></i>
            Niveaux
        </span>

        <h1>
            @if(!empty($filiere->icon))
                {{ $filiere->icon }}
            @else
                <i class="bi bi-diagram-3-fill"></i>
            @endif
            {{ $filiere->name }}
        </h1>

        <p>
            {{ $domaine->name }}
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
                    'vitrine.superieur.filieres',
                    [
                        'domaineSlug' => $domaine->slug
                    ]
                ) }}"
                class="superieur-back"
                aria-label="Retour aux filières"
            >
                <i class="bi bi-arrow-left"></i>
                <span>Retour aux filières</span>
            </a>
        </div>


        {{-- EN-TÊTE --}}
        <div class="section-heading">

            <div>

                <span class="section-kicker">
                    Parcours académique
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


        @if($niveaux->isNotEmpty())

            {{-- GRILLE --}}
            <div class="superieur-grid">

                @foreach($niveaux as $niveau)

                    <a
                        href="{{ route(
                            'vitrine.superieur.modules',
                            [
                                'domaineSlug' => $domaine->slug,
                                'filiereSlug' => $filiere->slug,
                                'niveauSlug' => $niveau->slug
                            ]
                        ) }}"
                        class="superieur-card"
                    >

                        <div class="superieur-card-top">

                            <div class="superieur-icon">

                                @if(!empty($niveau->icon))
                                    {{ $niveau->icon }}
                                @else
                                    <i class="bi bi-layers-fill"></i>
                                @endif

                            </div>

                            <span class="superieur-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </div>


                        <div class="superieur-card-body">

                            <h3>
                                {{ $niveau->name }}
                            </h3>

                            <p>
                                <i class="bi bi-layers-fill"></i>
                                Niveau de formation
                            </p>

                            @if(!empty($niveau->description))
                                <p class="superieur-description">
                                    {{ $niveau->description }}
                                </p>
                            @endif

                        </div>


                        <div class="superieur-card-footer">

                            <span>
                                Voir les modules
                            </span>

                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </a>

                @endforeach

            </div>


            {{-- CAROUSEL MOBILE --}}
            <div
                id="superieurNiveauxCarousel"
                class="carousel slide superieur-carousel"
                data-bs-ride="false"
            >

                <div class="carousel-inner">

                    @foreach($niveaux as $index => $niveau)

                        <div
                            class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        >

                            <div class="superieur-carousel-item">

                                <a
                                    href="{{ route(
                                        'vitrine.superieur.modules',
                                        [
                                            'domaineSlug' => $domaine->slug,
                                            'filiereSlug' => $filiere->slug,
                                            'niveauSlug' => $niveau->slug
                                        ]
                                    ) }}"
                                    class="superieur-card superieur-mobile-card"
                                >

                                    <div class="superieur-card-top">

                                        <div class="superieur-icon">

                                            @if(!empty($niveau->icon))
                                                {{ $niveau->icon }}
                                            @else
                                                <i class="bi bi-layers-fill"></i>
                                            @endif

                                        </div>

                                        <span class="superieur-arrow">
                                            <i class="bi bi-arrow-up-right"></i>
                                        </span>

                                    </div>


                                    <div class="superieur-card-body">

                                        <h3>
                                            {{ $niveau->name }}
                                        </h3>

                                        <p>
                                            <i class="bi bi-layers-fill"></i>
                                            Niveau de formation
                                        </p>

                                        @if(!empty($niveau->description))
                                            <p class="superieur-description">
                                                {{ $niveau->description }}
                                            </p>
                                        @endif

                                    </div>


                                    <div class="superieur-card-footer">

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
                        data-bs-target="#superieurNiveauxCarousel"
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
                        data-bs-target="#superieurNiveauxCarousel"
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
                    Aucun niveau disponible
                </h3>

            </div>

        @endif

    </div>
</section>

</div>

@endsection
