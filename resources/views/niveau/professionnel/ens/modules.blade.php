@extends('layouts.app')

@section('title', $niveau->name . ' — Modules')

@section('content')

<div class="professionnel-page">

```
{{-- =========================================================
     HERO
========================================================== --}}

<section class="professionnel-hero">

    <div class="container">

        <span class="professionnel-badge">
            <i class="bi bi-book-fill"></i>
            MODULES
        </span>

        <h1>
            {{ $niveau->name }}
        </h1>

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
                href="{{ route('vitrine.professionnel.ens.niveaux', [
                    'formationSlug' => $formation->slug,
                    'programmeSlug' => $programme->slug,
                    'specialiteSlug' => $specialite->slug
                ]) }}"
                class="professionnel-back"
                aria-label="Retour aux niveaux"
            >
                <i class="bi bi-arrow-left"></i>

                <span>Retour aux niveaux</span>
            </a>

        </div>


        {{-- =================================================
             TITRE
        ================================================== --}}

        <div class="professionnel-section-heading">

            <div>

                <span class="professionnel-section-kicker">
                    MODULES
                </span>

                <h2>
                    Modules disponibles
                </h2>

            </div>

            <span class="professionnel-count">

                {{ $subjects->count() }}

                module{{ $subjects->count() > 1 ? 's' : '' }}

            </span>

        </div>


        @if($subjects->isNotEmpty())

            {{-- =================================================
                 DESKTOP
            ================================================== --}}

            <div class="professionnel-grid">

                @foreach($subjects as $subject)

                    <a
                        href="{{ route(
                            'vitrine.professionnel.ens.type_doc',
                            [
                                'programmeSlug' => $programme->slug,
                                'specialiteSlug' => $specialite->slug,
                                'niveauSlug' => $niveau->slug,
                                'moduleSlug' => $subject->slug
                            ]
                        ) }}"
                        class="professionnel-card"
                    >

                        {{-- CARD TOP --}}

                        <div class="professionnel-card-top">

                            <div class="professionnel-icon">
                                {{ $subject->icon ?? '📚' }}
                            </div>

                            <span class="professionnel-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </span>

                        </div>


                        {{-- CARD BODY --}}

                        <div class="professionnel-card-body">

                            <h2>
                                {{ $subject->name }}
                            </h2>

                            <p>
                                <i class="bi bi-bookmark-fill"></i>
                                Module
                            </p>

                        </div>


                        {{-- CARD FOOTER --}}

                        <div class="professionnel-card-footer">

                            <span>
                                Voir les documents
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
                id="ensModulesCarousel"
                class="carousel slide professionnel-carousel"
                data-bs-ride="false"
            >

                <div class="carousel-inner">

                    @foreach($subjects as $index => $subject)

                        <div
                            class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        >

                            <div class="professionnel-mobile-card">

                                <a
                                    href="{{ route(
                                        'vitrine.professionnel.ens.type_doc',
                                        [
                                            'programmeSlug' => $programme->slug,
                                            'specialiteSlug' => $specialite->slug,
                                            'niveauSlug' => $niveau->slug,
                                            'moduleSlug' => $subject->slug
                                        ]
                                    ) }}"
                                    class="professionnel-card"
                                >

                                    <div class="professionnel-card-top">

                                        <div class="professionnel-icon">
                                            {{ $subject->icon ?? '📚' }}
                                        </div>

                                        <span class="professionnel-arrow">
                                            <i class="bi bi-arrow-right"></i>
                                        </span>

                                    </div>


                                    <div class="professionnel-card-body">

                                        <h2>
                                            {{ $subject->name }}
                                        </h2>

                                        <p>
                                            <i class="bi bi-bookmark-fill"></i>
                                            Module
                                        </p>

                                    </div>


                                    <div class="professionnel-card-footer">

                                        <span>
                                            Voir les documents
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

                @if($subjects->count() > 1)

                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#ensModulesCarousel"
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
                        data-bs-target="#ensModulesCarousel"
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
                    <i class="bi bi-book"></i>
                </div>

                <h3>
                    Aucun module disponible
                </h3>

                <p>
                    Aucun module n'est actuellement disponible
                    pour ce niveau.
                </p>

            </div>

        @endif

    </div>

</section>
```

</div>

@endsection
