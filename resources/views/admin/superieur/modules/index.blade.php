@extends('layouts.admin_app')

@section('title', 'Gestion des modules')

@section('content')

<div class="admin-modules-page">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="modules-page-header">

        <div class="modules-header-content">

            <div class="modules-header-text">

                <div class="modules-eyebrow">
                    Enseignement supérieur
                </div>

                <h1 class="modules-title">
                    Gestion des modules
                </h1>

                <p class="modules-subtitle">
                    Gérez les modules par domaine, filière et niveau.
                </p>

            </div>


            <a
                href="{{ route('admin.superieur.modules.create') }}"
                class="modules-add-btn"
            >

                <i class="bi bi-plus-lg"></i>

                <span>
                    Ajouter un module
                </span>

            </a>

        </div>

    </div>


    {{-- =========================================================
         RECHERCHE
    ========================================================== --}}

    <div class="modules-search-bar">

        <div class="modules-search-box">

            <i class="bi bi-search modules-search-icon"></i>

            <input
                type="search"
                id="moduleSearch"
                class="modules-search-input"
                placeholder="Rechercher un module, une filière, un niveau ou un domaine..."
                autocomplete="off"
            >

            <button
                type="button"
                id="clearModuleSearch"
                class="modules-search-clear"
                aria-label="Effacer la recherche"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        <div class="modules-search-info">

            <i class="bi bi-collection"></i>

            <span id="moduleSearchResult">
                Recherche dans les modules
            </span>

        </div>

    </div>


    {{-- =========================================================
         MESSAGES
    ========================================================== --}}

    @if(session('success'))

        <div class="modules-alert modules-alert-success">

            <div class="modules-alert-icon">
                <i class="bi bi-check-circle"></i>
            </div>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="modules-alert modules-alert-danger">

            <div class="modules-alert-icon">
                <i class="bi bi-exclamation-circle"></i>
            </div>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    {{-- =========================================================
         DOMAINES
    ========================================================== --}}

    <div
        class="modules-domain-list"
        id="modulesDomainList"
    >

        @forelse($domaines as $domaine)

            <section
                class="modules-domain-card"
                data-domaine="{{ $domaine->name }}"
            >

                {{-- =================================================
                     DOMAINE
                ================================================== --}}

                <div class="modules-domain-header">

                    <div class="modules-domain-heading">

                        <div class="modules-domain-icon">
                            <i class="bi bi-diagram-3"></i>
                        </div>

                        <div>

                            <div class="modules-label">
                                Domaine
                            </div>

                            <h2>
                                {{ $domaine->name }}
                            </h2>

                        </div>

                    </div>


                    <div class="modules-domain-count">

                        <i class="bi bi-collection"></i>

                        <span>
                            {{ $domaine->filieres->count() }}
                            filière(s)
                        </span>

                    </div>

                </div>


                <div class="modules-domain-body">

                    {{-- =================================================
                         FILIÈRES
                    ================================================== --}}

                    @forelse($domaine->filieres as $filiere)

                        <div
                            class="modules-filiere-card"
                            data-filiere="{{ $filiere->name }}"
                        >

                            <div class="modules-filiere-header">

                                <div class="modules-filiere-heading">

                                    <div class="modules-filiere-icon">
                                        <i class="bi bi-mortarboard"></i>
                                    </div>

                                    <div>

                                        <div class="modules-label">
                                            Filière
                                        </div>

                                        <h3>
                                            {{ $filiere->name }}
                                        </h3>

                                    </div>

                                </div>


                                <div class="modules-filiere-count">

                                    {{ $filiere->levels->count() }}

                                    niveau(s)

                                </div>

                            </div>


                            <div class="modules-level-list">

                                {{-- =================================================
                                     NIVEAUX
                                ================================================== --}}

                                @forelse($filiere->levels as $level)

                                    <div
                                        class="modules-level-block"
                                        data-niveau="{{ $level->name }}"
                                    >

                                        <div class="modules-level-header">

                                            <div class="modules-level-title">

                                                <span class="modules-level-icon">
                                                    <i class="bi bi-layers"></i>
                                                </span>

                                                <div>

                                                    <span class="modules-level-label">
                                                        Niveau
                                                    </span>

                                                    <strong>
                                                        {{ $level->name }}
                                                    </strong>

                                                </div>

                                            </div>


                                            <div class="modules-level-count">

                                                <span>
                                                    {{ $level->subjects->count() }}
                                                    module(s)
                                                </span>

                                            </div>

                                        </div>


                                        {{-- =================================================
                                             TABLE
                                        ================================================== --}}

                                        <div class="modules-table-wrapper">

                                            <table class="modules-table">

                                                <thead>

                                                    <tr>

                                                        <th class="modules-order-column">
                                                            Ordre
                                                        </th>

                                                        <th>
                                                            Module
                                                        </th>

                                                        <th class="modules-status-column">
                                                            Statut
                                                        </th>

                                                        <th class="modules-actions-column">
                                                            Actions
                                                        </th>

                                                    </tr>

                                                </thead>


                                                <tbody>

                                                    @forelse($level->subjects as $subject)

                                                        <tr
                                                            class="module-row"
                                                            data-module="{{ $subject->name }}"
                                                        >

                                                            {{-- ORDRE --}}

                                                            <td class="modules-order-column">

                                                                <span class="modules-order-badge">
                                                                    {{ $subject->order }}
                                                                </span>

                                                            </td>


                                                            {{-- MODULE --}}

                                                            <td>

                                                                <div class="modules-name">

                                                                    <span class="modules-subject-icon">

                                                                        <i class="bi bi-journal-text"></i>

                                                                    </span>

                                                                    <span class="modules-subject-name">
                                                                        {{ $subject->name }}
                                                                    </span>

                                                                </div>

                                                            </td>


                                                            {{-- STATUT --}}

                                                            <td class="modules-status-column">

                                                                @if($subject->is_active)

                                                                    <span class="modules-status modules-status-active">

                                                                        <span class="modules-status-dot"></span>

                                                                        Actif

                                                                    </span>

                                                                @else

                                                                    <span class="modules-status modules-status-disabled">

                                                                        <span class="modules-status-dot"></span>

                                                                        Désactivé

                                                                    </span>

                                                                @endif

                                                            </td>


                                                            {{-- ACTIONS --}}

                                                            <td class="modules-actions-column">

                                                                <div class="modules-actions">

                                                                    <a
                                                                        href="{{ route(
                                                                            'admin.superieur.modules.edit',
                                                                            $subject
                                                                        ) }}"
                                                                        class="modules-action-btn modules-edit-btn"
                                                                    >

                                                                        <i class="bi bi-pencil-square"></i>

                                                                        <span>
                                                                            Modifier
                                                                        </span>

                                                                    </a>


                                                                    <form
                                                                        action="{{ route(
                                                                            'admin.superieur.modules.destroy',
                                                                            $subject
                                                                        ) }}"
                                                                        method="POST"
                                                                        class="modules-delete-form"
                                                                        onsubmit="return confirm('Voulez-vous supprimer ce module ?')"
                                                                    >

                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button
                                                                            type="submit"
                                                                            class="modules-action-btn modules-delete-btn"
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


                                                    @empty

                                                        <tr class="module-empty-row">

                                                            <td
                                                                colspan="4"
                                                                class="modules-empty-cell"
                                                            >

                                                                <div class="modules-empty">

                                                                    <i class="bi bi-journal-x"></i>

                                                                    <span>
                                                                        Aucun module dans ce niveau.
                                                                    </span>

                                                                </div>

                                                            </td>

                                                        </tr>

                                                    @endforelse

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                @empty

                                    <div class="modules-no-level">

                                        <i class="bi bi-layers"></i>

                                        <span>
                                            Aucun niveau dans cette filière.
                                        </span>

                                    </div>

                                @endforelse

                            </div>

                        </div>

                    @empty

                        <div class="modules-no-filiere">

                            <i class="bi bi-mortarboard"></i>

                            <strong>
                                Aucune filière
                            </strong>

                            <span>
                                Aucune filière n'est associée à ce domaine.
                            </span>

                        </div>

                    @endforelse

                </div>

            </section>

        @empty

            <div class="modules-global-empty">

                <div class="modules-global-empty-icon">

                    <i class="bi bi-collection"></i>

                </div>

                <h3>
                    Aucun domaine académique trouvé
                </h3>

                <p>
                    Aucun domaine de l'enseignement supérieur
                    n'est actuellement disponible.
                </p>

            </div>

        @endforelse

    </div>


    {{-- =========================================================
         AUCUN RÉSULTAT DE RECHERCHE
    ========================================================== --}}

    <div
        id="modulesSearchEmpty"
        class="modules-search-empty"
        style="display: none;"
    >

        <div class="modules-search-empty-icon">

            <i class="bi bi-search"></i>

        </div>

        <h3>
            Aucun résultat
        </h3>

        <p>
            Aucun module, niveau, filière ou domaine ne correspond
            à votre recherche.
        </p>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT RECHERCHE
