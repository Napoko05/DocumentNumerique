@extends('layouts.app')

@section('content')

{{-- ================================================================
     HERO
================================================================ --}}
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <p class="text-sm font-semibold text-brand-700 uppercase tracking-wider mb-2">Catalogue</p>
        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-ink mb-1">Enseignement — Toutes sections</h1>
        <p class="text-sm text-ink-muted">Secondaire et Supérieur — Général &amp; Technique</p>
    </div>
</section>

{{-- ================================================================
     GRILLE 4 CARTES
================================================================ --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- ====== SECONDAIRE GÉNÉRAL ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3 bg-brand-50">
                <div class="w-8 h-8 rounded-lg bg-brand-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h2 class="font-heading font-bold text-base text-brand-800">Secondaire Général</h2>
            </div>

            <div class="p-5 space-y-4">
                {{-- 1er Cycle --}}
                <div>
                    <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider mb-2">1er Cycle</p>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach(['6ème', '5ème', '4ème', '3ème'] as $classe)
                            <a href="#"
                               class="flex items-center justify-center py-2 px-3 rounded-lg border border-brand-200 text-sm font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 transition-colors">
                                {{ $classe }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- 2nd Cycle --}}
                <div>
                    <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider mb-2">2nd Cycle</p>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['2nde', '1ère', 'Terminale'] as $classe)
                            <a href="#"
                               class="flex items-center justify-center py-2 px-3 rounded-lg border border-brand-200 text-sm font-medium text-brand-800 bg-brand-50 hover:bg-brand-100 transition-colors">
                                {{ $classe }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- ====== SECONDAIRE TECHNIQUE ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3 bg-accent-50">
                <div class="w-8 h-8 rounded-lg bg-accent-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h2 class="font-heading font-bold text-base text-accent-800">Secondaire Technique</h2>
            </div>

            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach([
                        'seconde-bep'      => 'Seconde (BEP)',
                        'premiere-bacpro'  => 'Première (BAC Pro)',
                        'terminale-bacpro' => 'Terminale (BAC Pro)',
                    ] as $level => $label)
                        <a href="{{ route('secondary.technique', ['level' => $level]) }}"
                           class="flex items-center justify-between px-4 py-3 rounded-lg border border-accent-200 bg-accent-50 text-sm font-medium text-accent-800 hover:bg-accent-100 transition-colors group">
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

        {{-- ====== SUPÉRIEUR GÉNÉRAL ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3 bg-emerald-50">
                <div class="w-8 h-8 rounded-lg bg-emerald-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                </div>
                <h2 class="font-heading font-bold text-base text-emerald-800">Supérieur Général</h2>
            </div>

            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach([
                        'licence'  => 'Licence',
                        'master'   => 'Master',
                        'doctorat' => 'Doctorat',
                    ] as $level => $label)
                        <a href="{{ route('niveau_filiere.superieur', ['level' => $level]) }}"
                           class="flex items-center justify-between px-4 py-3 rounded-lg border border-emerald-200 bg-emerald-50 text-sm font-medium text-emerald-800 hover:bg-emerald-100 transition-colors group">
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

        {{-- ====== SUPÉRIEUR TECHNIQUE ====== --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100 flex items-center gap-3 bg-rose-50">
                <div class="w-8 h-8 rounded-lg bg-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <h2 class="font-heading font-bold text-base text-rose-800">Supérieur Technique</h2>
            </div>

            <div class="p-5">
                <div class="flex flex-col gap-2">
                    @foreach([
                        'licence-pro' => 'Licence Pro',
                        'master-pro'  => 'Master Pro',
                    ] as $level => $label)
                        <a href="{{ route('niveau_filiere.superieur', ['level' => $level]) }}"
                           class="flex items-center justify-between px-4 py-3 rounded-lg border border-rose-200 bg-rose-50 text-sm font-medium text-rose-800 hover:bg-rose-100 transition-colors group">
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
