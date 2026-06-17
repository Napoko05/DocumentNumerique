<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', "YAA'Scientia") }} — Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    @vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/css/admin/style_list_user.css',
    'resources/css/admin/style_agent.css',
    ])
    @yield('head')
</head>

<body class="font-sans antialiased bg-surface-muted text-ink" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        {{-- ============================================================
             OVERLAY MOBILE
        ============================================================ --}}
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

        {{-- SIDEBAR --}}
        @include('partials.sidebar_admin')
        {{-- ============================================================
             ZONE PRINCIPALE
        ============================================================ --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Topbar --}}
            <header class="flex items-center justify-between h-16 px-4 sm:px-6 bg-white border-b border-slate-200 shrink-0">
                {{-- Burger mobile --}}
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden p-2 rounded-lg text-ink-soft hover:bg-surface-muted transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Titre page --}}
                <h1 class="font-heading font-bold text-base text-ink">@yield('page-title', 'Tableau de bord')</h1>

                {{-- Lien vers le site public --}}
                <a href="{{ url('/') }}" target="_blank"
                    class="flex items-center gap-1.5 text-xs font-medium text-ink-muted hover:text-ink transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Voir le site
                </a>
            </header>

            {{-- Contenu --}}
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                @yield('content')
            </main>

        </div>
    </div>

    @yield('scripts')
    @stack('scripts')

</body>

</html>