@extends('layouts.app')

@section('title', $formation->name)

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
                {{ $formation->name }}
            </h1>

            <p>
                Choisissez votre classe pour accéder aux ressources pédagogiques.
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
                        Classes disponibles
                    </h2>
                </div>

                <span class="class-count">
                    {{ $classes->count() }}
                    {{ $classes->count() > 1 ? 'classes' : 'classe' }}
                </span>

            </div>


            @if($classes->count())

                {{-- DESKTOP / TABLET --}}
                <div class="classes-grid">

                    @foreach($classes as $classe)

                        <a
                            href="{{ route(
                                'vitrine.secondaire.general.matieres',
                                $classe->slug
                            ) }}"
                            class="class-card"
                        >

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
                                    {{ $classe->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-file-earmark-text"></i>

                                    {{ $classe->documents_count }}
                                    {{ $classe->documents_count > 1
                                        ? 'documents disponibles'
                                        : 'document disponible'
                                    }}
                                </p>

                            </div>


                            <div class="class-card-footer">

                                <span>
                                    Consulter les ressources
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- MOBILE CAROUSEL --}}
                <div
                    id="classesCarousel"
                    class="carousel slide classes-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($classes->chunk(1) as $index => $chunk)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                @foreach($chunk as $classe)

                                    <a
                                        href="{{ route(
                                            'vitrine.secondaire.general.matieres',
                                            $classe->slug
                                        ) }}"
                                        class="class-card mobile-class-card"
                                    >

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
                                                {{ $classe->name }}
                                            </h3>

                                            <p>
                                                <i class="bi bi-file-earmark-text"></i>

                                                {{ $classe->documents_count }}

                                                {{ $classe->documents_count > 1
                                                    ? 'documents disponibles'
                                                    : 'document disponible'
                                                }}
                                            </p>

                                        </div>

                                        <div class="class-card-footer">

                                            <span>
                                                Consulter les ressources
                                            </span>

                                            <i class="bi bi-arrow-right"></i>

                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        @endforeach

                    </div>


                    @if($classes->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#classesCarousel"
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
                            data-bs-target="#classesCarousel"
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

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>

                    <h3>
                        Aucune classe disponible
                    </h3>

                    <p>
                        Aucune classe n'est actuellement disponible
                        pour cette formation.
                    </p>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection