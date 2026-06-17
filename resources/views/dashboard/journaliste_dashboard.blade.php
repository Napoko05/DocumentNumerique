@extends('layouts.journlist_app')

@section('page-title', 'Tableau de bord')

@section('content')

{{-- ================================================================
     STAT CARDS
================================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Total documents</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalDocuments }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Gratuits</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalFree }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-accent-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-accent-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Premium</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalPremium }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-violet-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Total vues</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalViews }}</p>
        </div>
    </div>

</div>

{{-- ================================================================
     TABLEAU DES DOCUMENTS
================================================================ --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <h2 class="font-heading font-bold text-base text-ink">Mes documents</h2>
        <a href="{{ route('journalist.documents.create') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-800 text-white text-xs font-semibold hover:bg-brand-700 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Publier
        </a>
    </div>

    @if($documents->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
            <div class="w-14 h-14 rounded-2xl bg-surface-muted flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-ink-faint" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="text-sm font-medium text-ink-muted">Aucun document publié pour l'instant</p>
            <a href="{{ route('journalist.documents.create') }}"
               class="mt-4 px-4 py-2 rounded-lg bg-brand-800 text-white text-sm font-semibold hover:bg-brand-700 transition-colors">
                Publier mon premier document
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-surface-muted border-b border-slate-100">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Titre</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Type</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Catégorie</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Niveau</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Cycle</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Accès</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-ink-muted uppercase tracking-wider">Vues</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($documents as $doc)
                        <tr class="hover:bg-surface-muted transition-colors">
                            <td class="px-6 py-4 font-medium text-ink">{{ $doc->title }}</td>
                            <td class="px-4 py-4 text-ink-soft">{{ ucfirst($doc->type) }}</td>
                            <td class="px-4 py-4 text-ink-soft">{{ ucfirst($doc->category) }}</td>
                            <td class="px-4 py-4 text-ink-soft">{{ $doc->level }}</td>
                            <td class="px-4 py-4 text-ink-soft">{{ $doc->cycle ?? '—' }}</td>
                            <td class="px-4 py-4">
                                @if($doc->premium)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-accent-100 text-accent-700">
                                        Premium
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">
                                        Gratuit
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-ink">{{ $doc->views }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

@endsection
