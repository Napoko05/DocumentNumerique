@php
    $staff = auth('staff')->user();

    $prenom = $staff->prenom ?? $staff->name ?? 'Journaliste';
    $nom = $staff->nom ?? '';

    $initiales = strtoupper(
        substr($prenom, 0, 1) .
        substr($nom, 0, 1)
    );
@endphp


{{-- =========================================================
     SIDEBAR JOURNALISTE
========================================================= --}}

<aside
    id="journalistSidebar"
    class="journalist-sidebar"
    aria-label="Navigation journaliste"
>


    {{-- =====================================================
         EN-TÊTE / LOGO
    ====================================================== --}}

    <div class="sidebar-brand">


        {{-- LOGO --}}

        <a
            href="{{ route('journaliste.dashboard') }}"
            class="sidebar-brand-link"
        >

            <img
                src="{{ asset('images/logo.png') }}"
                alt="YAA'Scientia"
                class="sidebar-logo"
            >


            <div class="sidebar-brand-text">

                <div class="sidebar-brand-title">
                    YAA'Scientia
                </div>

                <div class="sidebar-brand-subtitle">
                    Espace journaliste
                </div>

            </div>

        </a>


        {{-- BOUTON FERMER MOBILE --}}

        <button
            type="button"
            id="sidebarClose"
            class="sidebar-mobile-close d-lg-none"
            aria-label="Fermer le menu"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>



    {{-- =====================================================
         NAVIGATION
    ====================================================== --}}

    <nav class="sidebar-navigation">


        {{-- =================================================
             TABLEAU DE BORD
        ================================================== --}}

        <a
            href="{{ route('journaliste.dashboard') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.dashboard') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-grid-1x2-fill"></i>
            </span>

            <span class="sidebar-link-text">
                Tableau de bord
            </span>

        </a>



        {{-- =================================================
             CONTENU
        ================================================== --}}

        <div class="sidebar-section-title">
            Contenu
        </div>


        {{-- Publier --}}

        <a
            href="{{ route('journaliste.documents.create') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.documents.create') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-file-earmark-plus"></i>
            </span>

            <span class="sidebar-link-text">
                Publier un document
            </span>

        </a>


        {{-- Mes documents --}}

        <a
            href="{{ route('journaliste.documents.index') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.documents.index') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-files"></i>
            </span>

            <span class="sidebar-link-text">
                Mes documents
            </span>

        </a>


        {{-- Brouillons --}}

        <a
            href="{{ route('journaliste.documents.drafts') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.documents.drafts') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-file-earmark-text"></i>
            </span>

            <span class="sidebar-link-text">
                Brouillons
            </span>

        </a>


        {{-- Documents publiés --}}

        <a
            href="{{ route('journaliste.documents.published') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.documents.published') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-check2-circle"></i>
            </span>

            <span class="sidebar-link-text">
                Documents publiés
            </span>

        </a>



        {{-- =================================================
             ANALYSE
        ================================================== --}}

        <div class="sidebar-section-title">
            Analyse
        </div>


        {{-- Statistiques --}}

        <a
            href="{{ route('journaliste.statistiques') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.statistiques') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-bar-chart-line"></i>
            </span>

            <span class="sidebar-link-text">
                Statistiques
            </span>

        </a>


        {{-- Revenus --}}

        <a
            href="{{ route('journaliste.revenus') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.revenus') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-cash-coin"></i>
            </span>

            <span class="sidebar-link-text">
                Revenus
            </span>

        </a>


        {{-- Paiements --}}

        <a
            href="{{ route('journaliste.paiements') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.paiements') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-credit-card"></i>
            </span>

            <span class="sidebar-link-text">
                Paiements
            </span>

        </a>



        {{-- =================================================
             OUTILS
        ================================================== --}}

        <div class="sidebar-section-title">
            Outils
        </div>


        {{-- Profil --}}

        <a
            href="{{ route('journaliste.profil') }}"
            class="sidebar-link
                {{ request()->routeIs('journaliste.profil') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                <i class="bi bi-person-circle"></i>
            </span>

            <span class="sidebar-link-text">
                Mon profil
            </span>

        </a>


        {{-- Voir le site --}}

        <a
            href="{{ route('home') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="sidebar-link"
        >

            <span class="sidebar-icon">
                <i class="bi bi-box-arrow-up-right"></i>
            </span>

            <span class="sidebar-link-text">
                Voir le site
            </span>

        </a>

    </nav>



    {{-- =====================================================
         BAS DU SIDEBAR
    ====================================================== --}}

    <div class="sidebar-footer">


        {{-- =================================================
             UTILISATEUR CONNECTÉ
        ================================================== --}}

        <a
            href="{{ route('journaliste.profil') }}"
            class="sidebar-user"
        >

            <div class="sidebar-avatar">
                {{ $initiales }}
            </div>


            <div class="sidebar-user-info">

                <div class="sidebar-user-name">

                    {{ $prenom }}

                    @if($nom)
                        {{ $nom }}
                    @endif

                </div>


                <div class="sidebar-user-role">
                    Journaliste
                </div>

            </div>


            <i class="bi bi-chevron-right sidebar-user-arrow"></i>

        </a>



        {{-- =================================================
             DÉCONNEXION
        ================================================== --}}

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="sidebar-logout-form"
        >

            @csrf

            <button
                type="submit"
                class="sidebar-logout"
            >

                <span class="sidebar-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </span>

                <span>
                    Se déconnecter
                </span>

            </button>

        </form>

    </div>

</aside>