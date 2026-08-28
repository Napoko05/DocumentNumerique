@extends('layouts.app')

@section('content')

<div class="superieur-filieres-page">

    {{-- HEADER --}}
    <div class="superieur-filieres-header">

        <h1>
            🎓 {{ $domaine->name }}
        </h1>

        <p>
            Choisissez votre filière pour accéder aux ressources pédagogiques.
        </p>

    </div>


    {{-- FILIÈRES --}}
    <div class="superieur-filieres-grid">

        @forelse($filieres as $filiere)

            <a
                href="{{ route('vitrine.superieur.niveaux', [
                    'domaineSlug' => $domaine->slug,
                    'filiereSlug' => $filiere->slug
                ]) }}"
                class="superieur-filiere-card"
            >

                {{-- ICÔNE --}}
                <div class="superieur-filiere-icon">

                    @switch($filiere->slug)

                        @case('informatique')
                            💻
                            @break

                        @case('mathematiques')
                            📐
                            @break

                        @case('physique')
                            ⚛️
                            @break

                        @case('chimie')
                            🧪
                            @break

                        @case('droit')
                            ⚖️
                            @break

                        @case('gestion')
                            💼
                            @break

                        @case('economie')
                            📈
                            @break

                        @case('lettres')
                            📚
                            @break

                        @case('anglais')
                            🇬🇧
                            @break

                        @default
                            🎓

                    @endswitch

                </div>


                {{-- INFORMATIONS --}}
                <div class="superieur-filiere-content">

                    <h3>
                        {{ $filiere->name }}
                    </h3>

                    <p>
                        Consulter les cours, TD,
                        examens et corrigés
                    </p>


                    @if(isset($filiere->documents_count))

                        <span class="superieur-filiere-documents">

                            {{ $filiere->documents_count }}
                            document(s) disponible(s)

                        </span>

                    @endif

                </div>

            </a>

        @empty

            {{-- AUCUNE FILIÈRE --}}
            <div class="superieur-filieres-empty">

                <div class="superieur-filieres-empty-icon">
                    📂
                </div>

                <h3>
                    Aucune filière disponible
                </h3>

                <p>
                    Aucune filière active n'est encore
                    enregistrée pour ce domaine académique.
                </p>

            </div>

        @endforelse

    </div>


    {{-- RETOUR --}}
    <div class="superieur-filieres-back">

        <a
            href="{{ route('vitrine.superieur.domaines') }}"
            class="superieur-filieres-back-btn"
        >
            ← Retour aux domaines
        </a>

    </div>

</div>

@endsection