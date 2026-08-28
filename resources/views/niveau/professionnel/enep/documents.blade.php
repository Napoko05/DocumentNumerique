@extends('layouts.app')

@section('content')

<div class="formation-page">

    <section class="formation-hero">

        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-file-earmark-text-fill"></i>
                DOCUMENTS ENEP
            </span>

            <h1>
                {{ $formation->icon ?? '🎓' }}
                {{ $formation->name }}
            </h1>

            <p>
                {{ $niveau->name }}
                •
                {{ $module->name }}
                •
                {{ $documentType->name }}
            </p>

        </div>

    </section>

    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        RESSOURCES PÉDAGOGIQUES
                    </span>

                    <h2>
                        {{ $documentType->name }}
                    </h2>

                </div>

                <span class="class-count">

                    {{ $documents->count() }}

                    document{{ $documents->count() > 1 ? 's' : '' }}

                </span>

            </div>

            @if($documents->isNotEmpty())

            <div class="classes-grid">

                @foreach($documents as $document)
                <a
                    href="{{ route('vitrine.professionnel.enep.show', [
        'formationSlug' => $formation->slug,
        'niveauSlug' => $niveau->slug,
        'moduleSlug' => $module->slug,
        'typeSlug' => $documentType->slug,
        'documentSlug' => $document->slug
    ]) }}"
                    class="class-card">
                    <div class="class-card-top">

                        <div class="class-icon">
                            📄
                        </div>

                        <div class="class-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>

                    </div>

                    <div class="class-card-body">

                        <h3>
                            {{ $document->title }}
                        </h3>

                        <p>

                            <i class="bi bi-info-circle"></i>

                            {{ $document->description ?: 'Document pédagogique disponible.' }}

                        </p>

                    </div>

                    <div class="class-card-footer">

                        <span>
                            Consulter le document
                        </span>

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
                    Aucun document n'est actuellement disponible
                    pour ce type de document.
                </p>

            </div>

            @endif

            <div class="doc-type-back-container">

                <a
                    href="{{ route(
                        'vitrine.professionnel.enep.type_doc',
                        [
                            'formationSlug' => $formation->slug,
                            'niveauSlug' => $niveau->slug,
                            'moduleSlug' => $module->slug
                        ]
                    ) }}"
                    class="doc-type-back-btn">

                    <i class="bi bi-arrow-left"></i>

                    Retour aux types de documents

                </a>

            </div>

        </div>

    </section>

</div>

@endsection