@extends('layouts.app')

@section('content')

<div class="superieur-page">

<section class="superieur-hero">
    <div class="container">

        <span class="superieur-badge">
            <i class="bi bi-diagram-3-fill"></i>
            FILIÈRES
        </span>

        <h1>
            @if(!empty($domaine->icon))
                {{ $domaine->icon }}
            @else
                <i class="bi bi-mortarboard-fill"></i>
            @endif
            {{ $domaine->name }}
        </h1>

        <p>
            Découvrez les filières disponibles dans ce domaine académique.
        </p>

    </div>
</section>


<section class="superieur-content">
    <div class="container">

        <div class="section-heading">

            <div>

                <span class="section-kicker">
                    PARCOURS ACADÉMIQUE
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

                            <div class="superieur-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                        </div>


                        <div class="superieur-card-body">

                            <h3>
                                {{ $filiere->name }}
                            </h3>

                            <p>
                                <i class="bi bi-diagram-3-fill"></i>
                                Filière de formation
                            </p>

                            @if(!empty($filiere->description))

                                <p class="superieur-description">
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

                                        <div class="superieur-arrow">
                                            <i class="bi bi-arrow-right"></i>
                                        </div>

                                    </div>


                                    <div class="superieur-card-body">

                                        <h3>
                                            {{ $filiere->name }}
                                        </h3>

                                        <p>
                                            <i class="bi bi-diagram-3-fill"></i>
                                            Filière de formation
                                        </p>

                                        @if(!empty($filiere->description))

                                            <p class="superieur-description">
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

            <div class="superieur-empty">

                <div class="superieur-empty-icon">
                    <i class="bi bi-folder-x"></i>
                </div>

                <h3>
                    Aucune filière disponible
                </h3>

                <p>
                    Aucune filière académique n'est actuellement disponible
                    dans ce domaine.
                </p>

            </div>

        @endif


        <div class="superieur-back-container">

            <a
                href="{{ route(
                    'vitrine.superieur.domaines'
                ) }}"
                class="superieur-back-btn"
            >

                <i class="bi bi-arrow-left"></i>

                Retour aux domaines

            </a>

        </div>

    </div>
</section>

</div>

@endsection
