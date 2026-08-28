@extends('layouts.app')

@section('content')

<div class="document-list-page">

    {{-- HEADER --}}
    <div class="document-list-header">

        <h1>
            📄 {{ $type->name }}
        </h1>

        <p>
            Filière :
            <span>
                {{ $filiere->name }}
            </span>

            •

            Niveau :
            <span>
                {{ $niveau->name }}
            </span>
        </p>

    </div>


    {{-- DOCUMENTS --}}
    <div class="document-list-grid">

        @forelse($documents as $document)

            <div class="document-list-card">

                <div class="document-list-card-header">

                    <h3>
                        {{ $document->title }}
                    </h3>

                    <span>
                        📄
                    </span>

                </div>


                <p class="document-list-description">

                    {{ Str::limit(
                        $document->description ?? 'Ressource pédagogique disponible',
                        100
                    ) }}

                </p>


                <div class="document-list-meta">

                    @if($document->published_at)

                        <span>
                            📅 {{ $document->published_at->format('d/m/Y') }}
                        </span>

                    @endif

                </div>


                <a
                    href="#"
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
                    Aucun document disponible
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


    {{-- RETOUR --}}
    <div class="document-list-back-container">

        <a
            href="{{ route('vitrine.superieur.type_doc', [
                'domaineSlug' => $domaine->slug,
                'filiereSlug' => $filiere->slug,
                'niveauSlug' => $niveau->slug
            ]) }}"
            class="document-list-back-btn"
        >
            ← Retour aux types de documents
        </a>

    </div>

</div>

@endsection