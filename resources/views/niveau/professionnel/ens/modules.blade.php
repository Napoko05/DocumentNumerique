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

            <a href="{{ route('vitrine.professionnel.ens.programmes') }}">
                ENS
            </a>

            <span>/</span>

            <a href="{{ route(
                'vitrine.professionnel.ens.specialites',
                $programme->slug
            ) }}">
                {{ $programme->name }}
            </a>

            <span>/</span>

            <a href="{{ route(
                'vitrine.professionnel.ens.niveaux',
                [
                    'programmeSlug' => $programme->slug,
                    'specialiteSlug' => $specialite->slug
                ]
            ) }}">
                {{ $specialite->name }}
            </a>

            <span>/</span>

            <span>{{ $niveau->name }}</span>

        </div>

        <span class="page-kicker">
            ENS
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
                    href="{{ route(
                        'vitrine.professionnel.ens.type_doc',
                        [
                            'programmeSlug' => $programme->slug,
                            'specialiteSlug' => $specialite->slug,
                            'niveauSlug' => $niveau->slug,
                            'moduleSlug' => $subject->slug
                        ]
                    ) }}"
                    class="class-card"
                >

                    <div class="class-card-top">

                        <div class="class-icon">
                            {{ $subject->icon ?? '📚' }}
                        </div>

                        <span class="class-arrow">
                            →
                        </span>

                    </div>

                    <div class="class-card-body">

                        <h2>
                            {{ $subject->name }}
                        </h2>

                        <p>
                            Consulter les documents
                        </p>

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
    <div class="doc-type-back-container">

    <a
        href="{{ route('vitrine.professionnel.ens.niveaux', [
            'formationSlug' => $formation->slug,
            'programmeSlug' => $programme->slug,
            'specialiteSlug' => $specialite->slug
        ]) }}"
        class="doc-type-back-btn"
    >

        <i class="bi bi-arrow-left"></i>

        Retour aux niveaux

    </a>

</div>

</div>

@endsection