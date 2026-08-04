<aside class="fixed inset-y-0 left-0 z-30 w-64 flex-shrink-0 flex flex-col
               bg-sidebar transition-transform duration-300 ease-in-out
               lg:relative lg:translate-x-0"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

    {{-- Logo --}}
    <div class="flex items-center gap-3 px-5 h-16 border-b border-white/10 shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="Logo"
            class="h-8 w-8 rounded-lg object-contain bg-white/10 p-0.5">

        <div>
            <p class="font-heading font-bold text-white text-sm leading-tight">
                YAA'Scientia
            </p>
            <p class="text-xs text-sidebar-text">
                Administration
            </p>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
           {{ request()->routeIs('admin.dashboard') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>

            Tableau de bord
        </a>

        {{-- Séparateur --}}
        <div class="pt-4 pb-1 px-3">
            <p class="text-xs font-semibold text-white/30 uppercase tracking-wider">
                Gestion
            </p>
        </div>

        {{-- Utilisateurs avec sous-menu --}}
        <div x-data="{ openUsers: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }">

            {{-- Bouton principal --}}
            <button @click="openUsers = !openUsers"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                    {{ request()->routeIs('admin.users.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                {{-- Icon --}}
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>

                {{-- Texte --}}
                <span class="flex-1 text-left">
                    Utilisateurs
                </span>

                {{-- Flèche --}}
                <svg class="w-4 h-4 transition-transform duration-300"
                    :class="openUsers ? 'rotate-90' : ''"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Sous-menu --}}
            <div x-show="openUsers"
                x-transition
                class="mt-1 ml-6 space-y-1">

                {{-- Liste utilisateurs --}}
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
                   {{ request()->routeIs('admin.users.index') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>👤</span>
                    Liste utilisateurs
                </a>

                {{-- Créer utilisateur --}}
                <a href="{{ route('admin.users.create') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
                   {{ request()->routeIs('admin.users.create') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>➕</span>
                    Créer utilisateur
                </a>

                {{-- Utilisateurs bloqués --}}
                <a href="#"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
                   text-sidebar-text hover:bg-sidebar-hover hover:text-white">

                    <span>🚫</span>
                    Utilisateurs bloqués
                </a>

            </div>
        </div>

        {{-- Staff / Journalistes --}}
        {{-- Journalistes avec sous-menu --}}
        <div x-data="{ openJournalistes: {{ request()->routeIs('admin.staff.*') ? 'true' : 'false' }} }">

            {{-- Bouton principal --}}
            <button @click="openJournalistes = !openJournalistes"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
            {{ request()->routeIs('admin.staff.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>

                <span class="flex-1 text-left">
                    Journalistes
                </span>

                <svg class="w-4 h-4 transition-transform duration-300"
                    :class="openJournalistes ? 'rotate-90' : ''"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7" />
                </svg>
            </button>

            {{-- Sous-menu --}}
            <div x-show="openJournalistes"
                x-transition
                class="mt-1 ml-6 space-y-1">

                {{-- Liste journalistes --}}
                <a href="{{route('admin.staff.index')}}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
           {{ request()->routeIs('admin.staff.index') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>📋</span>
                    Liste journalistes
                </a>

                {{-- Créer journaliste --}}
                <a href="{{ route('admin.staff.create') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
           {{ request()->routeIs('admin.staff.create') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>➕</span>
                    Créer journaliste
                </a>

            </div>

        </div>

        {{-- Enseignement secondaire --}}
        <div x-data="{ openSecondaire: false }" class="space-y-1">

            {{-- Bouton principal --}}
            <button @click="openSecondaire = !openSecondaire"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
        {{ request()->routeIs('admin.secondaire.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                <svg class="w-4 h-4 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422A12.083 12.083 0 0118 20.5c-1.657.944-3.666 1.5-6 1.5s-4.343-.556-6-1.5a12.083 12.083 0 01-.16-9.922L12 14z" />

                </svg>

                <span class="flex-1 text-left">
                    Enseignement secondaire
                </span>


                <svg class="w-4 h-4 transition-transform duration-300"
                    :class="openSecondaire ? 'rotate-90' : ''"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7" />

                </svg>
            </button>

            {{-- Sous-menu --}}
            <div x-show="openSecondaire"
                x-transition
                class="mt-1 ml-6 space-y-1">
                {{-- Classes --}}
                <a href="{{ route('admin.secondaire.classes.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.secondaire.classes.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>🏫</span>

                    Gestion des classes

                </a>
                {{-- Ajouter classe --}}
                <a href="{{ route('admin.secondaire.classes.create') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.secondaire.classes.create') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>➕</span>

                    Ajouter une classe

                </a>
                {{-- Matières --}}
                <a href="{{ route('admin.secondaire.matieres.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.secondaire.subjects.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>📚</span>

                    Gestion des matières

                </a>
                {{-- Ajouter matière --}}
                <a href="{{ route('admin.secondaire.matieres.create') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.secondaire.subjects.create') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>➕</span>

                    Ajouter une matière
                </a>
            </div>
        </div>

        {{-- Enseignement superieur --}}
        <div x-data="{ openSecondaire: false }" class="space-y-1">

            {{-- Bouton principal --}}
            <button @click="openSecondaire = !openSecondaire"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
        {{ request()->routeIs('admin.secondaire.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                <svg class="w-4 h-4 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422A12.083 12.083 0 0118 20.5c-1.657.944-3.666 1.5-6 1.5s-4.343-.556-6-1.5a12.083 12.083 0 01-.16-9.922L12 14z" />

                </svg>

                <span class="flex-1 text-left">
                    Enseignement Superieur
                </span>


                <svg class="w-4 h-4 transition-transform duration-300"
                    :class="openSecondaire ? 'rotate-90' : ''"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7" />

                </svg>
            </button>

            {{-- Sous-menu --}}
            <div x-show="openSecondaire"
                x-transition
                class="mt-1 ml-6 space-y-1">
                {{-- Classes --}}
                <a href="{{ route('admin.superieur.filieres.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.secondaire.classes.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>🏫</span>

                    Gestion des filieres

                </a>
                {{-- Ajouter classe --}}
                <a href="{{ route('admin.superieur.filieres.create') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.superieur.filieres.create') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>➕</span>

                    Ajouter une filiere

                </a>
                {{-- Matières --}}
                <a href="#"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.secondaire.subjects.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>📚</span>

                    Gestion des modules

                </a>
                {{-- Ajouter matière --}}
                <a href="{{ route('admin.superieur.modules.index') }}"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
            {{ request()->routeIs('admin.superieur.modules.index') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

                    <span>➕</span>

                    Ajouter un module
                </a>
            </div>
        </div>
        {{-- Produits (Documents) --}}
        <a href="{{ route('admin.products.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
           {{ request()->routeIs('admin.products.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>

            Documents
        </a>

        {{-- Paiements --}}
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/25 cursor-not-allowed select-none">

            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
            </svg>

            <span>Paiements</span>

            <span class="ml-auto text-xs px-1.5 py-0.5 rounded bg-white/10 text-white/40">
                Bientôt
            </span>
        </div>

        {{-- Séparateur --}}
        <div class="pt-4 pb-1 px-3">
            <p class="text-xs font-semibold text-white/30 uppercase tracking-wider">
                Système
            </p>
        </div>

        {{-- Rôles --}}
        <a href="{{ route('admin.roles.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
           {{ request()->routeIs('admin.roles.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>

            Rôles
        </a>

        {{-- Permissions --}}
        <a href="{{ route('admin.permissions.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
           {{ request()->routeIs('admin.permissions.*') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">

            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>

            Permissions
        </a>

        {{-- Paramètres --}}
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/25 cursor-not-allowed select-none">

            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94-1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <span>Paramètres</span>

            <span class="ml-auto text-xs px-1.5 py-0.5 rounded bg-white/10 text-white/40">
                Bientôt
            </span>
        </div>

    </nav>

    {{-- Profil + déconnexion --}}
    <div class="px-3 py-4 border-t border-white/10 shrink-0">

        <div class="flex items-center gap-3 px-3 py-2 mb-2">

            <div class="w-8 h-8 rounded-full bg-brand-700 flex items-center justify-center shrink-0">
                <span class="text-xs font-bold text-white">
                    {{ strtoupper(substr(Auth::guard('staff')->user()->prenom ?? 'A', 0, 1)) }}{{ strtoupper(substr(Auth::guard('staff')->user()->nom ?? 'D', 0, 1)) }}
                </span>
            </div>

            <div class="min-w-0">
                <p class="text-sm font-medium text-white truncate">
                    {{ Auth::guard('staff')->user()->prenom ?? '' }}
                    {{ Auth::guard('staff')->user()->nom ?? '' }}
                </p>

                <p class="text-xs text-sidebar-text truncate">
                    Administrateur
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">

                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>

                Se déconnecter
            </button>
        </form>
    </div>

</aside>