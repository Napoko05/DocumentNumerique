@extends('layouts.journaliste_app')

@section('page-title', 'Statistiques')

@section('content')

<div class="journalist-page">

    {{-- EN-TÊTE --}}
    <div class="page-header">

        <div>
            <span class="page-kicker">
                ANALYSE
            </span>

            <h1>
                Statistiques
            </h1>

            <p>
                Suivez les performances de vos documents et leur visibilité.
            </p>
        </div>

        <a href="{{ route('journaliste.documents.index') }}"
           class="btn-primary-custom">
            <i class="fas fa-file-alt"></i>
            Mes documents
        </a>

    </div>


    {{-- STATISTIQUES PRINCIPALES --}}
    <div class="stats-grid">

        <div class="stat-card blue">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>

            <div class="stat-content">
                <span>Total documents</span>
                <strong>
                    {{ number_format($totalDocuments, 0, ',', ' ') }}
                </strong>
            </div>
        </div>


        <div class="stat-card green">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div class="stat-content">
                <span>Documents publiés</span>
                <strong>
                    {{ number_format($publishedDocuments, 0, ',', ' ') }}
                </strong>
            </div>
        </div>


        <div class="stat-card orange">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>

            <div class="stat-content">
                <span>En attente</span>
                <strong>
                    {{ number_format($pendingDocuments, 0, ',', ' ') }}
                </strong>
            </div>
        </div>


        <div class="stat-card red">
            <div class="stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>

            <div class="stat-content">
                <span>Rejetés</span>
                <strong>
                    {{ number_format($rejectedDocuments, 0, ',', ' ') }}
                </strong>
            </div>
        </div>

    </div>


    {{-- DEUXIÈME LIGNE --}}
    <div class="stats-grid secondary-stats">

        <div class="stat-card purple">
            <div class="stat-icon">
                <i class="fas fa-edit"></i>
            </div>

            <div class="stat-content">
                <span>Brouillons</span>
                <strong>
                    {{ number_format($draftDocuments, 0, ',', ' ') }}
                </strong>
            </div>
        </div>


        <div class="stat-card cyan">
            <div class="stat-icon">
                <i class="fas fa-unlock"></i>
            </div>

            <div class="stat-content">
                <span>Documents gratuits</span>
                <strong>
                    {{ number_format($freeDocuments, 0, ',', ' ') }}
                </strong>
            </div>
        </div>


        <div class="stat-card gold">
            <div class="stat-icon">
                <i class="fas fa-gem"></i>
            </div>

            <div class="stat-content">
                <span>Documents premium</span>
                <strong>
                    {{ number_format($premiumDocuments, 0, ',', ' ') }}
                </strong>
            </div>
        </div>


        <div class="stat-card dark">
            <div class="stat-icon">
                <i class="fas fa-eye"></i>
            </div>

            <div class="stat-content">
                <span>Total des vues</span>
                <strong>
                    {{ number_format($totalViews, 0, ',', ' ') }}
                </strong>
            </div>
        </div>

    </div>


    {{-- VUES PAR DOCUMENT --}}
    <div class="content-card">

        <div class="content-card-header">

            <div>
                <h2>
                    Performance des documents
                </h2>

                <p>
                    Classement de vos documents selon leur nombre de vues.
                </p>
            </div>

            <span class="header-badge">
                {{ $viewsByDocument->count() }} document(s)
            </span>

        </div>


        @if($viewsByDocument->isEmpty())

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fas fa-chart-line"></i>
                </div>

                <h3>
                    Aucune donnée disponible
                </h3>

                <p>
                    Les statistiques apparaîtront lorsque vous aurez publié des documents.
                </p>

            </div>

        @else

            <div class="table-wrapper">

                <table class="professional-table">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Document</th>
                            <th>Vues</th>
                            <th>Performance</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($viewsByDocument as $index => $document)

                            <tr>

                                <td>
                                    <span class="table-number">
                                        {{ $index + 1 }}
                                    </span>
                                </td>

                                <td>
                                    <div class="document-name">
                                        <div class="document-icon">
                                            <i class="fas fa-file-pdf"></i>
                                        </div>

                                        <span>
                                            {{ $document->title }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <strong>
                                        {{ number_format($document->views ?? 0, 0, ',', ' ') }}
                                    </strong>
                                </td>

                                <td>

                                    @php
                                        $maxViews = $viewsByDocument->max('views') ?: 1;
                                        $percentage = (($document->views ?? 0) / $maxViews) * 100;
                                    @endphp

                                    <div class="performance">

                                        <div class="performance-bar">
                                            <span style="width: {{ $percentage }}%;"></span>
                                        </div>

                                        <small>
                                            {{ round($percentage) }}%
                                        </small>

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

@endsection