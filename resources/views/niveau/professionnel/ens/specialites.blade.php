@extends('layouts.app')

@section('content')

<div class="formation-page">

    <section class="formation-hero">

        <div class="container">

            <div class="formation-badge">
                <i class="bi bi-mortarboard-fill"></i>
                SPÉCIALITÉS DE FORMATION
            </div>

            <h1>
                {{ $programme->icon ?? '🎓' }}
                {{ $programme->name }}
            </h1>

            <p>
                {{ $programme->description
                    ?? 'Choisissez votre spécialité de formation.' }}
            </p>

        </div>

    </section>


    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        SPÉCIALITÉS
                    </span>

                    <h2>
                        Choisissez votre spécialité
                    </h2>

                </div>

                <span class="class-count">

                    {{ $specialites->count() }}

                    spécialité{{ $specialites->count() > 1 ? 's' : '' }}

                </span>

            </div>


            @if($specialites->isNotEmpty())

                <div class="classes-grid">

                    @foreach($specialites as $specialite)

                        <a
                            href="{{ route('vitrine.professionnel.ens.niveaux', [
                                'formationSlug' => $formation->slug,
                                'programmeSlug' => $programme->slug,
                                'specialiteSlug' => $specialite->slug
                            ]) }}"
                            class="class-card"
                        >

                            <div class="class-card-top">

                                <div class="class-icon">
                                    {{ $specialite->icon ?? '📚' }}
                                </div>

                                <div class="class-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>


                            <div class="class-card-body">

                                <h3>
                                    {{ $specialite->name }}
                                </h3>

                                <p>

                                    <i class="bi bi-bookmark-fill"></i>

                                    Spécialité de formation

                                </p>

                            </div>


                            <div class="class-card-footer">

                                <span>
                                    Voir les niveaux
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- MOBILE --}}

                <div
                    id="ensSpecialitesCarousel"
                    class="carousel slide classes-carousel"
                    data-bs-ride="false"
                >

                    <div class="carousel-inner">

                        @foreach($specialites as $index => $specialite)

                            <div
                                class="carousel-item {{ $index === 0 ? 'active' : '' }}"
                            >

                                <div class="mobile-class-card">

                                    <a
                                        href="{{ route('vitrine.professionnel.ens.niveaux', [
                                            'formationSlug' => $formation->slug,
                                            'programmeSlug' => $programme->slug,
                                            'specialiteSlug' => $specialite->slug
                                        ]) }}"
                                        class="class-card"
                                    >

                                        <div class="class-card-top">

                                            <div class="class-icon">
                                                {{ $specialite->icon ?? '📚' }}
                                            </div>

                                            <div class="class-arrow">
                                                <i class="bi bi-arrow-right"></i>
                                            </div>

                                        </div>


                                        <div class="class-card-body">

                                            <h3>
                                                {{ $specialite->name }}
                                            </h3>

                                            <p>

                                                <i class="bi bi-bookmark-fill"></i>

                                                Spécialité de formation

                                            </p>

                                        </div>


                                        <div class="class-card-footer">

                                            <span>
                                                Voir les niveaux
                                            </span>

                                            <i class="bi bi-arrow-right"></i>

                                        </div>

                                    </a>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if($specialites->count() > 1)

                        <button
                            class="carousel-control-prev"
                            type="button"
                            data-bs-target="#ensSpecialitesCarousel"
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
                            data-bs-target="#ensSpecialitesCarousel"
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
                        <i class="bi bi-folder-x"></i>
                    </div>

                    <h3>
                        Aucune spécialité disponible
                    </h3>

                    <p>
                        Aucune spécialité n'est actuellement disponible
                        pour ce programme.
                    </p>

                </div>

            @endif


            {{-- RETOUR --}}

            <div class="doc-type-back-container">

                <a
                    href="{{ route('vitrine.professionnel.ens.programmes', [
                        'formationSlug' => $formation->slug
                    ]) }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux programmes

                </a>

            </div>

        </div>

    </section>

</div>

@endsection