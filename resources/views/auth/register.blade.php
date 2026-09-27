@extends('layouts.app')

@section('title', 'Inscription | YAA\'Scientia')

@section('content')

<div class="register-page">

    <div class="register-container">

        {{-- ================================
             EN-TÊTE
        ================================= --}}
        <div class="register-header">

            <a href="{{ url('/') }}" class="register-brand">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="YAA'Scientia"
                    class="register-logo"
                >

                <span class="register-brand-name">
                    YAA'Scientia
                </span>

            </a>

            <p class="register-subtitle">
                Créez votre compte gratuitement
            </p>

        </div>


        {{-- ================================
             CARTE D'INSCRIPTION
        ================================= --}}
        <div class="register-card">

            <div class="register-card-header">

                <h1 class="register-title">
                    Inscription
                </h1>

                <p class="register-description">
                    Créez votre compte pour accéder à YAA'Scientia.
                </p>

            </div>


            {{-- ================================
                 ERREURS DE VALIDATION
            ================================= --}}
            @if($errors->any())

                <div
                    class="register-alert register-alert-danger"
                    role="alert"
                    aria-live="polite"
                >

                    <i
                        class="bi bi-exclamation-circle-fill"
                        aria-hidden="true"
                    ></i>

                    <div>
                        {{ $errors->first() }}
                    </div>

                </div>

            @endif


            {{-- ================================
                 FORMULAIRE
            ================================= --}}
            <form
                method="POST"
                action="{{ route('register') }}"
                class="register-form"
                autocomplete="on"
            >

                @csrf


                {{-- ================================
                     NOM / PRÉNOM
                ================================= --}}
                <div class="register-row">

                    {{-- NOM --}}
                    <div class="register-group">

                        <label
                            for="nom"
                            class="register-label"
                        >
                            Nom
                        </label>

                        <input
                            type="text"
                            id="nom"
                            name="nom"
                            value="{{ old('nom') }}"
                            class="register-input @error('nom') is-invalid @enderror"
                            placeholder="SAVADOGO"
                            autocomplete="family-name"
                            maxlength="255"
                            required
                        >

                        @error('nom')
                            <span
                                class="register-error"
                                role="alert"
                            >
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    {{-- PRÉNOM --}}
                    <div class="register-group">

                        <label
                            for="prenom"
                            class="register-label"
                        >
                            Prénom
                        </label>

                        <input
                            type="text"
                            id="prenom"
                            name="prenom"
                            value="{{ old('prenom') }}"
                            class="register-input @error('prenom') is-invalid @enderror"
                            placeholder="Lamine"
                            autocomplete="given-name"
                            maxlength="255"
                            required
                        >

                        @error('prenom')
                            <span
                                class="register-error"
                                role="alert"
                            >
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                {{-- ================================
                     EMAIL
                ================================= --}}
                <div class="register-group">

                    <label
                        for="email"
                        class="register-label"
                    >
                        Adresse e-mail
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="register-input @error('email') is-invalid @enderror"
                        placeholder="email@exemple.com"
                        autocomplete="email"
                        maxlength="255"
                        inputmode="email"
                        required
                    >

                    @error('email')
                        <span
                            class="register-error"
                            role="alert"
                        >
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- ================================
                     NUMÉRO DE TÉLÉPHONE
                ================================= --}}
                <div class="register-group">

                    <label
                        for="numero"
                        class="register-label"
                    >
                        Numéro de téléphone
                    </label>

                    <input
                        type="tel"
                        id="numero"
                        name="numero"
                        value="{{ old('numero') }}"
                        class="register-input @error('numero') is-invalid @enderror"
                        placeholder="70 00 00 00"
                        autocomplete="tel"
                        inputmode="tel"
                        maxlength="255"
                        required
                    >

                    @error('numero')
                        <span
                            class="register-error"
                            role="alert"
                        >
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- ================================
                     MOT DE PASSE
                ================================= --}}
                <div class="register-group">

                    <label
                        for="password"
                        class="register-label"
                    >
                        Mot de passe
                    </label>

                    <div
                        class="register-password-wrapper"
                        style="
                            position: relative;
                            width: 100%;
                        "
                    >

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="register-input @error('password') is-invalid @enderror"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            minlength="8"
                            maxlength="255"
                            required
                            style="
                                width: 100%;
                                padding-right: 52px;
                            "
                        >

                        <button
                            type="button"
                            id="togglePassword"
                            class="register-password-toggle"
                            aria-label="Afficher le mot de passe"
                            aria-pressed="false"
                            title="Afficher le mot de passe"
                            style="
                                position: absolute !important;
                                top: 50% !important;
                                right: 8px !important;
                                transform: translateY(-50%) !important;
                                width: 38px !important;
                                height: 38px !important;
                                display: flex !important;
                                align-items: center !important;
                                justify-content: center !important;
                                border: 0 !important;
                                padding: 0 !important;
                                margin: 0 !important;
                                background: transparent !important;
                                cursor: pointer !important;
                                z-index: 20 !important;
                                color: #6c757d !important;
                            "
                        >

                            <i
                                id="passwordIcon"
                                class="bi bi-eye"
                                aria-hidden="true"
                            ></i>

                        </button>

                    </div>

                    @error('password')
                        <span
                            class="register-error"
                            role="alert"
                        >
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- ================================
                     CONFIRMATION MOT DE PASSE
                ================================= --}}
                <div class="register-group">

                    <label
                        for="password_confirmation"
                        class="register-label"
                    >
                        Confirmer le mot de passe
                    </label>

                    <div
                        class="register-password-wrapper"
                        style="
                            position: relative;
                            width: 100%;
                        "
                    >

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="register-input"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            minlength="8"
                            maxlength="255"
                            required
                            style="
                                width: 100%;
                                padding-right: 52px;
                            "
                        >

                        <button
                            type="button"
                            id="togglePasswordConfirmation"
                            class="register-password-toggle"
                            aria-label="Afficher la confirmation du mot de passe"
                            aria-pressed="false"
                            title="Afficher la confirmation du mot de passe"
                            style="
                                position: absolute !important;
                                top: 50% !important;
                                right: 8px !important;
                                transform: translateY(-50%) !important;
                                width: 38px !important;
                                height: 38px !important;
                                display: flex !important;
                                align-items: center !important;
                                justify-content: center !important;
                                border: 0 !important;
                                padding: 0 !important;
                                margin: 0 !important;
                                background: transparent !important;
                                cursor: pointer !important;
                                z-index: 20 !important;
                                color: #6c757d !important;
                            "
                        >

                            <i
                                id="passwordConfirmationIcon"
                                class="bi bi-eye"
                                aria-hidden="true"
                            ></i>

                        </button>

                    </div>

                </div>


                {{-- ================================
                     ACTIONS
                ================================= --}}
                <div class="register-actions">

                    <button
                        type="submit"
                        class="register-submit"
                    >

                        <i
                            class="bi bi-person-plus"
                            aria-hidden="true"
                        ></i>

                        <span>
                            Créer mon compte
                        </span>

                    </button>

                    <a
                        href="{{ route('home') }}"
                        class="register-cancel"
                    >
                        Annuler
                    </a>

                </div>

            </form>

        </div>


        {{-- ================================
             LIEN CONNEXION
        ================================= --}}
        <div class="register-login">

            <span>
                Déjà un compte ?
            </span>

            <a href="{{ route('login') }}">
                Se connecter
            </a>

        </div>

    </div>

