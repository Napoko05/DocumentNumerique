@extends('layouts.admin_app')

@section('page-title', 'Créer un utilisateur')

@section('content')

<div class="admin-user-edit-page">

<div class="admin-user-edit-wrapper">

    {{-- En-tête --}}
    <div class="admin-user-edit-heading">

        <div class="admin-user-edit-heading-content">

            <div class="admin-user-edit-icon">
                <i class="fas fa-user-plus"></i>
            </div>

            <div>
                <h1>Créer un utilisateur</h1>
                <p>Ajouter un nouvel utilisateur à la plateforme</p>
            </div>

        </div>

        <a
            href="{{ route('admin.users.index') }}"
            class="admin-user-edit-back"
        >
            <i class="fas fa-arrow-left"></i>
            <span>Retour à la liste</span>
        </a>

    </div>


    {{-- Carte principale --}}
    <div class="admin-user-edit-card">

        <form
            method="POST"
            action="{{ route('admin.users.store') }}"
            class="admin-user-edit-form"
        >

            @csrf


            {{-- Erreurs --}}
            @if($errors->any())

                <div class="admin-user-edit-alert">

                    <div class="admin-user-edit-alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>

                    <div>
                        <strong>Une erreur est survenue</strong>

                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            @endif


            {{-- Informations personnelles --}}
            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">

                    <div class="admin-user-edit-section-icon">
                        <i class="fas fa-user"></i>
                    </div>

                    <div>
                        <h2>Informations personnelles</h2>
                        <p>Identité et coordonnées de l'utilisateur</p>
                    </div>

                </div>


                <div class="admin-user-edit-grid">

                    {{-- Nom --}}
                    <div class="admin-user-field">

                        <label for="nom">
                            Nom <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-user"></i>

                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                value="{{ old('nom') }}"
                                required
                                placeholder="Nom"
                            >

                        </div>

                    </div>


                    {{-- Prénom --}}
                    <div class="admin-user-field">

                        <label for="prenom">
                            Prénom <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-user"></i>

                            <input
                                type="text"
                                id="prenom"
                                name="prenom"
                                value="{{ old('prenom') }}"
                                required
                                placeholder="Prénom"
                            >

                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="admin-user-field">

                        <label for="email">
                            Email <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-envelope"></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="email@exemple.com"
                            >

                        </div>

                    </div>


                    {{-- Téléphone --}}
                    <div class="admin-user-field">

                        <label for="numero">
                            Téléphone <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-phone"></i>

                            <input
                                type="text"
                                id="numero"
                                name="numero"
                                value="{{ old('numero') }}"
                                required
                                placeholder="+226 XX XX XX XX"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- Sécurité --}}
            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">

                    <div class="admin-user-edit-section-icon">
                        <i class="fas fa-lock"></i>
                    </div>

                    <div>
                        <h2>Sécurité du compte</h2>
                        <p>Définissez le mot de passe de connexion</p>
                    </div>

                </div>


                <div class="admin-user-edit-grid">

                    {{-- Mot de passe --}}
                    <div class="admin-user-field">

                        <label for="password">
                            Mot de passe <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-key"></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                placeholder="••••••••"
                            >

                        </div>

                    </div>


                    {{-- Confirmation --}}
                    <div class="admin-user-field">

                        <label for="password_confirmation">
                            Confirmer le mot de passe <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-shield-alt"></i>

                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                required
                                placeholder="••••••••"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- Rôle --}}
            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">

                    <div class="admin-user-edit-section-icon">
                        <i class="fas fa-user-tag"></i>
                    </div>

                    <div>
                        <h2>Rôle utilisateur</h2>
                        <p>Définissez les permissions de l'utilisateur</p>
                    </div>

                </div>


                <div class="admin-user-field">

                    <label for="role">
                        Rôle <span>*</span>
                    </label>

                    <div class="admin-user-input-wrapper">

                        <i class="fas fa-user-tag"></i>

                        <select
                            id="role"
                            name="role"
                            required
                        >

                            @foreach($roles as $role)

                                <option
                                    value="{{ $role->name }}"
                                    {{ old('role') == $role->name ? 'selected' : '' }}
                                >
                                    {{ $role->name }}
                                </option>

                            @endforeach

                        </select>

                        <i class="fas fa-chevron-down admin-user-select-arrow"></i>

                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="admin-user-edit-actions">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="admin-user-cancel-btn"
                >
                    <i class="fas fa-times"></i>
                    <span>Annuler</span>
                </a>

                <button
                    type="submit"
                    class="admin-user-save-btn"
                >
                    <i class="fas fa-user-plus"></i>
                    <span>Enregistrer</span>
                </button>

            </div>

        </form>

    </div>

</div>


</div>

@endsection
