@extends('layouts.app')

@section('title', 'Enseignement général')

@section('content')

<div class="secondaire-page">

    {{-- HEADER --}}
    <section class="secondaire-hero">
        <div class="container">

            <div class="secondaire-badge">
                <i class="bi bi-mortarboard-fill"></i>
                Enseignement général
            </div>

            <h1>
                Enseignement général
            </h1>

            <p>
                Explorez les formations de l’enseignement secondaire
                et accédez aux ressources pédagogiques adaptées
                à chaque niveau d’étude.
            </p>

        </div>
    </section>


    {{-- CONTENU --}}
    <section class="secondaire-content">

        <div class="container">
            {{-- RETOUR --}}
            <div class="secondaire-back-wrapper">

                <a
                    href="{{ url('/') }}"
                    class="professionnel-back"
                    aria-label="Retour à l'accueil">
                    <i class="bi bi-arrow-left"></i>
                    <span>Retour a l'acceuil</span>
                </a>

            </div>

            {{-- TITRE --}}
            <div class="section-heading">

                <div>
                    <span class="section-kicker">
                        PARCOURS PÉDAGOGIQUE
                    </span>

                    <h2>
                        Formations disponibles
                    </h2>
                </div>

                <span class="class-count">
                    {{ $formations->count() }}
                    {{ $formations->count() > 1 ? 'formations' : 'formation' }}
                </span>

            </div>


            @if($formations->count())

            {{-- DESKTOP / TABLET --}}
            <div class="secondaire-grid">

                @foreach($formations as $formation)

                <a
                    href="{{ route(
                                'vitrine.secondaire.formation',
                                [
                                    'formation' => $formation->slug,
                                ]
                            ) }}"
                    class="secondaire-card">

                    <div class="secondaire-card-top">

                        <div class="secondaire-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>

                        <span class="secondaire-arrow">
                            <i class="bi bi-arrow-up-right"></i>
                        </span>

                    </div>


                    <div class="secondaire-card-body">

                        <h3>
                            {{ $formation->name }}
                        </h3>

                        <p>
                            <i class="bi bi-layers"></i>

                            {{ $formation->levels_count }}

                            {{ $formation->levels_count > 1
                                        ? 'niveaux disponibles'
                                        : 'niveau disponible'
                                    }}
                        </p>

                    </div>


                    <div class="secondaire-card-footer">

                        <span>
                            Consulter les niveaux
                        </span>

                        <i class="bi bi-arrow-right"></i>

                    </div>

                </a>

                @endforeach

            </div>


            {{-- MOBILE CAROUSEL --}}
            <div
                id="formationsCarousel"
                class="carousel slide secondaire-carousel"
                data-bs-ride="false">

                <div class="carousel-inner">

                    @foreach($formations as $index => $formation)

                    <div
                        class="carousel-item secondaire-carousel-item {{ $index === 0 ? 'active' : '' }}">

                        <a
                            href="{{ route(
                                        'vitrine.secondaire.formation',
                                        [
                                            'formation' => $formation->slug,
                                        ]
                                    ) }}"
                            class="secondaire-mobile-card">

                            <div class="secondaire-card-top">

                                <div class="secondaire-icon">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>

                                <span class="secondaire-arrow">
                                    <i class="bi bi-arrow-up-right"></i>
                                </span>

                            </div>


                            <div class="secondaire-card-body">

                                <h3>
                                    {{ $formation->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-layers"></i>

                                    {{ $formation->levels_count }}

                                    {{ $formation->levels_count > 1
                                                ? 'niveaux disponibles'
                                                : 'niveau disponible'
                                            }}
                                </p>

                            </div>


                            <div class="secondaire-card-footer">

                                <span>
                                    Consulter les niveaux
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    </div>

                    @endforeach

                </div>


                @if($formations->count() > 1)

                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#formationsCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>

                    <span class="visually-hidden">
                        Précédent
                    </span>
                </button>


                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#formationsCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>

                    <span class="visually-hidden">
                        Suivant
                    </span>
                </button>

                @endif

            </div>


            @else

            {{-- AUCUNE FORMATION --}}
            <div class="secondaire-empty">

                <div class="secondaire-icon">
                    <i class="bi bi-mortarboard"></i>
                </div>

                <h3>
                    Aucune formation disponible
                </h3>

                <p>
                    Les formations de l’enseignement général
                    apparaîtront ici lorsqu’elles seront disponibles.
                </p>

            </div>

            @endif

        </div>

    </section>



</div>

@endsection