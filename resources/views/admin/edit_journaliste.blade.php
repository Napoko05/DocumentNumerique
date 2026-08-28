@extends('layouts.admin_app')

@section('content')

<div class="admin-page">

    <div class="admin-page-header">

        <div>

            <span class="admin-page-kicker">
                ADMINISTRATION
            </span>

            <h1>
                Modifier le journaliste
            </h1>

            <p>
                Modifiez les informations du compte de
                {{ $journaliste->prenom }} {{ $journaliste->nom }}.
            </p>

        </div>

        <a
            href="{{ route('admin.staff.index') }}"
            class="profile-btn profile-btn-secondary">
            ← Retour
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMATIONS DU PROFIL --}}
    {{-- ========================================================= --}}

    <section class="profile-section">

        <div class="profile-form-header">

            <div>

                <span class="profile-section-label">
                    PROFIL JOURNALISTE
                </span>

                <h3>
                    Informations personnelles
                </h3>

                <p>
                    Modifiez les informations personnelles et professionnelles
                    du journaliste.
                </p>

            </div>

        </div>


        <form
            method="POST"
            action="{{ route(
                'admin.staff.journalistes.update',
                $journaliste
            ) }}"
            class="profile-form">

            @csrf
            @method('PUT')


            <div class="profile-form-grid">


                {{-- NOM --}}

                <div class="profile-field">

                    <label for="nom">
                        Nom
                        <span class="required">*</span>
                    </label>

                    <input
                        id="nom"
                        name="nom"
                        type="text"
                        value="{{ old('nom', $journaliste->nom) }}"
                        required
                        class="@error('nom') is-invalid @enderror">

                    @error('nom')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- PRÉNOM --}}

                <div class="profile-field">

                    <label for="prenom">
                        Prénom
                        <span class="required">*</span>
                    </label>

                    <input
                        id="prenom"
                        name="prenom"
                        type="text"
                        value="{{ old('prenom', $journaliste->prenom) }}"
                        required
                        class="@error('prenom') is-invalid @enderror">

                    @error('prenom')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- MATRICULE --}}

                <div class="profile-field">

                    <label for="matricule">
                        Matricule
                    </label>

                    <input
                        id="matricule"
                        name="matricule"
                        type="text"
                        value="{{ old('matricule', $journaliste->matricule) }}"
                        required
                        class="@error('matricule') is-invalid @enderror">

                    @error('matricule')
                    <span class="field-error">{{ $message }}</span>
                    @enderror

                    <small class="profile-help">
                        Le matricule ne peut pas être modifié par le journaliste.
                    </small>

                </div>


                {{-- SEXE --}}

                <div class="profile-field">

                    <label for="sexe">
                        Sexe
                        <span class="required">*</span>
                    </label>

                    <select
                        id="sexe"
                        name="sexe"
                        required
                        class="@error('sexe') is-invalid @enderror">

                        <option value="">
                            Sélectionner
                        </option>

                        <option
                            value="Masculin"
                            @selected(
                            old('sexe', $journaliste->sexe)
                            === 'Masculin'
                            )
                            >
                            Masculin
                        </option>

                        <option
                            value="Féminin"
                            @selected(
                            old('sexe', $journaliste->sexe)
                            === 'Féminin'
                            )
                            >
                            Féminin
                        </option>

                    </select>

                    @error('sexe')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- DATE NAISSANCE --}}

                <div class="profile-field">

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
                        class="@error('date_naissance') is-invalid @enderror">

                    @error('date_naissance')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- LIEU NAISSANCE --}}

                <div class="profile-field">

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
                        class="@error('lieu_naissance') is-invalid @enderror">

                    @error('lieu_naissance')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- EMAIL --}}

                <div class="profile-field">

                    <label for="email">
                        Adresse e-mail
                        <span class="required">*</span>
                    </label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old(
                            'email',
                            $journaliste->email
                        ) }}"
                        required
                        class="@error('email') is-invalid @enderror">

                    @error('email')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- TÉLÉPHONE --}}

                <div class="profile-field">

                    <label for="tel">
                        Téléphone
                    </label>

                    <input
                        id="tel"
                        name="tel"
                        type="tel"
                        value="{{ old(
                            'tel',
                            $journaliste->tel
                        ) }}"
                        class="@error('tel') is-invalid @enderror">

                    @error('tel')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- VILLE --}}

                <div class="profile-field">

                    <label for="ville">
                        Ville
                    </label>

                    <input
                        id="ville"
                        name="ville"
                        type="text"
                        value="{{ old(
                            'ville',
                            $journaliste->ville
                        ) }}"
                        class="@error('ville') is-invalid @enderror">

                    @error('ville')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>


                {{-- SERVICE --}}

                <div class="profile-field">

                    <label for="service">
                        Service
                    </label>

                    <input
                        id="service"
                        name="service"
                        type="text"
                        value="{{ old('service', $journaliste->service) }}"
                        class="@error('service') is-invalid @enderror">

                    @error('service')
                    <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- SPÉCIALITÉ --}}

                <div class="profile-field">

                    <label for="specialite">
                        Spécialité
                    </label>

                    <input
                        id="specialite"
                        name="specialite"
                        type="text"
                        value="{{ old('specialite', $journaliste->specialite) }}"
                        class="@error('specialite') is-invalid @enderror">

                    @error('specialite')
                    <span class="field-error">{{ $message }}</span>
                    @enderror

                </div>

            </div>


            <div class="profile-form-actions">

                <a
                    href="{{ route('admin.staff.index') }}"
                    class="profile-btn profile-btn-secondary">
                    Annuler
                </a>

                <button
                    type="submit"
                    class="profile-btn profile-btn-primary">
                    Enregistrer les modifications
                </button>

            </div>

        </form>

    </section>


    {{-- ========================================================= --}}
    {{-- MOT DE PASSE --}}
    {{-- ========================================================= --}}

    <section class="profile-section">

        <div class="profile-form-header">

            <div>

                <span class="profile-section-label">
                    SÉCURITÉ
                </span>

                <h3>
                    Modifier le mot de passe
                </h3>

                <p>
                    L'administrateur peut définir un nouveau mot de passe
                    pour ce journaliste.
                </p>

            </div>

        </div>


        <form
            method="POST"
            action="{{ route(
                'admin.staff.journalistes.password.update',
                $journaliste
            ) }}"
            class="profile-form">

            @csrf
            @method('PUT')


            <div class="profile-form-grid profile-form-grid-single">


                {{-- NOUVEAU MOT DE PASSE --}}

                <div class="profile-field">

                    <label for="password">
                        Nouveau mot de passe
                        <span class="required">*</span>
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="@error('password') is-invalid @enderror">

                    @error('password')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                    <small class="profile-help">
                        Minimum 8 caractères.
                    </small>

                </div>


                {{-- CONFIRMATION --}}

                <div class="profile-field">

                    <label for="password_confirmation">
                        Confirmer le nouveau mot de passe
                        <span class="required">*</span>
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="@error('password_confirmation') is-invalid @enderror">

                    @error('password_confirmation')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                    @enderror

                </div>

            </div>


            <div class="profile-form-actions">

                <button
                    type="submit"
                    class="profile-btn profile-btn-primary">
                    Modifier le mot de passe
                </button>

            </div>

        </form>

    </section>

</div>

@endsection