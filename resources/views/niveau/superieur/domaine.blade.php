@extends('layouts.app')

@section('content')

<div class="superieur-domaines-page">

    {{-- HEADER --}}
    <div class="superieur-domaines-header">

        <h1>
            🎓 Enseignement Supérieur
        </h1>

        <p>
            Choisissez votre domaine académique.
        </p>

    </div>


    {{-- DOMAINES --}}
    <div class="superieur-domaines-grid">

        @forelse($domaines as $domaine)

            <a
                href="{{ route('vitrine.superieur.filieres', [
                    'domaineSlug' => $domaine->slug
                ]) }}"
                class="superieur-domaine-card"
            >

                <div class="superieur-domaine-icon">

                    @switch($domaine->slug)

                        @case('sciences-exactes')
                            🔬
                            @break

                        @case('sciences-sociales')
                            🌍
                            @break

                        @case('sciences-langage')
                            📚
                            @break

                        @default
                            🎓

                    @endswitch

                </div>


                <div class="superieur-domaine-content">

                    <h3>
                        {{ $domaine->name }}
                    </h3>

                    <p>
                        Découvrir les formations disponibles
                    </p>

                </div>

            </a>

        @empty

            <div class="superieur-domaines-empty">

                <div class="superieur-domaines-empty-icon">
                    🎓
                </div>

                <h3>
                    Aucun domaine disponible.
                </h3>

                <p>
                    Aucun domaine académique n'est actuellement disponible.
                </p>

            </div>

        @endforelse

    </div>

</div>

@endsection