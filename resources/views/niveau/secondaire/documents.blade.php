@extends('layouts.app')

@section('content')

<div class="document-list-page">

    {{-- HEADER --}}
    <div class="document-list-header">

        <h1>
            📄 {{ $type->name }} - {{ $matiere->name }}
        </h1>

        <p>
            Classe :
            <span>
                {{ $classe->name }}
            </span>
        </p>

    </div>


    {{-- DOCUMENTS --}}
    <div class="document-list-grid">

        @forelse($documents as $document)

            <div class="document-list-card">

                {{-- EN-TÊTE --}}
                <div class="document-list-card-header">

                    <h3>
                        {{ $document->title }}
                    </h3>

                    <span>
                        📄
                    </span>

                </div>


                {{-- DESCRIPTION --}}
                <p class="document-list-description">

                    {{ Str::limit(
                        $document->description ?? 'Ressource pédagogique disponible',
                        120
                    ) }}

                </p>


                {{-- INFORMATIONS --}}
                <div class="document-list-meta">

                    <div>
                        👤 {{ $document->staff->full_name ?? 'Inconnu' }}
                    </div>

                    <div>
                        👁️ {{ number_format($document->views) }} vue(s)
                    </div>

                    <div>
                        ⬇️ {{ number_format($document->downloads) }} téléchargement(s)
                    </div>

                </div>


                {{-- OUVRIR --}}
                <a
                    href="{{ route('documents.show', $document->slug) }}"
                    class="document-list-open-btn"
                >
                    📖 Ouvrir
                </a>

            </div>

        @empty

            <div class="document-list-empty">

                <div class="document-list-empty-icon">
                    📂
                </div>

                <h3>
                    Aucun document disponible.
                </h3>

                <p>
                    Aucun document n'est actuellement disponible
                    pour cette catégorie.
                </p>

            </div>

        @endforelse

    </div>


    {{-- PAGINATION --}}
    @if($documents->hasPages())

        <div class="document-list-pagination">

            {{ $documents->links() }}

        </div>

    @endif

</div>

@endsection