@extends('layouts.app')

@section('content')

<div class="formation-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="formation-hero">

        <div class="container">

            <div class="formation-badge">
                <i class="bi bi-mortarboard-fill"></i>
                PROGRAMMES DE FORMATION
            </div>

            <h1>
                {{ $formation->icon ?? '🎓' }}
                {{ $formation->name }}
            </h1>

            <p>
                {{ $formation->description
                    ?? 'Choisissez votre programme de formation.' }}
            </p>

        </div>

    </section>


    {{-- =========================================================
         CONTENT
    ========================================================== --}}

    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        PROGRAMMES
                    </span>

                    <h2>
                        Choisissez votre programme
                    </h2>

                </div>

                <span class="class-count">
                    {{ $programmes->count() }}
                    programme{{ $programmes->count() > 1 ? 's' : '' }}
                </span>

            </div>


            {{-- =================================================
                 PROGRAMMES
            ================================================== --}}

            @if($programmes->isNotEmpty())

                <div class="classes-grid">

                    @foreach($programmes as $programme)

                        <a
                            href="{{ route('vitrine.professionnel.ens.specialites', [
                                'programmeSlug' => $programme->slug
                            ]) }}"
                            class="class-card"
                        >

                            <div class="class-card-top">

                                <div class="class-icon">
                                    {{ $programme->icon ?? '🎓' }}
                                </div>

                                <div class="class-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>


                            <div class="class-card-body">

                                <h3>
                                    {{ $programme->name }}
                                </h3>

                                <p>

                                    <i class="bi bi-info-circle"></i>

                                    {{ $programme->description
                                        ?? 'Programme de formation disponible.' }}

                                </p>

                            </div>


                            <div class="class-card-footer">

                                <span>
                                    Voir les spécialités
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
                    id="programmesCarousel"
                    class="carousel slide classes-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($programmes as $index => $programme)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <div class="mobile-class-card">

                                    <a
                                        href="{{ route('vitrine.professionnel.ens.specialites', [
                                            'programmeSlug' => $programme->slug
                                        ]) }}"
                                        class="class-card"
                                    >

                                        <div class="class-card-top">

                                            <div class="class-icon">
                                                {{ $programme->icon ?? '🎓' }}
                                            </div>

                                            <div class="class-arrow">
                                                <i class="bi bi-arrow-right"></i>
                                            </div>

                                        </div>


                                        <div class="class-card-body">

                                            <h3>
                                                {{ $programme->name }}
                                            </h3>

                                            <p>

                                                <i class="bi bi-info-circle"></i>

                                                {{ $programme->description
                                                    ?? 'Programme de formation disponible.' }}

                                            </p>

                                        </div>


                                        <div class="class-card-footer">

                                            <span>
                                                Voir les spécialités
                                            </span>

                                            <i class="bi bi-arrow-right"></i>

                                        </div>

                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if($programmes->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#programmesCarousel"
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
                            data-bs-target="#programmesCarousel"
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
                     EMPTY STATE
                ================================================== --}}

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="bi bi-folder-x"></i>
                    </div>

                    <h3>
                        Aucun programme disponible
                    </h3>

                    <p>
                        Aucun programme n'est actuellement disponible
                        pour cette formation.
                    </p>

                </div>

            @endif


            {{-- =================================================
                 RETOUR
            ================================================== --}}

            <div class="doc-type-back-container">

                <a
                    href="{{ route('vitrine.professionnel.formations') }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux formations

                </a>

            </div>

        </div>

    </section>

</div>

@endsection