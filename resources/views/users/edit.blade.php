@extends('layouts.admin_app')

@section('page-title', 'Modifier un utilisateur')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

        <h2 class="font-heading font-bold text-lg text-ink mb-6">
            Modifier l'utilisateur
        </h2>

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.users.update', $user->id) }}"
              class="space-y-5">

            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">
                        Nom
                    </label>

                    <input type="text"
                           name="nom"
                           value="{{ $user->nom }}"
                           required
                           class="input-field">
                </div>

                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">
                        Prénom
                    </label>

                    <input type="text"
                           name="prenom"
                           value="{{ $user->prenom }}"
                           required
                           class="input-field">
                </div>

            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">
                    Email
                </label>

                <input type="email"
                       name="email"
                       value="{{ $user->email }}"
                       required
                       class="input-field">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">
                    Téléphone
                </label>

                <input type="text"
                       name="numero"
                       value="{{ $user->numero }}"
                       class="input-field">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">
                    Rôle
                </label>

                <select name="role" class="input-field">

                    @foreach($roles as $role)

                        <option value="{{ $role->name }}"
                            {{ $user->hasRole($role->name) ? 'selected' : '' }}>

                            {{ $role->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="flex items-center gap-3 pt-2">

                <button type="submit" class="btn-primary">
                    Mettre à jour
                </button>

                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 text-sm font-medium text-ink-soft hover:text-ink transition-colors">
                    Annuler
                </a>

            </div>

        </form>

    </div>
</div>

@endsection