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
            <span class="text-ink font-medium">Secondaire Technique</span>
        </nav>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-accent-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-accent-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="font-heading text-2xl sm:text-3xl font-bold text-ink">Enseignement Secondaire — Technique</h1>
                <p class="text-sm text-ink-muted">Filières techniques et professionnelles du secondaire</p>
            </div>
        </div>
    </div>
</section>

{{-- Grille des niveaux --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

        @foreach([
            [
                'level' => 'seconde-bep',
                'label' => 'Seconde (BEP)',
                'desc'  => 'Classe de Seconde — Brevet d\'Études Professionnelles',
                'color' => 'brand',
            ],
            [
                'level' => 'premiere-bacpro',
                'label' => 'Première (BAC Pro)',
                'desc'  => 'Classe de Première technique — BAC Professionnel',
                'color' => 'accent',
            ],
            [
                'level' => 'terminale-bacpro',
                'label' => 'Terminale (BAC Pro)',
                'desc'  => 'Classe de Terminale technique — BAC Professionnel',
                'color' => 'emerald',
            ],
        ] as $item)
            <a href="{{ route('secondary.technique', ['level' => $item['level']]) }}"
               class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-{{ $item['color'] }}-300 transition-all p-6 flex flex-col gap-4">
                <div class="w-12 h-12 rounded-xl bg-{{ $item['color'] }}-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-{{ $item['color'] }}-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="font-heading font-bold text-base text-ink mb-1 group-hover:text-{{ $item['color'] }}-800 transition-colors">
                        {{ $item['label'] }}
                    </h2>
                    <p class="text-sm text-ink-muted leading-relaxed">{{ $item['desc'] }}</p>
                </div>
                <div class="flex items-center gap-1 text-sm font-medium text-{{ $item['color'] }}-700 opacity-0 group-hover:opacity-100 transition-opacity">
                    Accéder
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        @endforeach

    </div>
</section>

@endsection
