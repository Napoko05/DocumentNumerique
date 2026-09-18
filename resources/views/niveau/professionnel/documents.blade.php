@extends('layouts.app')

@section('content')

<div class="professionnel-page">

    {{-- HERO --}}
    <section class="professionnel-hero">

        <div class="container">

            <span class="professionnel-badge">
                <i class="bi bi-file-earmark-text-fill"></i>
                DOCUMENTS
            </span>

            <h1>
                📚 {{ $formation->name }}
            </h1>

            <p>
                {{ $specialite->name }}
                •
                {{ $niveau->name }}
                •
                {{ $documentType->name }}
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
                        'vitrine.professionnel.specialite.type_doc',
                        [
                            'formationSlug' => $formation->slug,
                            'specialiteSlug' => $specialite->slug,
                            'niveauSlug' => $niveau->slug,
                            'moduleSlug' => $module->slug
                        ]
                    ) }}"
                    class="professionnel-back"
                    aria-label="Retour aux types de documents"
                >

                    <i class="bi bi-arrow-left"></i>

                    <span>Retour aux types de documents</span>

                </a>

            </div>


            {{-- TITRE --}}
            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        RESSOURCES PÉDAGOGIQUES
                    </span>

                    <h2>
                        {{ $documentType->name }}
                    </h2>

                </div>

                <span class="class-count">

                    {{ $documents->count() }}

                    document{{ $documents->count() > 1 ? 's' : '' }}

                </span>

            </div>


            {{-- DOCUMENTS --}}
            @if($documents->isNotEmpty())

                <div class="professionnel-grid">

                    @foreach($documents as $document)

                        <div class="professionnel-card">

                            {{-- HAUT DE LA CARTE --}}
                            <div class="professionnel-card-top">

                                <div class="professionnel-icon">
                                    📄
                                </div>

                                @if($document->isPremium())

                                    <span class="document-premium-badge">
                                        <i class="bi bi-lock-fill"></i>
                                        PREMIUM
                                    </span>

                                @else

                                    <span class="document-free-badge">
                                        GRATUIT
                                    </span>

                                @endif

                            </div>


                            {{-- CORPS --}}
                            <div class="professionnel-card-body">

                                <h3>
                                    {{ $document->title }}
                                </h3>

                                @if($document->description)

                                    <p>

                                        <i class="bi bi-info-circle"></i>

                                        {{ $document->description }}

                                    </p>

                                @endif

                            </div>


                            {{-- ACTIONS --}}
                            <div class="professionnel-card-footer document-actions">

                                <a
                                    href="{{ route('documents.read', $document) }}"
                                    target="_blank"
                                    class="document-view-btn"
                                >
                                    <i class="bi bi-eye"></i>
                                    Ouvrir
                                </a>

                                <a
                                    href="{{ route('documents.download', $document) }}"
                                    class="document-download-btn"
                                >
                                    <i class="bi bi-download"></i>
                                    Télécharger
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- ÉTAT VIDE --}}
                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>

                    <h3>
                        Aucun document disponible
                    </h3>

                    <p>
                        Aucun document n'est actuellement disponible
                        pour ce type de document.
                    </p>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection