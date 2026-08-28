@extends('layouts.app')

@section('content')

<div class="formation-page">

    {{-- =========================================================
         HERO
    ========================================================== --}}

    <section class="formation-hero">

        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-folder-fill"></i>
                TYPES DE DOCUMENTS
            </span>

            <h1>
                📚 {{ $module->name }}
            </h1>

            <p>
                {{ $formation->name }}
                •
                {{ $programme->name }}
                •
                {{ $specialite->name }}
                •
                {{ $niveau->name }}
            </p>

        </div>

    </section>


    {{-- =========================================================
         CONTENU
    ========================================================== --}}

    <section class="formation-content">

        <div class="container">

            {{-- =================================================
                 FIL D'ARIANE
            ================================================== --}}

            <div class="formation-breadcrumb">

                <span>
                    {{ $formation->name }}
                </span>

                <i class="bi bi-chevron-right"></i>

                <span>
                    {{ $programme->name }}
                </span>

                <i class="bi bi-chevron-right"></i>

                <span>
                    {{ $specialite->name }}
                </span>

                <i class="bi bi-chevron-right"></i>

                <span>
                    {{ $niveau->name }}
                </span>

                <i class="bi bi-chevron-right"></i>

                <strong>
                    {{ $module->name }}
                </strong>

            </div>


            {{-- =================================================
                 EN-TÊTE
            ================================================== --}}

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        DOCUMENTS
                    </span>

                    <h2>
                        Choisissez un type de document
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

                <div class="classes-grid">

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
                            class="class-card"
                        >

                            {{-- CARD TOP --}}

                            <div class="class-card-top">

                                <div class="class-icon">

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

                                <div class="class-arrow">
                                    <i class="bi bi-arrow-right"></i>
                                </div>

                            </div>


                            {{-- CARD BODY --}}

                            <div class="class-card-body">

                                <h3>
                                    {{ $type->name }}
                                </h3>

                                <p>
                                    <i class="bi bi-file-earmark-text"></i>
                                    Documents de {{ $module->name }}
                                </p>

                            </div>


                            {{-- CARD FOOTER --}}

                            <div class="class-card-footer">

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
                        Aucun document publié n'est actuellement
                        disponible pour le module
                        <strong>{{ $module->name }}</strong>.
                    </p>

                </div>

            @endif


            {{-- =================================================
                 RETOUR AUX MODULES
            ================================================== --}}

            <div class="doc-type-back-container">

                <a
                    href="{{ route('vitrine.professionnel.ens.modules', [
                        'formationSlug' => $formation->slug,
                        'programmeSlug' => $programme->slug,
                        'specialiteSlug' => $specialite->slug,
                        'niveauSlug' => $niveau->slug
                    ]) }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux modules

                </a>

            </div>

        </div>

    </section>

</div>

@endsection