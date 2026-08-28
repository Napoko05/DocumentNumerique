@extends('layouts.app')

@section('content')

<div class="matiere-page">

    {{-- HEADER --}}
    <div class="matiere-header">

        <div class="matiere-back">
            <a
                href="{{ route('vitrine.secondaire.general.classes', $classe->formation->slug) }}"
                class="matiere-back-btn">
                ← Précédent
            </a>
        </div>

        <h1>
            📚 Classe : {{ $classe->name }}
        </h1>

        <p>
            Choisissez une matière pour accéder aux ressources pédagogiques.
        </p>

    </div>


    {{-- MATIÈRES --}}
    @if($matieres->count())

    <div class="matiere-carousel-wrapper">

        <button
            type="button"
            class="matiere-carousel-btn matiere-carousel-prev"
            aria-label="Matières précédentes">
            ‹
        </button>


        <div
            class="matiere-carousel"
            id="matiereCarousel">

            @foreach($matieres as $matiere)

            <a
                href="{{ route(
                            'vitrine.secondaire.general.type_doc',
                            [$classe->slug, $matiere->slug]
                        ) }}"
                class="matiere-card">

                <div class="matiere-card-icon">
                    {{ $matiere->icon ?? '📚' }}
                </div>

                <h3>
                    {{ $matiere->name }}
                </h3>

                <p>
                    📄 {{ $matiere->documents_count }} document(s)
                </p>

            </a>

            @endforeach

        </div>


        <button
            type="button"
            class="matiere-carousel-btn matiere-carousel-next"
            aria-label="Matières suivantes">
            ›
        </button>

    </div>

    @else

    <div class="matiere-empty">

        <div class="matiere-empty-card">

            <div class="matiere-empty-icon">
                📚
            </div>

            <h3>
                Aucune matière disponible.
            </h3>

            <p>
                Cette classe ne contient actuellement aucune matière.
            </p>

        </div>

    </div>

    @endif

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const carousel = document.getElementById('matiereCarousel');

        const previousButton = document.querySelector(
            '.matiere-carousel-prev'
        );

        const nextButton = document.querySelector(
            '.matiere-carousel-next'
        );

        if (!carousel) {
            return;
        }

        const scrollAmount = 300;


        previousButton.addEventListener('click', function() {

            carousel.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });

        });


        nextButton.addEventListener('click', function() {

            carousel.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });

        });

    });
</script>

@endsection