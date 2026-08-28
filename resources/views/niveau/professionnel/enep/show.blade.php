@extends('layouts.app')

@section('title', $document->title)

@section('content')

<div class="formation-page">

    <section class="formation-hero">

        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-file-earmark-text-fill"></i>
                DOCUMENT ENEP
            </span>

            <h1>
                {{ $formation->icon ?? '🎓' }}
                {{ $document->title }}
            </h1>

            <p>
                {{ $niveau->name }}
                •
                {{ $module->name }}
                •
                {{ $documentType->name }}
            </p>

        </div>

    </section>

    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        RESSOURCE PÉDAGOGIQUE
                    </span>

                    <h2>
                        {{ $document->title }}
                    </h2>

                </div>

                <span class="class-count">
                    <i class="bi bi-eye"></i>
                    {{ $document->views }} vue{{ $document->views > 1 ? 's' : '' }}
                </span>

            </div>

            <div class="document-show-card">

                <div class="document-show-header">

                    <div class="document-show-icon">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>

                    <div>

                        <span class="document-type-label">
                            {{ $documentType->name }}
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

                    <div class="document-meta-item">

                        <i class="bi bi-building"></i>

                        <div>
                            <span>Formation</span>
                            <strong>{{ $formation->name }}</strong>
                        </div>

                    </div>

                    <div class="document-meta-item">

                        <i class="bi bi-mortarboard"></i>

                        <div>
                            <span>Niveau</span>
                            <strong>{{ $niveau->name }}</strong>
                        </div>

                    </div>

                    <div class="document-meta-item">

                        <i class="bi bi-book"></i>

                        <div>
                            <span>Module</span>
                            <strong>{{ $module->name }}</strong>
                        </div>

                    </div>

                    <div class="document-meta-item">

                        <i class="bi bi-file-earmark"></i>

                        <div>
                            <span>Type</span>
                            <strong>{{ $documentType->name }}</strong>
                        </div>

                    </div>

                </div>

                @if($document->content)

                    <div class="document-content">

                        <h3>
                            Contenu
                        </h3>

                        <div class="document-content-text">
                            {!! $document->content !!}
                        </div>

                    </div>

                @endif

                @if($document->file_path)

                    <div class="document-file">

                        <div class="document-file-info">

                            <i class="bi bi-file-earmark-pdf-fill"></i>

                            <div>

                                <strong>
                                    Document PDF
                                </strong>

                                <span>
                                    Consultez le fichier pédagogique
                                </span>

                            </div>

                        </div>

                        <a
                            href="{{ asset('storage/' . $document->file_path) }}"
                            target="_blank"
                            class="document-action-btn"
                        >

                            <i class="bi bi-eye"></i>

                            Consulter le PDF

                        </a>

                    </div>

                @endif

            </div>

            <div class="doc-type-back-container">

                <a
                    href="{{ route(
                        'vitrine.professionnel.enep.type_doc',
                        [
                            'formationSlug' => $formation->slug,
                            'niveauSlug' => $niveau->slug,
                            'moduleSlug' => $module->slug
                        ]
                    ) }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux types de documents

                </a>

            </div>

        </div>

    </section>

</div>

@endsection