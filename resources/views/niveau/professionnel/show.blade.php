@extends('layouts.app')

@section('content')

<div class="formation-page">

    <section class="formation-hero">
        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-file-earmark-text-fill"></i>
                DOCUMENT
            </span>

            <h1>
                {{ $document->title }}
            </h1>

            <p>
                {{ $formation->name }}

                @if(isset($specialite) && $specialite)
                    • {{ $specialite->name }}
                @endif

                • {{ $niveau->name }}
                • {{ $documentType->name }}
            </p>

        </div>
    </section>

    <section class="formation-content">

        <div class="container">

            <div class="document-show-card">

                <div class="document-show-header">

                    <div class="document-show-icon">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>

                    <div>
                        <span class="section-kicker">
                            DOCUMENT PÉDAGOGIQUE
                        </span>

                        <h2>
                            {{ $document->title }}
                        </h2>
                    </div>

                </div>

                @if($document->description)

                    <div class="document-description">

                        <h3>
                            Description
                        </h3>

                        <p>
                            {{ $document->description }}
                        </p>

                    </div>

                @endif

                <div class="document-meta">

                    <div>
                        <i class="bi bi-building"></i>
                        <strong>Formation</strong>
                        <span>{{ $formation->name }}</span>
                    </div>

                    @if(isset($specialite) && $specialite)

                        <div>
                            <i class="bi bi-diagram-3"></i>
                            <strong>Spécialité</strong>
                            <span>{{ $specialite->name }}</span>
                        </div>

                    @endif

                    <div>
                        <i class="bi bi-mortarboard"></i>
                        <strong>Niveau</strong>
                        <span>{{ $niveau->name }}</span>
                    </div>

                    <div>
                        <i class="bi bi-folder"></i>
                        <strong>Type</strong>
                        <span>{{ $documentType->name }}</span>
                    </div>

                </div>

                @if($document->file_path)

                    <div class="document-action">

                        <a
                            href="{{ asset('storage/' . $document->file_path) }}"
                            target="_blank"
                            class="document-view-btn"
                        >
                            <i class="bi bi-eye"></i>
                            Consulter le document
                        </a>

                    </div>

                @endif

            </div>

            <div class="doc-type-back-container">

                <a
                    href="{{ route(
                        'vitrine.professionnel.specialite.documents',
                        [
                            'formationSlug' => $formation->slug,
                            'specialiteSlug' => $specialite->slug,
                            'niveauSlug' => $niveau->slug,
                            'moduleSlug' => $module->slug,
                            'typeSlug' => $documentType->slug
                        ]
                    ) }}"
                    class="doc-type-back-btn"
                >
                    <i class="bi bi-arrow-left"></i>
                    Retour aux documents
                </a>

            </div>

        </div>

    </section>

</div>

@endsection