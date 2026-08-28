@extends('layouts.app')

@section('title', 'Enseignement secondaire')

@section('content')

<div class="formation-page">

```
{{-- HEADER --}}
<section class="formation-hero">
    <div class="container">

        <div class="formation-badge">
            <i class="bi bi-mortarboard-fill"></i>
            Enseignement secondaire
        </div>

        <h1>
            Enseignement secondaire
        </h1>

        <p>
            Explorez les formations de l’enseignement secondaire
            et accédez aux ressources pédagogiques adaptées
            à chaque niveau d’étude.
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
            <div class="classes-grid">

                @foreach($formations as $formation)

                    <a
                        href="{{ route(
                            'vitrine.secondaire.formation',
                            [
                                'formation' => $formation->slug,
                            ]
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

                        <div class="class-card-footer">

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
                class="carousel slide classes-carousel"
                data-bs-ride="false"
            >

                <div class="carousel-inner">

                    @foreach($formations as $index => $formation)

                        <div
                            class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                        >

                            <a
                                href="{{ route(
                                    'vitrine.secondaire.formation',
                                    [
                                        'formation' => $formation->slug,
                                    ]
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

                                <div class="class-card-footer">

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
                        data-bs-target="#formationsCarousel"
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
                    Aucune formation disponible
                </h3>

                <p>
                    Les formations de l’enseignement secondaire
                    apparaîtront ici lorsqu’elles seront disponibles.
                </p>

            </div>

        @endif

    </div>

</section>

{{-- RETOUR --}}
<div class="container">

    <a
        href="{{ route('vitrine.secondaire.index') }}"
        class="vitrine-back"
    >
        <i class="bi bi-arrow-left"></i>
        Retour aux formations
    </a>

</div>

</div>

@endsection
