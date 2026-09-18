@extends('layouts.app')

@section('title', $niveau->name . ' — Modules')

@section('content')

<div class="professionnel-page">

    {{-- HERO --}}
    <section class="professionnel-hero">

        <div class="container">

            <span class="professionnel-badge">
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


    {{-- CONTENU --}}
    <section class="professionnel-content">

        <div class="container">

            {{-- RETOUR --}}
            <div class="professionnel-back-wrapper">

                <a
                    href="{{ route(
                        'vitrine.professionnel.specialite.niveaux',
                        [
                            'formationSlug' => $formation->slug,
                            'specialiteSlug' => $specialite->slug
                        ]
                    ) }}"
                    class="professionnel-back"
                    aria-label="Retour aux niveaux"
                >

                    <i class="bi bi-arrow-left"></i>

                    <span>Retour aux niveaux</span>

                </a>

            </div>


            {{-- TITRE --}}
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

                    module{{ $subjects->count() > 1 ? 's' : '' }}

                </span>

            </div>


            {{-- MODULES --}}
            @if($subjects->isNotEmpty())

                <div class="professionnel-grid">

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
                            class="professionnel-card"
                        >

                            <div class="professionnel-card-top">

                                <div class="professionnel-icon">

                                    {{ $module->icon ?? '📚' }}

                                </div>

                                <div class="professionnel-arrow">

                                    <i class="bi bi-arrow-right"></i>

                                </div>

                            </div>


                            <div class="professionnel-card-body">

                                <h3>
                                    {{ $module->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-file-earmark-text"></i>
                                    Consulter les documents disponibles
                                </p>

                            </div>


                            <div class="professionnel-card-footer">

                                <span>
                                    Voir les types de documents
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                {{-- ÉTAT VIDE --}}
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

        </div>

    </section>

</div>

@endsection