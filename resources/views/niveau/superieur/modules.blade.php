@extends('layouts.app')

@section('title', $niveau->name . ' — Modules / Matières')

@section('content')

<div class="superieur-page">

{{-- HERO --}}
<section class="superieur-hero">
    <div class="container">

        <span class="superieur-badge">
            <i class="bi bi-book-fill"></i>
            Modules / Matières
        </span>

        <h1>
            {{ $niveau->name }}
        </h1>

        <p>
            {{ $domaine->name }}
            •
            {{ $filiere->name }}
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
                    'vitrine.superieur.niveaux',
                    [
                        'domaineSlug' => $domaine->slug,
                        'filiereSlug' => $filiere->slug
                    ]
                ) }}"
                class="superieur-back"
                aria-label="Retour aux niveaux"
            >
                <i class="bi bi-arrow-left"></i>
                <span>Retour aux niveaux</span>
            </a>
        </div>


        {{-- EN-TÊTE --}}
        <div class="section-heading">

            <div>

                <span class="section-kicker">
                    Parcours académique
                </span>

                <h2>
                    Modules / Matières
                </h2>

            </div>

            <span class="class-count">
                {{ $subjects->count() }}
                matière{{ $subjects->count() > 1 ? 's' : '' }}
            </span>

        </div>


        @if($subjects->isNotEmpty())

            {{-- GRILLE --}}
            <div class="superieur-grid">

                @foreach($subjects as $subject)

                    <a
                        href="{{ route(
                            'vitrine.superieur.documents',
                            [
                                'domaineSlug' => $domaine->slug,
                                'filiereSlug' => $filiere->slug,
                                'niveauSlug' => $niveau->slug,
                                'subjectSlug' => $subject->slug
                            ]
                        ) }}"
                        class="superieur-card"
                    >

                        <div class="superieur-card-top">

                            <div class="superieur-icon">

                                @if(!empty($subject->icon))
                                    {{ $subject->icon }}
                                @else
                                    <i class="bi bi-book-fill"></i>
                                @endif

                            </div>

                            <span class="superieur-arrow">
                                <i class="bi bi-arrow-up-right"></i>
                            </span>

                        </div>


                        <div class="superieur-card-body">

                            <h3>
                                {{ $subject->name }}
                            </h3>

                            <p>
                                <i class="bi bi-book-fill"></i>
                                Module / Matière
                            </p>

                            @if(!empty($subject->description))
                                <p class="superieur-description">
                                    {{ $subject->description }}
                                </p>
                            @endif

                        </div>


                        <div class="superieur-card-footer">

                            <span>
                                Voir les documents
                            </span>

                            <i class="bi bi-arrow-right"></i>

                        </div>

                    </a>

                @endforeach

            </div>


            {{-- CAROUSEL MOBILE --}}
            <div
                id="superieurSubjectsCarousel"
                class="carousel slide superieur-carousel"
                data-bs-ride="false"
            >

                <div class="carousel-inner">

                    @foreach($subjects as $index => $subject)

                        <div
                            class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        >

                            <div class="superieur-carousel-item">

                                <a
                                    href="{{ route(
                                        'vitrine.superieur.documents',
                                        [
                                            'domaineSlug' => $domaine->slug,
                                            'filiereSlug' => $filiere->slug,
                                            'niveauSlug' => $niveau->slug,
                                            'subjectSlug' => $subject->slug
                                        ]
                                    ) }}"
                                    class="superieur-card superieur-mobile-card"
                                >

                                    <div class="superieur-card-top">

                                        <div class="superieur-icon">

                                            @if(!empty($subject->icon))
                                                {{ $subject->icon }}
                                            @else
                                                <i class="bi bi-book-fill"></i>
                                            @endif

                                        </div>

                                        <span class="superieur-arrow">
                                            <i class="bi bi-arrow-up-right"></i>
                                        </span>

                                    </div>


                                    <div class="superieur-card-body">

                                        <h3>
                                            {{ $subject->name }}
                                        </h3>

                                        <p>
                                            <i class="bi bi-book-fill"></i>
                                            Module / Matière
                                        </p>

                                        @if(!empty($subject->description))
                                            <p class="superieur-description">
                                                {{ $subject->description }}
                                            </p>
                                        @endif

                                    </div>


                                    <div class="superieur-card-footer">

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


                @if($subjects->count() > 1)

                    <button
                        class="carousel-control-prev"
                        type="button"
                        data-bs-target="#superieurSubjectsCarousel"
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
                        data-bs-target="#superieurSubjectsCarousel"
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
                    Aucun module disponible
                </h3>

            </div>

        @endif

    </div>
</section>


</div>

@endsection
