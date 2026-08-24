@extends('layouts.admin_app')

@section('page-title', 'Tableau de bord')

@section('content')

<div class="admin-dashboard">

    {{-- =========================================================
         STATISTIQUES PRINCIPALES
    ========================================================== --}}

    <div class="dashboard-stat-grid">

        {{-- UTILISATEURS --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon dashboard-icon-blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857
                        M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                        M7 20H2v-2a3 3 0 015.356-1.857
                        M7 20v-2c0-.656.126-1.283.356-1.857
                        m0 0a5.002 5.002 0 019.288 0
                        M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>

            <div class="dashboard-stat-content">
                <span>Utilisateurs</span>
                <strong>{{ $totalUsers }}</strong>
            </div>

        </div>


        {{-- JOURNALISTES --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon dashboard-icon-green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5
                        m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>

            <div class="dashboard-stat-content">
                <span>Journalistes</span>
                <strong>{{ $totalJournalists }}</strong>
            </div>

        </div>


        {{-- DOCUMENTS --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon dashboard-icon-purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                        a1 1 0 01.707.293l5.414 5.414
                        a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>

            <div class="dashboard-stat-content">
                <span>Documents</span>
                <strong>{{ $totalDocuments }}</strong>
            </div>

        </div>


        {{-- VUES --}}
        <div class="dashboard-stat-card">

            <div class="dashboard-stat-icon dashboard-icon-orange">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0
                        M2.458 12C3.732 7.943 7.523 5 12 5
                        c4.478 0 8.268 2.943 9.542 7
                        -1.274 4.057-5.064 7-9.542 7
                        -4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>

            <div class="dashboard-stat-content">
                <span>Vues totales</span>
                <strong>{{ number_format($totalViews ?? 0, 0, ',', ' ') }}</strong>
            </div>

        </div>

    </div>


    {{-- =========================================================
         ACTIONS / DOCUMENTS / PAIEMENTS
    ========================================================== --}}

    <div class="dashboard-main-grid">


        {{-- ACTIONS RAPIDES --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">
                <h2>Actions rapides</h2>
            </div>

            <div class="quick-actions">

                <a href="{{ route('admin.users.index') }}"
                   class="quick-action">

                    <div class="quick-action-icon blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292
                                M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1
                                a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0
                                4 4 0 018 0z"/>
                        </svg>
                    </div>

                    <div class="quick-action-content">
                        <strong>Gérer les utilisateurs</strong>
                        <span>Créer, modifier, bloquer</span>
                    </div>

                    <span class="quick-arrow">›</span>

                </a>


                <a href="{{ route('admin.staff.create') }}"
                   class="quick-action">

                    <div class="quick-action-icon green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3
                                m-2-5a4 4 0 11-8 0 4 4 0 018 0z
                                M3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>

                    <div class="quick-action-content">
                        <strong>Créer un journaliste</strong>
                        <span>Ajouter un membre du staff</span>
                    </div>

                    <span class="quick-arrow">›</span>

                </a>


                <a href="{{ route('admin.products.index') }}"
                   class="quick-action">

                    <div class="quick-action-icon purple">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5
                                a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414
                                a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>

                    <div class="quick-action-content">
                        <strong>Gérer les documents</strong>
                        <span>Produits et publications</span>
                    </div>

                    <span class="quick-arrow">›</span>

                </a>

            </div>

        </div>


        {{-- DOCUMENTS --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header">
                <h2>Documents</h2>
            </div>

            <div class="dashboard-list">

                <div class="dashboard-list-item">
                    <span>Publiés</span>
                    <strong class="badge badge-green">
                        {{ $publishedDocs }}
                    </strong>
                </div>

                <div class="dashboard-list-item">
                    <span>En attente</span>
                    <strong class="badge badge-orange">
                        {{ $pendingDocs }}
                    </strong>
                </div>

                <div class="dashboard-list-item">
                    <span>Premium</span>
                    <strong class="badge badge-purple">
                        {{ $premiumDocs }}
                    </strong>
                </div>

            </div>

        </div>


        {{-- PAIEMENTS --}}
        <div class="dashboard-panel">

            <div class="dashboard-panel-header payment-header">

                <div>
                    <h2>Paiements</h2>

                    <span class="coming-soon">
                        Bientôt disponible
                    </span>
                </div>

            </div>

            <div class="dashboard-list">

                <div class="dashboard-list-item">
                    <span>Revenus total</span>
                    <strong>
                        {{ number_format($totalRevenue ?? 0, 0, ',', ' ') }}
                        FCFA
                    </strong>
                </div>

                <div class="dashboard-list-item">
                    <span>Transactions</span>
                    <strong>
                        {{ $totalTransactions ?? 0 }}
                    </strong>
                </div>

                <div class="dashboard-list-item">
                    <span>Aujourd'hui</span>
                    <strong>
                        {{ $todaySales ?? 0 }}
                    </strong>
                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         SYSTÈME
    ========================================================== --}}

    <div class="dashboard-system-grid">

        {{-- ROLES --}}
        <a href="{{ route('admin.roles.index') }}"
           class="system-card">

            <div class="system-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4
                        m5.618-4.016A11.955 11.955 0 0112 2.944
                        a11.955 11.955 0 01-8.618 3.04
                        A12.02 12.02 0 003 9
                        c0 5.591 3.824 10.29 9 11.622
                        5.176-1.332 9-6.03 9-11.622
                        0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>

            <div>
                <strong>Rôles & Permissions</strong>
                <span>Gérer les accès et les droits</span>
            </div>

            <span class="system-arrow">›</span>

        </a>


        {{-- PARAMÈTRES --}}
        <div class="system-card disabled">

            <div class="system-icon gray">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756
                        3.35 0a1.724 1.724 0 002.573 1.066
                        c1.543-.94 3.31.826 2.37 2.37
                        a1.724 1.724 0 001.065 2.572
                        c1.756.426 1.756 2.924 0 3.35
                        a1.724 1.724 0 00-1.066 2.573
                        c.94 1.543-.826 3.31-2.37 2.37
                        a1.724 1.724 0 00-2.572 1.065
                        c-.426 1.756-2.924 1.756-3.35 0
                        a1.724 1.724 0 00-2.573-1.066
                        c-1.543.94-3.31-.826-2.37-2.37
                        a1.724 1.724 0 00-1.065-2.572
                        c-1.756-.426-1.756-2.924 0-3.35
                        a1.724 1.724 0 001.066-2.573
                        c-.94-1.543.826-3.31 2.37-2.37
                        .996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>

            <div>
                <strong>Paramètres système</strong>
                <span>Configuration générale de la plateforme</span>
            </div>

            <span class="coming-soon ml-auto">
                Bientôt
            </span>

        </div>

    </div>

</div>

@endsection