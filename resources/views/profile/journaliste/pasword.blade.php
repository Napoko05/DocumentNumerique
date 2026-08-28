
@extends('layouts.journaliste_app')

@section('title', 'Modifier le mot de passe')

@section('content')

<div class="admin-page">

    <div class="admin-page-header">

        <div>
            <span class="admin-section-label">
                SÉCURITÉ
            </span>

            <h1>
                Modifier le mot de passe
            </h1>

            <p>
                Définissez un nouveau mot de passe pour ce journaliste.
            </p>
        </div>

        <a
            href="{{ route('admin.staff.journalistes.index') }}"
            class="admin-btn admin-btn-secondary"
        >
            Retour
        </a>

    </div>


    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>
    @endif


    @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            {{ session('error') }}
        </div>
    @endif


    <div class="admin-edit-card">

        <div class="admin-edit-header">

            <div>

                <span class="admin-section-label">
                    COMPTE JOURNALISTE
                </span>

                <h2>
                    {{ $journaliste->prenom }} {{ $journaliste->nom }}
                </h2>

                <p>
                    Modification sécurisée du mot de passe du compte.
                </p>

            </div>

        </div>


        <form
            method="POST"
            action="{{ route(
                'admin.staff.journalistes.password.update',
                $journaliste
            ) }}"
            class="admin-form"
        >

            @csrf
            @method('PUT')


            <div class="admin-form-grid admin-form-grid-single">


                {{-- NOUVEAU MOT DE PASSE --}}

                <div class="admin-form-field">

                    <label for="password">
                        Nouveau mot de passe <span>*</span>
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="@error('password') is-invalid @enderror"
                    >

                    @error('password')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                    <small class="admin-form-help">
                        Le mot de passe doit contenir au minimum 8 caractères.
                    </small>

                </div>


                {{-- CONFIRMATION --}}

                <div class="admin-form-field">

                    <label for="password_confirmation">
                        Confirmer le mot de passe <span>*</span>
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                        class="@error('password_confirmation') is-invalid @enderror"
                    >

                    @error('password_confirmation')
                        <small class="admin-field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>


            <div class="admin-form-actions">

                <a
                    href="{{ route(
                        'admin.staff.journalistes.edit',
                        $journaliste
                    ) }}"
                    class="admin-btn admin-btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-btn admin-btn-warning"
                >
                    Modifier le mot de passe
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
