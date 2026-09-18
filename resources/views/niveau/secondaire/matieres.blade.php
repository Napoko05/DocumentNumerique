@extends('layouts.app')

@section('title', $subject->name)

@section('content')

<div class="secondaire-page">

    {{-- =====================================================
         HERO
         ===================================================== --}}
    <section class="secondaire-hero">

        <div class="container">

            <div class="secondaire-badge">
                <i class="bi bi-book-fill"></i>
                Ressources pédagogiques
            </div>

            <h1>{{ $subject->name }}</h1>

            <p>
                Documents disponibles pour {{ $level->name }}.
            </p>

        </div>

    </section>


    {{-- =====================================================
         CONTENU
         ===================================================== --}}
    <section class="secondaire-content">

        <div class="container">

            {{-- =================================================
                 RETOUR EN HAUT
                 ================================================= --}}
            <div class="secondaire-back-wrapper">

                <a
                    href="{{ route(
                        'vitrine.secondaire.niveau',
                        [
                            'formation' => $formationModel->slug,
                            'niveau' => $level->slug,
                        ]
                    ) }}"
                    class="secondaire-back"
                    aria-label="Retour à {{ $level->name }}"
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Retour à {{ $level->name }}</span>
                </a>

            </div>


            {{-- =================================================
                 TITRE
                 ================================================= --}}
            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        {{ $formationModel->name }}
                    </span>

                    <h2>
                        Documents disponibles
                    </h2>

                </div>

                <span class="class-count">
                    {{ $documents->count() }}
                    document{{ $documents->count() > 1 ? 's' : '' }}
                </span>

            </div>


            {{-- =================================================
                 DOCUMENTS
                 ================================================= --}}
            @if($documents->isNotEmpty())

                <div class="secondaire-grid">

                    @foreach($documents as $document)

                        <div class="secondaire-card document-card">

                            {{-- =================================
                                 ICÔNE / COUVERTURE
                                 ================================= --}}
                            <div class="secondaire-card-top">

                                <div class="secondaire-icon document-cover">

                                    @if($document->cover_image)

                                        <img
                                            src="{{ asset('storage/' . $document->cover_image) }}"
                                            alt="{{ $document->title }}"
                                        >

                                    @else

                                        <i class="bi bi-file-earmark-text"></i>

                                    @endif

                                </div>

                                <span class="secondaire-arrow">
                                    <i class="bi bi-file-earmark-text"></i>
                                </span>

                            </div>


                            {{-- =================================
                                 CONTENU
                                 ================================= --}}
                            <div class="secondaire-card-body">

                                <span class="card-kicker">
                                    {{ $document->documentType->name ?? 'DOCUMENT' }}
                                </span>

                                <h3>
                                    {{ $document->title }}
                                </h3>


                                @if($document->description)

                                    <p>
                                        <i class="bi bi-text-left"></i>
                                        {{ Str::limit($document->description, 100) }}
                                    </p>

                                @endif


                                {{-- =============================
                                     TYPE D'ACCÈS
                                     ============================= --}}
                                <p>

                                    @if($document->access_type === 'premium')

                                        <i class="bi bi-lock-fill"></i>
                                        Premium

                                    @else

                                        <i class="bi bi-unlock-fill"></i>
                                        Gratuit

                                    @endif

                                </p>

                            </div>


                            {{-- =================================
                                 ACTIONS
                                 ================================= --}}
                            <div class="document-actions">

                                <a
                                    href="{{ route('documents.read', $document) }}"
                                    target="_blank"
                                    class="document-view-btn"
                                >
                                    <i class="bi bi-eye"></i>
                                    Ouvrir
                                </a>


                                <a
                                    href="{{ route('documents.download', $document) }}"
                                    class="document-download-btn"
                                >
                                    <i class="bi bi-download"></i>
                                    Télécharger
                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                {{-- =============================================
                     AUCUN DOCUMENT
                     ============================================= --}}
                <div class="secondaire-empty">

                    <div class="secondaire-empty-icon">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>

                    <h3>
                        Aucun document disponible
                    </h3>

                    <p>
                        Aucun document publié n'est actuellement disponible
                        pour cette matière.
                    </p>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection
