@extends('layouts.admin_app')

@section('page-title', 'Tableau de bord')

@section('content')

{{-- ================================================================
     STAT CARDS — LIGNE 1
================================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    {{-- Utilisateurs --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Utilisateurs</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalUsers }}</p>
        </div>
    </div>

    {{-- Journalistes --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Journalistes</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalJournalists }}</p>
        </div>
    </div>

    {{-- Documents --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-violet-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-violet-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Documents</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalDocuments }}</p>
        </div>
    </div>

    {{-- Vues --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-accent-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-accent-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </div>
        <div>
            <p class="text-xs font-semibold text-ink-muted uppercase tracking-wider">Vues totales</p>
            <p class="font-heading font-bold text-2xl text-ink mt-0.5">{{ $totalViews }}</p>
        </div>
    </div>

</div>

{{-- ================================================================
     LIGNE 2 — ACTIONS RAPIDES + DOCUMENTS + PAIEMENTS
================================================================ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

    {{-- Actions rapides --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h2 class="font-heading font-bold text-sm text-ink mb-4">Actions rapides</h2>
        <div class="flex flex-col gap-2">

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 hover:border-brand-300 hover:bg-brand-50 transition-colors group">
                <svg class="w-4 h-4 text-brand-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-ink group-hover:text-brand-800">Gérer les utilisateurs</p>
                    <p class="text-xs text-ink-muted">Créer, modifier, bloquer</p>
                </div>
                <svg class="w-4 h-4 text-ink-faint group-hover:text-brand-600 shrink-0"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.staff.create') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 hover:border-emerald-300 hover:bg-emerald-50 transition-colors group">
                <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-ink group-hover:text-emerald-800">Créer un journaliste</p>
                    <p class="text-xs text-ink-muted">Ajouter un membre du staff</p>
                </div>
                <svg class="w-4 h-4 text-ink-faint group-hover:text-emerald-600 shrink-0"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-200 hover:border-violet-300 hover:bg-violet-50 transition-colors group">
                <svg class="w-4 h-4 text-violet-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-ink group-hover:text-violet-800">Gérer les documents</p>
                    <p class="text-xs text-ink-muted">Produits et publications</p>
                </div>
                <svg class="w-4 h-4 text-ink-faint group-hover:text-violet-600 shrink-0"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

        </div>
    </div>

    {{-- Documents stats --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h2 class="font-heading font-bold text-sm text-ink mb-4">Documents</h2>
        <div class="flex flex-col gap-3">
            @foreach([
                ['Publiés',    $publishedDocs, 'bg-emerald-100', 'text-emerald-700'],
                ['En attente', $pendingDocs,   'bg-accent-100',  'text-accent-700'],
                ['Premium',    $premiumDocs,   'bg-violet-100',  'text-violet-700'],
            ] as [$label, $value, $bg, $color])
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-surface-muted">
                    <span class="text-sm font-medium text-ink-soft">{{ $label }}</span>
                    <span class="px-2.5 py-1 rounded-lg {{ $bg }} {{ $color }} text-sm font-bold">{{ $value }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Paiements stats --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h2 class="font-heading font-bold text-sm text-ink mb-1">Paiements</h2>
        <p class="text-xs text-ink-muted mb-4">
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-xs">
                Bientôt disponible
            </span>
        </p>
        <div class="flex flex-col gap-3">
            @foreach([
                ['Revenus total',  number_format($totalRevenue, 0, ',', ' ') . ' FCFA'],
                ['Transactions',   $totalTransactions],
                ["Aujourd'hui",    $todaySales],
            ] as [$label, $value])
                <div class="flex items-center justify-between px-4 py-3 rounded-xl bg-surface-muted">
                    <span class="text-sm font-medium text-ink-soft">{{ $label }}</span>
                    <span class="text-sm font-bold text-ink-muted">{{ $value }}</span>
                </div>
            @endforeach
        </div>
    </div>

</div>

{{-- ================================================================
     LIGNE 3 — SYSTÈME
================================================================ --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

    <a href="{{ route('admin.roles.index') }}"
       class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:border-brand-300 hover:shadow-md transition-all group flex items-center gap-4">
        <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-sm text-ink group-hover:text-brand-800">Rôles &amp; Permissions</p>
            <p class="text-xs text-ink-muted mt-0.5">Gérer les accès et les droits</p>
        </div>
        <svg class="w-4 h-4 text-ink-faint group-hover:text-brand-600 ml-auto shrink-0"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </a>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center gap-4 opacity-60 cursor-not-allowed">
        <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-sm text-ink-soft">Paramètres système</p>
            <p class="text-xs text-ink-muted mt-0.5">Configuration générale de la plateforme</p>
        </div>
        <span class="ml-auto text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-400 shrink-0">Bientôt</span>
    </div>

</div>

@endsection
