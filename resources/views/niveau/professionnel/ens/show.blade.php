@extends('layouts.app')

@section('content')

<div class="formation-page">

    <section class="formation-hero">

        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-file-earmark-text"></i>
                DOCUMENT
            </span>

            <h1>
                {{ $document->title }}
            </h1>

            <p>
                {{ $formation->name }}
                •
                {{ $programme->name }}
                •
                {{ $specialite->name }}
                •
                {{ $niveau->name }}
                •
                {{ $module->name }}
            </p>

        </div>

    </section>


    <section class="formation-content">

        <div class="container">

            {{-- FIL D'ARIANE --}}

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

                <span>
                    {{ $module->name }}
                </span>

                <i class="bi bi-chevron-right"></i>

                <strong>
                    {{ $documentType->name }}
                </strong>

            </div>


            {{-- RETOUR AUX DOCUMENTS --}}

            <div class="doc-type-back-container">

                <a
                    href="{{ route('vitrine.professionnel.ens.documents', [
                        'formationSlug' => $formation->slug,
                        'programmeSlug' => $programme->slug,
                        'specialiteSlug' => $specialite->slug,
                        'niveauSlug' => $niveau->slug,
                        'moduleSlug' => $module->slug,
                        'typeSlug' => $documentType->slug
                    ]) }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour aux documents

                </a>

            </div>


            {{-- INFORMATIONS DOCUMENT --}}

            <div class="document-detail-card">

                <div class="document-detail-header">

                    <span class="section-kicker">
                        {{ $documentType->name }}
                    </span>

                    <h1>
                        {{ $document->title }}
                    </h1>

                    <div class="document-meta">

                        <span>
                            <i class="bi bi-book"></i>
                            {{ $module->name }}
                        </span>

                        <span>
                            <i class="bi bi-mortarboard"></i>
                            {{ $niveau->name }}
                        </span>

                        <span>
                            <i class="bi bi-eye"></i>
                            {{ $document->views }} vue{{ $document->views > 1 ? 's' : '' }}
                        </span>

                    </div>

                </div>


                {{-- DESCRIPTION --}}

                @if($document->description)

                    <div class="document-description">

                        <h3>
                            <i class="bi bi-info-circle"></i>
                            Description
                        </h3>

                        <p>
                            {{ $document->description }}
                        </p>

                    </div>

                @endif


                {{-- FICHIER --}}

                <div class="document-viewer">

                    @if($document->file_path)

                        <div class="document-viewer-header">

                            <div>

                                <strong>
                                    <i class="bi bi-file-earmark-pdf"></i>
                                    Document PDF
                                </strong>

                                <span>
                                    {{ strtoupper($document->file_extension ?? 'PDF') }}
                                </span>

                            </div>

                            <a
                                href="{{ asset('storage/' . $document->file_path) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="document-open-btn"
                            >

                                <i class="bi bi-box-arrow-up-right"></i>

                                Ouvrir le PDF

                            </a>

                        </div>


                        <div class="document-pdf-container">

                            <iframe
                                src="{{ asset('storage/' . $document->file_path) }}"
                                title="{{ $document->title }}"
                                class="document-pdf"
                            ></iframe>

                        </div>

                    @else

                        <div class="empty-state">

                            <div class="empty-icon">
                                <i class="bi bi-file-earmark-x"></i>
                            </div>

                            <h3>
                                Document indisponible
                            </h3>

                            <p>
                                Le fichier PDF de ce document
                                n'est pas actuellement disponible.
                            </p>

                        </div>

                    @endif

                </div>

            </div>


            {{-- RETOUR AUX TYPES --}}

            <div class="doc-type-back-container">

                <a
                    href="{{ route('vitrine.professionnel.ens.type_doc', [
                        'formationSlug' => $formation->slug,
                        'programmeSlug' => $programme->slug,
                        'specialiteSlug' => $specialite->slug,
                        'niveauSlug' => $niveau->slug,
                        'moduleSlug' => $module->slug
                    ]) }}"
                    class="doc-type-back-btn"
                >

                    <i class="bi bi-arrow-left"></i>

                    Retour au module

                </a>

            </div>

        </div>

    </section>

</div>

@endsection