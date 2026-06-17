@extends('layouts.app')

@section('content')

{{-- ================================================================
     HERO
================================================================ --}}
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="flex items-center gap-2 text-xs text-ink-muted mb-4">
            <a href="{{ url('/') }}" class="hover:text-ink transition-colors">Accueil</a>
            <span>/</span>
            <span class="text-ink font-medium">Enseignement Professionnel</span>
        </nav>
        <p class="text-sm font-semibold text-accent-700 uppercase tracking-wider mb-2">Catalogue</p>
        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-ink mb-1">Enseignement Professionnel</h1>
        <p class="text-sm text-ink-muted">Établissements de formation professionnelle et technique supérieure</p>
    </div>
</section>

{{-- ================================================================
     GRILLE ÉTABLISSEMENTS
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        {{-- ====== ENS ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-brand-700">
                <h2 class="font-heading font-bold text-sm text-white">ENS</h2>
                <p class="text-xs text-brand-200">École Normale Supérieure</p>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider mb-2">Années</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['1ère Année', '2ème Année', '3ème Année', '3ème'] as $item)
                            <a href="#"
                               class="flex items-center justify-center py-2 px-2 rounded-lg border border-brand-200 text-xs font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 transition-colors text-center">
                                {{ $item }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider mb-2">CAPCEG</p>
                    <div class="flex flex-col gap-1.5">
                        @foreach(['Français & Anglais', 'Math & Physique Chimie', 'Math & Science de la Vie et de la Terre'] as $item)
                            <a href="#"
                               class="px-3 py-2 rounded-lg border border-slate-200 text-xs font-medium text-ink-soft hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800 transition-colors">
                                {{ $item }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider mb-2">INSPECTEUR</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['Primaire', 'Secondaire'] as $item)
                            <a href="#"
                               class="flex items-center justify-center py-2 px-2 rounded-lg border border-slate-200 text-xs font-medium text-ink-soft hover:border-brand-300 hover:bg-brand-50 hover:text-brand-800 transition-colors">
                                {{ $item }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== ENSP ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-accent-600">
                <h2 class="font-heading font-bold text-sm text-white">ENSP</h2>
                <p class="text-xs text-accent-100">École Nationale de Santé Publique</p>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach(['Licence 1', 'Licence 2', 'Licence 3', 'Rapport'] as $item)
                        <a href="#"
                           class="flex items-center justify-between px-4 py-2.5 rounded-lg border border-accent-200 bg-accent-50 text-sm font-medium text-accent-800 hover:bg-accent-100 transition-colors">
                            {{ $item }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ====== IDS ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-accent-600">
                <h2 class="font-heading font-bold text-sm text-white">IDS</h2>
                <p class="text-xs text-accent-100">Institut du Développement des Sciences</p>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach(['Math & PC', 'Math & SVT', 'Rapport'] as $item)
                        <a href="#"
                           class="flex items-center justify-between px-4 py-2.5 rounded-lg border border-accent-200 bg-accent-50 text-sm font-medium text-accent-800 hover:bg-accent-100 transition-colors">
                            {{ $item }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ====== ENEP ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-accent-600">
                <h2 class="font-heading font-bold text-sm text-white">ENEP</h2>
                <p class="text-xs text-accent-100">École Nationale des Enseignants du Primaire</p>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach(['Licence 1', 'Licence 2', 'Licence 3', 'Rapport'] as $item)
                        <a href="#"
                           class="flex items-center justify-between px-4 py-2.5 rounded-lg border border-accent-200 bg-accent-50 text-sm font-medium text-accent-800 hover:bg-accent-100 transition-colors">
                            {{ $item }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ====== UIT ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-emerald-700">
                <h2 class="font-heading font-bold text-sm text-white">UIT</h2>
                <p class="text-xs text-emerald-100">Université Internationale de Technologie</p>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach([
                        ['BTP', route('niveau_filiere.superieur', ['level' => 'licence'])],
                        ['Marketing & Comptabilité', route('niveau_filiere.superieur', ['level' => 'licence'])],
                        ['Électricité & Froid & Climatisation', route('niveau_filiere.superieur', ['level' => 'master'])],
                        ['Rapport', route('niveau_filiere.superieur', ['level' => 'doctorat'])],
                    ] as [$label, $url])
                        <a href="{{ $url }}"
                           class="flex items-center justify-between px-4 py-2.5 rounded-lg border border-emerald-200 bg-emerald-50 text-sm font-medium text-emerald-800 hover:bg-emerald-100 transition-colors group">
                            <span class="leading-snug">{{ $label }}</span>
                            <svg class="w-4 h-4 shrink-0 ml-2 opacity-50 group-hover:opacity-100 transition-opacity"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ====== SUPÉRIEUR TECHNIQUE ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-3 border-b border-slate-100 bg-rose-600">
                <h2 class="font-heading font-bold text-sm text-white">Supérieur Technique</h2>
                <p class="text-xs text-rose-100">Filières professionnalisantes</p>
            </div>
            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach([
                        ['Licence Pro', route('niveau_filiere.superieur', ['level' => 'licence-pro'])],
                        ['Master Pro',  route('niveau_filiere.superieur', ['level' => 'master-pro'])],
                    ] as [$label, $url])
                        <a href="{{ $url }}"
                           class="flex items-center justify-between px-4 py-2.5 rounded-lg border border-rose-200 bg-rose-50 text-sm font-medium text-rose-800 hover:bg-rose-100 transition-colors group">
                            {{ $label }}
                            <svg class="w-4 h-4 opacity-50 group-hover:opacity-100 transition-opacity"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
