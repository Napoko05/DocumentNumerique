@extends('layouts.app')

@section('title', $niveau->name . ' — Modules')

@section('content')

<div class="formation-page">

    <section class="formation-hero">

        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-book-fill"></i>
                RESSOURCES PÉDAGOGIQUES
            </span>

            <h1>
                {{ $formation->icon ?? '🎓' }}
                {{ $formation->name }}
            </h1>

            <p>
                {{ $specialite->name }}
                •
                {{ $niveau->name }}
            </p>

        </div>

    </section>

    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        MODULES / MATIÈRES
                    </span>

                    <h2>
                        Choisissez votre module
                    </h2>

                </div>

                <span class="class-count">

                    {{ $subjects->count() }}

                    subjects{{ $subjects->count() > 1 ? 's' : '' }}

                </span>

            </div>

            @if($subjects->isNotEmpty())

                <div class="classes-grid">

                    @foreach($subjects as $module)

                        <a
                            href="{{ route(
                                'vitrine.professionnel.specialite.type_doc',
                                [
                                    'formationSlug' => $formation->slug,
                                    'specialiteSlug' => $specialite->slug,
                                    'niveauSlug' => $niveau->slug,
                                    'moduleSlug' => $module->slug
                                ]
                            ) }}"
                            class="class-card"
                        >

                            <div class="class-card-top">

                                <div class="class-icon">
                                    {{ $module->icon ?? '📚' }}
                                </div>

                                <div class="class-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>

                            <div class="class-card-body">

                                <h3>
                                    {{ $module->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-file-earmark-text"></i>
                                    Consulter les documents disponibles
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
                        Aucun module disponible
                    </h3>

                    <p>
                        Aucun module ou matière n'est actuellement
                        disponible pour ce niveau.
                    </p>

                </div>

            @endif

            <div class="doc-type-back-container">

                <a
                    href="{{ route(
                        'vitrine.professionnel.specialite.niveaux',
                        [
                            'formationSlug' => $formation->slug,
                            'specialiteSlug' => $specialite->slug
                        ]
                    ) }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux niveaux

                </a>

            </div>

        </div>

    </section>

</div>

@endsection