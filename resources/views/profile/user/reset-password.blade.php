@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')

<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <div class="admin-page-kicker">
                SÉCURITÉ DU COMPTE
            </div>

            <h1>Réinitialiser le mot de passe</h1>

            <p>
                Définissez un nouveau mot de passe sécurisé pour votre compte.
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="profile-alert profile-alert-danger">

            <div class="profile-alert-icon">!</div>

            <div>
                <strong>Impossible de continuer</strong>

                <ul class="profile-alert-errors">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        </div>
    @endif

    @if(session('error'))
        <div class="profile-alert profile-alert-danger">

            <div class="profile-alert-icon">!</div>

            <div>
                <strong>Erreur</strong>
                <p>{{ session('error') }}</p>
            </div>

        </div>
    @endif

    <div class="admin-edit-card">

        <div class="admin-edit-header">
            <div>
                <h2>Nouveau mot de passe</h2>

                <p>
                    Choisissez un mot de passe d'au moins 8 caractères.
                </p>
            </div>
        </div>

        <form
            method="POST"
            action="{{ route('password.update') }}"
            class="admin-form"
        >
            @csrf

            <input
                type="hidden"
                name="token"
                value="{{ $token }}"
            >

            <div class="admin-form-grid-single">

                <div class="admin-form-field">

                    <label for="email">
                        Adresse email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $email) }}"
                        class="@error('email') is-invalid @enderror"
                        autocomplete="email"
                        required
                    >

                    @error('email')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="admin-form-field">

                    <label for="password">
                        Nouveau mot de passe
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="@error('password') is-invalid @enderror"
                        autocomplete="new-password"
                        required
                    >

                    @error('password')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                    <small class="admin-form-help">
                        Minimum 8 caractères.
                    </small>

                </div>

                <div class="admin-form-field">

                    <label for="password_confirmation">
                        Confirmer le nouveau mot de passe
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        required
                    >

                </div>

            </div>

            <div class="admin-form-actions">

                <a
                    href="{{ route('login') }}"
                    class="admin-btn admin-btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-btn admin-btn-primary"
                >
                    Réinitialiser le mot de passe
                </button>

            </div>

        </form>

    </div>

</div>

@endsection