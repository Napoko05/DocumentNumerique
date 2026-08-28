@extends('layouts.admin_app')

@section('title', 'Ajouter un module')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-lg-8">

            <div class="card shadow-sm">

                <div class="card-header">
                    <h5 class="mb-0">
                        Ajouter un module
                    </h5>
                </div>

                <div class="card-body">

                    <form
                        action="{{ route('admin.superieur.modules.store') }}"
                        method="POST"
                    >

                        @csrf

                        {{-- DOMAINE --}}
                        <div class="mb-3">

                            <label
                                for="academic_domain_id"
                                class="form-label"
                            >
                                Domaine académique
                            </label>

                            <select
                                id="academic_domain_id"
                                class="form-select"
                            >

                                <option value="">
                                    Sélectionner un domaine
                                </option>

                                @foreach($domaines as $domaine)

                                    <option
                                        value="{{ $domaine->id }}"
                                    >
                                        {{ $domaine->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- FILIÈRE --}}
                        <div class="mb-3">

                            <label
                                for="filiere_id"
                                class="form-label"
                            >
                                Filière
                            </label>

                            <select
                                id="filiere_id"
                                name="filiere_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Sélectionner une filière
                                </option>

                                @foreach($domaines as $domaine)

                                    @foreach($domaine->filieres as $filiere)

                                        <option
                                            value="{{ $filiere->id }}"
                                            data-domaine="{{ $domaine->id }}"
                                            @selected(
                                                old('filiere_id') == $filiere->id
                                            )
                                        >
                                            {{ $filiere->name }}
                                        </option>

                                    @endforeach

                                @endforeach

                            </select>

                            @error('filiere_id')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- NIVEAU --}}
                        <div class="mb-3">

                            <label
                                for="level_id"
                                class="form-label"
                            >
                                Niveau
                            </label>

                            <select
                                id="level_id"
                                name="level_id"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Sélectionner un niveau
                                </option>

                                @foreach($domaines as $domaine)

                                    @foreach($domaine->filieres as $filiere)

                                        @foreach($filiere->levels as $level)

                                            <option
                                                value="{{ $level->id }}"
                                                data-filiere="{{ $filiere->id }}"
                                                @selected(
                                                    old('level_id') == $level->id
                                                )
                                            >
                                                {{ $level->name }}
                                            </option>

                                        @endforeach

                                    @endforeach

                                @endforeach

                            </select>

                            @error('level_id')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- MODULE --}}
                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Nom du module
                            </label>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                placeholder="Exemple : Algorithmique"
                                required
                            >

                            @error('name')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- POSITION --}}
                        <div class="mb-4">

                            <label
                                for="position"
                                class="form-label"
                            >
                                Ordre d'affichage
                            </label>

                            <input
                                id="position"
                                type="number"
                                name="position"
                                min="0"
                                class="form-control"
                                value="{{ old('position', 0) }}"
                            >

                            @error('position')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="text-muted">
                                Définit l'ordre d'affichage du module dans le niveau.
                            </small>

                        </div>


                        {{-- BOUTONS --}}
                        <div class="d-flex gap-2">

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Enregistrer
                            </button>

                            <a
                                href="{{ route('admin.superieur.modules.index') }}"
                                class="btn btn-secondary"
                            >
                                Annuler
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const domaine = document.getElementById('academic_domain_id');
    const filiere = document.getElementById('filiere_id');
    const level = document.getElementById('level_id');

    function filtrerFilieres() {

        const domaineId = domaine.value;

        Array.from(filiere.options).forEach(function (option) {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden =
                option.dataset.domaine !== domaineId;

        });

        filiere.value = '';
        level.value = '';

        Array.from(level.options).forEach(function (option) {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden = true;

        });

    }


    function filtrerNiveaux() {

        const filiereId = filiere.value;

        Array.from(level.options).forEach(function (option) {

            if (!option.value) {
                option.hidden = false;
                return;
            }

            option.hidden =
                option.dataset.filiere !== filiereId;

        });

        level.value = '';

    }


    domaine.addEventListener(
        'change',
        filtrerFilieres
    );


    filiere.addEventListener(
        'change',
        filtrerNiveaux
    );


    /*
     * Initialisation après validation
     */
    if (domaine.value) {
        filtrerFilieres();
    }

    if (filiere.value) {
        filtrerNiveaux();
    }

});

</script>

@endsection