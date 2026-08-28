@extends('layouts.app')

@section('title', $document->title)

@section('content')

<div class="vitrine-page">

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

    <span>
        {{ $subject->name }}
    </span>

    <i class="bi bi-chevron-right"></i>

    <strong>
        Document
    </strong>

</div>

<article class="document-show">

    <div class="document-show-header">

        <div class="document-show-type">

            <span class="page-kicker">
                {{ $document->documentType->name ?? 'DOCUMENT' }}
            </span>

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

        <h1>
            {{ $document->title }}
        </h1>

        @if($document->description)

            <p class="document-description">
                {{ $document->description }}
            </p>

        @endif

    </div>

    <div class="document-show-grid">

        <div class="document-preview">

            @if($document->cover_image)

                <img
                    src="{{ asset('storage/' . $document->cover_image) }}"
                    alt="{{ $document->title }}"
                    class="document-cover"
                >

            @else

                <div class="document-placeholder">

                    <i class="bi bi-file-earmark-pdf"></i>

                    <span>
                        Document PDF
                    </span>

                </div>

            @endif

        </div>

        <div class="document-information">

            <div class="info-item">

                <span>
                    Formation
                </span>

                <strong>
                    {{ $formationModel->name }}
                </strong>

            </div>

            <div class="info-item">

                <span>
                    Niveau
                </span>

                <strong>
                    {{ $level->name }}
                </strong>

            </div>

            <div class="info-item">

                <span>
                    Matière
                </span>

                <strong>
                    {{ $subject->name }}
                </strong>

            </div>

            <div class="info-item">

                <span>
                    Type
                </span>

                <strong>
                    {{ $document->documentType->name ?? 'Document' }}
                </strong>

            </div>

            @if($document->file_size)

                <div class="info-item">

                    <span>
                        Taille
                    </span>

                    <strong>
                        {{ number_format($document->file_size / 1024 / 1024, 2) }}
                        Mo
                    </strong>

                </div>

            @endif

            <div class="document-action">

                @if($document->access_type === 'free')

                    <a
                        href="{{ asset('storage/' . $document->file_path) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn-document-primary"
                    >
                        <i class="bi bi-file-earmark-pdf"></i>
                        Consulter le document
                    </a>

                @else

                    <div class="premium-message">

                        <i class="bi bi-lock-fill"></i>

                        <div>

                            <strong>
                                Document premium
                            </strong>

                            <p>
                                Ce document nécessite un accès payant.
                            </p>

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

    @if($document->content)

        <div class="document-content">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        CONTENU
                    </span>

                    <h2>
                        Présentation du document
                    </h2>

                </div>

            </div>

            <div class="document-content-body">

                {!! $document->content !!}

            </div>

        </div>

    @endif

    @if($document->tags->isNotEmpty())

        <div class="document-tags">

            @foreach($document->tags as $tag)

                <span>
                    #{{ $tag->name }}
                </span>

            @endforeach

        </div>

    @endif

</article>

</div>
<a
    href="{{ route(
        'vitrine.secondaire.subject',
        [
            'formation' => $formationModel->slug,
            'niveau' => $level->slug,
            'matiere' => $subject->slug,
        ]
    ) }}"
    class="vitrine-back"
>
    <i class="bi bi-arrow-left"></i>
    Retour à {{ $subject->name }}
</a>

@endsection
