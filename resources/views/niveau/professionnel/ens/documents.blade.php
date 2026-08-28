@extends('layouts.app')

@section('content')

<div class="formation-page">

    <section class="formation-hero">
        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-file-earmark-text"></i>
                DOCUMENTS
            </span>

            <h1>
                {{ $documentType->name }}
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

                <span>{{ $formation->name }}</span>

                <i class="bi bi-chevron-right"></i>

                <span>{{ $programme->name }}</span>

                <i class="bi bi-chevron-right"></i>

                <span>{{ $specialite->name }}</span>

                <i class="bi bi-chevron-right"></i>

                <span>{{ $niveau->name }}</span>

                <i class="bi bi-chevron-right"></i>

                <span>{{ $module->name }}</span>

                <i class="bi bi-chevron-right"></i>

                <strong>{{ $documentType->name }}</strong>

            </div>


            {{-- EN-TÊTE --}}

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        DOCUMENTS PÉDAGOGIQUES
                    </span>

                    <h2>
                        {{ $documentType->name }}
                    </h2>

                    <p class="section-description">
                        Documents disponibles pour le module
                        <strong>{{ $module->name }}</strong>.
                    </p>

                </div>

                <span class="class-count">

                    {{ $documents->total() }}

                    document{{ $documents->total() > 1 ? 's' : '' }}

                </span>

            </div>


            {{-- DOCUMENTS --}}

            @if($documents->isNotEmpty())

                <div class="classes-grid">

                    @foreach($documents as $document)

                        <a
                            href="{{ route('vitrine.professionnel.ens.show', [
                                'programmeSlug' => $programme->slug,
                                'specialiteSlug' => $specialite->slug,
                                'niveauSlug' => $niveau->slug,
                                'moduleSlug' => $module->slug,
                                'typeSlug' => $documentType->slug,
                                'documentSlug' => $document->slug
                            ]) }}"
                            class="class-card"
                        >

                            <div class="class-card-top">

                                <div class="class-icon">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </div>

                                <div class="class-arrow">
                                    <i class="bi bi-arrow-up-right"></i>
                                </div>

                            </div>


                            <div class="class-card-body">

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

                            </div>


                            <div class="class-card-footer">

                                <span>

                                    <i class="bi bi-file-earmark-pdf"></i>

                                    {{ strtoupper($document->file_extension ?? 'PDF') }}

                                    <span class="mx-1">•</span>

                                    <i class="bi bi-eye"></i>

                                    {{ $document->views }}

                                </span>

                                <i class="bi bi-arrow-right"></i>

                            </div>

                        </a>

                    @endforeach

                </div>


                {{-- PAGINATION --}}

                <div class="documents-pagination">

                    {{ $documents->links() }}

                </div>

            @else

                {{-- EMPTY STATE --}}

                <div class="empty-state">

                    <div class="empty-icon">
                        <i class="bi bi-folder-x"></i>
                    </div>

                    <h3>
                        Aucun document disponible
                    </h3>

                    <p>
                        Aucun document publié n'est actuellement
                        disponible pour le module
                        <strong>{{ $module->name }}</strong>
                        dans cette catégorie.
                    </p>

                </div>

            @endif


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

                    Retour aux types de documents

                </a>

            </div>

        </div>

    </section>

</div>

@endsection