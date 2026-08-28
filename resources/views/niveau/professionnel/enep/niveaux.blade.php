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
                Choisissez votre niveau de formation.
                @if(!empty($formation->description))
                    — {{ $formation->description }}
                @endif
            </p>

        </div>

    </section>

    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        PARCOURS DE FORMATION
                    </span>

                    <h2>
                        Choisissez votre niveau
                    </h2>

                </div>

                <span class="class-count">

                    {{ $niveaux->count() }}

                    niveau{{ $niveaux->count() > 1 ? 'x' : '' }}

                </span>

            </div>

            @if($niveaux->isNotEmpty())

                <div class="classes-grid">

                    @foreach($niveaux as $niveau)

                        <a
                            href="{{ route(
                                'vitrine.professionnel.enep.modules',
                                [
                                    'formationSlug' => $formation->slug,
                                    'niveauSlug' => $niveau->slug
                                ]
                            ) }}"
                            class="class-card"
                        >

                            <div class="class-card-top">

                                <div class="class-icon">
                                    {{ $niveau->icon ?? '🎓' }}
                                </div>

                                <div class="class-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>

                            <div class="class-card-body">

                                <h3>
                                    {{ $niveau->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-mortarboard-fill"></i>
                                    Niveau de formation
                                </p>

                            </div>

                            <div class="class-card-footer">

                                <span>
                                    Voir les types de documents
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
                        Aucun niveau disponible
                    </h3>

                    <p>
                        Aucun niveau n'est actuellement disponible
                        pour cette formation.
                    </p>

                </div>

            @endif

            <div class="doc-type-back-container">

                <a
                    href="{{ route(
                        'vitrine.professionnel.formations'
                    ) }}"
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