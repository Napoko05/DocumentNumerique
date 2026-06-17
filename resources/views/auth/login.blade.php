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
            <p class="text-sm text-ink-muted mt-2">Connectez-vous à votre espace</p>
        </div>

        {{-- Carte --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">

            <h1 class="font-heading font-bold text-xl text-ink mb-6">Connexion</h1>

            {{-- Succès --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Erreurs --}}
            @if($errors->any())
                <div class="mb-4 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                {{-- Email ou Matricule --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">
                        Email ou Matricule
                    </label>
                    <input type="text"
                           name="login"
                           value="{{ old('login') }}"
                           required
                           class="input-field"
                           placeholder="email@exemple.com ou ADM0001">
                </div>

                {{-- Mot de passe --}}
                <div>
                    <label class="block text-sm font-medium text-ink mb-1.5">
                        Mot de passe
                    </label>
                    <input type="password"
                           name="password"
                           required
                           class="input-field"
                           placeholder="••••••••">
                </div>

                {{-- Se souvenir --}}
                <div class="flex items-center gap-2">
                    <input type="checkbox"
                           name="remember"
                           id="remember"
                           class="w-4 h-4 rounded border-slate-300 text-brand-700 focus:ring-brand-500">
                    <label for="remember" class="text-sm text-ink-soft">Se souvenir de moi</label>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col gap-3 pt-1">
                    <button type="submit" class="btn-primary w-full justify-center">
                        Connexion
                    </button>
                    <a href="{{ route('home') }}"
                       class="text-center text-sm font-medium text-ink-muted hover:text-ink transition-colors">
                        Annuler
                    </a>
                </div>

            </form>
        </div>

        {{-- Lien inscription --}}
        <p class="text-center text-sm text-ink-muted mt-6">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-semibold text-brand-800 hover:text-brand-700 transition-colors">
                S'inscrire
            </a>
        </p>

    </div>
</div>

@endsection
