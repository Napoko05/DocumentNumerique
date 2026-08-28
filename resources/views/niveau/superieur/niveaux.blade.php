@extends('layouts.app')

@section('content')

<div class="superieur-niveaux-page">

    {{-- HEADER --}}
    <div class="superieur-niveaux-header">

        <h1 class="superieur-niveaux-title">
            🎓 {{ $filiere->name }}
        </h1>

        <p class="superieur-niveaux-subtitle">
            Choisissez votre niveau d'étude.
        </p>

    </div>


    {{-- NIVEAUX --}}
    <div class="superieur-niveaux-grid">

        @forelse($niveaux as $niveau)

            <a href="{{ route('vitrine.superieur.type_doc', [
                'domaineSlug' => $domaine->slug,
                'filiereSlug' => $filiere->slug,
                'niveauSlug' => $niveau->slug
            ]) }}"
            class="superieur-niveau-card">

                <div class="superieur-niveau-icon">
                    🎓
                </div>

                <div class="superieur-niveau-content">

                    <h3 class="superieur-niveau-name">
                        {{ $niveau->name }}
                    </h3>

                    <p class="superieur-niveau-description">
                        Accéder aux documents
                    </p>

                    @if(isset($niveau->documents_count))

                        <p class="superieur-niveau-count">
                            {{ $niveau->documents_count }} document(s)
                        </p>

                    @endif

                </div>

            </a>

        @empty

            <div class="superieur-niveaux-empty">

                <div class="superieur-niveaux-empty-icon">
                    📂
                </div>

                <h3>
                    Aucun niveau disponible
                </h3>

                <p>
                    Aucun niveau n'est enregistré pour cette filière.
                </p>

            </div>

        @endforelse

    </div>


    {{-- RETOUR --}}
    <div class="superieur-niveaux-back">

        <a href="{{ route('vitrine.superieur.filieres', [
            'domaineSlug' => $domaine->slug
        ]) }}"
        class="superieur-niveaux-back-btn">

            <span>←</span>
            Retour aux filières

        </a>

    </div>

</div>

@endsection