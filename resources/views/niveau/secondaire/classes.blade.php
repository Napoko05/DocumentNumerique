@extends('layouts.app')

@section('title', $level->name)

@section('content')

<div class="secondaire-page">

    {{-- =====================================================
         HERO
         ===================================================== --}}
    <section class="secondaire-hero">
        <div class="container">

            <div class="secondaire-badge">
                <i class="bi bi-mortarboard-fill"></i>
                Niveau
            </div>

            <h1>{{ $level->name }}</h1>

            <p>
                Consultez les matières et ressources pédagogiques disponibles.
            </p>

        </div>
    </section>


    {{-- =====================================================
         CONTENU
         ===================================================== --}}
    <section class="secondaire-content">

        <div class="container">

            {{-- =================================================
                 RETOUR EN HAUT
                 ================================================= --}}
            <div class="secondaire-back-wrapper">

                <a
                    href="{{ route(
                        'vitrine.secondaire.formation',
                        [
                            'formation' => $formationModel->slug,
                        ]
                    ) }}"
                    class="secondaire-back"
                    aria-label="Retour à {{ $formationModel->name }}"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Retour à {{ $formationModel->name }}</span>
                </a>

            </div>


            {{-- =================================================
                 TITRE
                 ================================================= --}}
            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        {{ $formationModel->name }}
                    </span>

                    <h2>
                        Matières disponibles
                    </h2>

                </div>

                <span class="class-count">
                    {{ $subjects->count() }}
                    {{ $subjects->count() > 1 ? 'matières' : 'matière' }}
                </span>

            </div>


            {{-- =================================================
                 MATIÈRES
                 ================================================= --}}
            @if($subjects->count())

                {{-- =============================================
                     DESKTOP / TABLETTE
                     ============================================= --}}
                <div class="secondaire-grid">

                    @foreach($subjects as $subject)

                        <a
                            href="{{ route(
                                'vitrine.secondaire.subject',
                                [
                                    'formation' => $formationModel->slug,
                                    'niveau' => $level->slug,
                                    'matiere' => $subject->slug,
                                ]
                            ) }}"
                            class="secondaire-card"
                        >

                            <div class="secondaire-card-top">

                                <div class="secondaire-icon">
                                    <i class="bi bi-book-fill"></i>
                                </div>

                                <span class="secondaire-arrow">
                                    <i class="bi bi-arrow-up-right"></i>
                                </span>

                            </div>


                            <div class="secondaire-card-body">

                                <h3>
                                    {{ $subject->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-file-earmark-text"></i>

                                    {{ $subject->documents_count }}

                                    {{ $subject->documents_count > 1
                                        ? 'documents disponibles'
                                        : 'document disponible'
                                    }}
                                </p>

                            </div>


                            <div class="secondaire-card-footer">

                                <span>
                                    Consulter les ressources
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- =============================================
                     MOBILE : CAROUSEL
                     ============================================= --}}
                <div
                    id="subjectsCarousel"
                    class="carousel slide secondaire-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($subjects as $index => $subject)

                            <div
                                class="carousel-item secondaire-carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <a
                                    href="{{ route(
                                        'vitrine.secondaire.subject',
                                        [
                                            'formation' => $formationModel->slug,
                                            'niveau' => $level->slug,
                                            'matiere' => $subject->slug,
                                        ]
                                    ) }}"
                                    class="secondaire-card secondaire-mobile-card"
                                >

                                    <div class="secondaire-card-top">

                                        <div class="secondaire-icon">
                                            <i class="bi bi-book-fill"></i>
                                        </div>

                                        <span class="secondaire-arrow">
                                            <i class="bi bi-arrow-up-right"></i>
                                        </span>

                                    </div>


                                    <div class="secondaire-card-body">

                                        <h3>
                                            {{ $subject->name }}
                                        </h3>

                                        <p>
                                            <i class="bi bi-file-earmark-text"></i>

                                            {{ $subject->documents_count }}

                                            {{ $subject->documents_count > 1
                                                ? 'documents disponibles'
                                                : 'document disponible'
                                            }}
                                        </p>

                                    </div>


                                    <div class="secondaire-card-footer">

                                        <span>
                                            Consulter les ressources
                                        </span>

                                        <i class="bi bi-arrow-right"></i>

                                    </div>

                                </a>

                            </div>

                        @endforeach

                    </div>


                    @if($subjects->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#subjectsCarousel"
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
                            data-bs-target="#subjectsCarousel"
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

                {{-- =============================================
                     AUCUNE MATIÈRE
                     ============================================= --}}
                <div class="secondaire-empty">

                    <div class="secondaire-empty-icon">
                        <i class="bi bi-book"></i>
                    </div>

                    <h3>
                        Aucune matière disponible
                    </h3>

                    <p>
                        Aucune matière n'est actuellement disponible
                        pour ce niveau.
                    </p>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection
