
@extends('layouts.app')

@section('title', 'Connexion | YAA\'Scientia')

@section('head')
    @vite('resources/css/auth.css')
@endsection

@section('content')

<div class="auth-page">

    <div class="auth-container">

        {{-- =====================================================
             PARTIE GAUCHE
        ====================================================== --}}

        <section class="auth-intro">

            {{-- Logo --}}
            <div class="auth-brand">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo YAA'Scientia"
                >

                <span class="auth-brand-name">
                    YAA'Scientia
                </span>

            </div>


            {{-- Présentation --}}
            <div class="auth-intro-content">

                <span class="auth-intro-badge">
                    Bibliothèque numérique
                </span>

                <h1>
                    Le savoir à portée de main.
                </h1>

                <p>
                    Accédez à votre espace YAA'Scientia et retrouvez
                    vos ressources pédagogiques, livres numériques
                    et contenus scientifiques.
                </p>


                {{-- AVANTAGES --}}
                <div class="auth-features">

                    <div class="auth-feature">

                        <span class="auth-feature-icon">
                            <i
                                class="bi bi-check-lg"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span>
                            Ressources éducatives accessibles facilement
                        </span>

                    </div>


                    <div class="auth-feature">

                        <span class="auth-feature-icon">
                            <i
                                class="bi bi-shield-lock"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span>
                            Un espace sécurisé et personnel
                        </span>

                    </div>


                    <div class="auth-feature">

                        <span class="auth-feature-icon">
                            <i
                                class="bi bi-book"
                                aria-hidden="true"
                            ></i>
                        </span>

                        <span>
                            Des contenus adaptés à votre parcours
                        </span>

                    </div>

                </div>

            </div>

        </section>


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}

        <section class="auth-form-wrapper">

            <div class="auth-form">

                {{-- TITRE --}}
                <h2 class="auth-title">
                    Bon retour !
                </h2>

                <p class="auth-subtitle">
                    Connectez-vous à votre compte YAA'Scientia.
                </p>


                {{-- MESSAGE SUCCÈS --}}
                @if(session('success'))

                    <div
                        class="auth-alert auth-alert-success"
                        role="alert"
                        aria-live="polite"
                    >
                        {{ session('success') }}
                    </div>

                @endif


                {{-- ERREURS --}}
                @if($errors->any())

                    <div
                        class="auth-alert auth-alert-error"
                        role="alert"
                        aria-live="polite"
                    >
                        {{ $errors->first() }}
                    </div>

                @endif


                {{-- FORMULAIRE --}}
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    autocomplete="on"
                >

                    @csrf


                    {{-- =================================================
                         EMAIL / TÉLÉPHONE / MATRICULE
                    ================================================== --}}

                    <div class="auth-field">

                        <label
                            for="login"
                            class="auth-label"
                        >
                            Email, numéro de téléphone ou matricule
                        </label>

                        <input
                            id="login"
                            type="text"
                            name="login"
                            value="{{ old('login') }}"
                            required
                            autofocus
                            autocomplete="username"
                            maxlength="255"
                            class="auth-input @error('login') is-invalid @enderror"
                            placeholder="Email, téléphone ou matricule"
                        >

                        @error('login')

                            <div
                                class="auth-error"
                                role="alert"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                         MOT DE PASSE
                    ================================================== --}}

                    <div class="auth-field">

                        <label
                            for="password"
                            class="auth-label"
                        >
                            Mot de passe
                        </label>


                        {{-- Conteneur du champ + œil --}}
                        <div class="auth-input-wrapper">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                maxlength="255"
                                class="auth-input auth-password-input @error('password') is-invalid @enderror"
                                placeholder="Votre mot de passe"
                            >


                            {{-- Bouton afficher / masquer --}}
                            <button
                                type="button"
                                id="togglePassword"
                                class="auth-password-toggle"
                                aria-label="Afficher le mot de passe"
                                aria-pressed="false"
                                title="Afficher le mot de passe"
                            >

                                <i
                                    id="passwordIcon"
                                    class="bi bi-eye"
                                    aria-hidden="true"
                                ></i>

                            </button>

                        </div>


                        @error('password')

                            <div
                                class="auth-error"
                                role="alert"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                         OPTIONS
                    ================================================== --}}

                    <div class="auth-options">

                        <label class="auth-checkbox">

                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                {{ old('remember') ? 'checked' : '' }}
                            >

                            <span>
                                Se souvenir de moi
                            </span>

                        </label>


                        @if(Route::has('password.request'))

                            <a
                                href="{{ route('password.request') }}"
                                class="auth-link"
                            >
                                Mot de passe oublié ?
                            </a>

                        @endif

                    </div>


                    {{-- =================================================
                         BOUTON CONNEXION
                    ================================================== --}}

                    <button
                        type="submit"
                        class="auth-submit"
                    >
                        Se connecter
                    </button>

                </form>


                {{-- =================================================
                     INSCRIPTION
                ================================================== --}}

                <div class="auth-register">

                    <span>
                        Vous n'avez pas encore de compte ?
                    </span>

                    <a href="{{ route('register') }}">
                        Créer un compte
                    </a>

                </div>


                {{-- =================================================
                     RETOUR ACCUEIL
                ================================================== --}}

                <a
                    href="{{ url('/') }}"
                    class="auth-back"
                >

                    <i
                        class="bi bi-arrow-left me-1"
                        aria-hidden="true"
                    ></i>

                    Retour à l'accueil

                </a>

            </div>

        </section>

    </div>

