@extends('layouts.journaliste_app')

@section('title', 'Mot de passe oublié')

@section('content')

<div class="admin-page">

    <div class="admin-page-header">
        <div>
            <div class="admin-page-kicker">
                SÉCURITÉ DU COMPTE
            </div>

            <h1>Mot de passe oublié</h1>

            <p>
                Utilisez votre adresse email pour recevoir un lien
                sécurisé permettant de réinitialiser votre mot de passe.
            </p>
        </div>

        <a
            href="{{ route('journaliste.profil.password.edit') }}"
            class="admin-btn admin-btn-secondary"
        >
            ← Retour
        </a>
    </div>

    {{-- Message de succès --}}
    @if(session('success'))
        <div class="profile-alert profile-alert-success">
            <div class="profile-alert-icon">✓</div>

            <div>
                <strong>Opération réussie</strong>

                <p>
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    {{-- Message d'erreur --}}
    @if(session('error'))
        <div class="profile-alert profile-alert-danger">
            <div class="profile-alert-icon">!</div>

            <div>
                <strong>Erreur</strong>

                <p>
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif

    {{-- Erreurs de validation --}}
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

    <div class="admin-edit-card">

        <div class="admin-edit-header">
            <div>
                <h2>Réinitialiser votre mot de passe</h2>

                <p>
                    Un lien de réinitialisation sera envoyé à l'adresse
                    email associée à votre compte journaliste.
                </p>
            </div>
        </div>

        <form
            method="POST"
            action="{{ route('journaliste.password.email') }}"
            class="admin-form"
        >
            @csrf

            <div class="admin-form-grid-single">

                <div class="admin-form-field">

                    <label for="email">
                        Adresse email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="@error('email') is-invalid @enderror"
                        placeholder="exemple@email.com"
                        autocomplete="email"
                        required
                        autofocus
                    >

                    @error('email')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                    <small class="admin-form-help">
                        Saisissez l'adresse email utilisée pour votre
                        compte journaliste.
                    </small>

                </div>

            </div>

            <div class="admin-form-actions">

                <a
                    href="{{ route('journaliste.profil.password.edit') }}"
                    class="admin-btn admin-btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-btn admin-btn-primary"
                >
                    Envoyer le lien
                </button>

            </div>

        </form>

    </div>

</div>

@endsection