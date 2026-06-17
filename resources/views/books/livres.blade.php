@extends('layouts.app')

@section('content')

{{-- ================================================================
     HERO CATALOGUE
================================================================ --}}
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-2xl">
            <p class="text-sm font-semibold text-brand-700 uppercase tracking-wider mb-2">Catalogue</p>
            <h1 class="font-heading text-3xl sm:text-4xl font-bold text-ink mb-3">
                Livres numériques
            </h1>
            <p class="text-ink-muted text-base leading-relaxed">
                Découvrez notre sélection d'ouvrages scientifiques classés par niveau d'étude.
                Choisissez votre section pour accéder aux ressources adaptées.
            </p>
        </div>
    </div>
</section>

{{-- ================================================================
     GRILLE PRINCIPALE — 2 CATÉGORIES
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- ====== ENSEIGNEMENT SECONDAIRE ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- En-tête de catégorie --}}
            <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-lg text-ink">Enseignement Secondaire</h2>
                    <p class="text-sm text-ink-muted">Documents et manuels pour le secondaire.</p>
                </div>
            </div>

            <div class="p-6 space-y-5">

                {{-- Général --}}
                <div class="rounded-xl border border-slate-100 bg-surface-soft p-5">
                    <h3 class="text-sm font-semibold text-ink mb-1">Général</h3>
                    <p class="text-xs text-ink-muted mb-4">Sélectionnez votre cycle :</p>

                    <div class="space-y-3">
                        {{-- 1er Cycle --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg border border-brand-200 bg-white text-sm font-medium text-brand-800 hover:bg-brand-50 transition-colors">
                                <span>1er cycle (6e — 3e)</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="mt-2 grid grid-cols-2 gap-2">
                                @foreach(['6e' => '6ème', '5e' => '5ème', '4e' => '4ème', '3e' => '3ème'] as $slug => $label)
                                    <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => $slug]) }}"
                                       class="flex items-center justify-center px-3 py-2 rounded-lg border border-slate-200 bg-white text-sm font-medium text-ink-soft hover:border-brand-300 hover:text-brand-800 hover:bg-brand-50 transition-colors">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- 2nd Cycle --}}
                        <div x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-lg border border-brand-200 bg-white text-sm font-medium text-brand-800 hover:bg-brand-50 transition-colors">
                                <span>2nd cycle (2nde — Terminale)</span>
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" x-transition class="mt-2 grid grid-cols-3 gap-2">
                                @foreach(['2nde' => '2nde', '1ere' => '1ère', 'terminale' => 'Terminale'] as $slug => $label)
                                    <a href="{{ route('secondary.general', ['cycle' => '2nd-cycle', 'classe' => $slug]) }}"
                                       class="flex items-center justify-center px-3 py-2 rounded-lg border border-slate-200 bg-white text-sm font-medium text-ink-soft hover:border-brand-300 hover:text-brand-800 hover:bg-brand-50 transition-colors">
                                        {{ $label }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Technique --}}
                <div class="rounded-xl border border-slate-100 bg-surface-soft p-5">
                    <h3 class="text-sm font-semibold text-ink mb-1">Technique</h3>
                    <p class="text-xs text-ink-muted mb-4">Niveaux techniques :</p>
                    <div class="flex flex-col gap-2">
                        @foreach([
                            'seconde-bep'      => 'Seconde (BEP)',
                            'premiere-bacpro'  => 'Première (BAC Pro)',
                            'terminale-bacpro' => 'Terminale (BAC Pro)',
                        ] as $level => $label)
                            <a href="{{ route('secondary.technique', ['level' => $level]) }}"
                               class="flex items-center justify-between px-4 py-2.5 rounded-lg border border-slate-200 bg-white text-sm font-medium text-ink-soft hover:border-accent-300 hover:text-accent-700 hover:bg-accent-50 transition-colors group">
                                {{ $label }}
                                <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        {{-- ====== ENSEIGNEMENT SUPÉRIEUR ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

            {{-- En-tête de catégorie --}}
            <div class="px-6 py-5 border-b border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-heading font-bold text-lg text-ink">Enseignement Supérieur</h2>
                    <p class="text-sm text-ink-muted">Ressources pour Licence, Master et Doctorat.</p>
                </div>
            </div>

            <div class="p-6 space-y-5">

                {{-- Supérieur Général --}}
                <div class="rounded-xl border border-slate-100 bg-surface-soft p-5">
                    <h3 class="text-sm font-semibold text-ink mb-1">Général</h3>
                    <p class="text-xs text-ink-muted mb-4">Choisissez votre cycle :</p>
                    <div class="flex flex-col gap-2">
                        @foreach([
                            'licence'  => ['Licence',  'Cycle Licence — Bac+3'],
                            'master'   => ['Master',   'Cycle Master — Bac+5'],
                            'doctorat' => ['Doctorat', 'Recherche avancée'],
                        ] as $level => [$label, $desc])
                            <a href="{{ route('superior.general', ['level' => $level]) }}"
                               class="flex items-center justify-between px-4 py-3 rounded-lg border border-slate-200 bg-white hover:border-emerald-300 hover:bg-emerald-50 transition-colors group">
                                <div>
                                    <p class="text-sm font-medium text-ink group-hover:text-emerald-800">{{ $label }}</p>
                                    <p class="text-xs text-ink-muted">{{ $desc }}</p>
                                </div>
                                <svg class="w-4 h-4 text-ink-faint group-hover:text-emerald-600 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Supérieur Technique --}}
                <div class="rounded-xl border border-slate-100 bg-surface-soft p-5">
                    <h3 class="text-sm font-semibold text-ink mb-1">Technique</h3>
                    <p class="text-xs text-ink-muted mb-4">Filières professionnelles :</p>
                    <div class="flex flex-col gap-2">
                        @foreach([
                            'licence-pro' => ['Licence Pro',  'Cycle Licence Professionnelle'],
                            'master-pro'  => ['Master Pro',   'Cycle Master Professionnel'],
                        ] as $level => [$label, $desc])
                            <a href="{{ route('superior.technique', ['level' => $level]) }}"
                               class="flex items-center justify-between px-4 py-3 rounded-lg border border-slate-200 bg-white hover:border-accent-300 hover:bg-accent-50 transition-colors group">
                                <div>
                                    <p class="text-sm font-medium text-ink group-hover:text-accent-700">{{ $label }}</p>
                                    <p class="text-xs text-ink-muted">{{ $desc }}</p>
                                </div>
                                <svg class="w-4 h-4 text-ink-faint group-hover:text-accent-600 transition-colors"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

@endsection
