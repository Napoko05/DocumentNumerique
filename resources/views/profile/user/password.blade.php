@extends('layouts.app')

@section('title', 'Modifier mon mot de passe')

@section('content')

<div class="admin-user-edit-page">

<div class="admin-user-edit-wrapper">

    {{-- EN-TÊTE --}}
    <div class="admin-user-edit-heading">

        <div class="admin-user-edit-heading-content">

            <div class="admin-user-edit-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <div>
                <span class="admin-section-label">
                    SÉCURITÉ
                </span>

                <h1>
                    Modifier mon mot de passe
                </h1>

                <p>
                    Protégez votre compte avec un nouveau mot de passe.
                </p>
            </div>

        </div>

        <a
            href="{{ route('profile.edit') }}"
            class="admin-user-edit-back"
        >
            <i class="bi bi-arrow-left"></i>
            Retour au profil
        </a>

    </div>

    {{-- SUCCÈS --}}
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
                <strong>Veuillez corriger les erreurs :</strong>

                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    @endif

    <div class="admin-user-edit-card">

        <form
            method="POST"
            action="{{ route('profile.password.update') }}"
            class="admin-user-edit-form"
        >

            @csrf
            @method('PATCH')

            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">

                    <i class="bi bi-key-fill admin-user-edit-section-icon"></i>

                    <div>
                        <h2>Changement du mot de passe</h2>

                        <p>
                            Pour votre sécurité, indiquez d'abord votre mot de passe actuel.
                        </p>
                    </div>

                </div>

                <div class="admin-user-edit-grid">
                    
{{-- MOT DE PASSE ACTUEL --}}
<div class="admin-user-field">

    <label for="current_password">
        Mot de passe actuel <span>*</span>
    </label>

    <div class="admin-user-input-wrapper">

        <i class="bi bi-lock"></i>

        <input
            id="current_password"
            name="current_password"
            type="password"
            autocomplete="current-password"
            required
            class="@error('current_password') is-invalid @enderror"
        >

    </div>

    @error('current_password')
        <small class="text-danger">
            {{ $message }}
        </small>
    @enderror

    {{-- MOT DE PASSE OUBLIÉ --}}

    <div class="mt-2">

        <a
            href="{{ route('password.request') }}"
            class="text-decoration-none"
        >
            <i class="bi bi-question-circle"></i>
            Mot de passe oublié ?
        </a>

    </div>

</div>


                    {{-- NOUVEAU MOT DE PASSE --}}
                    <div class="admin-user-field">

                        <label for="password">
                            Nouveau mot de passe <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="bi bi-lock-fill"></i>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                minlength="8"
                                required
                                class="@error('password') is-invalid @enderror"
                            >

                        </div>

                        <small class="admin-form-help">
                            Le mot de passe doit contenir au minimum 8 caractères.
                        </small>

                        @error('password')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                    {{-- CONFIRMATION --}}
                    <div class="admin-user-field">

                        <label for="password_confirmation">
                            Confirmer le nouveau mot de passe <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="bi bi-lock-fill"></i>

                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                minlength="8"
                                required
                            >

                        </div>

                    </div>

                </div>

            </div>

            {{-- ACTIONS --}}
            <div class="admin-user-edit-actions">

                <a
                    href="{{ route('profile.edit') }}"
                    class="admin-user-cancel-btn"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-user-save-btn"
                >
                    <i class="bi bi-shield-check"></i>
                    Modifier le mot de passe
                </button>

            </div>

        </form>

    </div>

</div>

</div>

@endsection
