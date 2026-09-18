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
                Matière
            </div>

            <h1>{{ $subject->name }}</h1>

        </div>

    </section>


    {{-- =====================================================
         CONTENU
         ===================================================== --}}
    <section class="secondaire-content">

        <div class="container">

            {{-- =================================================
                 RETOUR
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
                >
                    <i class="bi bi-arrow-left"></i>
                    <span>Retour à {{ $level->name }}</span>
                </a>

            </div>


            {{-- =================================================
                 DOCUMENTS
                 ================================================= --}}
            @if($documents->count())

                <div class="secondaire-grid">

                    @foreach($documents as $document)

                        <article class="secondaire-card document-card">

                            <div class="secondaire-card-top">

                                <div class="secondaire-icon">
                                    <i class="bi bi-file-earmark-pdf"></i>
                                </div>

                            </div>


                            <div class="secondaire-card-body">

                                <h3>
                                    {{ $document->title }}
                                </h3>

                                @if($document->access_type === 'premium')

                                    <p>
                                        <i class="bi bi-lock-fill"></i>

                                        {{ number_format((float) $document->price, 0, ',', ' ') }}
                                        FCFA
                                    </p>

                                @else

                                    <p>
                                        <i class="bi bi-unlock-fill"></i>
                                        Gratuit
                                    </p>

                                @endif

                            </div>


                            {{-- =================================================
                                 ACTIONS
                                 ================================================= --}}
                            <div class="document-actions">

                                @if($document->access_type === 'premium')

                                    {{-- PREMIUM : PAIEMENT --}}
                                    <a
                                        href="{{ route(
                                            'payments.create',
                                            ['document' => $document->id]
                                        ) }}"
                                        class="btn-document-download"
                                    >
                                        <i class="bi bi-credit-card"></i>
                                        Payer
                                    </a>

                                @else

                                    {{-- GRATUIT : VOIR --}}
                                    <a
                                        href="{{ route(
                                            'documents.read',
                                            $document
                                        ) }}"
                                        target="_blank"
                                        class="btn-document-view"
                                    >
                                        <i class="bi bi-eye"></i>
                                        Voir
                                    </a>

                                    {{-- GRATUIT : TÉLÉCHARGER --}}
                                    <a
                                        href="{{ route(
                                            'documents.download',
                                            $document
                                        ) }}"
                                        class="btn-document-download"
                                    >
                                        <i class="bi bi-download"></i>
                                        Télécharger
                                    </a>

                                @endif

                            </div>

                        </article>

                    @endforeach

                </div>

            @else

                <div class="secondaire-empty">

                    <div class="secondaire-empty-icon">
                        <i class="bi bi-file-earmark-x"></i>
                    </div>

                    <h3>Aucun document disponible</h3>

                </div>

            @endif

        </div>

    </section>

</div>

@endsection
