@extends('layouts.journaliste_app')

@section('title', 'Mon profil')

@section('content')

<div class="admin-page">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="admin-page-header">

        <div>
            <span class="admin-page-kicker">
                MON PROFIL
            </span>

            <h1>
                Modifier mon profil
            </h1>

            <p>
                Gérez vos informations personnelles et professionnelles.
            </p>
        </div>

        <a
            href="{{ route('journaliste.dashboard') }}"
            class="admin-btn admin-btn-secondary"
        >
            ← Tableau de bord
        </a>

    </div>


    {{-- =========================================================
         MESSAGES
    ========================================================== --}}

    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            {{ session('error') }}
        </div>
    @endif


    {{-- =========================================================
         ERREURS DE VALIDATION
    ========================================================== --}}

    @if($errors->any())
        <div class="admin-alert admin-alert-danger">

            <strong>
                Vérifiez les informations saisies.
            </strong>

            <ul style="margin: 8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif


    {{-- =========================================================
         CARTE PROFIL
    ========================================================== --}}

    <div class="admin-profile-card">

        <div class="admin-profile-header">

            <div class="admin-profile-avatar">
                {{ strtoupper(substr($journaliste->prenom ?? 'J', 0, 1)) }}
            </div>

            <div>

                <h2>
                    {{ $journaliste->prenom }}
                    {{ $journaliste->nom }}
                </h2>

                <p>
                    {{ $journaliste->email }}
                </p>

                <span class="admin-profile-role">
                    Journaliste
                </span>

            </div>

        </div>

    </div>


    {{-- =========================================================
         INFORMATIONS PERSONNELLES
    ========================================================== --}}

    <div class="admin-edit-card">

        <div class="admin-edit-header">

            <div>

                <span class="admin-section-label">
                    MES INFORMATIONS
                </span>

                <h2>
                    Informations personnelles
                </h2>

                <p>
                    Vous pouvez modifier les informations personnelles
                    autorisées de votre compte.
                </p>

            </div>

        </div>


        {{-- =====================================================
             FORMULAIRE JOURNALISTE
        ====================================================== --}}

        <form
            method="POST"
            action="{{ route('journaliste.profil.update') }}"
            class="admin-form"
        >

            @csrf
            @method('PUT')


            <div class="admin-form-grid">


                {{-- =================================================
                     NOM
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="nom">
                        Nom <span>*</span>
                    </label>

                    <input
                        id="nom"
                        name="nom"
                        type="text"
                        value="{{ old('nom', $journaliste->nom) }}"
                        maxlength="100"
                        autocomplete="family-name"
                        required
                        class="@error('nom') is-invalid @enderror"
                    >

                    @error('nom')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     PRÉNOM
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="prenom">
                        Prénom <span>*</span>
                    </label>

                    <input
                        id="prenom"
                        name="prenom"
                        type="text"
                        value="{{ old('prenom', $journaliste->prenom) }}"
                        maxlength="100"
                        autocomplete="given-name"
                        required
                        class="@error('prenom') is-invalid @enderror"
                    >

                    @error('prenom')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     SEXE
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="sexe">
                        Sexe <span>*</span>
                    </label>

                    <select
                        id="sexe"
                        name="sexe"
                        required
                        class="@error('sexe') is-invalid @enderror"
                    >

                        <option value="">
                            Sélectionner
                        </option>

                        <option
                            value="Masculin"
                            @selected(
                                old('sexe', $journaliste->sexe) === 'Masculin'
                            )
                        >
                            Masculin
                        </option>

                        <option
                            value="Féminin"
                            @selected(
                                old('sexe', $journaliste->sexe) === 'Féminin'
                            )
                        >
                            Féminin
                        </option>

                    </select>

                    @error('sexe')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     DATE DE NAISSANCE
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="date_naissance">
                        Date de naissance
                    </label>

                    <input
                        id="date_naissance"
                        name="date_naissance"
                        type="date"
                        value="{{ old(
                            'date_naissance',
                            $journaliste->date_naissance
                                ? \Carbon\Carbon::parse(
                                    $journaliste->date_naissance
                                )->format('Y-m-d')
                                : ''
                        ) }}"
                        autocomplete="bday"
                        class="@error('date_naissance') is-invalid @enderror"
                    >

                    @error('date_naissance')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     LIEU DE NAISSANCE
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="lieu_naissance">
                        Lieu de naissance
                    </label>

                    <input
                        id="lieu_naissance"
                        name="lieu_naissance"
                        type="text"
                        value="{{ old(
                            'lieu_naissance',
                            $journaliste->lieu_naissance
                        ) }}"
                        maxlength="150"
                        autocomplete="off"
                        class="@error('lieu_naissance') is-invalid @enderror"
                    >

                    @error('lieu_naissance')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     VILLE
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="ville">
                        Ville
                    </label>

                    <input
                        id="ville"
                        name="ville"
                        type="text"
                        value="{{ old('ville', $journaliste->ville) }}"
                        maxlength="100"
                        autocomplete="address-level2"
                        class="@error('ville') is-invalid @enderror"
                    >

                    @error('ville')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     SPÉCIALITÉ
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="specialite">
                        Spécialité
                    </label>

                    <input
                        id="specialite"
                        name="specialite"
                        type="text"
                        value="{{ old(
                            'specialite',
                            $journaliste->specialite
                        ) }}"
                        maxlength="150"
                        class="@error('specialite') is-invalid @enderror"
                    >

                    @error('specialite')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     EMAIL
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="email">
                        Adresse e-mail <span>*</span>
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email', $journaliste->email) }}"
                        maxlength="255"
                        autocomplete="email"
                        required
                        class="@error('email') is-invalid @enderror"
                    >

                    @error('email')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     TÉLÉPHONE
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="tel">
                        Numéro de téléphone
                    </label>

                    <input
                        id="tel"
                        name="tel"
                        type="tel"
                        value="{{ old('tel', $journaliste->tel) }}"
                        maxlength="30"
                        autocomplete="tel"
                        class="@error('tel') is-invalid @enderror"
                    >

                    @error('tel')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>


            {{-- =====================================================
                 INFORMATIONS PROTÉGÉES
            ====================================================== --}}

            <div class="admin-protected-info">

                <div class="admin-protected-info-header">

                    <div class="admin-protected-info-icon">
                        🔒
                    </div>

                    <div>

                        <h3>
                            Informations professionnelles protégées
                        </h3>

                        <p>
                            Ces informations sont gérées par
                            l'administration et ne peuvent pas être
                            modifiées depuis votre profil.
                        </p>

                    </div>

                </div>


                <div class="admin-form-grid">


                    {{-- CNIB --}}

                    <div class="admin-form-field">

                        <label for="num_cnib">
                            N° CNIB
                        </label>

                        <input
                            id="num_cnib"
                            type="text"
                            value="{{ $journaliste->num_cnib ?: 'Non renseigné' }}"
                            readonly
                            disabled
                        >

                    </div>


                    {{-- MATRICULE --}}

                    <div class="admin-form-field">

                        <label for="matricule">
                            Matricule
                        </label>

                        <input
                            id="matricule"
                            type="text"
                            value="{{ $journaliste->matricule ?: 'Non renseigné' }}"
                            readonly
                            disabled
                        >

                    </div>


                    {{-- SERVICE --}}

                    <div class="admin-form-field">

                        <label for="service">
                            Service
                        </label>

                        <input
                            id="service"
                            type="text"
                            value="{{ $journaliste->service ?: 'Non renseigné' }}"
                            readonly
                            disabled
                        >

                    </div>


                    {{-- RÔLE --}}

                    <div class="admin-form-field">

                        <label for="role_label">
                            Fonction
                        </label>

                        <input
                            id="role_label"
                            type="text"
                            value="{{ $journaliste->role_label ?: 'Journaliste' }}"
                            readonly
                            disabled
                        >

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 ACTIONS
            ====================================================== --}}

            <div class="admin-form-actions">

                <a
                    href="{{ route('journaliste.dashboard') }}"
                    class="admin-btn admin-btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-btn admin-btn-primary"
                >
                    Enregistrer les modifications
                </button>

            </div>

        </form>

    </div>


    {{-- =========================================================
         MOT DE PASSE
    ========================================================== --}}

    <div class="admin-edit-card">

        <div class="admin-edit-header">

            <div>

                <span class="admin-section-label">
                    SÉCURITÉ
                </span>

                <h2>
                    Mot de passe
                </h2>

                <p>
                    Modifiez votre mot de passe depuis une page dédiée.
                </p>

            </div>

            <a
                href="{{ route('journaliste.profil.password.edit') }}"
                class="admin-btn admin-btn-warning"
            >
                Modifier le mot de passe
            </a>

        </div>

    </div>

</div>

@endsection
