@extends('layouts.app')

@section('title', $niveau->name . ' — Modules')

@section('content')

<div class="professionnel-page">

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
                    href="{{ route('vitrine.professionnel.formation.niveaux', [
                        'formationSlug' => $formation->slug
                    ]) }}"
                    class="professionnel-back"
                    aria-label="Retour aux niveaux"
                >

                    <i class="bi bi-arrow-left"></i>

                    <span>
                        Retour aux niveaux
                    </span>

                </a>

            </div>


            {{-- =================================================
                 EN-TÊTE
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


            {{-- =================================================
                 MODULES
            ================================================== --}}
            @if($subjects->isNotEmpty())

                {{-- =================================================
                     DESKTOP / TABLETTE
                ================================================== --}}
                <div class="professionnel-grid">

                    @foreach($subjects as $subject)

                        <a
                            href="{{ route('vitrine.professionnel.enep.type_doc', [
                                'formationSlug' => $formation->slug,
                                'niveauSlug' => $niveau->slug,
                                'moduleSlug' => $subject->slug
                            ]) }}"
                            class="professionnel-card"
                        >

                            {{-- CARD TOP --}}
                            <div class="professionnel-card-top">

                                <div class="professionnel-icon">
                                    {{ $subject->icon ?? '📚' }}
                                </div>

                                <div class="professionnel-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>


                            {{-- CARD BODY --}}
                            <div class="professionnel-card-body">

                                <h3>
                                    {{ $subject->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-file-earmark-text"></i>
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
                     CAROUSEL MOBILE
                ================================================== --}}
                <div
                    id="professionnelModulesCarousel"
                    class="carousel slide professionnel-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($subjects as $index => $subject)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <div class="professionnel-carousel-item">

                                    <a
                                        href="{{ route('vitrine.professionnel.enep.type_doc', [
                                            'formationSlug' => $formation->slug,
                                            'niveauSlug' => $niveau->slug,
                                            'moduleSlug' => $subject->slug
                                        ]) }}"
                                        class="professionnel-card professionnel-mobile-card"
                                    >

                                        {{-- CARD TOP --}}
                                        <div class="professionnel-card-top">

                                            <div class="professionnel-icon">
                                                {{ $subject->icon ?? '📚' }}
                                            </div>

                                            <div class="professionnel-arrow">
                                                <i class="bi bi-arrow-right"></i>
                                            </div>

                                        </div>


                                        {{-- CARD BODY --}}
                                        <div class="professionnel-card-body">

                                            <h3>
                                                {{ $subject->name }}
                                            </h3>

                                            <p>
                                                <i class="bi bi-file-earmark-text"></i>
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

                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- =================================================
                         CONTROLES
                    ================================================== --}}
                    @if($subjects->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#professionnelModulesCarousel"
                            data-bs-slide="prev"
                            aria-label="Module précédent"
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
                            data-bs-target="#professionnelModulesCarousel"
                            data-bs-slide="next"
                            aria-label="Module suivant"
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

</div>

@endsection
