@extends('layouts.journaliste_app')

@section('title', 'Mes documents')

@section('content')

<div class="documents-page">

    <div class="documents-container">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}

        <div class="documents-header">

            <div class="documents-header-content">

                <div class="documents-header-icon">
                    📚
                </div>

                <div>
                    <h1>
                        Mes documents
                    </h1>

                    <p>
                        Gérez et suivez tous vos documents
                    </p>
                </div>

            </div>

            <a
                href="{{ route('journaliste.documents.create') }}"
                class="documents-btn documents-btn-primary"
            >
                <span>＋</span>
                Nouveau document
            </a>

        </div>


        {{-- =====================================================
             MESSAGES
        ====================================================== --}}

        @if(session('success'))

            <div class="documents-alert documents-alert-success">

                <span class="documents-alert-icon">
                    ✓
                </span>

                <div>
                    {{ session('success') }}
                </div>

            </div>

        @endif


        @if(session('error'))

            <div class="documents-alert documents-alert-danger">

                <span class="documents-alert-icon">
                    !
                </span>

                <div>
                    {{ session('error') }}
                </div>

            </div>

        @endif


        {{-- =====================================================
             CARTE TABLEAU
        ====================================================== --}}

        <div class="documents-card">

            {{-- En-tête de carte --}}

            <div class="documents-card-header">

                <div>

                    <h2>
                        Liste de mes documents
                    </h2>

                    <p>
                        Retrouvez ici tous les documents que vous avez créés.
                    </p>

                </div>

                <div class="documents-count">

                    {{ $documents->total() }}

                    <span>
                        document{{ $documents->total() > 1 ? 's' : '' }}
                    </span>

                </div>

            </div>


            {{-- =================================================
                 TABLEAU
            ================================================== --}}

            <div class="documents-table-wrapper">

                <table class="documents-table">

                    <thead>

                        <tr>

                            <th>
                                Document
                            </th>

                            <th>
                                Formation
                            </th>

                            <th>
                                Filière
                            </th>

                            <th>
                                Niveau
                            </th>

                            <th>
                                Matière / Module
                            </th>

                            <th>
                                Accès
                            </th>

                            <th>
                                Prix
                            </th>

                            <th>
                                Vues
                            </th>

                            <th class="documents-actions-header">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($documents as $document)

                            <tr>

                                {{-- DOCUMENT --}}

                                <td class="documents-title-cell">

                                    <div class="documents-title-wrapper">

                                        <div class="documents-file-icon">
                                            📄
                                        </div>

                                        <div class="documents-title-content">

                                            <div class="documents-title">

                                                {{ $document->title }}

                                            </div>


                                            @if($document->documentType)

                                                <div class="documents-type">

                                                    {{ $document->documentType->name }}

                                                </div>

                                            @endif


                                            {{-- STATUT --}}

                                            <div class="documents-status">

                                                @if($document->status === 'published')

                                                    <span class="documents-status-badge documents-status-published">
                                                        ✓ Publié
                                                    </span>

                                                @elseif($document->status === 'pending')

                                                    <span class="documents-status-badge documents-status-pending">
                                                        ⏳ En attente
                                                    </span>

                                                @elseif($document->status === 'rejected')

                                                    <span class="documents-status-badge documents-status-rejected">
                                                        ✕ Rejeté
                                                    </span>

                                                @else

                                                    <span class="documents-status-badge documents-status-draft">
                                                        📝 Brouillon
                                                    </span>

                                                @endif

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                {{-- FORMATION --}}

                                <td class="documents-data-cell">

                                    {{ $document->formation?->name ?? '—' }}

                                </td>


                                {{-- FILIERE --}}

                                <td class="documents-data-cell">

                                    {{ $document->filiere?->name ?? '—' }}

                                </td>


                                {{-- NIVEAU --}}

                                <td class="documents-data-cell">

                                    {{ $document->level?->name ?? '—' }}

                                </td>


                                {{-- MATIERE --}}

                                <td class="documents-data-cell">

                                    {{ $document->subject?->name ?? '—' }}

                                </td>


                                {{-- ACCÈS --}}

                                <td>

                                    @if($document->access_type === 'free')

                                        <span class="documents-access documents-access-free">

                                            <span class="documents-access-dot"></span>

                                            Gratuit

                                        </span>

                                    @else

                                        <span class="documents-access documents-access-premium">

                                            <span class="documents-access-dot"></span>

                                            Premium

                                        </span>

                                    @endif

                                </td>


                                {{-- PRIX --}}

                                <td class="documents-price">

                                    @if(
                                        $document->access_type === 'premium'
                                        && $document->price
                                    )

                                        {{ number_format(
                                            (float) $document->price,
                                            0,
                                            ',',
                                            ' '
                                        ) }}

                                        <small>FCFA</small>

                                    @else

                                        <span class="documents-empty">
                                            —
                                        </span>

                                    @endif

                                </td>


                                {{-- VUES --}}

                                <td class="documents-views">

                                    <span>
                                        👁
                                    </span>

                                    {{ $document->views ?? 0 }}

                                </td>


                                {{-- ACTIONS --}}

                                <td>

                                    <div class="documents-actions">


                                        {{-- VOIR --}}

                                        <a
                                            href="{{ route(
                                                'journaliste.documents.show',
                                                $document
                                            ) }}"
                                            class="documents-action documents-action-view"
                                            title="Voir le document"
                                        >

                                            👁

                                            <span>
                                                Voir
                                            </span>

                                        </a>


                                        {{-- MODIFIER --}}

                                        <a
                                            href="{{ route(
                                                'journaliste.documents.edit',
                                                $document
                                            ) }}"
                                            class="documents-action documents-action-edit"
                                            title="Modifier le document"
                                        >

                                            ✏

                                            <span>
                                                Modifier
                                            </span>

                                        </a>


                                        {{-- SUPPRIMER --}}

                                        <form
                                            action="{{ route(
                                                'journaliste.documents.destroy',
                                                $document
                                            ) }}"
                                            method="POST"
                                            class="documents-delete-form"
                                            onsubmit="return confirm(
                                                'Voulez-vous vraiment supprimer ce document ?'
                                            );"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="documents-action documents-action-delete"
                                                title="Supprimer le document"
                                            >

                                                🗑

                                                <span>
                                                    Supprimer
                                                </span>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="9"
                                    class="documents-empty-row"
                                >

                                    <div class="documents-empty-icon">
                                        📂
                                    </div>

                                    <h3>
                                        Aucun document trouvé
                                    </h3>

                                    <p>
                                        Vous n'avez encore créé aucun document.
                                    </p>

                                    <a
                                        href="{{ route(
                                            'journaliste.documents.create'
                                        ) }}"
                                        class="documents-empty-btn"
                                    >
                                        ＋ Créer mon premier document
                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =================================================
                 PAGINATION
            ================================================== --}}

            @if($documents->hasPages())

                <div class="documents-pagination">

                    {{ $documents->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection