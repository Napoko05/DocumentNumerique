@extends('layouts.app')

@section('content')

<div class="doc-type-page">

    <div class="doc-type-header">

        <h1>
            📖 Types de documents
        </h1>

        <p>
            <strong>{{ $filiere->name }}</strong>
            •
            <span>{{ $niveau->name }}</span>
        </p>

        <p>
            Choisissez le type de document.
        </p>

    </div>

    <div class="doc-type-carousel-wrapper">

        <button
            type="button"
            class="doc-type-carousel-btn doc-type-carousel-prev"
            id="docTypePrev"
            aria-label="Précédent">
            ‹
        </button>

        <div
            class="doc-type-carousel"
            id="docTypeCarousel">

            <div class="doc-type-track">

                @forelse($types as $type)

                    <a
                        href="{{ route('vitrine.superieur.documents', [
                            'domaineSlug' => $domaine->slug,
                            'filiereSlug' => $filiere->slug,
                            'niveauSlug' => $niveau->slug,
                            'typeSlug' => $type->slug
                        ]) }}"
                        class="doc-type-card">

                        <div class="doc-type-icon">

                            @switch($type->slug)

                                @case('cours')
                                    📚
                                    @break

                                @case('travaux-diriges-td')
                                    📝
                                    @break

                                @case('travaux-pratiques-tp')
                                    🧪
                                    @break

                                @case('examens')
                                    📄
                                    @break

                                @case('corriges')
                                    ✅
                                    @break

                                @case('fiches-de-revision')
                                    📑
                                    @break

                                @default
                                    📁

                            @endswitch

                        </div>

                        <h3>
                            {{ $type->name }}
                        </h3>

                        <p>
                            {{ $type->documents_count ?? 0 }}
                            document(s)
                        </p>

                    </a>

                @empty

                    <div class="doc-type-empty">

                        <h3>
                            Aucun type de document disponible.
                        </h3>

                    </div>

                @endforelse

            </div>

        </div>

        <button
            type="button"
            class="doc-type-carousel-btn doc-type-carousel-next"
            id="docTypeNext"
            aria-label="Suivant">
            ›
        </button>

    </div>

    <div class="doc-type-back-container">

        <a
            href="{{ route('vitrine.superieur.filieres', [
                'domaineSlug' => $domaine->slug
            ]) }}"
            class="doc-type-back-btn">

            ← Retour aux filières

        </a>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const carousel = document.getElementById('docTypeCarousel');
    const prevButton = document.getElementById('docTypePrev');
    const nextButton = document.getElementById('docTypeNext');

    if (!carousel || !prevButton || !nextButton) {
        return;
    }

    function updateButtons() {

        const maxScroll =
            carousel.scrollWidth - carousel.clientWidth;

        prevButton.disabled =
            carousel.scrollLeft <= 5;

        nextButton.disabled =
            carousel.scrollLeft >= maxScroll - 5;
    }

    prevButton.addEventListener('click', function () {

        carousel.scrollBy({
            left: -260,
            behavior: 'smooth'
        });

    });

    nextButton.addEventListener('click', function () {

        carousel.scrollBy({
            left: 260,
            behavior: 'smooth'
        });

    });

    carousel.addEventListener(
        'scroll',
        updateButtons
    );

    window.addEventListener(
        'resize',
        updateButtons
    );

    setTimeout(updateButtons, 100);

});
</script>

@endsection