============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('moduleSearch');

    const clearButton =
        document.getElementById('clearModuleSearch');

    const resultInfo =
        document.getElementById('moduleSearchResult');

    const emptyResult =
        document.getElementById('modulesSearchEmpty');

    const domainCards =
        document.querySelectorAll('.modules-domain-card');


    if (!searchInput) {
        return;
    }


    function normalize(value) {

        return (value || '')
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();

    }


    function searchModules() {

        const search =
            normalize(searchInput.value);


        let totalModules = 0;


        domainCards.forEach(function (domainCard) {

            const domainName =
                normalize(
                    domainCard.dataset.domaine
                );


            let domainVisible = false;


            const filiereCards =
                domainCard.querySelectorAll(
                    '.modules-filiere-card'
                );


            filiereCards.forEach(function (filiereCard) {

                const filiereName =
                    normalize(
                        filiereCard.dataset.filiere
                    );


                let filiereVisible = false;


                const levelBlocks =
                    filiereCard.querySelectorAll(
                        '.modules-level-block'
                    );


                levelBlocks.forEach(function (levelBlock) {

                    const levelName =
                        normalize(
                            levelBlock.dataset.niveau
                        );


                    let levelVisible = false;


                    const moduleRows =
                        levelBlock.querySelectorAll(
                            '.module-row'
                        );


                    moduleRows.forEach(function (row) {

                        const moduleName =
                            normalize(
                                row.dataset.module
                            );


                        const match =
                            search === '' ||
                            moduleName.includes(search) ||
                            levelName.includes(search) ||
                            filiereName.includes(search) ||
                            domainName.includes(search);


                        if (match) {

                            row.style.display = '';

                            levelVisible = true;

                            filiereVisible = true;

                            domainVisible = true;

                            totalModules++;

                        } else {

                            row.style.display = 'none';

                        }

                    });


                    /*
                    Si la recherche correspond au niveau,
                    on affiche tous ses modules.
                    */

                    if (
                        search !== '' &&
                        levelName.includes(search)
                    ) {

                        moduleRows.forEach(function (row) {

                            row.style.display = '';

                            levelVisible = true;

                            filiereVisible = true;

                            domainVisible = true;

                        });

                    }


                    /*
                    Si la recherche correspond à la filière,
                    on affiche tous ses niveaux.
                    */

                    if (
                        search !== '' &&
                        filiereName.includes(search)
                    ) {

                        levelBlock.style.display = '';

                        filiereVisible = true;

                        domainVisible = true;

                        moduleRows.forEach(function (row) {

                            row.style.display = '';

                            totalModules++;

                        });

                    }


                    /*
                    Si la recherche correspond au domaine,
                    on affiche tout.
                    */

                    if (
                        search !== '' &&
                        domainName.includes(search)
                    ) {

                        levelBlock.style.display = '';

                        filiereVisible = true;

                        domainVisible = true;

                        moduleRows.forEach(function (row) {

                            row.style.display = '';

                        });

                    } else {

                        levelBlock.style.display =
                            levelVisible
                                ? ''
                                : 'none';

                    }

                });


                filiereCard.style.display =
                    filiereVisible
                        ? ''
                        : 'none';

            });


            domainCard.style.display =
                domainVisible || search === ''
                    ? ''
                    : 'none';

        });


        /*
        Recherche vide
        */

        if (search === '') {

            resultInfo.textContent =
                'Recherche dans les modules';

            emptyResult.style.display = 'none';

        } else {

            resultInfo.textContent =
                totalModules +
                (
                    totalModules > 1
                        ? ' module(s) trouvé(s)'
                        : ' module trouvé'
                );


            emptyResult.style.display =
                totalModules === 0
                    ? 'flex'
                    : 'none';

        }


        clearButton.style.display =
            search !== ''
                ? 'flex'
                : 'none';

    }


    searchInput.addEventListener(
        'input',
        searchModules
    );


    clearButton.addEventListener(
        'click',
        function () {

            searchInput.value = '';

            searchInput.focus();

            searchModules();

        }
    );


    searchModules();

});

</script>

@endsection