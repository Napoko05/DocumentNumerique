<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>YAA'Scientia · Bibliothèque numérique scientifique</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface-soft text-ink antialiased">

    {{-- ====================== NAVBAR ====================== --}}
    <nav x-data="{ mobileOpen: false }" class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="container-wide flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo.png') }}" alt="YAA'Scientia" class="w-10 h-10 rounded">
                <span class="font-heading text-xl font-extrabold text-ink">YAA'Scientia</span>
            </a>

            {{-- Desktop navigation --}}
            <div class="hidden lg:flex items-center gap-1">
                <a href="{{ route('home') }}"
                    class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request()->routeIs('home') ? 'text-brand-800 bg-brand-50' : 'text-ink-soft hover:text-brand-800 hover:bg-brand-50' }}">
                    Accueil
                </a>

                {{-- Dropdown Livres numériques --}}
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open"
                        class="px-4 py-2 rounded-lg font-medium text-sm flex items-center gap-1.5 transition-colors {{ request()->is('secondary*') || request()->is('superior*') ? 'text-brand-800 bg-brand-50' : 'text-ink-soft hover:text-brand-800 hover:bg-brand-50' }}">
                        <span>Livres numériques</span>
                        <svg :class="open && 'rotate-180'" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        class="absolute top-full right-0 mt-2 w-72 bg-white rounded-xl border border-slate-200 shadow-xl py-2 z-50"
                        style="display: none;">
                        <a href="{{ route('secondary.index') }}" class="flex items-start gap-3 px-4 py-3 hover:bg-brand-50 transition-colors group">
                            <div class="w-10 h-10 rounded-lg bg-brand-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-ink group-hover:text-brand-800 transition-colors">Enseignement secondaire</div>
                                <div class="text-xs text-ink-muted mt-0.5">Général & technique</div>
                            </div>
                        </a>
                        <a href="{{ route('secondary.technique', ['level' => 'bt']) }}" class="flex items-start gap-3 px-4 py-3 hover:bg-brand-50 transition-colors group">
                            <div class="w-10 h-10 rounded-lg bg-accent-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-accent-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-ink group-hover:text-brand-800 transition-colors">Enseignement professionnel</div>
                                <div class="text-xs text-ink-muted mt-0.5">Technique & métiers</div>
                            </div>
                        </a>
                    </div>
                </div>

                <a href="#apropos" class="px-4 py-2 rounded-lg font-medium text-sm text-ink-soft hover:text-brand-800 hover:bg-brand-50 transition-colors">
                    À propos
                </a>

                @auth
                <a href="{{ route('profile.edit') }}"
                    class="px-4 py-2 rounded-lg font-medium text-sm transition-colors {{ request()->routeIs('profile.*') ? 'text-brand-800 bg-brand-50' : 'text-ink-soft hover:text-brand-800 hover:bg-brand-50' }}">
                    Profil
                </a>
                @endauth
            </div>

            {{-- Desktop actions --}}
            <div class="hidden lg:flex items-center gap-2">
                @auth
                @php
                $user = Auth::user();
                if($user->hasRole('admin')){
                $dashboardRoute = route('admin.dashboard');
                } elseif($user->hasRole('journalist')){
                $dashboardRoute = route('journalist.dashboard');
                } else {
                $dashboardRoute = route('home');
                }
                @endphp
                <a href="{{ $dashboardRoute }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Tableau de bord
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="btn-ghost text-red-600 hover:bg-red-50 hover:text-red-700">
                        Se déconnecter
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn-ghost">Se connecter</a>
                <a href="{{ route('register') }}" class="btn-primary">S'inscrire</a>
                @endauth
            </div>

            {{-- Mobile burger --}}
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Menu">
                <svg x-show="!mobileOpen" class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileOpen" class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Mobile menu drawer --}}
        <div x-show="mobileOpen"
            x-transition
            class="lg:hidden border-t border-slate-200 bg-white"
            style="display: none;">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-medium text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-800">Accueil</a>
                <a href="{{ route('secondary.index') }}" class="block px-3 py-2 rounded-lg font-medium text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-800">Enseignement secondaire</a>
                <a href="{{ route('secondary.technique', ['level' => 'bt']) }}" class="block px-3 py-2 rounded-lg font-medium text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-800">Enseignement professionnel</a>
                <a href="#apropos" class="block px-3 py-2 rounded-lg font-medium text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-800">À propos</a>
                @auth
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg font-medium text-sm text-ink-soft hover:bg-brand-50 hover:text-brand-800">Profil</a>
                @endauth
            </div>
            <div class="px-4 py-3 border-t border-slate-200 space-y-2">
                @auth
                <a href="{{ $dashboardRoute }}" class="btn-secondary w-full">Tableau de bord</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-danger w-full">Se déconnecter</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn-secondary w-full">Se connecter</a>
                <a href="{{ route('register') }}" class="btn-primary w-full">S'inscrire</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ====================== HERO ====================== --}}
    <section class="relative overflow-hidden">
        {{-- Decorative background --}}
        <div class="absolute inset-0 -z-10 pointer-events-none">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-bl from-brand-50 to-transparent"></div>
        </div>

        <div class="container-wide section">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                {{-- Hero text --}}
                <div class="lg:col-span-6">
                    <span class="badge-info inline-flex items-center gap-1.5 mb-5">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="6" />
                        </svg>
                        Bibliothèque scientifique
                    </span>
                    <h1 class="font-heading text-4xl sm:text-5xl lg:text-6xl font-extrabold text-ink leading-[1.05] tracking-tight mb-6">
                        Le savoir,<br>
                        <span class="text-brand-800">à portée</span>
                        <span class="relative inline-block">
                            de tous
                            <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 200 12" preserveAspectRatio="none">
                                <path d="M0 8 Q 50 2 100 6 T 200 5" stroke="#F59E0B" stroke-width="4" fill="none" stroke-linecap="round" />
                            </svg>
                        </span>
                    </h1>
                    <p class="text-lg text-ink-soft leading-relaxed mb-8 max-w-xl">
                        Découvrez, lisez et louez des livres numériques dans une large sélection d'œuvres scientifiques. Conçu pour les étudiants, les chercheurs et les curieux.
                    </p>
                    <div class="flex flex-wrap gap-3 mb-10">
                        <a href="{{ route('books.index') }}" class="btn-primary">
                            Explorer les livres
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                        <a href="#apropos" class="btn-secondary">En savoir plus</a>
                    </div>

                    {{-- Stats / trust signals --}}
                    <div class="grid grid-cols-3 gap-6 max-w-md">
                        <div>
                            <div class="font-heading text-2xl font-extrabold text-brand-800">1k+</div>
                            <div class="text-xs text-ink-muted">Ouvrages</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl font-extrabold text-brand-800">10+</div>
                            <div class="text-xs text-ink-muted">Disciplines</div>
                        </div>
                        <div>
                            <div class="font-heading text-2xl font-extrabold text-brand-800">24/7</div>
                            <div class="text-xs text-ink-muted">Accessible</div>
                        </div>
                    </div>
                </div>

                {{-- Hero illustration (SVG) --}}
                <div class="lg:col-span-6">
                    <div class="relative">
                        <svg viewBox="0 0 500 480" class="w-full h-auto" xmlns="http://www.w3.org/2000/svg">
                            {{-- Background blob --}}
                            <circle cx="260" cy="240" r="200" fill="#DBEAFE" />

                            {{-- Decorative dot grid --}}
                            <g fill="#BFDBFE" opacity="0.6">
                                <circle cx="60" cy="80" r="3" />
                                <circle cx="100" cy="80" r="3" />
                                <circle cx="60" cy="120" r="3" />
                                <circle cx="100" cy="120" r="3" />
                                <circle cx="440" cy="380" r="3" />
                                <circle cx="400" cy="380" r="3" />
                                <circle cx="440" cy="420" r="3" />
                                <circle cx="400" cy="420" r="3" />
                            </g>

                            {{-- Floating papers behind --}}
                            <g transform="rotate(-15 150 220)">
                                <rect x="100" y="180" width="100" height="120" fill="white" stroke="#CBD5E1" stroke-width="2" rx="4" />
                                <line x1="115" y1="200" x2="180" y2="200" stroke="#E2E8F0" stroke-width="2" />
                                <line x1="115" y1="215" x2="170" y2="215" stroke="#E2E8F0" stroke-width="2" />
                                <line x1="115" y1="230" x2="180" y2="230" stroke="#E2E8F0" stroke-width="2" />
                                <line x1="115" y1="245" x2="160" y2="245" stroke="#E2E8F0" stroke-width="2" />
                            </g>

                            {{-- Main open book --}}
                            <g transform="translate(150 200)">
                                <path d="M0 30 L0 180 Q 80 165 100 175 L 100 25 Q 80 15 0 30 Z" fill="white" stroke="#1E40AF" stroke-width="3" />
                                <path d="M200 30 L200 180 Q 120 165 100 175 L 100 25 Q 120 15 200 30 Z" fill="white" stroke="#1E40AF" stroke-width="3" />
                                <line x1="20" y1="55" x2="85" y2="50" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" />
                                <line x1="20" y1="75" x2="85" y2="70" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                <line x1="20" y1="95" x2="85" y2="90" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                <line x1="20" y1="115" x2="85" y2="110" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                <line x1="20" y1="135" x2="75" y2="130" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                <line x1="115" y1="50" x2="180" y2="55" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" />
                                <line x1="115" y1="70" x2="180" y2="75" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                <line x1="115" y1="90" x2="180" y2="95" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                <line x1="115" y1="110" x2="180" y2="115" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                                <line x1="115" y1="130" x2="175" y2="135" stroke="#CBD5E1" stroke-width="2" stroke-linecap="round" />
                            </g>

                            {{-- Lightbulb (idea) --}}
                            <g transform="translate(380 130)">
                                <circle cx="0" cy="0" r="32" fill="#FBBF24" />
                                <circle cx="0" cy="-4" r="22" fill="#FDE68A" />
                                <rect x="-10" y="20" width="20" height="6" fill="#92400E" rx="1" />
                                <rect x="-7" y="28" width="14" height="4" fill="#78350F" rx="1" />
                                <line x1="-40" y1="-30" x2="-50" y2="-40" stroke="#F59E0B" stroke-width="3" stroke-linecap="round" />
                                <line x1="40" y1="-30" x2="50" y2="-40" stroke="#F59E0B" stroke-width="3" stroke-linecap="round" />
                                <line x1="0" y1="-50" x2="0" y2="-62" stroke="#F59E0B" stroke-width="3" stroke-linecap="round" />
                                <line x1="-50" y1="0" x2="-62" y2="0" stroke="#F59E0B" stroke-width="3" stroke-linecap="round" />
                                <line x1="50" y1="0" x2="62" y2="0" stroke="#F59E0B" stroke-width="3" stroke-linecap="round" />
                            </g>

                            {{-- Atom (sciences) --}}
                            <g transform="translate(110 380)">
                                <ellipse cx="0" cy="0" rx="40" ry="14" fill="none" stroke="#10B981" stroke-width="3" />
                                <ellipse cx="0" cy="0" rx="40" ry="14" fill="none" stroke="#10B981" stroke-width="3" transform="rotate(60)" />
                                <ellipse cx="0" cy="0" rx="40" ry="14" fill="none" stroke="#10B981" stroke-width="3" transform="rotate(-60)" />
                                <circle cx="0" cy="0" r="6" fill="#10B981" />
                            </g>

                            {{-- Graduation cap --}}
                            <g transform="translate(380 320)">
                                <path d="M-30 0 L0 -15 L30 0 L0 15 Z" fill="#1E3A8A" />
                                <path d="M-30 0 L0 15 L0 35 L-25 25 Z" fill="#1E40AF" />
                                <path d="M30 0 L0 15 L0 35 L25 25 Z" fill="#1D4ED8" />
                                <circle cx="25" cy="-8" r="3" fill="#F59E0B" />
                                <line x1="25" y1="-8" x2="35" y2="10" stroke="#F59E0B" stroke-width="2" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- DOCUMENTS RECENTS --}}
    <section class="bg-white border-y border-slate-200 py-16">

        <div class="container-wide">

            <div class="flex justify-between items-center mb-8">

                <div>
                    <p class="text-brand-700 font-semibold">
                        Dernières publications
                    </p>

                    <h2 class="text-3xl font-bold">
                        Documents récents
                    </h2>
                </div>

                <a href="{{ route('documents.index') }}"
                    class="text-brand-700 font-semibold">
                    Voir tout →
                </a>

            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestDocuments as $document)

                <div class="bg-white rounded-2xl shadow border overflow-hidden hover:shadow-lg transition">

                    @if($document->cover_image)

                    <img
                        src="{{ asset('storage/'.$document->cover_image) }}"
                        class="h-64 w-full object-cover">

                    @endif

                    <div class="p-5">

                        <h3 class="font-bold text-lg mb-2">
                            {{ $document->title }}
                        </h3>

                        <p class="text-sm text-slate-500 mb-4">
                            {{ Str::limit($document->description, 100) }}
                        </p>

                        <div class="flex justify-between items-center">

                            @if($document->access_type == 'premium')

                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full text-xs">
                                Premium
                            </span>

                            @else

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                Gratuit
                            </span>

                            @endif

                            <span class="text-xs text-slate-500">
                                👁 {{ $document->views }}
                            </span>

                        </div>

                        <a href="{{ route('documents.show',$document) }}"
                            class="btn-primary w-full mt-4 justify-center">

                            Consulter

                        </a>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </section>

    {{-- ====================== LIVRES RECOMMANDÉS ====================== --}}

    <section class="section bg-slate-50">

        <div class="container-wide">

            <h2 class="font-heading text-3xl font-bold mb-8">
                Documents Premium
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                @foreach($premiumDocuments as $document)

                <div class="bg-white rounded-2xl border overflow-hidden">

                    <img src="{{ asset('storage/'.$document->cover_image) }}"
                        class="h-52 w-full object-cover">

                    <div class="p-4">

                        <h3 class="font-semibold">
                            {{ $document->title }}
                        </h3>

                        <p class="text-orange-600 font-bold mt-2">
                            {{ number_format($document->price,0,' ',' ') }} FCFA
                        </p>

                        <a href="{{ route('documents.show',$document) }}"
                            class="btn-primary w-full mt-3">
                            Consulter
                        </a>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </section>

    {{-- ====================== À PROPOS ====================== --}}
    <section id="apropos" class="section scroll-mt-20">
        <div class="container-wide">
            <div class="text-center mb-14">
                <div class="text-sm font-medium text-accent-600 mb-2">À propos</div>
                <h2 class="font-heading text-3xl sm:text-4xl font-extrabold text-ink mb-3">
                    Une plateforme pour le <span class="text-brand-800">savoir partagé</span>
                </h2>
                <p class="text-ink-muted max-w-2xl mx-auto">Une plateforme innovante pour partager et explorer le savoir scientifique.</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                {{-- Image with decorative shapes --}}
                <div class="relative">
                    <div class="aspect-square max-w-md mx-auto bg-brand-50 rounded-3xl flex items-center justify-center p-8">
                        <img src="{{ asset('images/etude.png') }}" alt="Lecture et savoir" class="w-full h-auto">
                    </div>
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-accent-100 rounded-full -z-10"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-emerald-100 rounded-full -z-10"></div>
                </div>

                {{-- Mission text --}}
                <div>
                    <h3 class="font-heading text-2xl font-bold text-ink mb-5">Notre mission</h3>
                    <p class="text-ink-soft leading-relaxed mb-4">
                        <strong class="text-ink">YAA'Scientia</strong> est une bibliothèque numérique offrant un accès simplifié à des milliers d'ouvrages scientifiques.
                    </p>
                    <p class="text-ink-soft leading-relaxed mb-8">
                        Une plateforme intuitive, moderne et évolutive, pensée pour démocratiser l'accès au savoir scientifique au Burkina Faso et au-delà.
                    </p>

                    <ul class="space-y-4 mb-10">
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center mt-0.5">
                                <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span class="text-ink-soft">Large collection d'ouvrages scientifiques</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center mt-0.5">
                                <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span class="text-ink-soft">Interface simple et responsive</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center mt-0.5">
                                <svg class="w-3.5 h-3.5 text-emerald-700" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span class="text-ink-soft">Recherche et location de livres</span>
                        </li>
                    </ul>

                    <a href="{{ route('contact.form') }}" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ====================== FOOTER ====================== --}}
    <footer class="bg-ink text-slate-300">
        <div class="container-wide section">
            <div class="grid md:grid-cols-4 gap-8 mb-10">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-10 h-10 bg-white rounded p-1 flex items-center justify-center">
                            <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-8 h-8">
                        </div>
                        <span class="font-heading font-extrabold text-white text-lg">YAA'Scientia</span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                        Bibliothèque numérique scientifique. Démocratiser l'accès au savoir scientifique au Burkina Faso et au-delà.
                    </p>
                </div>
                <div>
                    <h4 class="font-heading font-bold text-white mb-4 text-sm uppercase tracking-wider">Navigation</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition-colors">Accueil</a></li>
                        <li><a href="{{ route('books.index') }}" class="text-slate-400 hover:text-white transition-colors">Catalogue</a></li>
                        <li><a href="#apropos" class="text-slate-400 hover:text-white transition-colors">À propos</a></li>
                        <li><a href="{{ route('contact.form') }}" class="text-slate-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-heading font-bold text-white mb-4 text-sm uppercase tracking-wider">Contact</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li>Bobo-Dioulasso</li>
                        <li>Burkina Faso</li>
                        <li class="pt-1">contact@yaascientia.bf</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-slate-500">© {{ date('Y') }} YAA'Scientia. Tous droits réservés.</p>
                <p class="text-xs text-slate-500">Fait avec ❤ au Burkina Faso</p>
            </div>
        </div>
    </footer>

</body>

</html>