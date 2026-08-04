@extends('layouts.journalist_app')

@section('title', 'Ajouter un document')

@section('content')

<div class="container py-4">


    {{-- ========================================================= --}}
    {{-- TITRE --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Ajouter un document

            </h2>

            <p class="text-muted mb-0">

                Complétez les informations puis publiez votre document.

            </p>
        </div>

        <a
            href="{{ route('journaliste.documents.index') }}"
            class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>

            Retour

        </a>
    </div>

    {{-- ========================================================= --}}
    {{-- BARRE DE PROGRESSION --}}
    {{-- ========================================================= --}}

    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <div class="row text-center">

                <div class="col-md-4">

                    <div
                        class="step-indicator active"
                        id="indicator-1">

                        <span>

                            1

                        </span>

                    </div>

                    <strong>

                        Parcours

                    </strong>

                </div>


                <div class="col-md-4">

                    <div
                        class="step-indicator"
                        id="indicator-2">

                        <span>

                            2

                        </span>

                    </div>

                    <strong>

                        Document

                    </strong>

                </div>

                <div class="col-md-4">

                    <div
                        class="step-indicator"
                        id="indicator-3">

                        <span>

                            3

                        </span>

                    </div>

                    <strong>

                        Récapitulatif

                    </strong>

                </div>

            </div>

        </div>

    </div>
    {{-- ========================================================= --}}
    {{-- FORMULAIRE --}}
    {{-- ========================================================= --}}
    <form
        id="documentForm"
        method="POST"
        action="{{ route('journaliste.documents.store') }}"
        enctype="multipart/form-data"

        data-formations-url="{{ url('/journaliste/ajax/formations') }}"
        data-filieres-url="{{ url('/journaliste/ajax/filieres') }}"
        data-programs-url="{{ url('/journaliste/ajax/formations') }}"
        data-specialites-url="{{ url('/journaliste/ajax/programs') }}"
        data-levels-url="{{ url('/journaliste/ajax/specialites') }}"
        data-subjects-url="{{ url('/journaliste/ajax/levels') }}">
        @csrf

        {{-- Le reste du formulaire --}}


        {{-- ========================================================= --}}
        {{-- WIZARD : BARRE DE PROGRESSION --}}
        {{-- ========================================================= --}}

        <div class="document-wizard">

            <div class="wizard-progress">
                <div class="wizard-progress-line">
                    <div class="wizard-progress-fill" id="wizardProgressFill"></div>
                </div>

                <div class="wizard-step active" data-step="1">

                    <button type="button" class="wizard-step-number">
                        <span>1</span>
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12l4 4L19 6"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="wizard-step-text">
                        <strong>Classification</strong>
                        <small>Organisation académique</small>
                    </div>

                </div>

                <div class="wizard-step" data-step="2">

                    <button type="button" class="wizard-step-number">
                        <span>2</span>
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12l4 4L19 6"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="wizard-step-text">
                        <strong>Informations</strong>
                        <small>Détails de la publication</small>
                    </div>

                </div>

                <div class="wizard-step" data-step="3">

                    <button type="button" class="wizard-step-number">
                        <span>3</span>
                        <svg viewBox="0 0 24 24" fill="none">
                            <path d="M5 12l4 4L19 6"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>

                    <div class="wizard-step-text">
                        <strong>Validation</strong>
                        <small>Fichier et publication</small>
                    </div>

                </div>

            </div>


        </div>


        {{-- ===================================================== --}}
        {{-- ÉTAPE 1 --}}
        {{-- ===================================================== --}}

        <div
            class="form-step"
            id="step-1">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Étape 1 :
                        Catégorie et parcours pédagogique

                    </h5>

                </div>


                <div class="card-body">


                    {{-- ================================================= --}}
                    {{-- CATÉGORIE --}}
                    {{-- ================================================= --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Catégorie d’enseignement

                            <span class="text-danger">

                                *

                            </span>

                        </label>


                        <select

                            name="teaching_category_id"

                            id="teaching_category_id"

                            class="form-select"

                            required>

                            <option value="">

                                -- Sélectionner une catégorie --

                            </option>


                            @foreach ($categories as $category)

                            <option

                                value="{{ $category->id }}"

                                data-slug="{{ $category->slug }}"

                                @selected(
                                old( 'teaching_category_id'
                                )==$category->id
                                )

                                >

                                {{ $category->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FORMATION --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="formation-container">

                        <label class="form-label fw-bold">

                            Formation

                        </label>


                        <select

                            name="formation_id"

                            id="formation_id"

                            class="form-select">

                            <option value="">

                                -- Sélectionner une formation --

                            </option>


                            @foreach ($formations as $formation)

                            <option

                                value="{{ $formation->id }}"

                                data-slug="{{ $formation->slug }}"

                                @selected(
                                old( 'formation_id'
                                )==$formation->id
                                )

                                >

                                {{ $formation->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FILIÈRE --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="filiere-container">

                        <label class="form-label fw-bold">

                            Filière

                        </label>


                        <select

                            name="filiere_id"

                            id="filiere_id"

                            class="form-select">

                            <option value="">

                                -- Sélectionner une filière --

                            </option>


                            @foreach ($filieres as $filiere)

                            <option

                                value="{{ $filiere->id }}"

                                @selected(
                                old( 'filiere_id'
                                )==$filiere->id
                                )

                                >

                                {{ $filiere->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PROGRAMME --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="program-container">

                        <label class="form-label fw-bold">

                            Programme

                        </label>


                        <select

                            name="program_id"

                            id="program_id"

                            class="form-select">

                            <option value="">

                                -- Sélectionner un programme --

                            </option>

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SPÉCIALITÉ --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="specialite-container">

                        <label class="form-label fw-bold">

                            Spécialité

                        </label>


                        <select

                            name="specialite_id"

                            id="specialite_id"

                            class="form-select">

                            <option value="">

                                -- Sélectionner une spécialité --

                            </option>


                            @foreach ($specialites as $specialite)

                            <option

                                value="{{ $specialite->id }}"

                                @selected(
                                old( 'specialite_id'
                                )==$specialite->id
                                )

                                >

                                {{ $specialite->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- NIVEAU --}}
                    {{-- ================================================= --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Niveau / Classe

                            <span class="text-danger">

                                *

                            </span>

                        </label>


                        <select

                            name="level_id"

                            id="level_id"

                            class="form-select"

                            required>

                            <option value="">

                                -- Sélectionner un niveau --

                            </option>


                            @foreach ($levels as $level)

                            <option

                                value="{{ $level->id }}"

                                data-formation="{{ $level->formation_id }}"

                                data-filiere="{{ $level->filiere_id }}"

                                data-specialite="{{ $level->specialite_id }}"

                                @selected(
                                old( 'level_id'
                                )==$level->id
                                )

                                >

                                {{ $level->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- MATIÈRE / MODULE --}}
                    {{-- ================================================= --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Matière / Module

                            <span class="text-danger">

                                *

                            </span>

                        </label>


                        <select

                            name="subject_id"

                            id="subject_id"

                            class="form-select"

                            required>

                            <option value="">

                                -- Sélectionner une matière --

                            </option>


                            @foreach ($subjects as $subject)

                            <option

                                value="{{ $subject->id }}"

                                data-level="{{ $subject->level_id }}"

                                @selected(
                                old( 'subject_id'
                                )==$subject->id
                                )

                                >

                                {{ $subject->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- ================================================= --}}
                    {{-- BOUTON SUIVANT --}}
                    {{-- ================================================= --}}

                    <div class="text-end">

                        <button

                            type="button"

                            class="btn btn-primary px-4"

                            onclick="nextStep(2)">

                            Suivant

                            <i class="bi bi-arrow-right"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- ÉTAPE 2 --}}
        {{-- ===================================================== --}}

        <div
            class="form-step d-none"
            id="step-2">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Étape 2 :
                        Informations et fichier

                    </h5>

                </div>


                <div class="card-body">


                    {{-- TITRE --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Titre du document

                            <span class="text-danger">

                                *

                            </span>

                        </label>


                        <input

                            type="text"

                            name="title"

                            id="title"

                            class="form-control"

                            value="{{ old('title') }}"

                            required>

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Description

                        </label>


                        <textarea

                            name="description"

                            class="form-control"

                            rows="4">{{ old('description') }}</textarea>

                    </div>


                    {{-- CONTENU --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Contenu complémentaire

                        </label>


                        <textarea

                            name="content"

                            class="form-control"

                            rows="5">{{ old('content') }}</textarea>

                    </div>


                    {{-- TYPE DOCUMENT --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Type de document

                            <span class="text-danger">

                                *

                            </span>

                        </label>


                        <select

                            name="document_type_id"

                            class="form-select"

                            required>

                            <option value="">

                                -- Sélectionner un type --

                            </option>


                            @foreach ($documentTypes as $type)

                            <option

                                value="{{ $type->id }}"

                                @selected(
                                old( 'document_type_id'
                                )==$type->id
                                )

                                >

                                {{ $type->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- PDF --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Document PDF

                            <span class="text-danger">

                                *

                            </span>

                        </label>


                        <input

                            type="file"

                            name="file_path"

                            class="form-control"

                            accept=".pdf"

                            required>

                    </div>

                    {{-- COUVERTURE --}}

                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Image de couverture

                        </label>
                        <input

                            type="file"

                            name="cover_image"

                            class="form-control"

                            accept=".jpg,.jpeg,.png,.webp">

                    </div>

                    {{-- ACCÈS --}}

                    <div class="row">

                        <div class="col-md-6">

                            <label class="form-label fw-bold">

                                Type d’accès

                            </label>
                            <select

                                name="access_type"

                                id="access_type"

                                class="form-select"

                                required>

                                <option value="free">

                                    Gratuit

                                </option>

                                <option value="premium">

                                    Premium

                                </option>

                            </select>

                        </div>


                        <div
                            class="col-md-6"
                            id="price-container">

                            <label class="form-label fw-bold">

                                Prix

                            </label>


                            <input

                                type="number"

                                name="price"

                                class="form-control"

                                min="0"

                                step="0.01"

                                value="{{ old('price') }}">

                        </div>

                    </div>


                    {{-- NAVIGATION --}}

                    <div class="d-flex justify-content-between mt-4">

                        <button

                            type="button"

                            class="btn btn-outline-secondary"

                            onclick="previousStep(1)">

                            Précédent

                        </button>


                        <button

                            type="button"

                            class="btn btn-primary px-4"

                            onclick="nextStep(3)">

                            Voir le récapitulatif

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- ÉTAPE 3 --}}
        {{-- ===================================================== --}}

        <div
            class="form-step d-none"
            id="step-3">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Étape 3 :
                        Vérification et publication

                    </h5>

                </div>


                <div class="card-body">

                    <div
                        class="alert alert-info">

                        Vérifiez les informations avant
                        de publier le document.

                    </div>


                    <div
                        id="document-summary">

                    </div>


                    <div class="d-flex justify-content-between mt-4">

                        <button

                            type="button"

                            class="btn btn-outline-secondary"

                            onclick="previousStep(2)">

                            Précédent

                        </button>


                        <button

                            type="submit"

                            class="btn btn-success px-4">

                            <i class="bi bi-cloud-upload"></i>

                            Publier le document

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection

@push('styles')

<style>
    .step-indicator {

        width: 42px;

        height: 42px;

        margin: 0 auto 8px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        background: #e9ecef;

        color: #6c757d;

        font-weight: bold;

    }

    .step-indicator.active {

        background: #0d6efd;

        color: white;

    }
</style>

@endpush

@push('scripts')
@vite('resources/js/admin/document-wizard.js')
@endpush