
@extends('layouts.app')

@section('title', 'Domaines académiques')

@section('content')

<div class="superieur-page">

    {{-- HERO --}}
    <section class="superieur-hero">
        <div class="container">

            <span class="superieur-badge">
                <i class="bi bi-mortarboard-fill"></i>
                Enseignement supérieur
            </span>

            <h1>
                🎓 Domaines académiques
            </h1>

        </div>
    </section>


    {{-- CONTENU --}}
    <section class="superieur-content">
        <div class="container">

            {{-- RETOUR --}}
            <div class="superieur-back-wrapper">
                <a
                    href="{{ url('/') }}"
                    class="superieur-back"
                    aria-label="Retour à l'accueil"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Retour à l'accueil</span>
                </a>
            </div>


            {{-- EN-TÊTE --}}
            <div class="section-heading">

                <div>
                    <span class="section-kicker">
                        Parcours académique
                    </span>

                    <h2>
                        Choisissez un domaine
                    </h2>
                </div>

                <span class="class-count">
                    {{ $domaines->count() }}
                    domaine{{ $domaines->count() > 1 ? 's' : '' }}
                </span>

            </div>


            @if($domaines->isNotEmpty())

                {{-- GRILLE DES DOMAINES --}}
                <div class="superieur-grid">

                    @foreach($domaines as $domaine)

                        <a
                            href="{{ route(
                                'vitrine.superieur.filieres',
                                ['domaineSlug' => $domaine->slug]
                            ) }}"
                            class="superieur-card"
                        >

                            <div class="superieur-card-top">

                                <div class="superieur-icon">
                                    @if(!empty($domaine->icon))
                                        {{ $domaine->icon }}
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
                                    {{ $domaine->name }}
                                </h3>

                                @if(!empty($domaine->description))
                                    <p>
                                        <i class="bi bi-info-circle-fill"></i>
                                        {{ $domaine->description }}
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


                {{-- CAROUSEL MOBILE --}}
                <div
                    id="superieurDomainesCarousel"
                    class="carousel slide superieur-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($domaines as $index => $domaine)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <div class="superieur-carousel-item">

                                    <a
                                        href="{{ route(
                                            'vitrine.superieur.filieres',
                                            ['domaineSlug' => $domaine->slug]
                                        ) }}"
                                        class="superieur-card superieur-mobile-card"
                                    >

                                        <div class="superieur-card-top">

                                            <div class="superieur-icon">
                                                @if(!empty($domaine->icon))
                                                    {{ $domaine->icon }}
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
                                                {{ $domaine->name }}
                                            </h3>

                                            @if(!empty($domaine->description))
                                                <p>
                                                    <i class="bi bi-info-circle-fill"></i>
                                                    {{ $domaine->description }}
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


                    @if($domaines->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#superieurDomainesCarousel"
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
                            data-bs-target="#superieurDomainesCarousel"
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
                        Aucun domaine disponible
                    </h3>

                </div>

            @endif

        </div>
    </section>

</div>

@endsection
