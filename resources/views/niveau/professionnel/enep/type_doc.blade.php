@extends('layouts.app')

@section('content')

<div class="formation-page">

    <section class="formation-hero">

        <div class="container">

            <span class="formation-badge">
                <i class="bi bi-folder-fill"></i>
                RESSOURCES PÉDAGOGIQUES
            </span>

            <h1>
                📚 {{ $module->name }}
            </h1>

            <p>
                {{ $formation->name }}
                •
                {{ $niveau->name }}
            </p>

        </div>

    </section>

    <section class="formation-content">

        <div class="container">

            <div class="section-heading">

                <div>

                    <span class="section-kicker">
                        {{ $module->name }}
                    </span>

                    <h2>
                        Choisissez le type de document
                    </h2>

                </div>

                <span class="class-count">

                    {{ $types->count() }}

                    type{{ $types->count() > 1 ? 's' : '' }}

                </span>

            </div>

            @if($types->isNotEmpty())

            <div class="classes-grid">

                @foreach($types as $type)

                <a
                    href="{{ route('vitrine.professionnel.enep.documents', [
        'formationSlug' => $formation->slug,
        'niveauSlug' => $niveau->slug,
        'moduleSlug' => $module->slug,
        'typeSlug' => $type->slug
    ]) }}"
                    class="class-card">

                    <div class="class-card-top">

                        <div class="class-icon">

                            @switch($type->slug)

                            @case('cours')
                            📚
                            @break

                            @case('td')
                            📝
                            @break

                            @case('tp')
                            🧪
                            @break

                            @case('examens')
                            📄
                            @break

                            @case('corriges')
                            ✅
                            @break

                            @case('memoires')
                            📕
                            @break

                            @case('rapports')
                            📘
                            @break

                            @case('sujets')
                            🎯
                            @break

                            @default
                            📁

                            @endswitch

                        </div>

                        <div class="class-arrow">
                            <i class="bi bi-arrow-right"></i>
                        </div>

                    </div>

                    <div class="class-card-body">

                        <h3>
                            {{ $type->name }}
                        </h3>

                        <p>
                            <i class="bi bi-file-earmark-text"></i>
                            Ressources disponibles
                        </p>

                    </div>

                    <div class="class-card-footer">

                        <span>
                            Voir les documents
                        </span>

                        <i class="bi bi-arrow-right"></i>

                    </div>

                </a>

                @endforeach

            </div>

            @else

            <div class="empty-state">

                <div class="empty-icon">
                    <i class="bi bi-folder-x"></i>
                </div>

                <h3>
                    Aucun type de document disponible
                </h3>

                <p>
                    Aucun type de document n'est actuellement
                    disponible pour ce module.
                </p>

            </div>

            @endif

            <div class="doc-type-back-container">

                <a
                    href="{{ route('vitrine.professionnel.enep.modules', [
                        'formationSlug' => $formation->slug,
                        'niveauSlug' => $niveau->slug
                    ]) }}"
                    class="doc-type-back-btn">

                    <i class="bi bi-arrow-left"></i>

                    Retour aux modules

                </a>

            </div>

        </div>

    </section>

</div>

@endsection