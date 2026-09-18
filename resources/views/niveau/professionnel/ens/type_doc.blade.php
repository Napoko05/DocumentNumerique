@extends('layouts.app')

@section('content')

<div class="professionnel-page">

{{-- =========================================================
     HERO
========================================================== --}}

<section class="professionnel-hero">

    <div class="container">

        <span class="professionnel-badge">
            <i class="bi bi-folder-fill"></i>
            TYPES DE DOCUMENTS
        </span>

        <h1>
            📚 {{ $module->name }}
        </h1>

    </div>

</section>


{{-- =========================================================
     CONTENU
========================================================== --}}

<section class="professionnel-content">

    <div class="container">

        {{-- =================================================
             RETOUR
        ================================================== --}}

        <div class="professionnel-back-wrapper">

            <a
                href="{{ route('vitrine.professionnel.ens.modules', [
                    'formationSlug' => $formation->slug,
                    'programmeSlug' => $programme->slug,
                    'specialiteSlug' => $specialite->slug,
                    'niveauSlug' => $niveau->slug
                ]) }}"
                class="professionnel-back"
                aria-label="Retour aux modules"
            >
                <i class="bi bi-arrow-left"></i>

                <span>Retour aux modules</span>

            </a>

        </div>


        {{-- =================================================
             EN-TÊTE
        ================================================== --}}

        <div class="professionnel-section-heading">

            <div>

                <span class="professionnel-section-kicker">
                    DOCUMENTS
                </span>

                <h2>
                    Types de documents
                </h2>

            </div>

            <span class="professionnel-count">

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
                        href="{{ route('vitrine.professionnel.ens.documents', [
                            'formationSlug' => $formation->slug,
                            'programmeSlug' => $programme->slug,
                            'specialiteSlug' => $specialite->slug,
                            'niveauSlug' => $niveau->slug,
                            'moduleSlug' => $module->slug,
                            'typeSlug' => $type->slug
                        ]) }}"
                        class="professionnel-card"
                    >

                        {{-- =================================================
                             CARD TOP
                        ================================================== --}}

                        <div class="professionnel-card-top">

                            <div class="professionnel-icon">

                                @switch($type->slug)

                                    @case('cours')
                                        📚
                                        @break

                                    @case('exercices')
                                        📝
                                        @break

                                    @case('corriges')
                                        ✅
                                        @break

                                    @case('sujets-dexamen')
                                        📄
                                        @break

                                    @case('annales')
                                        📚
                                        @break

                                    @case('travaux-pratiques')
                                        🧪
                                        @break

                                    @case('rapports')
                                        📘
                                        @break

                                    @case('memoires')
                                        📕
                                        @break

                                    @case('theses')
                                        🎓
                                        @break

                                    @case('articles-scientifiques')
                                        📰
                                        @break

                                    @case('fiches-de-revision')
                                        📝
                                        @break

                                    @case('concours')
                                        🏆
                                        @break

                                    @default
                                        📁

                                @endswitch

                            </div>

                            <div class="professionnel-arrow">
                                <i class="bi bi-arrow-right"></i>
                            </div>

                        </div>


                        {{-- =================================================
                             CARD BODY
                        ================================================== --}}

                        <div class="professionnel-card-body">

                            <h3>
                                {{ $type->name }}
                            </h3>

                            <p>
                                <i class="bi bi-file-earmark-text"></i>
                                Documents
                            </p>

                        </div>


                        {{-- =================================================
                             CARD FOOTER
                        ================================================== --}}

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
                 ÉTAT VIDE
            ================================================== --}}

            <div class="professionnel-empty">

                <div class="professionnel-empty-icon">
                    <i class="bi bi-folder-x"></i>
                </div>

                <h3>
                    Aucun type de document disponible
                </h3>

                <p>
                    Aucun type de document n'est actuellement
                    disponible pour ce module.
                </p>

            </div>

        @endif

    </div>

</section>


</div>

@endsection
