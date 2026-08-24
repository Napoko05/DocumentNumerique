@extends('layouts.journaliste_app')

@section('page-title', 'Mes documents')

@section('content')

<div class="journalist-documents-page">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="documents-page-header">

        <div class="documents-page-title">

            <span class="documents-eyebrow">
                ESPACE JOURNALISTE
            </span>

            <h1>
                Mes documents
            </h1>

            <p>
                Gérez vos documents, publications et contenus pédagogiques.
            </p>

        </div>

        <div class="documents-page-actions">

            <a
                href="{{ route('journaliste.dashboard') }}"
                class="documents-btn documents-btn-secondary"
            >
                <i class="bi bi-arrow-left"></i>
                Tableau de bord
            </a>

            <a
                href="{{ route('journaliste.documents.create') }}"
                class="documents-btn documents-btn-primary"
            >
                <i class="bi bi-plus-lg"></i>
                Nouveau document
            </a>

        </div>

    </div>


    {{-- =========================================================
         MESSAGES
    ========================================================== --}}

    @if(session('success'))

        <div class="documents-alert documents-alert-success">

            <div class="documents-alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="documents-alert-content">
                {{ session('success') }}
            </div>

            <button
                type="button"
                class="documents-alert-close"
                onclick="this.parentElement.remove()"
                aria-label="Fermer"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="documents-alert documents-alert-danger">

            <div class="documents-alert-icon">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>

            <div class="documents-alert-content">
                {{ session('error') }}
            </div>

            <button
                type="button"
                class="documents-alert-close"
                onclick="this.parentElement.remove()"
                aria-label="Fermer"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>

    @endif


    {{-- =========================================================
         BARRE D'INFORMATIONS
    ========================================================== --}}

    <div class="documents-toolbar">

        <div class="documents-toolbar-left">

            <div class="documents-toolbar-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>

            <div>

                <strong>
                    Mes publications
                </strong>

                <span>
                    {{ $documents->total() }}
                    document{{ $documents->total() > 1 ? 's' : '' }}
                </span>

            </div>

        </div>


        <div class="documents-toolbar-page">

            Page

            <strong>
                {{ $documents->currentPage() }}
            </strong>

            sur

            <strong>
                {{ $documents->lastPage() }}
            </strong>

        </div>

    </div>


    {{-- =========================================================
         AUCUN DOCUMENT
    ========================================================== --}}

    @if($documents->isEmpty())

        <div class="documents-empty">

            <div class="documents-empty-icon">
                <i class="bi bi-file-earmark-x"></i>
            </div>

            <h2>
                Aucun document
            </h2>

            <p>
                Vous n'avez encore ajouté aucun document.
                Commencez dès maintenant à enrichir la plateforme.
            </p>

            <a
                href="{{ route('journaliste.documents.create') }}"
                class="documents-btn documents-btn-primary"
            >
                <i class="bi bi-plus-lg"></i>
                Ajouter mon premier document
            </a>

        </div>

    @else

        {{-- =====================================================
             TABLEAU
        ====================================================== --}}

        <div class="documents-table-card">

            <div class="documents-table-scroll">

                <table class="documents-table">

                    <thead>

                        <tr>

                            <th>
                                Document
                            </th>

                            <th>
                                Formation / Filière
                            </th>

                            <th>
                                Niveau / Module
                            </th>

                            <th>
                                Type
                            </th>

                            <th>
                                Accès
                            </th>

                            <th>
                                Statut
                            </th>

                            <th class="documents-text-right">
                                Vues
                            </th>

                            <th class="documents-text-right">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @foreach($documents as $document)

                        <tr>

                            {{-- =====================================
                                 DOCUMENT
                            ====================================== --}}

                            <td>

                                <div class="document-main">

                                    <div class="document-icon">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>

                                    <div class="document-main-info">

                                        <strong
                                            title="{{ $document->title }}"
                                        >
                                            {{ \Illuminate\Support\Str::limit(
                                                $document->title,
                                                55
                                            ) }}
                                        </strong>

                                        <small>
                                            {{ $document->documentType?->name
                                                ?? 'Type non renseigné' }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- =====================================
                                 FORMATION / FILIÈRE
                            ====================================== --}}

                            <td>

                                <div class="document-hierarchy">

                                    @if($document->formation)

                                        <strong>
                                            {{ $document->formation->name }}
                                        </strong>

                                    @else

                                        <span class="document-muted">
                                            Aucune formation
                                        </span>

                                    @endif


                                    @if($document->filiere)

                                        <small>
                                            {{ $document->filiere->name }}
                                        </small>

                                    @else

                                        <small class="document-muted">
                                            Aucune filière
                                        </small>

                                    @endif

                                </div>

                            </td>


                            {{-- =====================================
                                 NIVEAU / MODULE
                            ====================================== --}}

                            <td>

                                <div class="document-hierarchy">

                                    <strong>
                                        {{ $document->level?->name ?? '—' }}
                                    </strong>

                                    <small>
                                        {{ $document->subject?->name
                                            ?? 'Aucun module' }}
                                    </small>

                                </div>

                            </td>


                            {{-- =====================================
                                 TYPE
                            ====================================== --}}

                            <td>

                                <span class="document-type">
                                    <i class="bi bi-file-earmark"></i>

                                    {{ $document->documentType?->name
                                        ?? 'Non renseigné' }}

                                </span>

                            </td>


                            {{-- =====================================
                                 ACCÈS
                            ====================================== --}}

                            <td>

                                @if($document->access_type === 'premium')

                                    <span class="document-badge document-badge-premium">

                                        <i class="bi bi-gem"></i>

                                        Premium

                                    </span>

                                @else

                                    <span class="document-badge document-badge-free">

                                        <i class="bi bi-unlock"></i>

                                        Gratuit

                                    </span>

                                @endif

                            </td>


                            {{-- =====================================
                                 STATUT
                            ====================================== --}}

                            <td>

                                @if($document->status === 'published')

                                    <span class="document-badge document-badge-published">

                                        <i class="bi bi-check-circle-fill"></i>

                                        Publié

                                    </span>

                                @elseif($document->status === 'pending')

                                    <span class="document-badge document-badge-pending">

                                        <i class="bi bi-clock-fill"></i>

                                        En attente

                                    </span>

                                @elseif($document->status === 'rejected')

                                    <span class="document-badge document-badge-rejected">

                                        <i class="bi bi-x-circle-fill"></i>

                                        Rejeté

                                    </span>

                                @else

                                    <span class="document-badge document-badge-draft">

                                        <i class="bi bi-pencil-fill"></i>

                                        Brouillon

                                    </span>

                                @endif

                            </td>


                            {{-- =====================================
                                 VUES
                            ====================================== --}}

                            <td class="documents-text-right">

                                <div class="document-views">

                                    <i class="bi bi-eye"></i>

                                    <strong>
                                        {{ number_format(
                                            $document->views ?? 0,
                                            0,
                                            ',',
                                            ' '
                                        ) }}
                                    </strong>

                                </div>

                            </td>


                            {{-- =====================================
                                 ACTIONS
                            ====================================== --}}

                            <td>

                                <div class="document-actions">

                                    {{-- VOIR --}}

                                    <a
                                        href="{{ route(
                                            'journaliste.documents.show',
                                            $document
                                        ) }}"
                                        class="document-action document-action-view"
                                        title="Voir le document"
                                        aria-label="Voir"
                                    >
                                        <i class="bi bi-eye"></i>
                                    </a>


                                    {{-- MODIFIER --}}

                                    <a
                                        href="{{ route(
                                            'journaliste.documents.edit',
                                            $document
                                        ) }}"
                                        class="document-action document-action-edit"
                                        title="Modifier le document"
                                        aria-label="Modifier"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </a>


                                    {{-- SUPPRIMER --}}

                                    <form
                                        action="{{ route(
                                            'journaliste.documents.destroy',
                                            $document
                                        ) }}"
                                        method="POST"
                                        class="document-delete-form"
                                        onsubmit="return confirm(
                                            'Voulez-vous vraiment supprimer ce document ?'
                                        );"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="document-action document-action-delete"
                                            title="Supprimer le document"
                                            aria-label="Supprimer"
                                        >
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =====================================================
             PAGINATION
        ====================================================== --}}

        @if($documents->hasPages())

            <div class="documents-pagination">

                <div class="documents-pagination-summary">

                    Affichage de

                    <strong>
                        {{ $documents->firstItem() }}
                    </strong>

                    à

                    <strong>
                        {{ $documents->lastItem() }}
                    </strong>

                    sur

                    <strong>
                        {{ $documents->total() }}
                    </strong>

                    documents

                </div>


                <div class="documents-pagination-links">

                    {{-- PRÉCÉDENT --}}

                    @if($documents->onFirstPage())

                        <span class="documents-page-disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>

                    @else

                        <a
                            href="{{ $documents->previousPageUrl() }}"
                            class="documents-page-link"
                            aria-label="Page précédente"
                        >
                            <i class="bi bi-chevron-left"></i>
                        </a>

                    @endif


                    {{-- PAGES --}}

                    @foreach(
                        $documents->getUrlRange(
                            max(1, $documents->currentPage() - 2),
                            min(
                                $documents->lastPage(),
                                $documents->currentPage() + 2
                            )
                        ) as $page => $url
                    )

                        @if($page == $documents->currentPage())

                            <span class="documents-page-current">
                                {{ $page }}
                            </span>

                        @else

                            <a
                                href="{{ $url }}"
                                class="documents-page-link"
                            >
                                {{ $page }}
                            </a>

                        @endif

                    @endforeach


                    {{-- SUIVANT --}}

                    @if($documents->hasMorePages())

                        <a
                            href="{{ $documents->nextPageUrl() }}"
                            class="documents-page-link"
                            aria-label="Page suivante"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </a>

                    @else

                        <span class="documents-page-disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>

                    @endif

                </div>

            </div>

        @endif

    @endif

</div>

@endsection