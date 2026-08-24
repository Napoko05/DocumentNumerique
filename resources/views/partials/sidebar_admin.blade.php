<aside class="admin-sidebar"
    x-data
    :class="{ 'admin-sidebar-open': sidebarOpen }">

    {{-- =========================================================
        LOGO
    ========================================================== --}}
    <div class="admin-sidebar-header">

        <div class="admin-sidebar-brand">

            <img
                src="{{ asset('images/logo.png') }}"
                alt="YAA'Scientia"
                class="admin-sidebar-logo"
            >

            <div class="admin-sidebar-brand-text">
                <p>YAA'Scientia</p>
                <span>Administration</span>
            </div>

        </div>

    </div>


    {{-- =========================================================
        NAVIGATION
    ========================================================== --}}
    <nav class="admin-sidebar-nav">

        {{-- =======================
            TABLEAU DE BORD
        ======================== --}}
        <a href="{{ route('admin.dashboard') }}"
           class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

            <svg class="admin-nav-icon"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>

            </svg>

            <span>Tableau de bord</span>

        </a>


        {{-- =====================================================
            SECTION GESTION
        ====================================================== --}}
        <div class="admin-sidebar-section-title">
            Gestion
        </div>


        {{-- =====================================================
            UTILISATEURS
        ====================================================== --}}
        <div
            class="admin-sidebar-group"
            x-data="{ openUsers: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }"
        >

            <button
                type="button"
                @click="openUsers = !openUsers"
                class="admin-nav-link admin-nav-button
                {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
            >

                <svg class="admin-nav-icon"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>

                </svg>

                <span class="admin-nav-text">
                    Utilisateurs
                </span>

                <svg
                    class="admin-nav-arrow"
                    :class="{ 'rotate': openUsers }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5l7 7-7 7"/>

                </svg>

            </button>


            <div
                x-show="openUsers"
                x-transition
                class="admin-submenu"
            >

                <a
                    href="{{ route('admin.users.index') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.users.index') ? 'active' : '' }}"
                >
                    <span>👤</span>
                    <span>Liste utilisateurs</span>
                </a>


                <a
                    href="{{ route('admin.users.create') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.users.create') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    <span>Créer utilisateur</span>
                </a>


                <a
                    href="#"
                    class="admin-submenu-link"
                >
                    <span>🚫</span>
                    <span>Utilisateurs bloqués</span>
                </a>

            </div>

        </div>


        {{-- =====================================================
            JOURNALISTES
        ====================================================== --}}
        <div
            class="admin-sidebar-group"
            x-data="{ openJournalistes: {{ request()->routeIs('admin.staff.*') ? 'true' : 'false' }} }"
        >

            <button
                type="button"
                @click="openJournalistes = !openJournalistes"
                class="admin-nav-link admin-nav-button
                {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}"
            >

                <svg class="admin-nav-icon"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>

                </svg>

                <span class="admin-nav-text">
                    Journalistes
                </span>

                <svg
                    class="admin-nav-arrow"
                    :class="{ 'rotate': openJournalistes }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5l7 7-7 7"/>

                </svg>

            </button>


            <div
                x-show="openJournalistes"
                x-transition
                class="admin-submenu"
            >

                <a
                    href="{{ route('admin.staff.index') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.staff.index') ? 'active' : '' }}"
                >
                    <span>📋</span>
                    <span>Liste journalistes</span>
                </a>


                <a
                    href="{{ route('admin.staff.create') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.staff.create') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    <span>Créer journaliste</span>
                </a>

            </div>

        </div>


        {{-- =====================================================
            ENSEIGNEMENT SECONDAIRE
        ====================================================== --}}
        <div
            class="admin-sidebar-group"
            x-data="{ openSecondaire: {{ request()->routeIs('admin.secondaire.*') ? 'true' : 'false' }} }"
        >

            <button
                type="button"
                @click="openSecondaire = !openSecondaire"
                class="admin-nav-link admin-nav-button
                {{ request()->routeIs('admin.secondaire.*') ? 'active' : '' }}"
            >

                <svg class="admin-nav-icon"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422A12.083 12.083 0 0118 20.5c-1.657.944-3.666 1.5-6 1.5s-4.343-.556-6-1.5a12.083 12.083 0 01-.16-9.922L12 14z"/>

                </svg>

                <span class="admin-nav-text">
                    Enseignement secondaire
                </span>

                <svg
                    class="admin-nav-arrow"
                    :class="{ 'rotate': openSecondaire }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5l7 7-7 7"/>

                </svg>

            </button>


            <div
                x-show="openSecondaire"
                x-transition
                class="admin-submenu"
            >

                <a
                    href="{{ route('admin.secondaire.classes.index') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.secondaire.classes.*') ? 'active' : '' }}"
                >
                    <span>🏫</span>
                    <span>Gestion des classes</span>
                </a>


                <a
                    href="{{ route('admin.secondaire.classes.create') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.secondaire.classes.create') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    <span>Ajouter une classe</span>
                </a>


                <a
                    href="{{ route('admin.secondaire.matieres.index') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.secondaire.matieres.*') ? 'active' : '' }}"
                >
                    <span>📚</span>
                    <span>Gestion des matières</span>
                </a>


                <a
                    href="{{ route('admin.secondaire.matieres.create') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.secondaire.matieres.create') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    <span>Ajouter une matière</span>
                </a>

            </div>

        </div>


        {{-- =====================================================
            ENSEIGNEMENT SUPÉRIEUR
        ====================================================== --}}
        <div
            class="admin-sidebar-group"
            x-data="{ openSuperieur: {{ request()->routeIs('admin.superieur.*') ? 'true' : 'false' }} }"
        >

            <button
                type="button"
                @click="openSuperieur = !openSuperieur"
                class="admin-nav-link admin-nav-button
                {{ request()->routeIs('admin.superieur.*') ? 'active' : '' }}"
            >

                <svg class="admin-nav-icon"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422A12.083 12.083 0 0118 20.5c-1.657.944-3.666 1.5-6 1.5s-4.343-.556-6-1.5a12.083 12.083 0 01-.16-9.922L12 14z"/>

                </svg>

                <span class="admin-nav-text">
                    Enseignement supérieur
                </span>

                <svg
                    class="admin-nav-arrow"
                    :class="{ 'rotate': openSuperieur }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5l7 7-7 7"/>

                </svg>

            </button>


            <div
                x-show="openSuperieur"
                x-transition
                class="admin-submenu"
            >

                <a
                    href="{{ route('admin.superieur.filieres.index') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.superieur.filieres.*') ? 'active' : '' }}"
                >
                    <span>🏫</span>
                    <span>Gestion des filières</span>
                </a>


                <a
                    href="{{ route('admin.superieur.filieres.create') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.superieur.filieres.create') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    <span>Ajouter une filière</span>
                </a>


                <a
                    href="{{ route('admin.superieur.modules.index') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.superieur.modules.*') ? 'active' : '' }}"
                >
                    <span>📚</span>
                    <span>Gestion des modules</span>
                </a>


                <a
                    href="{{ route('admin.superieur.modules.create') }}"
                    class="admin-submenu-link
                    {{ request()->routeIs('admin.superieur.modules.create') ? 'active' : '' }}"
                >
                    <span>➕</span>
                    <span>Ajouter un module</span>
                </a>

            </div>

        </div>


        {{-- =====================================================
            DOCUMENTS
        ====================================================== --}}
        <a
            href="{{ route('admin.products.index') }}"
            class="admin-nav-link
            {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
        >

            <svg class="admin-nav-icon"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

            </svg>

            <span>Documents</span>

        </a>


        {{-- =====================================================
            PAIEMENTS
        ====================================================== --}}
        <div class="admin-nav-disabled">

            <svg class="admin-nav-icon"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>

            </svg>

            <span>Paiements</span>

            <span class="admin-coming-soon">
                Bientôt
            </span>

        </div>


        {{-- =====================================================
            SYSTÈME
        ====================================================== --}}
        <div class="admin-sidebar-section-title">
            Système
        </div>


        {{-- ROLES --}}
        <a
            href="{{ route('admin.roles.index') }}"
            class="admin-nav-link
            {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
        >

            <svg class="admin-nav-icon"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>

            </svg>

            <span>Rôles</span>

        </a>


        {{-- PERMISSIONS --}}
        <a
            href="{{ route('admin.permissions.index') }}"
            class="admin-nav-link
            {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}"
        >

            <svg class="admin-nav-icon"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>

            </svg>

            <span>Permissions</span>

        </a>


        {{-- PARAMÈTRES --}}
        <div class="admin-nav-disabled">

            <svg class="admin-nav-icon"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 000 3.35 1.724 1.724 0 001.066 2.573c.94-1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31-2.37-2.37-.996.608-2.296.07-2.572-1.065z"/>

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

            </svg>

            <span>Paramètres</span>

            <span class="admin-coming-soon">
                Bientôt
            </span>

        </div>

    </nav>


    {{-- =========================================================
        PROFIL / LOGOUT
    ========================================================== --}}
    <div class="admin-sidebar-footer">

        <div class="admin-sidebar-user">

            <div class="admin-user-avatar">

                {{ strtoupper(substr(Auth::guard('staff')->user()->prenom ?? 'A', 0, 1)) }}{{ strtoupper(substr(Auth::guard('staff')->user()->nom ?? 'D', 0, 1)) }}

            </div>


            <div class="admin-user-info">

                <p>
                    {{ Auth::guard('staff')->user()->prenom ?? '' }}
                    {{ Auth::guard('staff')->user()->nom ?? '' }}
                </p>

                <span>
                    Administrateur
                </span>

            </div>

        </div>


        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="admin-logout-button"
            >

                <svg
                    class="admin-nav-icon"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>

                </svg>

                <span>
                    Se déconnecter
                </span>

            </button>

        </form>

    </div>

</aside>