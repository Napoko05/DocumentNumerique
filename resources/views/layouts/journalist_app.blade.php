<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', "YAA'Scientia") }} — Journaliste</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('head')
</head>

<body class="font-sans antialiased bg-surface-muted text-ink" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        {{-- Overlay mobile --}}
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-20 bg-black/50 lg:hidden"
             style="display:none;">
        </div>

        {{-- ============================================================
             SIDEBAR
        ============================================================ --}}
        <aside class="fixed inset-y-0 left-0 z-30 w-64 flex-shrink-0 flex flex-col
                       bg-sidebar transition-transform duration-300 ease-in-out
                       lg:relative lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-5 h-16 border-b border-white/10 shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                     class="h-8 w-8 rounded-lg object-contain bg-white/10 p-0.5">
                <div>
                    <p class="font-heading font-bold text-white text-sm leading-tight">YAA'Scientia</p>
                    <p class="text-xs text-sidebar-text">Espace journaliste</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-0.5">

                <a href="{{ route('journaliste.dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('journaliste.dashboard') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Tableau de bord
                </a>

                <div class="pt-4 pb-1 px-3">
                    <p class="text-xs font-semibold text-white/30 uppercase tracking-wider">Contenu</p>
                </div>

                <a href="{{ route('journaliste.documents.create') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                          {{ request()->routeIs('journaliste.documents.create') ? 'bg-sidebar-active text-sidebar-text-active' : 'text-sidebar-text hover:bg-sidebar-hover hover:text-white' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Publier un document
                </a>

                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/25 cursor-not-allowed select-none">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Mes documents</span>
                    <span class="ml-auto text-xs px-1.5 py-0.5 rounded bg-white/10 text-white/40">Bientôt</span>
                </div>

                <div class="pt-4 pb-1 px-3">
                    <p class="text-xs font-semibold text-white/30 uppercase tracking-wider">Abonnés</p>
                </div>

                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-white/25 cursor-not-allowed select-none">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <span>Utilisateurs premium</span>
                    <span class="ml-auto text-xs px-1.5 py-0.5 rounded bg-white/10 text-white/40">Bientôt</span>
                </div>

            </nav>

            {{-- Profil + déconnexion --}}
            <div class="px-3 py-4 border-t border-white/10 shrink-0">
                <div class="flex items-center gap-3 px-3 py-2 mb-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-700 flex items-center justify-center shrink-0">
                        <span class="text-xs font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->prenom ?? auth()->user()->name ?? 'J', 0, 1)) }}{{ strtoupper(substr(auth()->user()->nom ?? '', 0, 1)) }}
                        </span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-white truncate">
                            {{ auth()->user()->prenom ?? auth()->user()->name ?? 'Journaliste' }}
                            {{ auth()->user()->nom ?? '' }}
                        </p>
                        <p class="text-xs text-sidebar-text truncate">Journaliste</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Se déconnecter
                    </button>
                </form>
            </div>

        </aside>

        {{-- ============================================================
             ZONE PRINCIPALE
        ============================================================ --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Topbar --}}
            <header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white border-b border-slate-200 shrink-0">
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-2 rounded-lg text-ink-soft hover:bg-surface-muted transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <h1 class="font-heading font-bold text-base text-ink">@yield('page-title', 'Tableau de bord')</h1>

                <a href="{{ url('/') }}" target="_blank"
                   class="flex items-center gap-1.5 text-xs font-medium text-ink-muted hover:text-ink transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Voir le site
                </a>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                @yield('content')
            </main>

        </div>
    </div>

    @yield('scripts')
    @stack('scripts')

</body>
</html>
