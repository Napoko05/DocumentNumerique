@extends('layouts.app')

@section('content')

<div class="superieur-page">

<section class="superieur-hero">
    <div class="container">

        <span class="superieur-badge">
            <i class="bi bi-building-fill"></i>
            FORMATIONS SUPÉRIEURES
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
            Choisissez une formation académique.
        </p>

    </div>
</section>

<section class="superieur-content">

    <div class="container">

        <div class="section-heading">

            <div>
                <span class="section-kicker">
                    FORMATIONS
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

                            <div class="superieur-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                        </div>

                        <div class="superieur-card-body">

                            <h3>
                                {{ $formation->name }}
                            </h3>

                            @if(!empty($formation->description))

                                <p class="superieur-description">
                                    <i class="bi bi-info-circle-fill"></i>
                                    {{ $formation->description }}
                                </p>

                            @else

                                <p>
                                    <i class="bi bi-mortarboard-fill"></i>
                                    Formation académique
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


            {{-- =====================================================
                 CAROUSEL MOBILE
                 ===================================================== --}}

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

                                        <div class="superieur-arrow">
                                            <i class="bi bi-arrow-right"></i>
                                        </div>

                                    </div>

                                    <div class="superieur-card-body">

                                        <h3>
                                            {{ $formation->name }}
                                        </h3>

                                        @if(!empty($formation->description))

                                            <p class="superieur-description">
                                                <i class="bi bi-info-circle-fill"></i>
                                                {{ $formation->description }}
                                            </p>

                                        @else

                                            <p>
                                                <i class="bi bi-mortarboard-fill"></i>
                                                Formation académique
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

                <p>
                    Aucune formation n'est actuellement disponible
                    dans ce domaine.
                </p>

            </div>

        @endif


        {{-- =========================================================
             RETOUR
             ========================================================= --}}

        <div class="doc-type-back-container">

            <a
                href="{{ route('vitrine.superieur.domaines') }}"
                class="doc-type-back-btn"
            >
                <i class="bi bi-arrow-left"></i>
                Retour aux domaines
            </a>

        </div>

    </div>

</section>

</div>

@endsection
