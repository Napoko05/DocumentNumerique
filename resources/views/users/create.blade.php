@extends('layouts.admin_app')

@section('page-title', 'Créer un utilisateur')

@section('content')

<div class="max-w-2xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <h2 class="font-heading font-bold text-lg text-ink mb-6">Créer un utilisateur</h2>

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Nom</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="input-field" placeholder="Nom">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Prénom</label>
                    <input type="text" name="prenom" value="{{ old('prenom') }}" required class="input-field" placeholder="Prénom">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="input-field" placeholder="email@exemple.com">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Téléphone</label>
                <input type="text" name="numero" value="{{ old('numero') }}" required class="input-field" placeholder="+226 XX XX XX XX">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Mot de passe</label>
                    <input type="password" name="password" required class="input-field" placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Confirmer</label>
                    <input type="password" name="password_confirmation" required class="input-field" placeholder="••••••••">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Rôle</label>
                <select name="role" class="input-field">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Enregistrer</button>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-ink-soft hover:text-ink transition-colors">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
