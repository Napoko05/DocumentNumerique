@extends('layouts.app')

@section('title', $subject->name)

@section('content')

<div class="vitrine-page">

    <a
        href="{{ route(
        'vitrine.secondaire.niveau',
        [
            'formation' => $formationModel->slug,
            'niveau' => $level->slug,
        ]
    ) }}"
        class="vitrine-back">
        <i class="bi bi-arrow-left"></i>
        Retour à {{ $level->name }}
    </a>

    <div class="breadcrumb-vitrine">

        <a href="{{ url('/') }}">
            Accueil
        </a>

        <i class="bi bi-chevron-right"></i>

        <span>
            Secondaire
        </span>

        <i class="bi bi-chevron-right"></i>

        <span>
            {{ $formationModel->name }}
        </span>

        <i class="bi bi-chevron-right"></i>

        <span>
            {{ $level->name }}
        </span>

        <i class="bi bi-chevron-right"></i>

        <strong>
            {{ $subject->name }}
        </strong>

    </div>

    <div class="page-header">

        <div>

            <span class="page-kicker">
                MATIÈRE
            </span>

            <h1>
                {{ $subject->name }}
            </h1>

            <p>
                Consultez les documents pédagogiques disponibles pour ce niveau.
            </p>

        </div>

        <div class="class-count">

            {{ $documents->count() }}

            document{{ $documents->count() > 1 ? 's' : '' }}

        </div>

    </div>

    @if($documents->count())

    <div class="superieur-grid">

        @foreach($documents as $document)

        <a
            href="{{ route(
                    'vitrine.secondaire.document',
                    [
                        'formation' => $formationModel->slug,
                        'niveau' => $level->slug,
                        'matiere' => $subject->slug,
                        'slug' => $document->slug,
                    ]
                ) }}"
            class="superieur-card">

            <div class="superieur-card-icon">

                <i class="bi bi-file-earmark-text"></i>

            </div>

            <div class="superieur-card-content">

                <span class="card-kicker">
                    {{ $document->documentType->name ?? 'DOCUMENT' }}
                </span>

                <h3>
                    {{ $document->title }}
                </h3>

                @if($document->description)

                <p>
                    {{ $document->description }}
                </p>

                @endif

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

            <div class="superieur-card-arrow">

                <i class="bi bi-arrow-right"></i>

            </div>

        </a>

        @endforeach

    </div>

    @else

    <div class="empty-state">

        <div class="empty-icon">

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

@endsection