@extends('layouts.admin_app')

@section('title', 'Gestion des niveaux')

@section('page-title', 'Gestion des niveaux')

@section('content')

<div class="admin-levels-page">


    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="levels-page-header">

        <div class="levels-page-heading">

            <div class="levels-page-icon">
                <i class="bi bi-layers"></i>
            </div>

            <div>

                <h1>
                    Gestion des niveaux
                </h1>

                <p>
                    Enseignement supérieur
                    <span>•</span>
                    Domaines → Filières → Niveaux → Modules
                </p>

            </div>

        </div>


        <a
            href="{{ route('admin.superieur.levels.create') }}"
            class="levels-add-button"
        >
            <i class="bi bi-plus-lg"></i>
            <span>Ajouter un niveau</span>
        </a>

    </div>



    {{-- =========================================================
         MESSAGES
    ========================================================== --}}

    @if(session('success'))

        <div class="levels-alert levels-alert-success">

            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="levels-alert levels-alert-danger">

            <i class="bi bi-exclamation-triangle-fill"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif



    {{-- =========================================================
         RECHERCHE
    ========================================================== --}}

    <div class="levels-search-card">

        <form
            method="GET"
            action="{{ route('admin.superieur.levels.index') }}"
            class="levels-search-form"
        >

            <div class="levels-search-wrapper">

                <i class="bi bi-search"></i>

                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    class="levels-search-input"
                    placeholder="Rechercher un niveau, une filière ou un domaine..."
                    autocomplete="off"
                >

                @if($search !== '')

                    <a
                        href="{{ route('admin.superieur.levels.index') }}"
                        class="levels-search-clear"
                        aria-label="Effacer la recherche"
                    >
                        <i class="bi bi-x-lg"></i>
                    </a>

                @endif

            </div>


            <button
                type="submit"
                class="levels-search-button"
            >
                <i class="bi bi-search"></i>
                Rechercher
            </button>

        </form>

    </div>



    {{-- =========================================================
         RÉSULTATS
    ========================================================== --}}

    <div class="levels-result-line">

        <span>

            {{ $levels->total() }}

            {{ $levels->total() > 1
                ? 'niveaux'
                : 'niveau'
            }}

        </span>


        @if($search !== '')

            <span class="levels-result-search">

                pour « {{ $search }} »

            </span>

        @endif

    </div>



    {{-- =========================================================
         REGROUPEMENT PAR DOMAINE
    ========================================================== --}}

    @php

        /*
        |--------------------------------------------------------------------------
        | On regroupe les niveaux par domaine académique.
        |
        | Niveau
        |    ↓
        | Filière
        |    ↓
        | Domaine académique
        |--------------------------------------------------------------------------
        */

        $levelsByDomain = $levels->groupBy(function ($level) {

            return $level->filiere?->academicDomain?->id
                ?? 'undefined';

        });

    @endphp



    {{-- =========================================================
         DOMAINES
    ========================================================== --}}

    @forelse($levelsByDomain as $domainId => $domainLevels)

        @php

            /*
            |--------------------------------------------------------------------------
            | Récupérer le domaine du groupe
            |--------------------------------------------------------------------------
            */

            $domain = $domainLevels
                ->first()
                ?->filiere
                ?->academicDomain;

        @endphp



        {{-- =====================================================
             CARTE DOMAINE
        ====================================================== --}}

        <section class="levels-domain-card">


            {{-- =================================================
                 EN-TÊTE DOMAINE
            ================================================== --}}

            <div class="levels-domain-header">

                <div>

                    <span class="levels-domain-label">
                        Domaine
                    </span>

                    <h2>

                        {{ $domain?->name ?? 'Domaine non défini' }}

                    </h2>

                </div>


                <span class="levels-domain-count">

                    {{ $domainLevels->count() }}

                    {{ $domainLevels->count() > 1
                        ? 'niveaux'
                        : 'niveau'
                    }}

                </span>

            </div>



            {{-- =================================================
                 FILIÈRES
            ================================================== --}}

            <div class="levels-domain-body">


                @foreach(
                    $domainLevels->groupBy('filiere_id')
                    as $filiereId => $filiereLevels
                )

                    @php

                        $filiere = $filiereLevels
                            ->first()
                            ?->filiere;

                    @endphp



                    {{-- =========================================
                         BLOC FILIÈRE
                    ========================================== --}}

                    <div class="levels-filiere-block">


                        {{-- =====================================
                             EN-TÊTE FILIÈRE
                        ====================================== --}}

                        <div class="levels-filiere-header">

                            <div class="levels-filiere-name">

                                <span class="levels-filiere-icon">

                                    <i class="bi bi-diagram-3"></i>

                                </span>


                                <div>

                                    <span>
                                        Filière
                                    </span>

                                    <strong>

                                        {{ $filiere?->name
                                            ?? 'Filière non définie'
                                        }}

                                    </strong>

                                </div>

                            </div>


                            <span class="levels-filiere-count">

                                {{ $filiereLevels->count() }}

                                {{ $filiereLevels->count() > 1
                                    ? 'niveaux'
                                    : 'niveau'
                                }}

                            </span>

                        </div>



                        {{-- =====================================
                             TABLEAU DES NIVEAUX
                        ====================================== --}}

                        <div class="levels-table-wrapper">

                            <table class="levels-table">

                                <thead>

                                    <tr>

                                        <th class="levels-order-column">
                                            Ordre
                                        </th>

                                        <th>
                                            Niveau
                                        </th>

                                        <th>
                                            Modules
                                        </th>

                                        <th>
                                            Statut
                                        </th>

                                        <th class="levels-actions-column">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @foreach(
                                        $filiereLevels->sortBy([
                                            ['order', 'asc'],
                                            ['name', 'asc'],
                                        ])
                                        as $level
                                    )

                                        <tr>


                                            {{-- =================================
                                                 ORDRE
                                            ================================== --}}

                                            <td
                                                data-label="Ordre"
                                                class="levels-order-cell"
                                            >

                                                <span>
                                                    {{ $level->order }}
                                                </span>

                                            </td>



                                            {{-- =================================
                                                 NIVEAU
                                            ================================== --}}

                                            <td
                                                data-label="Niveau"
                                                class="levels-name-cell"
                                            >

                                                <div class="levels-name-content">


                                                    <span class="levels-level-icon">

                                                        <i class="bi bi-layers"></i>

                                                    </span>


                                                    <div>

                                                        <strong>
                                                            {{ $level->name }}
                                                        </strong>


                                                        @if($level->slug)

                                                            <small>
                                                                {{ $level->slug }}
                                                            </small>

                                                        @endif

                                                    </div>

                                                </div>

                                            </td>



                                            {{-- =================================
                                                 MODULES
                                            ================================== --}}

                                            <td
                                                data-label="Modules"
                                                class="levels-module-cell"
                                            >

                                                <span class="levels-module-count">

                                                    <i class="bi bi-journal-text"></i>

                                                    {{ $level->subjects_count }}

                                                </span>

                                            </td>



                                            {{-- =================================
                                                 STATUT
                                            ================================== --}}

                                            <td data-label="Statut">

                                                @if($level->is_active)

                                                    <span class="levels-status levels-status-active">

                                                        <span></span>

                                                        Actif

                                                    </span>

                                                @else

                                                    <span class="levels-status levels-status-inactive">

                                                        <span></span>

                                                        Désactivé

                                                    </span>

                                                @endif

                                            </td>



                                            {{-- =================================
                                                 ACTIONS
                                            ================================== --}}

                                            <td
                                                data-label="Actions"
                                                class="levels-actions-cell"
                                            >

                                                <div class="levels-actions">


                                                    {{-- MODIFIER --}}

                                                    <a
                                                        href="{{ route(
                                                            'admin.superieur.levels.edit',
                                                            $level
                                                        ) }}"
                                                        class="levels-action levels-action-edit"
                                                        title="Modifier"
                                                    >

                                                        <i class="bi bi-pencil-square"></i>

                                                        <span>
                                                            Modifier
                                                        </span>

                                                    </a>



                                                    {{-- SUPPRIMER --}}

                                                    <form
                                                        action="{{ route(
                                                            'admin.superieur.levels.destroy',
                                                            $level
                                                        ) }}"
                                                        method="POST"
                                                        onsubmit="return confirm(
                                                            'Voulez-vous vraiment supprimer ce niveau ?'
                                                        );"
                                                    >

                                                        @csrf

                                                        @method('DELETE')


                                                        <button
                                                            type="submit"
                                                            class="levels-action levels-action-delete"
                                                            title="Supprimer"
                                                        >

                                                            <i class="bi bi-trash3"></i>

                                                            <span>
                                                                Supprimer
                                                            </span>

                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                @endforeach

            </div>

        </section>


    @empty


        {{-- =====================================================
             AUCUN NIVEAU
        ====================================================== --}}

        <div class="levels-empty">

            <div class="levels-empty-icon">

                <i class="bi bi-layers"></i>

            </div>


            <h3>
                Aucun niveau trouvé
            </h3>


            <p>

                @if($search !== '')

                    Aucun niveau ne correspond à votre recherche.

                @else

                    Aucun niveau supérieur n'a encore été enregistré.

                @endif

            </p>


            @if($search === '')

                <a
                    href="{{ route('admin.superieur.levels.create') }}"
                    class="levels-add-button"
                >

                    <i class="bi bi-plus-lg"></i>

                    Ajouter le premier niveau

                </a>

            @endif

        </div>

    @endforelse



    {{-- =========================================================
         PAGINATION
    ========================================================== --}}

    @if($levels->hasPages())

        <div class="levels-pagination">


            {{-- INFORMATIONS --}}

            <div class="levels-pagination-info">

                Affichage de

                <strong>
                    {{ $levels->firstItem() }}
                </strong>

                à

                <strong>
                    {{ $levels->lastItem() }}
                </strong>

                sur

                <strong>
                    {{ $levels->total() }}
                </strong>

                résultats

            </div>



            {{-- NAVIGATION --}}

            <nav
                class="levels-pagination-nav"
                aria-label="Pagination des niveaux"
            >


                {{-- PRÉCÉDENT --}}

                @if($levels->onFirstPage())

                    <span class="levels-pagination-button disabled">

                        <i class="bi bi-chevron-left"></i>

                        Précédent

                    </span>

                @else

                    <a
                        href="{{ $levels->previousPageUrl() }}"
                        class="levels-pagination-button"
                    >

                        <i class="bi bi-chevron-left"></i>

                        Précédent

                    </a>

                @endif



                {{-- NUMÉROS --}}

                @foreach(
                    $levels->getUrlRange(
                        max(1, $levels->currentPage() - 2),
                        min(
                            $levels->lastPage(),
                            $levels->currentPage() + 2
                        )
                    )
                    as $page => $url
                )

                    @if($page == $levels->currentPage())

                        <span class="levels-pagination-number active">
                            {{ $page }}
                        </span>

                    @else

                        <a
                            href="{{ $url }}"
                            class="levels-pagination-number"
                        >
                            {{ $page }}
                        </a>

                    @endif

                @endforeach



                {{-- SUIVANT --}}

                @if($levels->hasMorePages())

                    <a
                        href="{{ $levels->nextPageUrl() }}"
                        class="levels-pagination-button"
                    >

                        Suivant

                        <i class="bi bi-chevron-right"></i>

                    </a>

                @else

                    <span class="levels-pagination-button disabled">

                        Suivant

                        <i class="bi bi-chevron-right"></i>

                    </span>

                @endif

            </nav>

        </div>

    @endif

</div>

@endsection
