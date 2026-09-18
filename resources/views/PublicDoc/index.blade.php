@extends('layouts.app')

@section('title', 'Bibliothèque numérique')

@section('content')

<section class="yaas-section yaas-documents">

    <div class="yaas-container">

        {{-- EN-TÊTE --}}
        <div class="yaas-section-heading">

            <div>

                <span class="yaas-section-label">
                    Bibliothèque
                </span>

                <h1>
                    Bibliothèque
                    <span>numérique.</span>
                </h1>

                <p>
                    Consultez nos ressources scientifiques
                    et approfondissez vos connaissances.
                </p>

            </div>

        </div>


        {{-- DOCUMENTS --}}
        <div class="yaas-document-grid">

            @forelse($documents as $document)

                <article class="yaas-document-card">

                    {{-- COUVERTURE --}}
                    <div class="document-cover">

                        @if($document->cover_image)

                            <img
                                src="{{ asset('storage/' . $document->cover_image) }}"
                                alt="{{ $document->title }}"
                                loading="lazy"
                            >

                        @else

                            <div class="document-cover-placeholder">
                                📖
                            </div>

                        @endif


                        {{-- TYPE --}}
                        <div class="document-type">

                            @if($document->access_type === 'premium')

                                <span class="premium">
                                    PREMIUM
                                </span>

                            @else

                                <span class="free">
                                    GRATUIT
                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- CONTENU --}}
                    <div class="document-content">

                        {{-- META --}}
                        <div class="document-meta">

                            <span>
                                📄 Document scientifique
                            </span>

                            <span>
                                👁 {{ $document->views }}
                            </span>

                        </div>


                        {{-- TITRE --}}
                        <h3>
                            {{ $document->title }}
                        </h3>


                        {{-- DESCRIPTION --}}
                        @if($document->description)

                            <p>
                                {{ Str::limit($document->description, 100) }}
                            </p>

                        @else

                            <p>
                                Ressource scientifique disponible
                                dans la bibliothèque numérique.
                            </p>

                        @endif


                        {{-- PRIX PREMIUM --}}
                        @if($document->access_type === 'premium')

                            <div class="document-price">

                                <i class="bi bi-lock-fill"></i>

                                {{ number_format((float) $document->price, 0, ',', ' ') }}
                                FCFA

                            </div>

                        @else

                            <div class="document-price document-free">

                                <i class="bi bi-unlock-fill"></i>

                                Gratuit

                            </div>

                        @endif


                        {{-- ACTIONS --}}
                        <div class="document-actions">

                            @if($document->access_type === 'premium')

                                <a
                                    href="{{ route(
                                        'payments.create',
                                        ['document' => $document->id]
                                    ) }}"
                                    class="document-button"
                                >
                                    <i class="bi bi-credit-card"></i>
                                    Payer
                                </a>

                            @else

                                <a
                                    href="{{ route('documents.read', $document) }}"
                                    target="_blank"
                                    class="document-button document-button-read"
                                >
                                    <i class="bi bi-eye"></i>
                                    Lire
                                </a>

                                <a
                                    href="{{ route('documents.download', $document) }}"
                                    class="document-button document-button-download"
                                >
                                    <i class="bi bi-download"></i>
                                    Télécharger
                                </a>

                            @endif

                        </div>

                    </div>

                </article>

            @empty

                <div class="yaas-empty-state">

                    <div>
                        📚
                    </div>

                    <h3>
                        Aucun document disponible
                    </h3>

                    <p>
                        Les prochaines publications apparaîtront ici.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}
        @if($documents->hasPages())

            <div class="yaas-pagination">

                {{ $documents->links() }}

            </div>

        @endif

    </div>

</section>

@endsection