</div>


{{-- =============================================================
     JAVASCRIPT — AFFICHER / MASQUER MOT DE PASSE
     
     Le script est directement dans la vue afin de ne pas dépendre
     de @stack('scripts') dans layouts.app.
============================================================= --}}

<script>
(function () {

    'use strict';

    function initializePasswordToggle() {

        const passwordInput =
            document.getElementById('password');

        const togglePassword =
            document.getElementById('togglePassword');

        const passwordIcon =
            document.getElementById('passwordIcon');


        /*
         * Vérification des éléments.
         */
        if (
            !passwordInput ||
            !togglePassword ||
            !passwordIcon
        ) {
            return;
        }


        /*
         * Évite d'enregistrer deux fois
         * le même événement.
         */
        if (
            togglePassword.dataset.initialized === 'true'
        ) {
            return;
        }

        togglePassword.dataset.initialized = 'true';


        /*
         * CLIC SUR L'ŒIL
         */
        togglePassword.addEventListener(
            'click',
            function (event) {

                /*
                 * Le bouton ne doit jamais
                 * envoyer le formulaire.
                 */
                event.preventDefault();
                event.stopPropagation();


                /*
                 * État actuel du champ.
                 */
                const isHidden =
                    passwordInput.type === 'password';


                /*
                 * Afficher / masquer.
                 */
                passwordInput.type = isHidden
                    ? 'text'
                    : 'password';


                /*
                 * Changer l'icône.
                 */
                passwordIcon.classList.toggle(
                    'bi-eye',
                    !isHidden
                );

                passwordIcon.classList.toggle(
                    'bi-eye-slash',
                    isHidden
                );


                /*
                 * Accessibilité.
                 */
                const label = isHidden
                    ? 'Masquer le mot de passe'
                    : 'Afficher le mot de passe';

                togglePassword.setAttribute(
                    'aria-label',
                    label
                );

                togglePassword.setAttribute(
                    'title',
                    label
                );

                togglePassword.setAttribute(
                    'aria-pressed',
                    isHidden
                        ? 'true'
                        : 'false'
                );


                /*
                 * Remet le curseur dans le champ.
                 */
                passwordInput.focus();

            }
        );

    }


    /*
     * Initialisation immédiate si le DOM
     * est déjà chargé.
     */
    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initializePasswordToggle
        );

    } else {

        initializePasswordToggle();

    }

})();
</script>

@endsection
