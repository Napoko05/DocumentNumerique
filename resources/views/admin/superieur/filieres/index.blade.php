@extends('layouts.admin_app')

@section('content')

<div class="admin-filieres-page">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="filieres-header">

        <div class="filieres-header-content">

            <div>
                <div class="filieres-eyebrow">
                    Enseignement supérieur
                </div>

                <h1 class="filieres-title">
                    Gestion des filières
                </h1>

                <p class="filieres-subtitle">
                    Gérez les filières rattachées aux différents domaines
                    de l'enseignement supérieur.
                </p>
            </div>


            <a href="{{ route('admin.superieur.filieres.create') }}"
               class="btn filieres-add-btn">

                <i class="bi bi-plus-lg"></i>

                <span>
                    Ajouter une filière
                </span>

            </a>

        </div>

    </div>


    {{-- =========================================================
         RECHERCHE
    ========================================================== --}}

    <div class="filieres-toolbar">

        <div class="filieres-search-wrapper">

            <i class="bi bi-search filieres-search-icon"></i>

            <input
                type="search"
                id="filiereSearch"
                class="form-control filieres-search"
                placeholder="Rechercher une filière..."
                autocomplete="off"
            >

            <button
                type="button"
                id="clearFiliereSearch"
                class="filieres-search-clear"
                aria-label="Effacer la recherche"
                title="Effacer">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>

        <div class="filieres-result-info">
            <span id="filiereSearchResult">
                {{ $domaines->sum(fn($domaine) => $domaine->filieres->count()) }}
                filière(s)
            </span>
        </div>

    </div>


    {{-- =========================================================
         LISTE DES DOMAINES
    ========================================================== --}}

    <div class="filieres-container">

        @forelse($domaines as $domaine)

            <section
                class="filiere-domain-card"
                data-domaine="{{ strtolower($domaine->name) }}"
            >

                {{-- =================================================
                     HEADER DOMAINE
                ================================================== --}}

                <div class="filiere-domain-header">

                    <div class="filiere-domain-title">

                        <div class="filiere-domain-icon">

                            <i class="bi bi-diagram-3"></i>

                        </div>

                        <div>

                            <div class="filiere-domain-label">
                                Domaine
                            </div>

                            <h2>
                                {{ $domaine->name }}
                            </h2>

                        </div>

                    </div>


                    <div class="filiere-domain-count">

                        <span class="domain-count-number">
                            {{ $domaine->filieres->count() }}
                        </span>

                        <span>
                            filière(s)
                        </span>

                    </div>

                </div>


                {{-- =================================================
                     TABLEAU
                ================================================== --}}

                <div class="filiere-table-wrapper">

                    <table class="table filiere-table">

                        <thead>

                            <tr>

                                <th>
                                    <span>
                                        Filière
                                    </span>
                                </th>

                                <th class="filiere-actions-column">
                                    <span>
                                        Actions
                                    </span>
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($domaine->filieres as $filiere)

                            <tr
                                class="filiere-row"
                                data-filiere="{{ strtolower($filiere->name) }}"
                            >

                                <td>

                                    <div class="filiere-name-wrapper">

                                        <div class="filiere-icon">

                                            <i class="bi bi-mortarboard"></i>

                                        </div>

                                        <div>

                                            <div class="filiere-name">
                                                {{ $filiere->name }}
                                            </div>

                                            <div class="filiere-domain-mobile">
                                                {{ $domaine->name }}
                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <td class="filiere-actions-column">

                                    <div class="filiere-actions">

                                        {{-- Modifier --}}

                                        <a
                                            href="{{ route(
                                                'admin.superieur.filieres.edit',
                                                $filiere
                                            ) }}"
                                            class="filiere-action-btn filiere-edit-btn"
                                            title="Modifier la filière"
                                        >

                                            <i class="bi bi-pencil-square"></i>

                                            <span>
                                                Modifier
                                            </span>

                                        </a>


                                        {{-- Supprimer --}}

                                        <form
                                            action="{{ route(
                                                'admin.superieur.filieres.destroy',
                                                $filiere
                                            ) }}"
                                            method="POST"
                                            class="filiere-delete-form"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="filiere-action-btn filiere-delete-btn"
                                                title="Supprimer la filière"
                                                onclick="return confirm('Supprimer cette filière ?')"
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

                            <tr class="filiere-empty-row">

                                <td colspan="2">

                                    <div class="filiere-empty">

                                        <div class="filiere-empty-icon">

                                            <i class="bi bi-folder2-open"></i>

                                        </div>

                                        <strong>
                                            Aucune filière
                                        </strong>

                                        <span>
                                            Ce domaine ne contient encore aucune filière.
                                        </span>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Message domaine sans résultat lors de la recherche --}}

                <div class="filiere-no-search-result">

                    <i class="bi bi-search"></i>

                    <span>
                        Aucune filière trouvée dans ce domaine.
                    </span>

                </div>

            </section>

        @empty

            <div class="filieres-global-empty">

                <div class="filieres-global-empty-icon">

                    <i class="bi bi-diagram-3"></i>

                </div>

                <h3>
                    Aucun domaine disponible
                </h3>

                <p>
                    Aucun domaine de l'enseignement supérieur
                    n'est actuellement disponible.
                </p>

                <a
                    href="{{ route('admin.superieur.filieres.create') }}"
                    class="btn filieres-add-btn"
                >

                    <i class="bi bi-plus-lg"></i>

                    Ajouter une filière

                </a>

            </div>

        @endforelse

    </div>


    {{-- =========================================================
         AUCUN RÉSULTAT GLOBAL
    ========================================================== --}}

    <div
        id="filieresNoGlobalResult"
        class="filieres-global-search-empty"
        style="display: none;"
    >

        <div class="filieres-global-empty-icon">

            <i class="bi bi-search"></i>

        </div>

        <h3>
            Aucune filière trouvée
        </h3>

        <p>
            Aucune filière ne correspond à votre recherche.
        </p>

    </div>

</div>


{{-- =============================================================
     RECHERCHE JAVASCRIPT
============================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('filiereSearch');
    const clearButton = document.getElementById('clearFiliereSearch');
    const resultInfo = document.getElementById('filiereSearchResult');
    const globalEmpty = document.getElementById('filieresNoGlobalResult');

    const domainCards = document.querySelectorAll('.filiere-domain-card');

    if (!searchInput) {
        return;
    }


    function normalizeText(text) {

        return text
            .toLowerCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim();

    }


    function performSearch() {

        const searchValue = normalizeText(searchInput.value);

        let totalResults = 0;
        let visibleDomains = 0;


        domainCards.forEach(function (domainCard) {

            const rows = domainCard.querySelectorAll('.filiere-row');

            let domainResults = 0;


            rows.forEach(function (row) {

                const filiereName =
                    normalizeText(
                        row.getAttribute('data-filiere') || ''
                    );

                const domainName =
                    normalizeText(
                        domainCard.getAttribute('data-domaine') || ''
                    );


                const matches =
                    searchValue === '' ||
                    filiereName.includes(searchValue) ||
                    domainName.includes(searchValue);


                if (matches) {

                    row.style.display = '';

                    domainResults++;

                    totalResults++;

                } else {

                    row.style.display = 'none';

                }

            });


            const noSearchResult =
                domainCard.querySelector('.filiere-no-search-result');


            const tableWrapper =
                domainCard.querySelector('.filiere-table-wrapper');


            if (domainResults > 0) {

                domainCard.style.display = '';

                visibleDomains++;

                if (noSearchResult) {
                    noSearchResult.style.display = 'none';
                }

                if (tableWrapper) {
                    tableWrapper.style.display = '';
                }

            } else {

                if (searchValue === '') {

                    domainCard.style.display = '';

                    visibleDomains++;

                    if (noSearchResult) {
                        noSearchResult.style.display = 'none';
                    }

                    if (tableWrapper) {
                        tableWrapper.style.display = '';
                    }

                } else {

                    domainCard.style.display = 'none';

                }

            }

        });


        if (resultInfo) {

            resultInfo.textContent =
                totalResults +
                (totalResults > 1
                    ? ' filières trouvées'
                    : ' filière trouvée');

        }


        if (clearButton) {

            clearButton.style.display =
                searchValue !== ''
                    ? 'flex'
                    : 'none';

        }


        if (globalEmpty) {

            globalEmpty.style.display =
                searchValue !== '' && totalResults === 0
                    ? 'flex'
                    : 'none';

        }

    }


    searchInput.addEventListener(
        'input',
        performSearch
    );


    if (clearButton) {

        clearButton.addEventListener(
            'click',
            function () {

                searchInput.value = '';

                searchInput.focus();

                performSearch();

            }
        );

    }


    performSearch();

});
</script>

@endsection