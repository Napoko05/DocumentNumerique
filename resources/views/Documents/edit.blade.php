@extends('layouts.journaliste_app')

@section('title', 'Modifier le document')

@section('content')

<div class="document-edit-page">

    <div class="document-edit-container">

        {{-- =====================================================
             EN-TÊTE
        ====================================================== --}}

        <div class="document-edit-header">

            <div class="document-edit-icon">
                ✏️
            </div>

            <div>
                <h1>
                    Modifier le document
                </h1>

                <p>
                    Modifiez les informations et les paramètres
                    de publication du document.
                </p>
            </div>

        </div>


        {{-- =====================================================
             ERREURS
        ====================================================== --}}

        @if ($errors->any())

        <div class="document-edit-alert">

            <div class="document-edit-alert-title">
                ⚠️ Des erreurs ont été détectées.
            </div>

            <ul>

                @foreach ($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

                @endforeach

            </ul>

        </div>

        @endif


        {{-- =====================================================
             CARTE
        ====================================================== --}}

        <div class="document-edit-card">

            <form
                action="{{ route(
                    'journaliste.documents.update',
                    $document
                ) }}"
                method="POST"
                enctype="multipart/form-data"
                class="document-edit-form">

                @csrf

                @method('PUT')


                {{-- =================================================
                     INFORMATIONS ACADÉMIQUES
                ================================================== --}}

                <div class="document-edit-academic-header">

                    <div class="document-academic-main-icon">
                        📚
                    </div>

                    <div>

                        <h2>
                            Informations académiques
                        </h2>

                        <p>
                            Ces informations déterminent le classement
                            et l'organisation du document.
                        </p>

                    </div>

                </div>


                <div class="document-edit-grid">


                    {{-- CATÉGORIE PÉDAGOGIQUE --}}
                    <div class="document-form-group document-form-full">

                        <label for="teaching_category_id">
                            Catégorie pédagogique
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            id="teaching_category_id"
                            name="teaching_category_id"
                            class="document-form-control document-form-select"
                            required>

                            <option value="">
                                -- Sélectionner une catégorie --
                            </option>

                           @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                data-code="{{ strtolower($category->code ?? '') }}"
                                @selected(
                                old( 'teaching_category_id' ,
                                $document->teaching_category_id
                                ) == $category->id
                                )
                                >
                                {{ $category->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- =================================================
                         DOMAINE ACADÉMIQUE
                         SUPÉRIEUR
                    ================================================== --}}

                    <div
                        class="document-form-group
                            document-academic-field
                            document-academic-superieur"
                        id="academicDomainContainer">

                        <label for="academic_domain_id">

                            Domaine académique

                        </label>

                        <select
                            id="academic_domain_id"
                            name="academic_domain_id"
                            class="document-form-control document-form-select">

                            <option value="">
                                -- Sélectionner un domaine --
                            </option>

                            @foreach(
                            $academicDomains
                            ?? []
                            as $domain
                            )

                            <option
                                value="{{ $domain->id }}"
                                @selected(
                                old( 'academic_domain_id' ,
                                $document->academic_domain_id
                                ) == $domain->id
                                )
                                >

                                {{ $domain->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         FORMATION
                    ================================================== --}}

                    <div
                        class="document-form-group
                            document-academic-field
                            document-academic-superieur"
                        id="formationContainer">

                        <label for="formation_id">

                            Formation

                        </label>

                        <select
                            id="formation_id"
                            name="formation_id"
                            class="document-form-control document-form-select">

                            <option value="">
                                -- Sélectionner une formation --
                            </option>

                            @foreach(
                            $formations
                            ?? []
                            as $formation
                            )

                            <option
                                value="{{ $formation->id }}"
                                @selected(
                                old( 'formation_id' ,
                                $document->formation_id
                                ) == $formation->id
                                )
                                >

                                {{ $formation->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         FILIÈRE
                    ================================================== --}}

                    <div
                        class="document-form-group
                            document-academic-field
                            document-academic-superieur"
                        id="filiereContainer">

                        <label for="filiere_id">

                            Filière

                        </label>

                        <select
                            id="filiere_id"
                            name="filiere_id"
                            class="document-form-control document-form-select">

                            <option value="">
                                -- Sélectionner une filière --
                            </option>

                            @foreach(
                            $filieres
                            ?? []
                            as $filiere
                            )

                            <option
                                value="{{ $filiere->id }}"
                                @selected(
                                old( 'filiere_id' ,
                                $document->filiere_id
                                ) == $filiere->id
                                )
                                >

                                {{ $filiere->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         PROGRAMME
                         ENS
                    ================================================== --}}

                    <div
                        class="document-form-group
                            document-academic-field
                            document-academic-ens"
                        id="programContainer">

                        <label for="program_id">

                            Programme ENS

                        </label>

                        <select
                            id="program_id"
                            name="program_id"
                            class="document-form-control document-form-select">

                            <option value="">
                                -- Sélectionner un programme --
                            </option>

                            @foreach(
                            $programs
                            ?? []
                            as $program
                            )

                            <option
                                value="{{ $program->id }}"
                                @selected(
                                old( 'program_id' ,
                                $document->program_id
                                ) == $program->id
                                )
                                >

                                {{ $program->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         SPÉCIALITÉ
                         ENS
                    ================================================== --}}

                    <div
                        class="document-form-group
                            document-academic-field
                            document-academic-ens"
                        id="specialiteContainer">

                        <label for="specialite_id">

                            Spécialité

                        </label>

                        <select
                            id="specialite_id"
                            name="specialite_id"
                            class="document-form-control document-form-select">

                            <option value="">
                                -- Sélectionner une spécialité --
                            </option>

                            @foreach(
                            $specialites
                            ?? []
                            as $specialite
                            )

                            <option
                                value="{{ $specialite->id }}"
                                @selected(
                                old( 'specialite_id' ,
                                $document->specialite_id
                                ) == $specialite->id
                                )
                                >

                                {{ $specialite->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         NIVEAU
                         COMMUN
                    ================================================== --}}

                    <div class="document-form-group">

                        <label for="level_id">

                            Niveau / Classe

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <select
                            id="level_id"
                            name="level_id"
                            class="document-form-control document-form-select"
                            required>

                            <option value="">
                                -- Sélectionner un niveau --
                            </option>

                            @foreach(
                            $levels
                            ?? []
                            as $level
                            )

                            <option
                                value="{{ $level->id }}"
                                @selected(
                                old( 'level_id' ,
                                $document->level_id
                                ) == $level->id
                                )
                                >

                                {{ $level->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         MATIÈRE
                    ================================================== --}}

                    <div
                        class="document-form-group
                            document-academic-field
                            document-academic-secondaire"
                        id="subjectContainer">

                        <label for="subject_id">

                            Matière / Module

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <select
                            id="subject_id"
                            name="subject_id"
                            class="document-form-control document-form-select"
                            required>

                            <option value="">
                                -- Sélectionner une matière --
                            </option>

                            @foreach(
                            $subjects
                            ?? []
                            as $subject
                            )

                            <option
                                value="{{ $subject->id }}"
                                @selected(
                                old( 'subject_id' ,
                                $document->subject_id
                                ) == $subject->id
                                )
                                >

                                {{ $subject->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         TYPE DE DOCUMENT
                    ================================================== --}}

                    <div class="document-form-group document-form-full">

                        <label for="document_type_id">

                            Type de document

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <select
                            id="document_type_id"
                            name="document_type_id"
                            class="document-form-control document-form-select"
                            required>

                            <option value="">
                                -- Sélectionner un type --
                            </option>

                            @foreach(
                            $documentTypes
                            ?? []
                            as $type
                            )

                            <option
                                value="{{ $type->id }}"
                                @selected(
                                old( 'document_type_id' ,
                                $document->document_type_id
                                ) == $type->id
                                )
                                >

                                {{ $type->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- =================================================
                         TITRE
                    ================================================== --}}

                    <div class="document-form-group document-form-full">

                        <label for="title">

                            Titre

                            <span class="required-mark">
                                *
                            </span>

                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old(
                                'title',
                                $document->title
                            ) }}"
                            required
                            class="document-form-control">

                    </div>


                    {{-- =================================================
                         DESCRIPTION
                    ================================================== --}}

                    <div class="document-form-group document-form-full">

                        <label for="description">

                            Description

                        </label>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            class="document-form-control document-form-textarea">{{ old(
                            'description',
                            $document->description
                        ) }}</textarea>

                    </div>


                    {{-- =================================================
                         TYPE D'ACCÈS
                    ================================================== --}}

                    <div class="document-form-group">

                        <label for="access_type">

                            Type d'accès

                        </label>

                        <select
                            id="access_type"
                            name="access_type"
                            class="document-form-control document-form-select">

                            <option
                                value="free"
                                @selected(
                                old( 'access_type' ,
                                $document->access_type
                                ) === 'free'
                                )
                                >

                                🟢 Gratuit

                            </option>

                            <option
                                value="premium"
                                @selected(
                                old( 'access_type' ,
                                $document->access_type
                                ) === 'premium'
                                )
                                >

                                🟠 Premium

                            </option>

                        </select>

                    </div>


                    {{-- =================================================
                         PRIX
                    ================================================== --}}

                    <div
                        id="priceDiv"
                        class="document-form-group
                            {{
                                old(
                                    'access_type',
                                    $document->access_type
                                ) === 'premium'
                                    ? ''
                                    : 'document-edit-hidden'
                            }}">

                        <label
                            for="price"
                            class="document-price-label">

                            💰 Prix (FCFA)

                        </label>

                        <div class="document-price-input-wrapper">

                            <input
                                type="number"
                                id="price"
                                name="price"
                                min="0"
                                step="1"
                                value="{{ old(
                                    'price',
                                    $document->price
                                ) }}"
                                class="document-form-control">

                            <span>
                                FCFA
                            </span>

                        </div>

                    </div>


                    {{-- =================================================
                         FICHIER
                    ================================================== --}}

                    <div class="document-form-group document-form-full">

                        <label for="file">

                            Remplacer le fichier

                        </label>

                        <div class="document-file-input-wrapper">

                            <input
                                type="file"
                                id="file"
                                name="file">

                        </div>

                        <p class="document-form-help">

                            Laissez ce champ vide pour conserver
                            le fichier actuel.

                        </p>

                    </div>


                    {{-- =================================================
                         FICHIER ACTUEL
                    ================================================== --}}

                    @if ($document->file_path)

                    <div class="document-form-group document-form-full">

                        <div class="document-current-file">

                            <div class="document-current-file-icon">
                                📄
                            </div>

                            <div class="document-current-file-content">

                                <div class="document-current-file-title">

                                    Fichier actuel

                                </div>

                                <div class="document-current-file-name">

                                    {{ basename(
                                            $document->file_path
                                        ) }}

                                </div>

                            </div>

                        </div>

                    </div>

                    @endif

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}

                <div class="document-edit-actions">

                    <button
                        type="submit"
                        class="document-edit-button document-edit-save">

                        💾

                        <span>
                            Enregistrer les modifications
                        </span>

                    </button>


                    <a
                        href="{{ route(
                            'journaliste.documents.index'
                        ) }}"
                        class="document-edit-button document-edit-cancel">

                        ❌

                        <span>
                            Annuler
                        </span>

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
        |--------------------------------------------------------------------------
        | ÉLÉMENTS
        |--------------------------------------------------------------------------
        */

        const category =
            document.getElementById(
                'teaching_category_id'
            );

        const academicDomain =
            document.getElementById(
                'academicDomainContainer'
            );

        const formation =
            document.getElementById(
                'formationContainer'
            );

        const filiere =
            document.getElementById(
                'filiereContainer'
            );

        const program =
            document.getElementById(
                'programContainer'
            );

        const specialite =
            document.getElementById(
                'specialiteContainer'
            );

        const subject =
            document.getElementById(
                'subjectContainer'
            );

        const accessType =
            document.getElementById(
                'access_type'
            );

        const priceDiv =
            document.getElementById(
                'priceDiv'
            );

        const priceInput =
            document.getElementById(
                'price'
            );


        /*
        |--------------------------------------------------------------------------
        | AFFICHAGE DES CHAMPS ACADÉMIQUES
        |--------------------------------------------------------------------------
        */

        function updateAcademicFields() {

            const selectedOption =
                category.options[
                    category.selectedIndex
                ];

            if (!selectedOption) {
                return;
            }


            const categoryName =
                selectedOption.text
                .trim()
                .toLowerCase();


            /*
            |--------------------------------------------------------------------------
            | CACHER TOUT
            |--------------------------------------------------------------------------
            */

            academicDomain.style.display = 'none';

            formation.style.display = 'none';

            filiere.style.display = 'none';

            program.style.display = 'none';

            specialite.style.display = 'none';

            subject.style.display = 'none';


            /*
            |--------------------------------------------------------------------------
            | SUPÉRIEUR
            |--------------------------------------------------------------------------
            */

            if (
                categoryName.includes('supérieur') ||
                categoryName.includes('superieur')
            ) {

                academicDomain.style.display = '';

                formation.style.display = '';

                filiere.style.display = '';

            }


            /*
            |--------------------------------------------------------------------------
            | ENS
            |--------------------------------------------------------------------------
            */
            else if (
                categoryName.includes('ens')
            ) {

                program.style.display = '';

                specialite.style.display = '';

            }


            /*
            |--------------------------------------------------------------------------
            | SECONDAIRE
            |--------------------------------------------------------------------------
            */
            else if (
                categoryName.includes('secondaire')
            ) {

                subject.style.display = '';

            }


            /*
            |--------------------------------------------------------------------------
            | PROFESSIONNEL
            |--------------------------------------------------------------------------
            */
            else if (
                categoryName.includes('professionnel')
            ) {

                subject.style.display = '';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | CHANGEMENT DE CATÉGORIE
        |--------------------------------------------------------------------------
        */

        if (category) {

            category.addEventListener(
                'change',
                updateAcademicFields
            );

            updateAcademicFields();

        }


        /*
        |--------------------------------------------------------------------------
        | GESTION DU PRIX
        |--------------------------------------------------------------------------
        */

        function togglePrice() {

            if (
                accessType.value === 'premium'
            ) {

                priceDiv.classList.remove(
                    'document-edit-hidden'
                );

                priceInput.required = true;

            } else {

                priceDiv.classList.add(
                    'document-edit-hidden'
                );

                priceInput.required = false;

                priceInput.value = '';

            }

        }


        if (
            accessType &&
            priceDiv &&
            priceInput
        ) {

            accessType.addEventListener(
                'change',
                togglePrice
            );

            togglePrice();

        }

    });
</script>

@endpush