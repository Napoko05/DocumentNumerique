@extends('layouts.admin_app')

@section('title', 'Ajouter un niveau')

@section('page-title', 'Ajouter un niveau')

@section('content')

<div class="admin-level-form-page">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="level-form-header">

        <div>

            <div class="level-form-breadcrumb">

                <a href="{{ route('admin.superieur.levels.index') }}">
                    Gestion des niveaux
                </a>

                <i class="bi bi-chevron-right"></i>

                <span>Ajouter</span>

            </div>

            <h1>Ajouter un niveau</h1>

            <p>
                Sélectionnez un domaine, puis une filière
                pour créer un niveau de l'enseignement supérieur.
            </p>

        </div>

        <a
            href="{{ route('admin.superieur.levels.index') }}"
            class="level-back-button"
        >
            <i class="bi bi-arrow-left"></i>
            Retour
        </a>

    </div>

    {{-- =========================================================
         FORMULAIRE
    ========================================================== --}}

    <form
        method="POST"
        action="{{ route('admin.superieur.levels.store') }}"
        class="level-form-card"
        id="levelCreateForm"
    >

        @csrf

        {{-- =====================================================
             1 — DOMAINE
        ====================================================== --}}

        <div class="level-form-section">

            <div class="level-form-section-title">

                <span>
                    <i class="bi bi-diagram-3"></i>
                </span>

                <div>

                    <h2>Domaine académique</h2>

                    <p>
                        Sélectionnez le domaine académique.
                    </p>

                </div>

            </div>

            <div class="level-form-group">

                <label for="academic_domain_id">

                    Domaine

                    <span>*</span>

                </label>

                <select
                    name="academic_domain_id"
                    id="academic_domain_id"
                    class="level-form-control @error('academic_domain_id') is-invalid @enderror"
                    required
                >

                    <option value="">
                        Sélectionner un domaine
                    </option>


                    @foreach($domains as $domain)

                        <option
                            value="{{ $domain->id }}"
                            {{ old('academic_domain_id') == $domain->id ? 'selected' : '' }}
                        >
                            {{ $domain->name }}
                        </option>

                    @endforeach

                </select>


                @error('academic_domain_id')

                    <div class="level-form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        </div>

        {{-- =====================================================
             2 — FILIÈRE
        ====================================================== --}}

        <div
            class="level-form-section"
            id="filiereSection"
            style="display: none;"
        >
            <div class="level-form-section-title">

                <span>
                    <i class="bi bi-diagram-2"></i>
                </span>

                <div>

                    <h2>Filière</h2>

                    <p>
                        Sélectionnez une filière appartenant
                        au domaine choisi.
                    </p>

                </div>

            </div>

            <div class="level-form-group">

                <label for="filiere_id">

                    Filière

                    <span>*</span>

                </label>

                <select
                    name="filiere_id"
                    id="filiere_id"
                    class="level-form-control @error('filiere_id') is-invalid @enderror"
                    required
                    disabled
                >

                    <option value="">
                        Sélectionner une filière
                    </option>

                </select>

                @error('filiere_id')

                    <div class="level-form-error">
                        {{ $message }}
                    </div>

                @enderror
                <div
                    id="noFiliereMessage"
                    class="level-form-help"
                    style="display: none;"
                >
                    Aucune filière active n'est disponible
                    dans ce domaine.
                </div>

            </div>

        </div>

        {{-- =====================================================
             3 — INFORMATIONS DU NIVEAU
        ====================================================== --}}

        <div
            class="level-form-section"
            id="levelInformationSection"
            style="display: none;"
        >

            <div class="level-form-section-title">

                <span>
                    <i class="bi bi-layers"></i>
                </span>

                <div>

                    <h2>Informations du niveau</h2>

                    <p>
                        Définissez le nom et l'ordre d'affichage.
                    </p>

                </div>

            </div>

            <div class="level-form-grid">


                {{-- NOM --}}

                <div class="level-form-group level-form-group-large">

                    <label for="name">

                        Nom du niveau

                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name') }}"
                        class="level-form-control @error('name') is-invalid @enderror"
                        placeholder="Exemple : Licence 1"
                        required
                        disabled
                    >
                    @error('name')

                        <div class="level-form-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ORDRE --}}

                <div class="level-form-group">

                    <label for="order">

                        Ordre

                        <span>*</span>

                    </label>


                    <input
                        type="number"
                        name="order"
                        id="order"
                        value="{{ old('order', 1) }}"
                        min="1"
                        max="255"
                        class="level-form-control @error('order') is-invalid @enderror"
                        required
                        disabled
                    >


                    @error('order')

                        <div class="level-form-error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

            </div>

        </div>



        {{-- =====================================================
             4 — STATUT
        ====================================================== --}}

        <div
            class="level-form-section"
            id="levelStatusSection"
            style="display: none;"
        >

            <div class="level-form-section-title">

                <span>
                    <i class="bi bi-toggle-on"></i>
                </span>

                <div>

                    <h2>Statut</h2>

                    <p>
                        Déterminez si le niveau est visible et utilisable.
                    </p>

                </div>

            </div>


            <label class="level-switch">

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    id="is_active"
                    {{ old('is_active', true) ? 'checked' : '' }}
                    disabled
                >

                <span class="level-switch-slider"></span>

                <span class="level-switch-text">
                    Niveau actif
                </span>

            </label>

        </div>



        {{-- =====================================================
             FOOTER
        ====================================================== --}}

        <div class="level-form-footer">

            <a
                href="{{ route('admin.superieur.levels.index') }}"
                class="level-cancel-button"
            >
                Annuler
            </a>


            <button
                type="submit"
                class="level-submit-button"
                id="submitLevelButton"
                disabled
            >
                <i class="bi bi-check-lg"></i>
                Enregistrer le niveau
            </button>

        </div>

    </form>

