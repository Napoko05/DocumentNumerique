@extends('layouts.app')

@section('content')

<div class="professionnel-page">

    {{-- =====================================================
         HERO
    ===================================================== --}}

    <section class="professionnel-hero">

        <div class="container">

            <span class="professionnel-badge">
                <i class="bi bi-folder-fill"></i>
                RESSOURCES PÉDAGOGIQUES
            </span>

            <h1>
                📚 Types de documents
            </h1>

            <p>
                {{ $formation->name }}
                •
                {{ $specialite->name }}
                •
                {{ $niveau->name }}
            </p>

        </div>

    </section>


    {{-- =====================================================
         CONTENU
    ===================================================== --}}

    <section class="professionnel-content">

        <div class="container">

            {{-- =================================================
                 RETOUR
            ================================================== --}}

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


            {{-- =================================================
                 TITRE
            ================================================== --}}

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        DOCUMENTS
                    </span>

                    <h2>
                        Choisissez le type de document
                    </h2>

                </div>

                <span class="class-count">

                    {{ $types->count() }}

                    type{{ $types->count() > 1 ? 's' : '' }}

                </span>

            </div>


            {{-- =================================================
                 TYPES DE DOCUMENTS
            ================================================== --}}

            @if($types->isNotEmpty())

                <div class="professionnel-grid">

                    @foreach($types as $type)

                        <a
                            href="{{ route(
                                'vitrine.professionnel.specialite.documents',
                                [
                                    'formationSlug' => $formation->slug,
                                    'specialiteSlug' => $specialite->slug,
                                    'niveauSlug' => $niveau->slug,
                                    'moduleSlug' => $module->slug,
                                    'typeSlug' => $type->slug
                                ]
                            ) }}"
                            class="professionnel-card"
                        >

                            {{-- CARD TOP --}}

                            <div class="professionnel-card-top">

                                <div class="professionnel-icon">

                                    @switch($type->slug)

                                        @case('cours')
                                            📚
                                            @break

                                        @case('td')
                                            📝
                                            @break

                                        @case('tp')
                                            🧪
                                            @break

                                        @case('examens')
                                            📄
                                            @break

                                        @case('corriges')
                                            ✅
                                            @break

                                        @case('memoires')
                                            📕
                                            @break

                                        @case('rapports')
                                            📘
                                            @break

                                        @case('sujets')
                                            🎯
                                            @break

                                        @default
                                            📁

                                    @endswitch

                                </div>

                                <div class="professionnel-arrow">

                                    <i class="bi bi-arrow-right"></i>

                                </div>

                            </div>


                            {{-- CARD BODY --}}

                            <div class="professionnel-card-body">

                                <h3>
                                    {{ $type->name }}
                                </h3>

                                <p>

                                    <i class="bi bi-file-earmark-text"></i>

                                    Ressources disponibles

                                </p>

                            </div>


                            {{-- CARD FOOTER --}}

                            <div class="professionnel-card-footer">

                                <span>
                                    Voir les documents
                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

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
                        Aucun type de document disponible
                    </h3>

                    <p>
                        Aucun type de document n'est actuellement
                        disponible pour ce niveau.
                    </p>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection