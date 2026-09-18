@extends('layouts.admin_app')

@section('page-title', 'Modifier un utilisateur')

@section('content')

<div class="admin-user-edit-page">

<div class="admin-user-edit-wrapper">

    {{-- EN-TÊTE --}}
    <div class="admin-user-edit-heading">

        <div class="admin-user-edit-heading-content">

            <div class="admin-user-edit-icon">
                <i class="fas fa-user-edit"></i>
            </div>

            <div>
                <h1>Modifier un utilisateur</h1>

                <p>
                    Modifiez les informations et le rôle de cet utilisateur.
                </p>
            </div>

        </div>

        <a
            href="{{ route('admin.users.index') }}"
            class="admin-user-edit-back"
        >
            <i class="fas fa-arrow-left"></i>
            Retour
        </a>

    </div>


    {{-- CARTE --}}
    <div class="admin-user-edit-card">

        {{-- ERREURS --}}
        @if($errors->any())

            <div class="admin-user-edit-alert">

                <div class="admin-user-edit-alert-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>

                <div>
                    <strong>Impossible d'enregistrer les modifications.</strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>

        @endif


        {{-- FORMULAIRE --}}
        <form
            method="POST"
            action="{{ route('admin.users.update', $user->id) }}"
            class="admin-user-edit-form"
        >

            @csrf
            @method('PUT')


            {{-- INFORMATIONS PERSONNELLES --}}
            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">

                    <div class="admin-user-edit-section-icon">
                        <i class="fas fa-user"></i>
                    </div>

                    <div>
                        <h2>Informations personnelles</h2>
                        <p>Identité de l'utilisateur</p>
                    </div>

                </div>


                <div class="admin-user-edit-grid">

                    {{-- NOM --}}
                    <div class="admin-user-field">

                        <label for="nom">
                            Nom
                            <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-user"></i>

                            <input
                                type="text"
                                id="nom"
                                name="nom"
                                value="{{ old('nom', $user->nom) }}"
                                required
                                autocomplete="family-name"
                                placeholder="Nom"
                            >

                        </div>

                    </div>


                    {{-- PRÉNOM --}}
                    <div class="admin-user-field">

                        <label for="prenom">
                            Prénom
                            <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-user"></i>

                            <input
                                type="text"
                                id="prenom"
                                name="prenom"
                                value="{{ old('prenom', $user->prenom) }}"
                                required
                                autocomplete="given-name"
                                placeholder="Prénom"
                            >

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="admin-user-field">

                        <label for="email">
                            Adresse e-mail
                            <span>*</span>
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-envelope"></i>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                autocomplete="email"
                                placeholder="exemple@email.com"
                            >

                        </div>

                    </div>


                    {{-- TÉLÉPHONE --}}
                    <div class="admin-user-field">

                        <label for="numero">
                            Téléphone
                        </label>

                        <div class="admin-user-input-wrapper">

                            <i class="fas fa-phone"></i>

                            <input
                                type="text"
                                id="numero"
                                name="numero"
                                value="{{ old('numero', $user->numero) }}"
                                autocomplete="tel"
                                placeholder="Numéro de téléphone"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- RÔLE --}}
            <div class="admin-user-edit-section">

                <div class="admin-user-edit-section-title">

                    <div class="admin-user-edit-section-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>

                    <div>
                        <h2>Rôle et autorisations</h2>
                        <p>Définissez le niveau d'accès de l'utilisateur</p>
                    </div>

                </div>


                <div class="admin-user-field">

                    <label for="role">
                        Rôle
                        <span>*</span>
                    </label>

                    <div class="admin-user-input-wrapper">

                        <i class="fas fa-shield-alt"></i>

                        <select
                            name="role"
                            id="role"
                            required
                        >

                            @foreach($roles as $role)

                                <option
                                    value="{{ $role->name }}"
                                    {{ $user->hasRole($role->name) ? 'selected' : '' }}
                                >
                                    {{ $role->name }}
                                </option>

                            @endforeach

                        </select>

                        <i class="fas fa-chevron-down admin-user-select-arrow"></i>

                    </div>

                </div>

            </div>


            {{-- UTILISATEUR ACTUEL --}}
            <div class="admin-user-current">

                <div class="admin-user-current-avatar">
                    <i class="fas fa-user"></i>
                </div>

                <div class="admin-user-current-info">

                    <strong>
                        {{ $user->nom }} {{ $user->prenom }}
                    </strong>

                    <span>
                        {{ $user->email }}
                    </span>

                </div>

            </div>


            {{-- ACTIONS --}}
            <div class="admin-user-edit-actions">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="admin-user-cancel-btn"
                >
                    <i class="fas fa-times"></i>
                    Annuler
                </a>

                <button
                    type="submit"
                    class="admin-user-save-btn"
                >
                    <i class="fas fa-save"></i>
                    Mettre à jour
                </button>

            </div>

        </form>

    </div>

</div>
</div>

@endsection