</div>

{{-- =============================================================
     JAVASCRIPT
     Domaine → Filières → Niveau
============================================================= --}}
@php
    $domainsData = $domains->map(function ($domain) {
        return [
            'id' => $domain->id,
            'name' => $domain->name,
            'filieres' => $domain->filieres->map(function ($filiere) {
                return [
                    'id' => $filiere->id,
                    'name' => $filiere->name,
                ];
            })->values()->all(),
        ];
    })->values()->all();
@endphp

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | DONNÉES DES DOMAINES ET FILIÈRES
    |--------------------------------------------------------------------------
    */

    const domains = @json($domainsData);


    /*
    |--------------------------------------------------------------------------
    | ÉLÉMENTS DU FORMULAIRE
    |--------------------------------------------------------------------------
    */

    const domainSelect =
        document.getElementById('academic_domain_id');

    const filiereSelect =
        document.getElementById('filiere_id');

    const filiereSection =
        document.getElementById('filiereSection');

    const levelInformationSection =
        document.getElementById('levelInformationSection');

    const levelStatusSection =
        document.getElementById('levelStatusSection');

    const noFiliereMessage =
        document.getElementById('noFiliereMessage');

    const nameInput =
        document.getElementById('name');

    const orderInput =
        document.getElementById('order');

    const activeInput =
        document.getElementById('is_active');

    const submitButton =
        document.getElementById('submitLevelButton');


    /*
    |--------------------------------------------------------------------------
    | ANCIENNES VALEURS
    |--------------------------------------------------------------------------
    */

    const oldDomainId =
        @json(old('academic_domain_id'));

    const oldFiliereId =
        @json(old('filiere_id'));


    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION DES ÉLÉMENTS
    |--------------------------------------------------------------------------
    */

    if (
        !domainSelect ||
        !filiereSelect ||
        !filiereSection ||
        !levelInformationSection ||
        !levelStatusSection ||
        !nameInput ||
        !orderInput ||
        !activeInput ||
        !submitButton
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | AFFICHER / CACHER LES CHAMPS DU NIVEAU
    |--------------------------------------------------------------------------
    */

    function updateLevelFields() {

        const hasFiliere =
            filiereSelect.value !== '';


        levelInformationSection.style.display =
            hasFiliere ? 'block' : 'none';


        levelStatusSection.style.display =
            hasFiliere ? 'block' : 'none';


        nameInput.disabled =
            !hasFiliere;


        orderInput.disabled =
            !hasFiliere;


        activeInput.disabled =
            !hasFiliere;


        submitButton.disabled =
            !hasFiliere;
    }


    /*
    |--------------------------------------------------------------------------
    | CHARGER LES FILIÈRES DU DOMAINE
    |--------------------------------------------------------------------------
    */

    function loadFilieres(
        domainId,
        selectedFiliereId = null
    ) {

        /*
        |----------------------------------------------------------------------
        | Réinitialiser la liste
        |----------------------------------------------------------------------
        */

        filiereSelect.innerHTML = `
            <option value="">
                Sélectionner une filière
            </option>
        `;


        filiereSelect.disabled = true;


        /*
        |----------------------------------------------------------------------
        | Masquer les sections
        |----------------------------------------------------------------------
        */

        filiereSection.style.display = 'none';

        levelInformationSection.style.display = 'none';

        levelStatusSection.style.display = 'none';


        if (noFiliereMessage) {
            noFiliereMessage.style.display = 'none';
        }


        /*
        |----------------------------------------------------------------------
        | Désactiver les champs
        |----------------------------------------------------------------------
        */

        nameInput.disabled = true;

        orderInput.disabled = true;

        activeInput.disabled = true;

        submitButton.disabled = true;


        /*
        |----------------------------------------------------------------------
        | Aucun domaine
        |----------------------------------------------------------------------
        */

        if (!domainId) {
            return;
        }


        /*
        |----------------------------------------------------------------------
        | Trouver le domaine sélectionné
        |----------------------------------------------------------------------
        */

        const domain = domains.find(function (item) {

            return String(item.id) ===
                String(domainId);

        });


        if (!domain) {
            return;
        }


        /*
        |----------------------------------------------------------------------
        | Afficher la section filière
        |----------------------------------------------------------------------
        */

        filiereSection.style.display = 'block';


        /*
        |----------------------------------------------------------------------
        | Aucune filière disponible
        |----------------------------------------------------------------------
        */

        if (
            !domain.filieres ||
            domain.filieres.length === 0
        ) {

            if (noFiliereMessage) {
                noFiliereMessage.style.display = 'block';
            }

            return;
        }


        /*
        |----------------------------------------------------------------------
        | Ajouter les filières
        |----------------------------------------------------------------------
        */

        domain.filieres.forEach(function (filiere) {

            const option =
                document.createElement('option');


            option.value =
                filiere.id;


            option.textContent =
                filiere.name;


            if (
                selectedFiliereId &&
                String(selectedFiliereId) ===
                    String(filiere.id)
            ) {

                option.selected = true;
            }


            filiereSelect.appendChild(option);

        });


        /*
        |----------------------------------------------------------------------
        | Activer la liste
        |----------------------------------------------------------------------
        */

        filiereSelect.disabled = false;


        /*
        |----------------------------------------------------------------------
        | Restaurer l'ancienne sélection
        |----------------------------------------------------------------------
        */

        updateLevelFields();
    }


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE DOMAINE
    |--------------------------------------------------------------------------
    */

    domainSelect.addEventListener(
        'change',
        function () {

            loadFilieres(
                this.value
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CHANGEMENT DE FILIÈRE
    |--------------------------------------------------------------------------
    */

    filiereSelect.addEventListener(
        'change',
        function () {

            updateLevelFields();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESTAURATION APRÈS ERREUR DE VALIDATION
    |--------------------------------------------------------------------------
    */

    if (oldDomainId) {

        domainSelect.value =
            oldDomainId;


        loadFilieres(
            oldDomainId,
            oldFiliereId
        );

    } else {

        updateLevelFields();

    }

});

</script>



@endsection
