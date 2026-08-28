@extends('layouts.app')

@section('title', $formationModel->name)

@section('content')

<div class="formation-page">

    {{-- HEADER --}}
    <section class="formation-hero">
        <div class="container">

            <div class="formation-badge">
                <i class="bi bi-mortarboard-fill"></i>
                Formation
            </div>

            <h1>
                {{ $formationModel->name }}
            </h1>

            <p>
                Choisissez votre niveau pour accéder aux ressources pédagogiques.
            </p>

        </div>
    </section>

    {{-- CONTENU --}}
    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>
                    <span class="section-kicker">
                        PARCOURS PÉDAGOGIQUE
                    </span>

                    <h2>
                        Niveaux disponibles
                    </h2>
                </div>

                <span class="class-count">
                    {{ $levels->count() }}
                    {{ $levels->count() > 1 ? 'niveaux' : 'niveau' }}
                </span>

            </div>
            <a
                href="{{ route('vitrine.secondaire.index') }}"
                class="vitrine-back">
                <i class="bi bi-arrow-left"></i>
                Retour aux formations
            </a>


            @if($levels->count())

            {{-- DESKTOP / TABLET --}}
            <div class="classes-grid">

                @foreach($levels as $level)

                <a
                    href="{{ route(
                            'vitrine.secondaire.niveau',
                            [
                                'formation' => $formationModel->slug,
                                'niveau' => $level->slug,
                            ]
                        ) }}"
                    class="class-card">

                    <div class="class-card-top">

                        <div class="class-icon">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>

                        <span class="class-arrow">
                            <i class="bi bi-arrow-up-right"></i>
                        </span>

                    </div>

                    <div class="class-card-body">

                        <h3>
                            {{ $level->name }}
                        </h3>

                        <p>
                            <i class="bi bi-book"></i>

                            {{ $level->subjects_count }}

                            {{ $level->subjects_count > 1
                                    ? 'matières disponibles'
                                    : 'matière disponible'
                                }}
                        </p>

                    </div>

                    <div class="class-card-footer">

                        <span>
                            Consulter les matières
                        </span>

                        <i class="bi bi-arrow-right"></i>

                    </div>

                </a>

                @endforeach

            </div>

            {{-- MOBILE CAROUSEL --}}
            <div
                id="levelsCarousel"
                class="carousel slide classes-carousel"
                data-bs-ride="false">

                <div class="carousel-inner">

                    @foreach($levels as $index => $level)

                    <div
                        class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                        <a
                            href="{{ route(
                                    'vitrine.secondaire.niveau',
                                    [
                                        'formation' => $formationModel->slug,
                                        'niveau' => $level->slug,
                                    ]
                                ) }}"
                            class="class-card mobile-class-card">

                            <div class="class-card-top">

                                <div class="class-icon">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>

                                <span class="class-arrow">
                                    <i class="bi bi-arrow-up-right"></i>
                                </span>

                            </div>

                            <div class="class-card-body">

                                <h3>
                                    {{ $level->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-book"></i>

                                    {{ $level->subjects_count }}

                                    {{ $level->subjects_count > 1
                                            ? 'matières disponibles'
                                            : 'matière disponible'
                                        }}
                                </p>

                            </div>

                            <div class="class-card-footer">

                                <span>
                                    Consulter les matières
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    </div>

                    @endforeach

                </div>

                @if($levels->count() > 1)

                <button
                    class="carousel-control-prev"
                    type="button"
                    data-bs-target="#levelsCarousel"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>

                    <span class="visually-hidden">
                        Précédent
                    </span>
                </button>

                <button
                    class="carousel-control-next"
                    type="button"
                    data-bs-target="#levelsCarousel"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>

                    <span class="visually-hidden">
                        Suivant
                    </span>
                </button>

                @endif

            </div>

            @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-mortarboard"></i>
                </div>

                <h3>
                    Aucun niveau disponible
                </h3>

                <p>
                    Aucun niveau n'est actuellement disponible
                    pour cette formation.
                </p>

            </div>

            @endif

        </div>

    </section>

</div>


@endsection