</div>


{{-- ==================================================
     JAVASCRIPT — AFFICHAGE / MASQUAGE MOTS DE PASSE
=================================================== --}}
@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
     * Fonction générique permettant d'afficher
     * ou de masquer un champ mot de passe.
     */
    function setupPasswordToggle(
        inputId,
        buttonId,
        iconId,
        showLabel,
        hideLabel
    ) {

        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        const icon = document.getElementById(iconId);

        if (!input || !button || !icon) {
            return;
        }

        button.addEventListener('click', function (event) {

            /*
             * Empêche le bouton de déclencher
             * l'envoi du formulaire.
             */
            event.preventDefault();
            event.stopPropagation();

            const shouldShow = input.type === 'password';

            input.type = shouldShow
                ? 'text'
                : 'password';

            /*
             * Changement de l'icône Bootstrap.
             */
            icon.classList.toggle(
                'bi-eye',
                !shouldShow
            );

            icon.classList.toggle(
                'bi-eye-slash',
                shouldShow
            );

            /*
             * Accessibilité.
             */
            const label = shouldShow
                ? hideLabel
                : showLabel;

            button.setAttribute(
                'aria-label',
                label
            );

            button.setAttribute(
                'title',
                label
            );

            button.setAttribute(
                'aria-pressed',
                shouldShow ? 'true' : 'false'
            );

            /*
             * On remet le curseur dans le champ.
             */
            input.focus();
        });
    }


    /*
     * MOT DE PASSE
     */
    setupPasswordToggle(
        'password',
        'togglePassword',
        'passwordIcon',
        'Afficher le mot de passe',
        'Masquer le mot de passe'
    );


    /*
     * CONFIRMATION DU MOT DE PASSE
     */
    setupPasswordToggle(
        'password_confirmation',
        'togglePasswordConfirmation',
        'passwordConfirmationIcon',
        'Afficher la confirmation du mot de passe',
        'Masquer la confirmation du mot de passe'
    );

});
</script>

@endpush

@endsection
