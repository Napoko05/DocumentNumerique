@extends('layouts.app')

@section('content')

{{-- ================================================================
     HERO + BREADCRUMB
================================================================ --}}
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="flex items-center gap-2 text-xs text-ink-muted mb-4">
            <a href="{{ url('/') }}" class="hover:text-ink transition-colors">Accueil</a>
            <span>/</span>
            <a href="{{ route('secondary.index') }}" class="hover:text-ink transition-colors">Catalogue</a>
            <span>/</span>
            <span class="text-ink font-medium">Secondaire Général</span>
        </nav>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div>
                <h1 class="font-heading text-2xl sm:text-3xl font-bold text-ink">Enseignement Secondaire — Général</h1>
                <p class="text-sm text-ink-muted">Manuels et documents pour le secondaire général</p>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     FILTRES
================================================================ --}}
<section class="bg-surface-muted border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
        <div class="flex flex-col sm:flex-row gap-4">

            <div class="flex-1">
                <label for="cycle" class="block text-xs font-semibold text-ink-muted uppercase tracking-wider mb-1.5">Cycle</label>
                <select id="cycle"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition">
                    <option>Choisir...</option>
                    <option>1er Cycle (6e, 5e, 4e, 3e)</option>
                    <option>2nd Cycle (2nde, 1ère, Tle)</option>
                </select>
            </div>

            <div class="flex-1">
                <label for="classe" class="block text-xs font-semibold text-ink-muted uppercase tracking-wider mb-1.5">Classe</label>
                <select id="classe"
                        class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-ink focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition">
                    <option>Choisir...</option>
                    <option>6ème</option>
                    <option>5ème</option>
                    <option>4ème</option>
                    <option>3ème</option>
                    <option>2nde</option>
                    <option>1ère</option>
                    <option>Terminale</option>
                </select>
            </div>

        </div>
    </div>
</section>

{{-- ================================================================
     GRILLE LIVRES
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        {{-- Carte livre exemple --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden group hover:shadow-md transition-shadow">

            {{-- Couverture --}}
            <div class="relative aspect-[3/4] bg-brand-700 flex items-center justify-center overflow-hidden">
                @if(file_exists(public_path('images/etude.png')))
                    <img src="{{ asset('images/etude.png') }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                         alt="Physique - 2nde">
                @else
                    {{-- Fallback initiale si pas d'image --}}
                    <span class="font-heading font-bold text-5xl text-white opacity-80">PH</span>
                @endif
                <div class="absolute bottom-0 left-0 right-0 px-3 py-2 bg-gradient-to-t from-black/60 to-transparent">
                    <span class="text-xs font-semibold text-white/80 uppercase tracking-wider">Physique</span>
                </div>
            </div>

            {{-- Infos --}}
            <div class="p-4">
                <h3 class="font-semibold text-sm text-ink mb-1 leading-snug">Physique — 2nde</h3>
                <p class="text-xs text-ink-muted mb-3">Sciences exactes</p>
                <a href="#"
                   class="block text-center px-3 py-2 rounded-lg bg-brand-800 text-white text-xs font-semibold hover:bg-brand-700 transition-colors">
                    Lire
                </a>
            </div>
        </div>

        {{-- Message si pas d'autres livres --}}
        <div class="sm:col-span-2 lg:col-span-3 xl:col-span-3 flex items-center justify-center py-10">
            <div class="text-center">
                <div class="w-14 h-14 rounded-2xl bg-surface-muted flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-ink-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-ink-muted">D'autres ouvrages arrivent bientôt</p>
                <p class="text-xs text-ink-faint mt-1">Utilisez les filtres pour affiner votre recherche</p>
            </div>
        </div>

    </div>
</section>

@endsection
