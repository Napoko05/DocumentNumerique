@extends('layouts.admin_app')

@section('title', 'Modifier le niveau')

@section('page-title', 'Modifier le niveau')

@section('content')

<div class="admin-level-form-page">

<div class="level-form-header">

    <div>

        <div class="level-form-breadcrumb">

            <a href="{{ route('admin.superieur.levels.index') }}">
                Gestion des niveaux
            </a>

            <i class="bi bi-chevron-right"></i>

            <span>Modifier</span>

        </div>

        <h1>Modifier le niveau</h1>

        <p>
            Modifiez les informations du niveau
            <strong>{{ $level->name }}</strong>.
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


<form
    method="POST"
    action="{{ route('admin.superieur.levels.update', $level) }}"
    class="level-form-card"
>

    @csrf
    @method('PUT')


    <div class="level-form-section">

        <div class="level-form-section-title">

            <span>
                <i class="bi bi-diagram-3"></i>
            </span>

            <div>
                <h2>Filière</h2>
                <p>Choisissez la filière du niveau.</p>
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
            >

                <option value="">
                    Sélectionner une filière
                </option>

                @foreach($filieres as $filiere)

                    <option
                        value="{{ $filiere->id }}"
                        {{ old('filiere_id', $level->filiere_id) == $filiere->id ? 'selected' : '' }}
                    >
                        {{ $filiere->domaine?->name ?? 'Domaine' }}
                        — {{ $filiere->name }}
                    </option>

                @endforeach

            </select>

            @error('filiere_id')
                <div class="level-form-error">
                    {{ $message }}
                </div>
            @enderror

        </div>

    </div>


    <div class="level-form-section">

        <div class="level-form-section-title">

            <span>
                <i class="bi bi-layers"></i>
            </span>

            <div>
                <h2>Informations du niveau</h2>
                <p>Modifiez le nom et l'ordre d'affichage.</p>
            </div>

        </div>


        <div class="level-form-grid">

            <div class="level-form-group level-form-group-large">

                <label for="name">
                    Nom du niveau
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $level->name) }}"
                    class="level-form-control @error('name') is-invalid @enderror"
                    required
                >

                @error('name')
                    <div class="level-form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="level-form-group">

                <label for="order">
                    Ordre
                    <span>*</span>
                </label>

                <input
                    type="number"
                    name="order"
                    id="order"
                    value="{{ old('order', $level->order) }}"
                    min="1"
                    max="255"
                    class="level-form-control @error('order') is-invalid @enderror"
                    required
                >

                @error('order')
                    <div class="level-form-error">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>


    <div class="level-form-section">

        <div class="level-form-section-title">

            <span>
                <i class="bi bi-toggle-on"></i>
            </span>

            <div>
                <h2>Statut</h2>
                <p>Déterminez si le niveau est actif.</p>
            </div>

        </div>


        <label class="level-switch">

            <input
                type="checkbox"
                name="is_active"
                value="1"
                {{ old('is_active', $level->is_active) ? 'checked' : '' }}
            >

            <span class="level-switch-slider"></span>

            <span class="level-switch-text">
                Niveau actif
            </span>

        </label>

    </div>


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
        >
            <i class="bi bi-check-lg"></i>
            Enregistrer les modifications
        </button>

    </div>

</form>

</div>

@endsection
