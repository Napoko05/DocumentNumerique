@extends('layouts.journaliste_app')

@section('title', 'Modifier le mot de passe')

@section('content')

<div class="admin-page">

    {{-- =========================================================
         EN-TÊTE
    ========================================================== --}}

    <div class="admin-page-header">

        <div>

            <span class="admin-section-label">
                SÉCURITÉ DU COMPTE
            </span>

            <h1>
                Modifier le mot de passe
            </h1>

            <p>
                Modifiez le mot de passe de votre compte journaliste.
            </p>

        </div>

        <a
            href="{{ route('journaliste.profil') }}"
            class="admin-btn admin-btn-secondary">
            ← Retour au profil
        </a>

    </div>


    {{-- =========================================================
         MESSAGE DE SUCCÈS
    ========================================================== --}}

    @if(session('success'))

    <div class="admin-alert admin-alert-success">

        {{ session('success') }}

    </div>

    @endif


    {{-- =========================================================
         MESSAGE D'ERREUR
    ========================================================== --}}

    @if(session('error'))

    <div class="admin-alert admin-alert-danger">

        {{ session('error') }}

    </div>

    @endif


    {{-- =========================================================
         ERREURS DE VALIDATION
    ========================================================== --}}

    @if($errors->any())

    <div class="admin-alert admin-alert-danger">

        <strong>
            Impossible de modifier le mot de passe.
        </strong>

        <ul style="margin:8px 0 0 18px;">

            @foreach($errors->all() as $error)

            <li>
                {{ $error }}
            </li>

            @endforeach

        </ul>

    </div>

    @endif


    {{-- =========================================================
         CARTE MOT DE PASSE
    ========================================================== --}}

    <div class="admin-edit-card">

        <div class="admin-edit-header">

            <div>

                <span class="admin-section-label">
                    COMPTE JOURNALISTE
                </span>

                <h2>
                    {{ $journaliste->prenom }}
                    {{ $journaliste->nom }}
                </h2>

                <p>
                    Pour modifier votre mot de passe, confirmez d'abord
                    votre mot de passe actuel.
                </p>

            </div>

        </div>


        {{-- =====================================================
             FORMULAIRE
        ====================================================== --}}

        <form
            method="POST"
            action="{{ route('journaliste.profil.password.update') }}"
            class="admin-form">

            @csrf
            @method('PUT')


            <div class="admin-form-grid admin-form-grid-single">


                {{-- =================================================
                     MOT DE PASSE ACTUEL
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="current_password">

                        Mot de passe actuel
                        <span>*</span>

                    </label>

                    <input
                        id="current_password"
                        name="current_password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="@error('current_password') is-invalid @enderror">

                    @error('current_password')

                    <small class="admin-field-error">
                        {{ $message }}
                    </small>

                    @enderror

                    {{-- Mot de passe oublié --}}
                    <div style="margin-top: 8px;">
                        <a
                            href="{{ route('journaliste.password.request') }}"
                            class="admin-form-help">
                            Mot de passe oublié ?
                        </a>
                    </div>



                </div>


                {{-- =================================================
                     NOUVEAU MOT DE PASSE
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="password">

                        Nouveau mot de passe
                        <span>*</span>

                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="@error('password') is-invalid @enderror">

                    @error('password')

                    <small class="admin-field-error">
                        {{ $message }}
                    </small>

                    @enderror

                    <small class="admin-form-help">
                        Le mot de passe doit contenir au minimum
                        8 caractères.
                    </small>

                </div>


                {{-- =================================================
                     CONFIRMATION
                ================================================== --}}

                <div class="admin-form-field">

                    <label for="password_confirmation">

                        Confirmer le nouveau mot de passe
                        <span>*</span>

                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="@error('password_confirmation') is-invalid @enderror">

                    @error('password_confirmation')

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
                    href="{{ route('journaliste.profil') }}"
                    class="admin-btn admin-btn-secondary">
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-btn admin-btn-warning">
                    🔐 Modifier le mot de passe
                </button>

            </div>

        </form>

    </div>

</div>

@endsection