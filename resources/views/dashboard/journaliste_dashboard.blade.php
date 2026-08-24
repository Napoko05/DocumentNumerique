@extends('layouts.journaliste_app')

@section('page-title', 'Tableau de bord Journaliste')

@section('content')

<div class="journalist-dashboard">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="jd-header">

        <div class="jd-header-content">

            <div class="jd-eyebrow">
                ESPACE JOURNALISTE
            </div>

            <h1 class="jd-header-title">
                Tableau de bord
            </h1>

            <p class="jd-header-description">
                Bienvenue
                <strong>
                    {{ $staff->prenom ?? '' }}
                    {{ $staff->nom ?? '' }}
                </strong>
            </p>

        </div>

        <div class="jd-header-action">

            <a href="{{ route('journaliste.documents.create') }}"
               class="jd-btn-primary">

                <i class="bi bi-plus-lg"></i>

                Nouveau document

            </a>

        </div>

    </div>


    {{-- =========================================================
         STATISTIQUES PRINCIPALES
    ========================================================== --}}

    <div class="jd-stat-grid">

        {{-- TOTAL DOCUMENTS --}}
        <div class="jd-stat-card">

            <div class="jd-stat-body">

                <div class="jd-stat-info">

                    <div class="jd-stat-label">
                        Documents
                    </div>

                    <h2 class="jd-stat-value">
                        {{ $totalDocuments }}
                    </h2>

                    <div class="jd-stat-description">
                        Total publié et en gestion
                    </div>

                </div>

                <div class="jd-stat-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

            </div>

        </div>


        {{-- GRATUITS --}}
        <div class="jd-stat-card success">

            <div class="jd-stat-body">

                <div class="jd-stat-info">

                    <div class="jd-stat-label">
                        Documents gratuits
                    </div>

                    <h2 class="jd-stat-value">
                        {{ $freeDocuments }}
                    </h2>

                    <div class="jd-stat-description">
                        Accès libre
                    </div>

                </div>

                <div class="jd-stat-icon">
                    <i class="bi bi-unlock"></i>
                </div>

            </div>

        </div>


        {{-- PREMIUM --}}
        <div class="jd-stat-card warning">

            <div class="jd-stat-body">

                <div class="jd-stat-info">

                    <div class="jd-stat-label">
                        Documents premium
                    </div>

                    <h2 class="jd-stat-value">
                        {{ $premiumDocuments }}
                    </h2>

                    <div class="jd-stat-description">
                        Contenus payants
                    </div>

                </div>

                <div class="jd-stat-icon">
                    <i class="bi bi-gem"></i>
                </div>

            </div>

        </div>


        {{-- VUES --}}
        <div class="jd-stat-card danger">

            <div class="jd-stat-body">

                <div class="jd-stat-info">

                    <div class="jd-stat-label">
                        Total des vues
                    </div>

                    <h2 class="jd-stat-value">
                        {{ number_format($totalViews ?? 0, 0, ',', ' ') }}
                    </h2>

                    <div class="jd-stat-description">
                        Consultations
                    </div>

                </div>

                <div class="jd-stat-icon">
                    <i class="bi bi-eye"></i>
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         ÉTAT DES DOCUMENTS
    ========================================================== --}}

    <div class="jd-panel">

        <div class="jd-panel-header">

            <div>

                <h2 class="jd-panel-title">
                    État des documents
                </h2>

                <p class="jd-panel-subtitle">
                    Suivi de vos publications
                </p>

            </div>

        </div>

        <div class="jd-panel-body">

            <div class="jd-status-grid">

                {{-- PUBLIÉS --}}
                <div class="jd-status-card success">

                    <div class="jd-status-icon">
                        <i class="bi bi-check-lg"></i>
                    </div>

                    <div>

                        <h3 class="jd-status-value">
                            {{ $publishedDocuments }}
                        </h3>

                        <div class="jd-status-label">
                            Publiés
                        </div>

                    </div>

                </div>


                {{-- EN ATTENTE --}}
                <div class="jd-status-card warning">

                    <div class="jd-status-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>

                    <div>

                        <h3 class="jd-status-value">
                            {{ $pendingDocuments }}
                        </h3>

                        <div class="jd-status-label">
                            En attente
                        </div>

                    </div>

                </div>


                {{-- BROUILLONS --}}
                <div class="jd-status-card secondary">

                    <div class="jd-status-icon">
                        <i class="bi bi-file-earmark"></i>
                    </div>

                    <div>

                        <h3 class="jd-status-value">
                            {{ $draftDocuments }}
                        </h3>

                        <div class="jd-status-label">
                            Brouillons
                        </div>

                    </div>

                </div>


                {{-- REJETÉS --}}
                <div class="jd-status-card danger">

                    <div class="jd-status-icon">
                        <i class="bi bi-x-lg"></i>
                    </div>

                    <div>

                        <h3 class="jd-status-value">
                            {{ $rejectedDocuments }}
                        </h3>

                        <div class="jd-status-label">
                            Rejetés
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         ACTIONS RAPIDES
    ========================================================== --}}

    <div class="jd-panel">

        <div class="jd-panel-header">

            <div>

                <h2 class="jd-panel-title">
                    Actions rapides
                </h2>

                <p class="jd-panel-subtitle">
                    Accédez rapidement aux principales fonctionnalités.
                </p>

            </div>

        </div>

        <div class="jd-panel-body">

            <div class="jd-actions-grid">


                {{-- NOUVEAU DOCUMENT --}}
                <a href="{{ route('journaliste.documents.create') }}"
                   class="jd-action primary">

                    <div class="jd-action-top">

                        <div class="jd-action-icon">
                            <i class="bi bi-file-earmark-plus"></i>
                        </div>

                        <i class="bi bi-arrow-right jd-action-arrow"></i>

                    </div>

                    <h3 class="jd-action-title">
                        Nouveau document
                    </h3>

                    <p class="jd-action-description">
                        Ajouter une nouvelle publication.
                    </p>

                </a>


                {{-- MES DOCUMENTS --}}
                <a href="{{ route('journaliste.documents.index') }}"
                   class="jd-action success">

                    <div class="jd-action-top">

                        <div class="jd-action-icon">
                            <i class="bi bi-folder2-open"></i>
                        </div>

                        <i class="bi bi-arrow-right jd-action-arrow"></i>

                    </div>

                    <h3 class="jd-action-title">
                        Mes documents
                    </h3>

                    <p class="jd-action-description">
                        Gérer mes publications.
                    </p>

                </a>


                {{-- UTILISATEURS --}}
                <a href="{{ route('journaliste.users') }}"
                   class="jd-action violet">

                    <div class="jd-action-top">

                        <div class="jd-action-icon">
                            <i class="bi bi-people"></i>
                        </div>

                        <i class="bi bi-arrow-right jd-action-arrow"></i>

                    </div>

                    <h3 class="jd-action-title">
                        Utilisateurs
                    </h3>

                    <p class="jd-action-description">
                        Consulter les utilisateurs de la plateforme.
                    </p>

                </a>

            </div>

        </div>

    </div>


    {{-- =========================================================
         REVENUS / TÉLÉCHARGEMENTS
    ========================================================== --}}

    <div class="jd-revenue-grid">


        {{-- REVENUS --}}
        <div class="jd-revenue-card">

            <div class="jd-revenue-content">

                <div class="jd-revenue-icon warning">
                    <i class="bi bi-cash-coin"></i>
                </div>

                <div>

                    <p class="jd-revenue-label">
                        Revenus
                    </p>

                    <h3 class="jd-revenue-value">
                        {{ number_format($revenue ?? 0, 0, ',', ' ') }}
                        FCFA
                    </h3>

                </div>

            </div>

            @if(Route::has('journaliste.revenues'))

                <a href="{{ route('journaliste.revenues') }}"
                   class="jd-revenue-link">

                    Voir les revenus
                    <i class="bi bi-arrow-right"></i>

                </a>

            @else

                <span class="jd-revenue-link">
                    Les revenus seront disponibles ici.
                </span>

            @endif

        </div>


        {{-- TÉLÉCHARGEMENTS --}}
        <div class="jd-revenue-card">

            <div class="jd-revenue-content">

                <div class="jd-revenue-icon primary">
                    <i class="bi bi-download"></i>
                </div>

                <div>

                    <p class="jd-revenue-label">
                        Documents téléchargés
                    </p>

                    <h3 class="jd-revenue-value">
                        {{ number_format($totalDownloads ?? 0, 0, ',', ' ') }}
                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         DOCUMENTS RÉCENTS
    ========================================================== --}}

    <div class="jd-panel">

        <div class="jd-panel-header">

            <div>

                <h2 class="jd-panel-title">
                    Mes documents récents
                </h2>

                <p class="jd-panel-subtitle">
                    Les 10 derniers documents ajoutés.
                </p>

            </div>

            <a href="{{ route('journaliste.documents.index') }}"
               class="jd-revenue-link">

                Voir tous
                <i class="bi bi-arrow-right"></i>

            </a>

        </div>


        <div class="jd-panel-body">

            @if($recentDocuments->isEmpty())

                <div class="jd-empty">

                    <div class="jd-empty-icon">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>

                    <h3 class="jd-empty-title">
                        Aucun document
                    </h3>

                    <p class="jd-empty-text">
                        Commencez par ajouter votre premier document.
                    </p>

                    <a href="{{ route('journaliste.documents.create') }}"
                       class="jd-btn-primary">

                        <i class="bi bi-plus-lg"></i>

                        Ajouter un document

                    </a>

                </div>

            @else

                <div class="jd-table-wrapper">

                    <table class="jd-table">

                        <thead>

                            <tr>

                                <th>Document</th>
                                <th>Formation / Filière</th>
                                <th>Niveau / Module</th>
                                <th>Accès</th>
                                <th>Statut</th>
                                <th>Vues</th>
                                <th>Actions</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($recentDocuments as $doc)

                                <tr>

                                    {{-- DOCUMENT --}}
                                    <td>

                                        <div>

                                            <p class="jd-document-title"
                                               title="{{ $doc->title }}">

                                                {{ \Illuminate\Support\Str::limit(
                                                    $doc->title,
                                                    45
                                                ) }}

                                            </p>

                                            <div class="jd-document-type">

                                                {{ $doc->documentType?->name
                                                    ?? 'Type non renseigné' }}

                                            </div>

                                        </div>

                                    </td>


                                    {{-- FORMATION / FILIÈRE --}}
                                    <td>

                                        <div>

                                            @if($doc->formation)

                                                <div class="jd-document-title">

                                                    {{ $doc->formation->name }}

                                                </div>

                                            @endif

                                            @if($doc->filiere)

                                                <div class="jd-document-type">

                                                    {{ $doc->filiere->name }}

                                                </div>

                                            @else

                                                <div class="jd-document-type">
                                                    Aucune filière
                                                </div>

                                            @endif

                                        </div>

                                    </td>


                                    {{-- NIVEAU / MODULE --}}
                                    <td>

                                        <div>

                                            <div class="jd-document-title">

                                                {{ $doc->level?->name ?? '—' }}

                                            </div>

                                            <div class="jd-document-type">

                                                {{ $doc->subject?->name
                                                    ?? 'Aucun module' }}

                                            </div>

                                        </div>

                                    </td>


                                    {{-- ACCÈS --}}
                                    <td>

                                        @if($doc->access_type === 'premium')

                                            <span class="jd-badge jd-badge-warning">

                                                <i class="bi bi-gem"></i>
                                                Premium

                                            </span>

                                        @else

                                            <span class="jd-badge jd-badge-success">

                                                <i class="bi bi-unlock"></i>
                                                Gratuit

                                            </span>

                                        @endif

                                    </td>


                                    {{-- STATUT --}}
                                    <td>

                                        @if($doc->status === 'published')

                                            <span class="jd-badge jd-badge-success">

                                                <i class="bi bi-check-lg"></i>
                                                Publié

                                            </span>

                                        @elseif($doc->status === 'pending')

                                            <span class="jd-badge jd-badge-warning">

                                                <i class="bi bi-hourglass-split"></i>
                                                En attente

                                            </span>

                                        @elseif($doc->status === 'rejected')

                                            <span class="jd-badge jd-badge-danger">

                                                <i class="bi bi-x-lg"></i>
                                                Rejeté

                                            </span>

                                        @else

                                            <span class="jd-badge jd-badge-secondary">

                                                <i class="bi bi-pencil"></i>
                                                Brouillon

                                            </span>

                                        @endif

                                    </td>


                                    {{-- VUES --}}
                                    <td>

                                        <strong>

                                            {{ number_format(
                                                $doc->views ?? 0,
                                                0,
                                                ',',
                                                ' '
                                            ) }}

                                        </strong>

                                    </td>


                                    {{-- ACTIONS --}}
                                    <td>

                                        <div class="jd-table-actions">

                                            @if(Route::has('journaliste.documents.show'))

                                                <a href="{{ route(
                                                    'journaliste.documents.show',
                                                    $doc
                                                ) }}"
                                                   class="jd-table-action"
                                                   title="Voir">

                                                    <i class="bi bi-eye"></i>

                                                </a>

                                            @endif


                                            @if(Route::has('journaliste.documents.edit'))

                                                <a href="{{ route(
                                                    'journaliste.documents.edit',
                                                    $doc
                                                ) }}"
                                                   class="jd-table-action"
                                                   title="Modifier">

                                                    <i class="bi bi-pencil"></i>

                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection