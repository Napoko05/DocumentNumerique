@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')

<div class="admin-user-edit-page">

<div class="admin-user-edit-wrapper">

    {{-- EN-TÊTE --}}
    <div class="admin-user-edit-heading">

        <div class="admin-user-edit-heading-content">

            <div class="admin-user-edit-icon">
                <i class="bi bi-person-circle"></i>
            </div>

            <div>
                <span class="admin-section-label">
                    MON COMPTE
                </span>

                <h1>
                    Mon profil
                </h1>

                <p>
                    Gérez vos informations personnelles et vos coordonnées.
                </p>
            </div>

        </div>

        <a
            href="{{ url()->previous() }}"
            class="admin-user-edit-back"
        >
            <i class="bi bi-arrow-left"></i>
            Retour
        </a>

    </div>

    {{-- MESSAGE DE SUCCÈS --}}
    @if(session('success'))
        <div class="admin-user-edit-alert admin-alert-success">
            <span class="admin-user-edit-alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </span>

            <span>
                {{ session('success') }}
            </span>
        </div>
    @endif

    {{-- ERREURS --}}
    @if($errors->any())
        <div class="admin-user-edit-alert admin-alert-danger">
            <span class="admin-user-edit-alert-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </span>

            <div>
                <strong>Veuillez corriger les erreurs suivantes :</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- PROFIL --}}
    <div class="admin-user-edit-card">

        <form
            method="POST"
            action="{{ route('profile.update') }}"
            class="admin-user-edit-form"
        >

            @csrf
            @method('PATCH')

            {{-- INFORMATIONS PERSONNELLES --}}
            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">
                    <i class="bi bi-person-vcard-fill admin-user-edit-section-icon"></i>

                    <div>
                        <h2>Informations personnelles</h2>
                        <p>
                            Ces informations permettent d'identifier votre compte.
                        </p>
                    </div>
                </div>

                <div class="admin-user-edit-grid">

                    {{-- NOM --}}
                    <div class="admin-user-field">

                        <label for="nom">
                            Nom <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">
                            <i class="bi bi-person"></i>

                            <input
                                id="nom"
                                name="nom"
                                type="text"
                                value="{{ old('nom', $user->nom) }}"
                                autocomplete="family-name"
                                required
                                class="@error('nom') is-invalid @enderror"
                            >
                        </div>

                        @error('nom')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- PRÉNOM --}}
                    <div class="admin-user-field">

                        <label for="prenom">
                            Prénom <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">
                            <i class="bi bi-person"></i>

                            <input
                                id="prenom"
                                name="prenom"
                                type="text"
                                value="{{ old('prenom', $user->prenom) }}"
                                autocomplete="given-name"
                                required
                                class="@error('prenom') is-invalid @enderror"
                            >
                        </div>

                        @error('prenom')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- EMAIL --}}
                    <div class="admin-user-field">

                        <label for="email">
                            Adresse e-mail <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">
                            <i class="bi bi-envelope"></i>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $user->email) }}"
                                autocomplete="email"
                                required
                                class="@error('email') is-invalid @enderror"
                            >
                        </div>

                        @error('email')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- TÉLÉPHONE --}}
                    <div class="admin-user-field">

                        <label for="numero">
                            Numéro de téléphone <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">
                            <i class="bi bi-telephone"></i>

                            <input
                                id="numero"
                                name="numero"
                                type="tel"
                                value="{{ old('numero', $user->numero) }}"
                                autocomplete="tel"
                                required
                                class="@error('numero') is-invalid @enderror"
                            >
                        </div>

                        @error('numero')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>

            {{-- SÉCURITÉ --}}
            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">

                    <i class="bi bi-shield-lock-fill admin-user-edit-section-icon"></i>

                    <div>
                        <h2>Sécurité du compte</h2>
                        <p>
                            La modification du mot de passe se fait séparément.
                        </p>
                    </div>

                </div>

                <div class="admin-user-edit-actions">

                    <a
                        href="{{ route('profile.password.edit') }}"
                        class="admin-btn admin-btn-warning"
                    >
                        <i class="bi bi-key-fill"></i>
                        Modifier mon mot de passe
                    </a>

                </div>

            </div>

            {{-- ACTIONS --}}
            <div class="admin-user-edit-actions">

                <a
                    href="{{ url()->previous() }}"
                    class="admin-user-cancel-btn"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-user-save-btn"
                >
                    <i class="bi bi-check-lg"></i>
                    Enregistrer les modifications
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection
