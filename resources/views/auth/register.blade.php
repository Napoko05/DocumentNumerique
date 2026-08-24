@extends('layouts.app')

@section('content')

<div class="register-page">

    <div class="register-container">

        {{-- =====================================================
             LOGO / EN-TÊTE
        ====================================================== --}}
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


        {{-- =====================================================
             CARTE
        ====================================================== --}}
        <div class="register-card">

            <div class="register-card-header">

                <h1 class="register-title">
                    Inscription
                </h1>

                <p class="register-description">
                    Créez votre compte pour accéder à YAA'Scientia.
                </p>

            </div>


            {{-- =================================================
                 ERREURS
            ================================================== --}}
            @if($errors->any())

                <div class="register-alert register-alert-danger">

                    <i class="bi bi-exclamation-circle-fill"></i>

                    <div>
                        {{ $errors->first() }}
                    </div>

                </div>

            @endif


            {{-- =================================================
                 FORMULAIRE
            ================================================== --}}
            <form
                method="POST"
                action="{{ route('register') }}"
                class="register-form"
            >

                @csrf


                {{-- NOM + PRÉNOM --}}
                <div class="register-row">

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
                            required
                        >

                        @error('nom')
                            <span class="register-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


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
                            required
                        >

                        @error('prenom')
                            <span class="register-error">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>

                </div>


                {{-- EMAIL --}}
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
                        required
                    >

                    @error('email')
                        <span class="register-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- MOT DE PASSE --}}
                <div class="register-group">

                    <label
                        for="password"
                        class="register-label"
                    >
                        Mot de passe
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="register-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        autocomplete="new-password"
                        required
                    >

                    @error('password')
                        <span class="register-error">
                            {{ $message }}
                        </span>
                    @enderror

                </div>


                {{-- CONFIRMATION --}}
                <div class="register-group">

                    <label
                        for="password_confirmation"
                        class="register-label"
                    >
                        Confirmer le mot de passe
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="register-input"
                        placeholder="••••••••"
                        autocomplete="new-password"
                        required
                    >

                </div>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}
                <div class="register-actions">

                    <button
                        type="submit"
                        class="register-submit"
                    >
                        <i class="bi bi-person-plus"></i>

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


        {{-- =====================================================
             CONNEXION
        ====================================================== --}}
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

@endsection