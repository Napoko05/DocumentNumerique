@extends('layouts.app')

@section('content')

<div class="superieur-page">

<section class="superieur-hero">

    <div class="container">

        <span class="superieur-badge">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            DOCUMENT
        </span>

        <h1>
            {{ $document->title }}
        </h1>

        <p>
            {{ $domaine->name }}
            •
            {{ $filiere->name }}
            •
            {{ $niveau->name }}
            •
            {{ $subject->name }}
        </p>

    </div>

</section>


<section class="superieur-content">

    <div class="container">

        <div class="document-show">

            <div class="document-show-header">

                <div class="document-show-icon">
                    <i class="bi bi-file-earmark-pdf-fill"></i>
                </div>

                <div>

                    <span class="section-kicker">
                        RESSOURCE PÉDAGOGIQUE
                    </span>

                    <h2>
                        {{ $document->title }}
                    </h2>

                </div>

            </div>


            @if(!empty($document->description))

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

                    <i class="bi bi-diagram-3-fill"></i>

                    <div>
                        <span>
                            Domaine
                        </span>

                        <strong>
                            {{ $domaine->name }}
                        </strong>
                    </div>

                </div>


                <div class="document-meta-item">

                    <i class="bi bi-book-fill"></i>

                    <div>
                        <span>
                            Filière
                        </span>

                        <strong>
                            {{ $filiere->name }}
                        </strong>
                    </div>

                </div>


                <div class="document-meta-item">

                    <i class="bi bi-mortarboard-fill"></i>

                    <div>
                        <span>
                            Niveau
                        </span>

                        <strong>
                            {{ $niveau->name }}
                        </strong>
                    </div>

                </div>


                <div class="document-meta-item">

                    <i class="bi bi-journal-text"></i>

                    <div>
                        <span>
                            Matière
                        </span>

                        <strong>
                            {{ $subject->name }}
                        </strong>
                    </div>

                </div>

            </div>


            @if(!empty($document->file_path))

                <div class="document-viewer">

                    <div class="document-viewer-header">

                        <div>

                            <i class="bi bi-file-earmark-pdf-fill"></i>

                            <span>
                                Aperçu du document
                            </span>

                        </div>

                        <a
                            href="{{ asset('storage/' . $document->file_path) }}"
                            target="_blank"
                            class="document-open-btn"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                            Ouvrir
                        </a>

                    </div>


                    <iframe
                        src="{{ asset('storage/' . $document->file_path) }}"
                        class="document-pdf"
                        title="{{ $document->title }}"
                    ></iframe>

                </div>

            @else

                <div class="superieur-empty">

                    <div class="superieur-empty-icon">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>

                    <h3>
                        Document indisponible
                    </h3>

                    <p>
                        Le fichier de ce document n'est actuellement pas disponible.
                    </p>

                </div>

            @endif


            <div class="superieur-back-container">

                <a
                    href="{{ route(
                        'vitrine.superieur.modules',
                        [
                            'domaineSlug' => $domaine->slug,
                            'filiereSlug' => $filiere->slug,
                            'niveauSlug' => $niveau->slug
                        ]
                    ) }}"
                    class="superieur-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux modules

                </a>

            </div>

        </div>

    </div>

</section>

</div>

@endsection