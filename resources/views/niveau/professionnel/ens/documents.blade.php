@extends('layouts.app')

@section('content')

<div class="professionnel-page">

{{-- HERO --}}
<section class="professionnel-hero">

    <div class="container">

        <span class="professionnel-badge">
            <i class="bi bi-file-earmark-text"></i>
            DOCUMENTS
        </span>

        <h1>
            {{ $documentType->name }}
        </h1>

    </div>

</section>


{{-- CONTENU --}}
<section class="professionnel-content">

    <div class="container">

        {{-- RETOUR --}}
        <div class="professionnel-back-wrapper">

            <a
                href="{{ route('vitrine.professionnel.ens.type_doc', [
                    'formationSlug' => $formation->slug,
                    'programmeSlug' => $programme->slug,
                    'specialiteSlug' => $specialite->slug,
                    'niveauSlug' => $niveau->slug,
                    'moduleSlug' => $module->slug
                ]) }}"
                class="professionnel-back"
                aria-label="Retour aux types de documents"
            >
                <i class="bi bi-arrow-left"></i>
                <span>Retour aux types de documents</span>
            </a>

        </div>


        {{-- EN-TÊTE --}}
        <div class="professionnel-section-heading">

            <div>

                <span class="professionnel-section-kicker">
                    DOCUMENTS
                </span>

                <h2>
                    {{ $documentType->name }}
                </h2>

            </div>

            <span class="professionnel-count">

                {{ $documents->total() }}

                document{{ $documents->total() > 1 ? 's' : '' }}

            </span>

        </div>


        {{-- DOCUMENTS --}}
        @if($documents->isNotEmpty())

            <div class="professionnel-grid">

                @foreach($documents as $document)

                    <div class="professionnel-card">

                        {{-- HAUT DE CARTE --}}
                        <div class="professionnel-card-top">

                            <div class="professionnel-icon">
                                <i class="bi bi-file-earmark-pdf"></i>
                            </div>

                            <div class="professionnel-arrow">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>

                        </div>


                        {{-- CORPS --}}
                        <div class="professionnel-card-body">

                            <h3>
                                {{ $document->title }}
                            </h3>

                            @if($document->description)

                                <p>
                                    {{ \Illuminate\Support\Str::limit(
                                        $document->description,
                                        120
                                    ) }}
                                </p>

                            @else

                                <p>
                                    <i class="bi bi-book"></i>
                                    {{ $module->name }}
                                </p>

                            @endif


                            {{-- TYPE / VUES --}}
                            <div class="professionnel-document-meta">

                                <span>
                                    <i class="bi bi-file-earmark"></i>
                                    {{ strtoupper($document->file_extension ?? 'PDF') }}
                                </span>

                                <span>
                                    <i class="bi bi-eye"></i>
                                    {{ $document->views }}
                                </span>

                            </div>

                        </div>


                        {{-- ACTIONS --}}
                        <div class="professionnel-card-footer professionnel-document-actions">

                            {{-- LIRE --}}
                            <a
                                href="{{ route('documents.read', $document) }}"
                                class="professionnel-document-view-btn"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Lire {{ $document->title }}"
                            >
                                <i class="bi bi-eye"></i>
                                <span>Lire</span>
                            </a>


                            {{-- TÉLÉCHARGER --}}
                            <a
                                href="{{ route('documents.download', $document) }}"
                                class="professionnel-document-download-btn"
                                aria-label="Télécharger {{ $document->title }}"
                            >
                                <i class="bi bi-download"></i>
                                <span>Télécharger</span>
                            </a>

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- PAGINATION --}}
            @if($documents->hasPages())

                <div class="professionnel-pagination">

                    {{ $documents->links() }}

                </div>

            @endif


        @else

            {{-- ÉTAT VIDE --}}
            <div class="professionnel-empty">

                <div class="professionnel-empty-icon">
                    <i class="bi bi-folder-x"></i>
                </div>

                <h3>
                    Aucun document disponible
                </h3>

                <p>
                    Aucun document n'est actuellement disponible
                    pour cette catégorie.
                </p>

            </div>

        @endif

    </div>

</section>

</div>

@endsection
