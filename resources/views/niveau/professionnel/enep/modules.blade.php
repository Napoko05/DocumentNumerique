@extends('layouts.app')

@section('title', $niveau->name . ' — Modules')

@section('content')

<div class="vitrine-page">

    <div class="page-header">

        <div class="breadcrumb">

            <a href="{{ route('vitrine.professionnel.formations') }}">
                Professionnel
            </a>

            <span>/</span>

            <a href="{{ route('vitrine.professionnel.formation.niveaux', [
                'formationSlug' => $formation->slug
            ]) }}">
                {{ $formation->name }}
            </a>

            <span>/</span>

            <span>{{ $niveau->name }}</span>

        </div>

        <span class="page-kicker">
            {{ $formation->name }}
        </span>

        <h1>
            Modules
        </h1>

        <p>
            Sélectionnez un module ou une matière pour consulter
            les types de documents disponibles.
        </p>

    </div>

    @if($subjects->isNotEmpty())

        <div class="classes-grid">

            @foreach($subjects as $subject)

                <a
                    href="{{ route('vitrine.professionnel.enep.type_doc', [
                        'formationSlug' => $formation->slug,
                        'niveauSlug' => $niveau->slug,
                        'moduleSlug' => $subject->slug
                    ]) }}"
                    class="class-card"
                >

                    <div class="class-card-top">

                        <div class="class-icon">
                            {{ $subject->icon ?? '📚' }}
                        </div>

                        <span class="class-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </span>

                    </div>

                    <div class="class-card-body">

                        <h2>
                            {{ $subject->name }}
                        </h2>

                        <p>
                            <i class="bi bi-file-earmark-text"></i>
                            Consulter les documents
                        </p>

                    </div>

                    <div class="class-card-footer">

                        <span>
                            Voir les types de documents
                        </span>

                        <i class="bi bi-arrow-right"></i>

                    </div>

                </a>

            @endforeach

        </div>

    @else

        <div class="empty-state">

            <div class="empty-icon">
                📚
            </div>

            <h2>
                Aucun module disponible
            </h2>

            <p>
                Aucun module ou matière ne possède actuellement
                de document publié pour ce niveau.
            </p>

        </div>

    @endif

    {{-- RETOUR AUX NIVEAUX --}}

    <div class="doc-type-back-container">

        <a
            href="{{ route('vitrine.professionnel.formation.niveaux', [
                'formationSlug' => $formation->slug
            ]) }}"
            class="doc-type-back-btn"
        >

            <i class="bi bi-arrow-left"></i>

            Retour aux niveaux

        </a>

    </div>

</div>

@endsection