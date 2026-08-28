@extends('layouts.app')

@section('content')

<div class="formation-page">

    <section class="formation-hero">
        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-mortarboard-fill"></i>
                FORMATION PROFESSIONNELLE
            </span>

            <h1>
                {{ $formation->icon ?? '🎓' }}
                {{ $formation->name }}
            </h1>

            <p>
                Choisissez votre spécialité de formation.
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
                            href="{{ route('vitrine.professionnel.specialite.niveaux', [
                                'formationSlug' => $formation->slug,
                                'specialiteSlug' => $specialite->slug
                            ]) }}"
                            class="class-card"
                        >

                            <div class="class-card-top">

                                <div class="class-icon">
                                    {{ $specialite->icon ?? '🎓' }}
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
                                    <i class="bi bi-mortarboard-fill"></i>
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

            @else

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="bi bi-folder-x"></i>
                    </div>

                    <h3>
                        Aucune spécialité disponible
                    </h3>

                    <p>
                        Aucune spécialité n'est actuellement enregistrée
                        pour cette formation.
                    </p>

                </div>

            @endif

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