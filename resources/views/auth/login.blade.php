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


                {{-- =================================================
                     AVANTAGES
                ================================================== --}}

                <div class="auth-features">

                    <div class="auth-feature">

                        <span class="auth-feature-icon">
                            <i class="bi bi-check-lg"></i>
                        </span>

                        <span>
                            Ressources éducatives accessibles facilement
                        </span>

                    </div>


                    <div class="auth-feature">

                        <span class="auth-feature-icon">
                            <i class="bi bi-shield-lock"></i>
                        </span>

                        <span>
                            Un espace sécurisé et personnel
                        </span>

                    </div>


                    <div class="auth-feature">

                        <span class="auth-feature-icon">
                            <i class="bi bi-book"></i>
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

                {{-- =================================================
                     TITRE
                ================================================== --}}

                <h2 class="auth-title">
                    Bon retour !
                </h2>

                <p class="auth-subtitle">
                    Connectez-vous à votre compte YAA'Scientia.
                </p>


                {{-- =================================================
                     MESSAGE SUCCÈS
                ================================================== --}}

                @if(session('success'))

                    <div
                        class="auth-alert auth-alert-success"
                        role="alert"
                    >
                        {{ session('success') }}
                    </div>

                @endif


                {{-- =================================================
                     ERREURS
                ================================================== --}}

                @if($errors->any())

                    <div
                        class="auth-alert auth-alert-error"
                        role="alert"
                    >
                        {{ $errors->first() }}
                    </div>

                @endif


                {{-- =================================================
                     FORMULAIRE
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route('login') }}"
                    novalidate
                >

                    @csrf


                    {{-- =================================================
                         EMAIL / MATRICULE
                    ================================================== --}}

                    <div class="auth-field">

                        <label
                            for="login"
                            class="auth-label"
                        >
                            Email ou matricule
                        </label>

                        <input
                            id="login"
                            type="text"
                            name="login"
                            value="{{ old('login') }}"
                            required
                            autofocus
                            autocomplete="username"
                            class="auth-input @error('login') is-invalid @enderror"
                            placeholder="email@exemple.com"
                        >

                        @error('login')

                            <div class="auth-error">
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

                        <div class="auth-input-wrapper">

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="auth-input auth-password-input @error('password') is-invalid @enderror"
                                placeholder="Votre mot de passe"
                            >

                            <button
                                type="button"
                                id="togglePassword"
                                class="auth-password-toggle"
                                aria-label="Afficher le mot de passe"
                                aria-pressed="false"
                            >
                                <i
                                    id="passwordIcon"
                                    class="bi bi-eye"
                                    aria-hidden="true"
                                ></i>
                            </button>

                        </div>

                        @error('password')

                            <div class="auth-error">
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

                    Vous n'avez pas encore de compte ?

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
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à l'accueil
                </a>

            </div>

        </section>

    </div>

</div>

@endsection


{{-- =============================================================
     JAVASCRIPT
============================================================= --}}

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const passwordIcon = document.getElementById('passwordIcon');

    if (!passwordInput || !togglePassword || !passwordIcon) {
        return;
    }

    togglePassword.addEventListener('click', function () {

        const isPassword = passwordInput.type === 'password';

        passwordInput.type = isPassword
            ? 'text'
            : 'password';

        passwordIcon.classList.toggle(
            'bi-eye',
            !isPassword
        );

        passwordIcon.classList.toggle(
            'bi-eye-slash',
            isPassword
        );

        togglePassword.setAttribute(
            'aria-label',
            isPassword
                ? 'Masquer le mot de passe'
                : 'Afficher le mot de passe'
        );

        togglePassword.setAttribute(
            'aria-pressed',
            isPassword ? 'true' : 'false'
        );

    });

});
</script>

@endpush