@extends('layouts.app')

@section('content')

<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4 py-12 bg-surface-soft">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex flex-col items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="YAA'Scientia"
                     class="h-14 w-14 rounded-2xl object-contain shadow-sm">
                <span class="font-heading font-bold text-xl text-ink">YAA'Scientia</span>
            </a>
            <p class="text-sm text-ink-muted mt-2">Créez votre compte gratuitement</p>
        </div>

        {{-- Carte --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

            <h1 class="font-heading font-bold text-xl text-ink mb-6">Inscription</h1>

            {{-- Erreurs --}}
            @if($errors->any())
                <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- Nom + Prénom côte à côte --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Nom</label>
                        <input type="text"
                               name="nom"
                               value="{{ old('nom') }}"
                               required
                               class="input-field"
                               placeholder="SOME">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-ink mb-1.5">Prénom</label>
                        <input type="text"
                               name="prenom"
                               value="{{ old('prenom') }}"
                               required
                               class="input-field"
                               placeholder="Arsène">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Email</label>
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           class="input-field"
                           placeholder="email@exemple.com">
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Mot de passe</label>
                    <input type="password"
                           name="password"
                           required
                           class="input-field"
                           placeholder="••••••••">
                </div>

                {{-- Confirmation --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">Confirmer le mot de passe</label>
                    <input type="password"
                           name="password_confirmation"
                           required
                           class="input-field"
                           placeholder="••••••••">
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-3 pt-2">
                    <button type="submit" class="btn-primary w-full justify-center">
                        Créer mon compte
                    </button>
                    <a href="{{ route('home') }}"
                       class="text-center text-sm font-medium text-ink-muted hover:text-ink transition-colors">
                        Annuler
                    </a>
                </div>

            </form>
        </div>

        {{-- Lien connexion --}}
        <p class="text-center text-sm text-ink-muted mt-6">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="font-semibold text-brand-800 hover:text-brand-700 transition-colors">
                Se connecter
            </a>
        </p>

    </div>
</div>

@endsection
