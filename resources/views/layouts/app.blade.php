<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', "YAA'Scientia") }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @yield('head')
</head>

<body class="font-sans antialiased bg-surface-soft text-ink" x-data>

    <!-- ============================================================
         HEADER STICKY
    ============================================================ -->
    <header class="sticky top-0 z-50 bg-white border-b border-slate-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-2 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="YAA'Scientia" class="h-9 w-9 rounded-lg object-contain">
                    <span class="font-heading font-bold text-lg text-ink">YAA'Scientia</span>
                </a>

                <!-- Nav desktop -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ url('/') }}"
                       class="px-3 py-2 text-sm font-medium rounded-lg transition-colors
                              {{ request()->is('/') ? 'bg-brand-50 text-brand-800' : 'text-ink-soft hover:text-ink hover:bg-surface-muted' }}">
                        Accueil
                    </a>

                    <!-- Dropdown livres -->
                    <div x-data="{ open: false }" class="relative"
                         @mouseenter="open = true" @mouseleave="open = false">
                        <button @click="open = !open"
                            class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-lg transition-colors
                                   {{ request()->is('secondary*') || request()->is('superior*') || request()->is('enseignement*') ? 'bg-brand-50 text-brand-800' : 'text-ink-soft hover:text-ink hover:bg-surface-muted' }}">
                            Livres numériques
                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute left-0 top-full mt-1 w-60 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50">
                            <a href="{{ route('secondary.index') }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink-soft hover:text-ink hover:bg-surface-muted transition-colors">
                                <svg class="w-4 h-4 text-brand-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Enseignement secondaire
                            </a>
                            <a href="{{ route('secondary.technique', ['level' => 'bt']) }}"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm text-ink-soft hover:text-ink hover:bg-surface-muted transition-colors">
                                <svg class="w-4 h-4 text-accent-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Enseignement professionnel
                            </a>
                        </div>
                    </div>

                    <a href="{{ url('/about') }}"
                       class="px-3 py-2 text-sm font-medium rounded-lg transition-colors
                              {{ request()->is('about') ? 'bg-brand-50 text-brand-800' : 'text-ink-soft hover:text-ink hover:bg-surface-muted' }}">
                        À propos
                    </a>
                </nav>

                <!-- Auth buttons desktop -->
                <div class="hidden md:flex items-center gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="px-3 py-2 text-sm font-medium text-ink-soft hover:text-ink hover:bg-surface-muted rounded-lg transition-colors">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                    class="px-3 py-2 text-sm font-medium text-ink-soft hover:text-ink hover:bg-surface-muted rounded-lg transition-colors">
                                Se déconnecter
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-3 py-2 text-sm font-medium text-ink-soft hover:text-ink transition-colors">
                            Se connecter
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 text-sm font-semibold text-white bg-brand-800 hover:bg-brand-700 rounded-lg transition-colors">
                            S'inscrire
                        </a>
                    @endauth
                </div>

                <!-- Burger mobile -->
                <div class="md:hidden" x-data="{ mobileOpen: false }">
                    <button @click="mobileOpen = !mobileOpen"
                            class="p-2 rounded-lg text-ink-soft hover:bg-surface-muted transition-colors">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Menu mobile déroulant -->
                    <div x-show="mobileOpen" x-transition
                         class="absolute top-16 left-0 right-0 bg-white border-b border-slate-100 shadow-md z-40 px-4 py-3 space-y-1">
                        <a href="{{ url('/') }}"
                           class="block px-3 py-2 rounded-lg text-sm font-medium text-ink-soft hover:bg-surface-muted">
                            Accueil
                        </a>
                        <a href="{{ route('secondary.index') }}"
                           class="block px-3 py-2 rounded-lg text-sm font-medium text-ink-soft hover:bg-surface-muted">
                            Enseignement secondaire
                        </a>
                        <a href="{{ route('secondary.technique', ['level' => 'bt']) }}"
                           class="block px-3 py-2 rounded-lg text-sm font-medium text-ink-soft hover:bg-surface-muted">
                            Enseignement professionnel
                        </a>
                        <a href="{{ url('/about') }}"
                           class="block px-3 py-2 rounded-lg text-sm font-medium text-ink-soft hover:bg-surface-muted">
                            À propos
                        </a>
                        <div class="pt-2 border-t border-slate-100 flex flex-col gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="block text-center px-4 py-2 rounded-lg text-sm font-medium border border-slate-200 text-ink-soft">
                                    Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="w-full text-center px-4 py-2 rounded-lg text-sm font-medium border border-slate-200 text-ink-soft">
                                        Se déconnecter
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}"
                                   class="block text-center px-4 py-2 rounded-lg text-sm font-medium border border-slate-200 text-ink-soft">
                                    Se connecter
                                </a>
                                <a href="{{ route('register') }}"
                                   class="block text-center px-4 py-2 rounded-lg text-sm font-semibold text-white bg-brand-800">
                                    S'inscrire
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- ============================================================
         CONTENU PRINCIPAL
    ============================================================ -->
    <main>
        @yield('content')
    </main>

    <!-- ============================================================
         FOOTER
    ============================================================ -->
    <footer class="bg-ink mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                             class="h-8 w-8 rounded-lg object-contain bg-white/10 p-0.5">
                        <span class="font-heading font-bold text-white">YAA'Scientia</span>
                    </div>
                    <p class="text-sm text-sidebar-text leading-relaxed">
                        Bibliothèque numérique scientifique. Démocratiser l'accès au savoir au Burkina Faso et au-delà.
                    </p>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-sidebar-text uppercase tracking-wider mb-4">Navigation</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-sm text-sidebar-text hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="{{ route('secondary.index') }}" class="text-sm text-sidebar-text hover:text-white transition-colors">Catalogue</a></li>
                        <li><a href="{{ url('/about') }}" class="text-sm text-sidebar-text hover:text-white transition-colors">À propos</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-sm text-sidebar-text hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-semibold text-sidebar-text uppercase tracking-wider mb-4">Contact</h4>
                    <ul class="space-y-2 text-sm text-sidebar-text">
                        <li>Bobo-Dioulasso</li>
                        <li>Burkina Faso</li>
                        <li>
                            <a href="mailto:contact@yaascientia.bf" class="hover:text-white transition-colors">
                                contact@yaascientia.bf
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p class="text-xs text-sidebar-text">© {{ date('Y') }} YAA'Scientia. Tous droits réservés.</p>
                <p class="text-xs text-sidebar-text">Fait avec <span class="text-red-400">♥</span> au Burkina Faso</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
    @stack('scripts')

</body>
</html>
