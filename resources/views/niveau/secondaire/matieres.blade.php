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
                RESSOURCES PÉDAGOGIQUES
            </span>

            <h1>
                {{ $subject->name }}
            </h1>

            <p>
                Documents disponibles pour
                <strong>{{ $level->name }}</strong>.
            </p>

        </div>

        <span class="class-count">

            {{ $documents->count() }}

            document{{ $documents->count() > 1 ? 's' : '' }}

        </span>

    </div>

    @if($documents->isNotEmpty())

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
            class="superieur-card document-card">

            <div class="superieur-card-icon">

                @if($document->cover_image)

                <img
                    src="{{ asset('storage/' . $document->cover_image) }}"
                    alt="{{ $document->title }}">

                @else

                <i class="bi bi-file-earmark-text"></i>

                @endif

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
                    {{ Str::limit($document->description, 120) }}
                </p>

                @endif

                <div class="document-meta">

                    @if($document->access_type === 'premium')

                    <span class="badge-premium">
                        <i class="bi bi-lock-fill"></i>
                        Premium
                    </span>

                    @else

                    <span class="badge-free">
                        <i class="bi bi-unlock-fill"></i>
                        Gratuit
                    </span>

                    @endif

                </div>

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
            Aucun document publié n'est actuellement disponible pour cette matière.
        </p>

    </div>

    @endif

</div>

@endsection