
@extends('layouts.journaliste_app')

@section('title', 'Modifier le journaliste')

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
                Modifiez les informations personnelles du journaliste.
            </p>

        </div>

        <a
            href="{{ route('admin.staff.index') }}"
            class="admin-btn admin-btn-secondary"
        >
            ← Retour
        </a>

    </div>


    {{-- =========================================================
         INFORMATIONS DU JOURNALISTE
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


        {{-- =====================================================
             ACTION MOT DE PASSE
        ====================================================== --}}

        <div class="admin-profile-actions">

            <a
                href="{{ route(
                    'admin.staff.journalistes.password.edit',
                    $journaliste
                ) }}"
                class="admin-btn admin-btn-warning"
            >
                🔐 Modifier le mot de passe
            </a>

        </div>

    </div>


    {{-- =========================================================
         FORMULAIRE PROFIL
    ========================================================== --}}

    <div class="admin-edit-card">

        <div class="admin-edit-header">

            <div>

                <span class="admin-section-label">
                    PROFIL
                </span>

                <h2>
                    Informations personnelles
                </h2>

                <p>
                    Modifiez les informations personnelles et les coordonnées
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
                        class="@error('tel') is-invalid @enderror"
                    >

                    @error('tel')
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
                        class="@error('date_naissance') is-invalid @enderror"
                    >

                    @error('date_naissance')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>


            {{-- =====================================================
                 ACTIONS
            ====================================================== --}}

            <div class="admin-form-actions">

                <a
                    href="{{ route('admin.staff.index') }}"
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

</div>

@endsection
