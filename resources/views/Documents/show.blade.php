@extends('layouts.journaliste_app')

@section('title', $document->title)

@section('content')

<div class="document-detail-page">

    <div class="document-detail-container">

        {{-- =========================
             HEADER
        ========================== --}}
        <div class="document-detail-header">

            <div class="document-header-icon">
                📄
            </div>

            <div class="document-header-content">
                <h1>{{ $document->title }}</h1>

                <p>
                    Détails complets du document
                </p>
            </div>

        </div>


        {{-- =========================
             CONTENU PRINCIPAL
        ========================== --}}
        <div class="document-detail-card">

            <div class="document-detail-body">

                {{-- =========================
                     INFORMATIONS
                ========================== --}}
                <section class="document-section">

                    <div class="document-section-title">
                        <span class="section-icon">📚</span>
                        <h2>Informations académiques</h2>
                    </div>

                    <div class="document-info-grid">

                        {{-- Formation --}}
                        <div class="document-info-item">

                            <div class="info-item-label">
                                🎓 Formation
                            </div>

                            <div class="info-item-value">
                                {{ $document->formation?->name ?? 'Non renseignée' }}
                            </div>

                        </div>


                        {{-- Filière --}}
                        <div class="document-info-item">

                            <div class="info-item-label">
                                🏛️ Filière
                            </div>

                            <div class="info-item-value">
                                {{ $document->filiere?->name ?? 'Non renseignée' }}
                            </div>

                        </div>


                        {{-- Niveau --}}
                        <div class="document-info-item">

                            <div class="info-item-label">
                                🎓 Niveau / Classe
                            </div>

                            <div class="info-item-value">
                                {{ $document->level?->name ?? 'Non renseigné' }}
                            </div>

                        </div>


                        {{-- Matière --}}
                        <div class="document-info-item">

                            <div class="info-item-label">
                                📖 Matière / Module
                            </div>

                            <div class="info-item-value">
                                {{ $document->subject?->name ?? 'Non renseigné' }}
                            </div>

                        </div>


                        {{-- Type --}}
                        <div class="document-info-item">

                            <div class="info-item-label">
                                📄 Type de document
                            </div>

                            <div class="info-item-value">
                                {{ $document->documentType?->name ?? 'Non renseigné' }}
                            </div>

                        </div>


                        {{-- Vues --}}
                        <div class="document-info-item">

                            <div class="info-item-label">
                                👁️ Nombre de vues
                            </div>

                            <div class="info-item-value">
                                {{ $document->views ?? 0 }}
                            </div>

                        </div>

                    </div>

                </section>


                <div class="document-divider"></div>


                {{-- =========================
                     ACCÈS
                ========================== --}}
                <section class="document-section">

                    <div class="document-section-title">
                        <span class="section-icon">🔐</span>
                        <h2>Accès au document</h2>
                    </div>

                    <div class="document-access-grid">

                        {{-- Type accès --}}
                        <div class="document-access-item">

                            <div class="info-item-label">
                                Type d'accès
                            </div>

                            @if($document->access_type === 'free')

                                <span class="document-badge badge-free">
                                    <span>●</span>
                                    Gratuit
                                </span>

                            @else

                                <span class="document-badge badge-premium">
                                    <span>●</span>
                                    Premium
                                </span>

                            @endif

                        </div>


                        {{-- Prix --}}
                        <div class="document-access-item">

                            <div class="info-item-label">
                                💰 Prix
                            </div>

                            @if(
                                $document->access_type === 'premium'
                                && $document->price
                            )

                                <div class="document-price">

                                    {{ number_format(
                                        (float) $document->price,
                                        0,
                                        ',',
                                        ' '
                                    ) }}

                                    <span>FCFA</span>

                                </div>

                            @else

                                <div class="document-free-price">
                                    Gratuit
                                </div>

                            @endif

                        </div>

                    </div>

                </section>


                <div class="document-divider"></div>


                {{-- =========================
                     STATUT
                ========================== --}}
                <section class="document-section">

                    <div class="document-section-title">
                        <span class="section-icon">📌</span>
                        <h2>Statut</h2>
                    </div>


                    @if($document->status === 'published')

                        <span class="document-status status-published">
                            <span>✓</span>
                            Publié
                        </span>

                    @elseif($document->status === 'pending')

                        <span class="document-status status-pending">
                            <span>⏳</span>
                            En attente de validation
                        </span>

                    @elseif($document->status === 'rejected')

                        <span class="document-status status-rejected">
                            <span>✕</span>
                            Rejeté
                        </span>

                    @else

                        <span class="document-status status-draft">
                            <span>📝</span>
                            Brouillon
                        </span>

                    @endif

                </section>


                <div class="document-divider"></div>


                {{-- =========================
                     DESCRIPTION
                ========================== --}}
                <section class="document-section">

                    <div class="document-section-title">
                        <span class="section-icon">📄</span>
                        <h2>Description</h2>
                    </div>


                    @if($document->description)

                        <div class="document-description">
                            {{ $document->description }}
                        </div>

                    @else

                        <p class="document-empty">
                            Aucune description n'a été ajoutée.
                        </p>

                    @endif

                </section>


                {{-- =========================
                     FICHIER
                ========================== --}}
                @if($document->file_path)

                    <div class="document-divider"></div>

                    <section class="document-section">

                        <div class="document-section-title">
                            <span class="section-icon">📎</span>
                            <h2>Fichier</h2>
                        </div>


                        <div class="document-file-box">

                            <div class="document-file-info">

                                <div class="document-file-icon">
                                    📄
                                </div>

                                <div>

                                    <div class="document-file-title">
                                        Document joint
                                    </div>

                                    @if($document->file_extension)

                                        <div class="document-file-format">
                                            Format :
                                            <strong>
                                                {{ strtoupper($document->file_extension) }}
                                            </strong>
                                        </div>

                                    @endif

                                </div>

                            </div>


                            <a
                                href="{{ asset('storage/' . $document->file_path) }}"
                                target="_blank"
                                class="document-file-button"
                            >
                                👁️ Ouvrir le fichier
                            </a>

                        </div>

                    </section>

                @endif


                <div class="document-divider"></div>


                {{-- =========================
                     ACTIONS
                ========================== --}}
                <div class="document-actions">

                    <a
                        href="{{ route('journaliste.documents.edit', $document) }}"
                        class="document-action document-action-primary"
                    >
                        ✏️
                        <span>Modifier</span>
                    </a>


                    <a
                        href="{{ route('journaliste.documents.index') }}"
                        class="document-action document-action-secondary"
                    >
                        ←
                        <span>Retour à mes documents</span>
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection