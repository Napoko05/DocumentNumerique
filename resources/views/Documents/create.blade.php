@extends('layouts.journaliste_app')

@section('title','Ajouter un document')

@section('content')

<div class="container py-4">

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

            <i class="bi bi-arrow-left me-1"></i>
            Retour

        </a>

    </div>


    {{-- MESSAGES --}}

    @if(session('success'))

    <div
        class="alert alert-success alert-dismissible fade show"
        role="alert">

        <i class="bi bi-check-circle me-2"></i>

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fermer">
        </button>

    </div>

    @endif


    @if(session('error'))

    <div
        class="alert alert-danger alert-dismissible fade show"
        role="alert">

        <i class="bi bi-exclamation-triangle me-2"></i>

        {{ session('error') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fermer">
        </button>

    </div>

    @endif


    {{-- ERREURS --}}

    @if($errors->any())

    <div class="alert alert-danger" role="alert">

        <div class="fw-bold mb-2">

            <i class="bi bi-exclamation-triangle me-2"></i>

            Veuillez corriger les erreurs suivantes :

        </div>

        <ul class="mb-0">

            @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif


    <form
        id="documentForm"
        method="POST"
        action="{{ route('journaliste.documents.store') }}"
        enctype="multipart/form-data"
        novalidate

        data-formations-url="{{ url('/journaliste/ajax/formations') }}"
        data-academic-domains-url="{{ url('/journaliste/ajax/academic-domains') }}"
        data-filieres-url="{{ url('/journaliste/ajax/filieres') }}"
        data-secondary-levels-url="{{ url('/journaliste/ajax/secondary/levels') }}"
        data-higher-levels-url="{{ url('/journaliste/ajax/higher/levels') }}"
        data-professional-levels-url="{{ url('/journaliste/ajax/professional/levels') }}"
        data-programs-url="{{ url('/journaliste/ajax/programs') }}"
        data-specialites-by-formation-url="{{ url('/journaliste/ajax/specialites-by-formation') }}"
        data-specialites-url="{{ url('/journaliste/ajax/specialites') }}"
        data-specialite-levels-url="{{ url('/journaliste/ajax/specialite/levels') }}"
        data-subjects-url="{{ url('/journaliste/ajax/subjects') }}">

        @csrf


        {{-- ========================================================= --}}
        {{-- PROGRESSION --}}
        {{-- ========================================================= --}}

        <div class="document-wizard mb-4">

            <div class="wizard-progress">

                <div class="wizard-progress-line">

                    <div
                        class="wizard-progress-fill"
                        id="wizardProgressFill">
                    </div>

                </div>


                <div
                    class="wizard-step active"
                    data-step="1">

                    <button
                        type="button"
                        class="wizard-step-number"
                        aria-label="Étape 1">

                        <span>1</span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true">

                            <path
                                d="M5 12l4 4L19 6"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round" />

                        </svg>

                    </button>

                    <div class="wizard-step-text">

                        <strong>
                            Classification
                        </strong>

                        <small>
                            Parcours pédagogique
                        </small>

                    </div>

                </div>


                <div
                    class="wizard-step"
                    data-step="2">

                    <button
                        type="button"
                        class="wizard-step-number"
                        aria-label="Étape 2">

                        <span>2</span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true">

                            <path
                                d="M5 12l4 4L19 6"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round" />

                        </svg>

                    </button>

                    <div class="wizard-step-text">

                        <strong>
                            Document
                        </strong>

                        <small>
                            Informations et fichier
                        </small>

                    </div>

                </div>


                <div
                    class="wizard-step"
                    data-step="3">

                    <button
                        type="button"
                        class="wizard-step-number"
                        aria-label="Étape 3">

                        <span>3</span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true">

                            <path
                                d="M5 12l4 4L19 6"
                                stroke="currentColor"
                                stroke-width="2.5"
                                stroke-linecap="round"
                                stroke-linejoin="round" />

                        </svg>

                    </button>

                    <div class="wizard-step-text">

                        <strong>
                            Validation
                        </strong>

                        <small>
                            Récapitulatif et publication
                        </small>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- ÉTAPE 1 --}}
        {{-- ========================================================= --}}

        <div
            class="form-step active"
            id="step-1">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        Étape 1 : Classification du document
                    </h5>

                </div>

                <div class="card-body p-4">


                    {{-- CATÉGORIE --}}

                    <div class="mb-4">

                        <label
                            for="teaching_category_id"
                            class="form-label fw-bold">

                            Catégorie d’enseignement

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="teaching_category_id"
                            id="teaching_category_id"
                            class="form-select @error('teaching_category_id') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Sélectionner une catégorie --
                            </option>

                            @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                data-slug="{{ $category->slug }}"
                                @selected(old('teaching_category_id')==$category->id)>

                                {{ $category->name }}

                            </option>

                            @endforeach

                        </select>

                        @error('teaching_category_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div
                            id="categoryError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SUPÉRIEUR : DOMAINE --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="academicDomainContainer"
                        style="display:none;">

                        <label
                            for="academic_domain_id"
                            class="form-label fw-bold">

                            Domaine académique

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="academic_domain_id"
                            id="academic_domain_id"
                            class="form-select @error('academic_domain_id') is-invalid @enderror"
                            disabled>

                            <option value="">
                                -- Sélectionner un domaine académique --
                            </option>

                        </select>

                        @error('academic_domain_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div
                            id="academicDomainError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FORMATION --}}
                    {{-- SECONDAIRE / PROFESSIONNEL --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="formationContainer"
                        style="display:none;">

                        <label
                            for="formation_id"
                            class="form-label fw-bold">

                            Formation

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="formation_id"
                            id="formation_id"
                            class="form-select @error('formation_id') is-invalid @enderror"
                            disabled>

                            <option value="">
                                -- Sélectionner une formation --
                            </option>

                        </select>

                        @error('formation_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div
                            id="formationError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FILIÈRE --}}
                    {{-- SUPÉRIEUR --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="filiereContainer"
                        style="display:none;">

                        <label
                            for="filiere_id"
                            class="form-label fw-bold">

                            Filière

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="filiere_id"
                            id="filiere_id"
                            class="form-select @error('filiere_id') is-invalid @enderror"
                            disabled>

                            <option value="">
                                -- Sélectionner une filière --
                            </option>

                        </select>

                        @error('filiere_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div
                            id="filiereError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PROGRAMME --}}
                    {{-- PROFESSIONNEL / PROGRAMMES SPÉCIFIQUES --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="programContainer"
                        style="display:none;">

                        <label
                            for="program_id"
                            class="form-label fw-bold">

                            Programme

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="program_id"
                            id="program_id"
                            class="form-select @error('program_id') is-invalid @enderror"
                            disabled>

                            <option value="">
                                -- Sélectionner un programme --
                            </option>

                        </select>

                        @error('program_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div
                            id="programError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SPÉCIALITÉ --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="specialiteContainer"
                        style="display:none;">

                        <label
                            for="specialite_id"
                            class="form-label fw-bold">

                            Spécialité

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="specialite_id"
                            id="specialite_id"
                            class="form-select @error('specialite_id') is-invalid @enderror"
                            disabled>

                            <option value="">
                                -- Sélectionner une spécialité --
                            </option>

                        </select>

                        @error('specialite_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div
                            id="specialiteError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- NIVEAU --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="levelContainer"
                        style="display:none;">

                        <label
                            for="level_id"
                            class="form-label fw-bold">

                            Niveau / Classe

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="level_id"
                            id="level_id"
                            class="form-select @error('level_id') is-invalid @enderror"
                            disabled>

                            <option value="">
                                -- Sélectionner un niveau / une classe --
                            </option>

                        </select>

                        @error('level_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                        <div
                            id="levelError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- MATIÈRE --}}
                    {{-- ================================================= --}}

                    <div
                        class="mb-4"
                        id="subjectContainer"
                        style="display:none;">

                        <label
                            for="subject_id"
                            class="form-label fw-bold">

                            Matière / Module

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="subject_id"
                            id="subject_id"
                            class="form-select @error('subject_id') is-invalid @enderror"
                            disabled>

                            <option value="">
                                -- Sélectionner une matière / un module --
                            </option>

                        </select>

                        @error('subject_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div
                            id="subjectError"
                            class="field-error"
                            style="display:none;">
                        </div>

                    </div>


                    {{-- AIDE --}}

                    <div
                        id="classificationInfo"
                        class="alert alert-light border">

                        <i class="bi bi-info-circle me-2"></i>

                        Sélectionnez les éléments du parcours
                        pédagogique dans l'ordre.

                    </div>


                    {{-- NAVIGATION --}}

                    <div class="d-flex justify-content-end mt-4">

                        <button
                            type="button"
                            class="btn btn-primary px-4"
                            onclick="nextStep(2)">

                            Suivant

                            <i class="bi bi-arrow-right ms-1"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- ÉTAPE 2 --}}
        {{-- ========================================================= --}}

        <div
            class="form-step"
            id="step-2">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        Étape 2 : Informations du document
                    </h5>

                </div>

                <div class="card-body p-4">


                    {{-- TITRE --}}

                    <div class="mb-4">

                        <label
                            for="title"
                            class="form-label fw-bold">

                            Titre du document

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            name="title"
                            id="title"
                            class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}"
                            maxlength="255"
                            autocomplete="off"
                            required>

                        @error('title')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="mb-4">

                        <label
                            for="description"
                            class="form-label fw-bold">

                            Description

                        </label>

                        <textarea
                            name="description"
                            id="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="4"
                            maxlength="2000">{{ old('description') }}</textarea>

                        @error('description')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                    {{-- CONTENU --}}

                    <div class="mb-4">

                        <label
                            for="content"
                            class="form-label fw-bold">

                            Contenu complémentaire

                        </label>

                        <textarea
                            name="content"
                            id="content"
                            class="form-control @error('content') is-invalid @enderror"
                            rows="5"
                            maxlength="10000">{{ old('content') }}</textarea>

                        @error('content')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                    {{-- TYPE DOCUMENT --}}

                    <div class="mb-4">

                        <label
                            for="document_type_id"
                            class="form-label fw-bold">

                            Type de document

                            <span class="text-danger">*</span>

                        </label>

                        <select
                            name="document_type_id"
                            id="document_type_id"
                            class="form-select @error('document_type_id') is-invalid @enderror"
                            required>

                            <option value="">
                                -- Sélectionner un type de document --
                            </option>

                            @foreach($documentTypes as $type)

                            <option
                                value="{{ $type->id }}"
                                @selected(old('document_type_id')==$type->id)>

                                {{ $type->name }}

                            </option>

                            @endforeach

                        </select>

                        @error('document_type_id')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                    {{-- PDF --}}

                    <div class="mb-4">

                        <label
                            for="file_path"
                            class="form-label fw-bold">

                            Document PDF

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="file"
                            name="file_path"
                            id="file_path"
                            class="form-control @error('file_path') is-invalid @enderror"
                            accept=".pdf,application/pdf"
                            required>

                        @error('file_path')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                        <div class="form-text">
                            Format accepté : PDF — Taille maximale : 20 Mo.
                        </div>

                    </div>


                    {{-- COUVERTURE --}}

                    <div class="mb-4">

                        <label
                            for="cover_image"
                            class="form-label fw-bold">

                            Image de couverture

                        </label>

                        <input
                            type="file"
                            name="cover_image"
                            id="cover_image"
                            class="form-control @error('cover_image') is-invalid @enderror"
                            accept=".jpg,.jpeg,.png,.webp">

                        <div class="form-text">
                            JPG, JPEG, PNG ou WEBP.
                        </div>

                        @error('cover_image')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                        @enderror

                    </div>


                    {{-- ACCÈS / PRIX --}}

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label
                                for="access_type"
                                class="form-label fw-bold">

                                Type d'accès

                                <span class="text-danger">*</span>

                            </label>

                            <select
                                name="access_type"
                                id="access_type"
                                class="form-select @error('access_type') is-invalid @enderror"
                                required>

                                <option
                                    value="free"
                                    @selected(old('access_type','free')==='free' )>

                                    Gratuit

                                </option>

                                <option
                                    value="premium"
                                    @selected(old('access_type')==='premium' )>

                                    Premium

                                </option>

                            </select>

                            @error('access_type')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>


                        <div
                            class="col-md-6"
                            id="price-container">

                            <label
                                for="price"
                                class="form-label fw-bold">

                                Prix

                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    name="price"
                                    id="price"
                                    class="form-control @error('price') is-invalid @enderror"
                                    min="0"
                                    max="999999999"
                                    step="0.01"
                                    value="{{ old('price') }}"
                                    inputmode="decimal">

                                <span class="input-group-text">
                                    FCFA
                                </span>

                            </div>

                            @error('price')

                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>

                            @enderror

                        </div>

                    </div>


                    <div class="d-flex justify-content-between mt-4">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            onclick="previousStep(1)">

                            <i class="bi bi-arrow-left me-1"></i>

                            Précédent

                        </button>

                        <button
                            type="button"
                            class="btn btn-primary px-4"
                            onclick="nextStep(3)">

                            Voir le récapitulatif

                            <i class="bi bi-arrow-right ms-1"></i>

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- ÉTAPE 3 --}}
        {{-- ========================================================= --}}

        <div
            class="form-step"
            id="step-3">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-bold">
                        Étape 3 : Vérification et publication
                    </h5>

                </div>

                <div class="card-body p-4">

                    <div class="alert alert-info">

                        <i class="bi bi-info-circle me-2"></i>

                        Vérifiez toutes les informations avant
                        de publier le document.

                    </div>


                    <div
                        id="document-summary"
                        class="document-summary">
                    </div>


                    <div
                        class="form-check mt-4"
                        style="
        display:flex !important;
        align-items:flex-start !important;
        gap:10px !important;
        width:100% !important;
        margin:0 !important;
        padding:14px 16px !important;
        border:1px solid #d9e1ea !important;
        border-radius:8px !important;
        background:#f8fafc !important;
    ">

                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="confirm_information"
                            id="confirm_information"
                            value="1"
                            required
                            style="
            width:18px !important;
            min-width:18px !important;
            max-width:18px !important;
            height:18px !important;
            min-height:18px !important;
            max-height:18px !important;
            margin:2px 0 0 0 !important;
            padding:0 !important;
            flex:0 0 18px !important;
            appearance:auto !important;
            cursor:pointer !important;
            accent-color:#0d6efd !important;
        ">

                        <label
                            class="form-check-label"
                            for="confirm_information"
                            style="
            display:block !important;
            width:auto !important;
            margin:0 !important;
            padding:0 !important;
            font-size:14px !important;
            line-height:1.5 !important;
            color:#343a40 !important;
            cursor:pointer !important;
            flex:1 !important;
        ">

                            Je confirme que les informations saisies
                            sont exactes et que le document respecte
                            les règles de publication.

                        </label>

                        @error('confirm_information')

                        <div
                            class="text-danger small mt-1"
                            style="
                width:100% !important;
                flex-basis:100% !important;
            ">

                            {{ $message }}

                        </div>

                        @enderror

                    </div>


                    <div class="d-flex justify-content-between mt-4">

                        <button
                            type="button"
                            class="btn btn-outline-secondary"
                            onclick="previousStep(2)">

                            <i class="bi bi-arrow-left me-1"></i>

                            Modifier

                        </button>

                        <button
                            type="submit"
                            class="btn btn-success px-4"
                            id="publishDocumentBtn">

                            <i class="bi bi-cloud-upload me-1"></i>

                            Publier le document

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection


@push('scripts')

@vite('resources/js/journaliste/document-wizard.js')

@endpush