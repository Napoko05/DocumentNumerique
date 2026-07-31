@extends('layouts.app')

@section('head')
<style>
    .scroll-banner {
        overflow: hidden;
        white-space: nowrap;
    }
    .scroll-banner span {
        display: inline-block;
        animation: marquee 22s linear infinite;
    }
    @keyframes marquee {
        0%   { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
</style>
@endsection

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
            <span class="text-ink font-medium">Filières &amp; Spécialités</span>
        </nav>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h1 class="font-heading text-2xl sm:text-3xl font-bold text-ink">Filières &amp; Spécialités</h1>
                <p class="text-sm text-ink-muted">Enseignement Supérieur — Général &amp; Technique</p>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     SUPÉRIEUR GÉNÉRAL
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Bandeau citation --}}
    <div class="mb-8 px-5 py-3 rounded-xl bg-brand-50 border border-brand-100 scroll-banner">
        <span class="text-sm font-medium text-brand-800 italic">
            "Le savoir est une lumière qui éclaire chaque étape du parcours académique. Explorez les licences pour bâtir vos fondations, les masters pour approfondir vos connaissances, et les doctorats pour repousser les limites de la recherche."
        </span>
    </div>

    {{-- Titre section --}}
    <div class="flex items-center gap-3 mb-6">
        <div class="w-8 h-8 rounded-lg bg-brand-700 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
            </svg>
        </div>
        <h2 class="font-heading font-bold text-xl text-ink">Supérieur Général</h2>
    </div>

    {{-- Grille filières générales --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-14">

        {{-- Licence --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-brand-50 text-center">
                <h3 class="font-heading font-bold text-sm text-brand-800">Licence</h3>
            </div>
            <div class="p-4 flex flex-wrap gap-2 justify-center">
                @foreach([
                    'Licence en Droit',
                    'Licence en Lettres Modernes',
                    'Licence en Sciences Économiques',
                    'Licence en Mathématiques',
                    'Licence en Informatique',
                ] as $filiere)
                    <a href="#"
                       class="inline-flex items-center px-3 py-1.5 rounded-full border border-brand-200 bg-brand-50 text-xs font-medium text-brand-800 hover:bg-brand-700 hover:text-white hover:border-brand-700 transition-colors">
                        {{ $filiere }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Master --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-brand-50 text-center">
                <h3 class="font-heading font-bold text-sm text-brand-800">Master</h3>
            </div>
            <div class="p-4 flex flex-wrap gap-2 justify-center">
                @foreach([
                    'Master en Droit Public',
                    'Master en Sciences de Gestion',
                    'Master en Informatique',
                    'Master en Mathématiques Appliquées',
                    'Master en Histoire',
                ] as $filiere)
                    <a href="#"
                       class="inline-flex items-center px-3 py-1.5 rounded-full border border-brand-200 bg-brand-50 text-xs font-medium text-brand-800 hover:bg-brand-700 hover:text-white hover:border-brand-700 transition-colors">
                        {{ $filiere }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Doctorat --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-brand-50 text-center">
                <h3 class="font-heading font-bold text-sm text-brand-800">Doctorat</h3>
            </div>
            <div class="p-4 flex flex-wrap gap-2 justify-center">
                @foreach([
                    'Doctorat en Droit',
                    'Doctorat en Sciences Économiques',
                    'Doctorat en Informatique',
                    'Doctorat en Lettres',
                ] as $filiere)
                    <a href="#"
                       class="inline-flex items-center px-3 py-1.5 rounded-full border border-brand-200 bg-brand-50 text-xs font-medium text-brand-800 hover:bg-brand-700 hover:text-white hover:border-brand-700 transition-colors">
                        {{ $filiere }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ================================================================
         SUPÉRIEUR TECHNIQUE
    ================================================================ --}}

    {{-- Bandeau citation --}}
    <div class="mb-8 px-5 py-3 rounded-xl bg-emerald-50 border border-emerald-100 scroll-banner">
        <span class="text-sm font-medium text-emerald-800 italic">
            "Les filières techniques forgent l'expertise pratique. Les licences professionnelles ouvrent la voie aux métiers spécialisés, tandis que les masters professionnels affinent vos compétences pour devenir acteur du progrès."
        </span>
    </div>

    {{-- Titre section --}}
    <div class="flex items-center gap-3 mb-6">
        <div class="w-8 h-8 rounded-lg bg-emerald-700 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <h2 class="font-heading font-bold text-xl text-ink">Supérieur Technique</h2>
    </div>

    {{-- Grille filières techniques --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Licence Pro --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-emerald-50 text-center">
                <h3 class="font-heading font-bold text-sm text-emerald-800">Licence Professionnelle</h3>
            </div>
            <div class="p-4 flex flex-wrap gap-2 justify-center">
                @foreach([
                    'Licence Pro en Réseaux & Télécoms',
                    'Licence Pro en Génie Civil',
                    'Licence Pro en Électronique',
                    'Licence Pro en Comptabilité',
                ] as $filiere)
                    <a href="#"
                       class="inline-flex items-center px-3 py-1.5 rounded-full border border-emerald-200 bg-emerald-50 text-xs font-medium text-emerald-800 hover:bg-emerald-700 hover:text-white hover:border-emerald-700 transition-colors">
                        {{ $filiere }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Master Pro --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-emerald-50 text-center">
                <h3 class="font-heading font-bold text-sm text-emerald-800">Master Professionnel</h3>
            </div>
            <div class="p-4 flex flex-wrap gap-2 justify-center">
                @foreach([
                    'Master Pro en Informatique',
                    'Master Pro en Énergie',
                    'Master Pro en Génie Industriel',
                    'Master Pro en Finance',
                ] as $filiere)
                    <a href="#"
                       class="inline-flex items-center px-3 py-1.5 rounded-full border border-emerald-200 bg-emerald-50 text-xs font-medium text-emerald-800 hover:bg-emerald-700 hover:text-white hover:border-emerald-700 transition-colors">
                        {{ $filiere }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>

</section>

@endsection
