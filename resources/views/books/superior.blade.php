@extends('layouts.app')

@section('content')

{{-- Breadcrumb + titre --}}
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <nav class="flex items-center gap-2 text-xs text-ink-muted mb-4">
            <a href="{{ url('/') }}" class="hover:text-ink transition-colors">Accueil</a>
            <span>/</span>
            <a href="{{ route('secondary.index') }}" class="hover:text-ink transition-colors">Catalogue</a>
            <span>/</span>
            <span class="text-ink font-medium">Enseignement Supérieur</span>
        </nav>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                </svg>
            </div>
            <div>
                <h1 class="font-heading text-2xl sm:text-3xl font-bold text-ink">Enseignement Supérieur</h1>
                <p class="text-sm text-ink-muted">Filières générales et techniques — Licence, Master, Doctorat</p>
            </div>
        </div>
    </div>
</section>

{{-- Contenu --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- Supérieur Général --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-emerald-50">
                <h2 class="font-heading font-bold text-base text-emerald-800">Supérieur Général</h2>
                <p class="text-xs text-emerald-700 mt-0.5">Formations académiques universitaires</p>
            </div>
            <div class="p-6 flex flex-col gap-3">
                @foreach([
                    'licence'  => ['Licence',  'Cycle Licence — Bac+3', 'Fondations académiques'],
                    'master'   => ['Master',   'Cycle Master — Bac+5',  'Approfondissement et spécialisation'],
                    'doctorat' => ['Doctorat', 'Recherche — Bac+8',     'Recherche et innovation scientifique'],
                ] as $level => [$label, $badge, $desc])
                    <a href="{{ route('superior.general', ['level' => $level]) }}"
                       class="group flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 transition-colors">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-sm text-ink group-hover:text-emerald-800">{{ $label }}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 font-medium">{{ $badge }}</span>
                            </div>
                            <p class="text-xs text-ink-muted">{{ $desc }}</p>
                        </div>
                        <svg class="w-5 h-5 text-ink-faint group-hover:text-emerald-600 shrink-0 transition-colors"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Supérieur Technique --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-accent-50">
                <h2 class="font-heading font-bold text-base text-accent-800">Supérieur Technique</h2>
                <p class="text-xs text-accent-700 mt-0.5">Formations professionnalisantes</p>
            </div>
            <div class="p-6 flex flex-col gap-3">
                @foreach([
                    'licence-pro' => ['Licence Pro', 'Bac+3 Pro', 'Cycle Licence Professionnelle'],
                    'master-pro'  => ['Master Pro',  'Bac+5 Pro', 'Cycle Master Professionnel'],
                ] as $level => [$label, $badge, $desc])
                    <a href="{{ route('superior.technique', ['level' => $level]) }}"
                       class="group flex items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-accent-300 hover:bg-accent-50 transition-colors">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-semibold text-sm text-ink group-hover:text-accent-800">{{ $label }}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-accent-100 text-accent-700 font-medium">{{ $badge }}</span>
                            </div>
                            <p class="text-xs text-ink-muted">{{ $desc }}</p>
                        </div>
                        <svg class="w-5 h-5 text-ink-faint group-hover:text-accent-600 shrink-0 transition-colors"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</section>

@endsection
