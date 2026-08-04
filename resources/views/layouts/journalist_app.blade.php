<!DOCTYPE html>

<html lang="fr">

<head>
    <meta charset="UTF-8">

```
<meta
    name="viewport"
    content="width=device-width, initial-scale=1"
>

<meta
    name="csrf-token"
    content="{{ csrf_token() }}"
>

<title>
    @yield('title', config('app.name', "YAA'Scientia") . ' — Journaliste')
</title>

{{-- ============================================================
     POLICES
============================================================ --}}
<link
    rel="preconnect"
    href="https://fonts.googleapis.com"
>

<link
    rel="preconnect"
    href="https://fonts.gstatic.com"
    crossorigin
>

<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
    rel="stylesheet"
>

{{-- ============================================================
     ALPINE JS
============================================================ --}}
<script
    defer
    src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
></script>

{{-- ============================================================
     VITE
============================================================ --}}
@vite([
    'resources/css/app.css',
     'resources/css/journalist/wizare.css',
    'resources/js/app.js'
])

@yield('head')

</head>

<body
    class="font-sans antialiased bg-slate-50 text-slate-800"
    x-data="{ sidebarOpen: false }">
@php


/*
|--------------------------------------------------------------------------
| UTILISATEUR CONNECTÉ
|--------------------------------------------------------------------------
|
| Le journaliste utilise le guard "staff".
|
*/

$staff = auth('staff')->user();

$initiales = strtoupper(
    substr(
        $staff->prenom
            ?? $staff->name
            ?? 'J',
        0,
        1
    )
);

$initiales .= strtoupper(
    substr(
        $staff->nom
            ?? '',
        0,
        1
    )
);


@endphp

<div class="flex h-screen overflow-hidden">


{{-- ============================================================
     OVERLAY MOBILE
============================================================ --}}
<div
    x-show="sidebarOpen"

    x-transition:enter="
        transition-opacity
        ease-out
        duration-200
    "

    x-transition:enter-start="
        opacity-0
    "

    x-transition:enter-end="
        opacity-100
    "

    x-transition:leave="
        transition-opacity
        ease-in
        duration-150
    "

    x-transition:leave-start="
        opacity-100
    "

    x-transition:leave-end="
        opacity-0
    "

    @click="sidebarOpen = false"

    class="fixed   inset-0   z-20   bg-black/50  lg:hidden " style="display: none;"
>
</div>


{{-- ============================================================
     SIDEBAR
============================================================ --}}
<aside

    class=" fixed  inset-y-0  left-0  z-30 flex  w-64  flex-shrink-0  flex-col  bg-slate-900 transition-transform duration-300 ease-in-out  lg:relative lg:translate-x-0 "

    :class="  sidebarOpen     ? 'translate-x-0'    : '-translate-x-full'">


    {{-- ========================================================
         LOGO
    ======================================================== --}}
    <div
        class="
            flex
            h-16
            shrink-0
            items-center
            gap-3

            border-b
            border-white/10

            px-5
        "
    >

        <img
            src="{{ asset('images/logo.png') }}"

            alt="Logo YAA'Scientia"

            class="
                h-9
                w-9

                rounded-lg

                bg-white/10

                object-contain

                p-1
            "
        >

        <div>

            <p
                class="
                    font-heading
                    text-sm
                    font-bold
                    leading-tight
                    text-white
                "
            >
                YAA'Scientia
            </p>

            <p
                class="
                    text-xs
                    text-slate-400
                "
            >
                Espace journaliste
            </p>

        </div>

    </div>


    {{-- ========================================================
         NAVIGATION
    ======================================================== --}}
    <nav  class=" flex-1 space-y-1 overflow-y-auto  px-3 py-4 ">

        {{-- ====================================================
             TABLEAU DE BORD
        ==================================================== --}}
        <a href="{{ route('journaliste.dashboard') }}"

            @click="sidebarOpen = false"

            class="  flex  items-center
          gap-3

                rounded-lg

                px-3
                py-2.5

                text-sm
                font-medium

                transition-colors

                {{
                    request()->routeIs(
                        'journaliste.dashboard'
                    )

                    ? 'bg-blue-600 text-white'

                    : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                }}
            "
        >

            <svg
                class="h-4 w-4"

                fill="none"

                stroke="currentColor"

                viewBox="0 0 24 24"
            >

                <path

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    stroke-width="2"

                    d="
                        M3 12l2-2m0 0l7-7
                        7 7M5 10v10
                        a1 1 0 001 1h3

                        m10-11l2 2

                        m-2-2v10

                        a1 1 0 01-1 1h-3

                        m-6 0

                        a1 1 0 001-1v-4

                        a1 1 0 011-1h2

                        a1 1 0 011 1v4

                        a1 1 0 001 1

                        m-6 0h6
                    "
                />

            </svg>

            Tableau de bord

        </a>


        {{-- ====================================================
             SECTION CONTENU
        ==================================================== --}}
        <div
            class="
                px-3
                pb-1
                pt-5
            "
        >

            <p
                class="
                    text-xs
                    font-semibold
                    uppercase
                    tracking-wider
                    text-white/30
                "
            >
                Contenu
            </p>

        </div>


        {{-- PUBLIER --}}
        <a

            href="{{ route('journaliste.documents.create') }}"

            @click="sidebarOpen = false"

            class="
                flex
                items-center
                gap-3

                rounded-lg

                px-3
                py-2.5

                text-sm
                font-medium

                transition-colors

                {{
                    request()->routeIs(
                        'journaliste.documents.create'
                    )

                    ? 'bg-blue-600 text-white'

                    : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                }}
            "
        >

            <span>
                ➕
            </span>

            Publier un document

        </a>


        {{-- MES DOCUMENTS --}}
        <a

            href="{{ route('journaliste.documents.index') }}"

            @click="sidebarOpen = false"

            class="
                flex
                items-center
                gap-3

                rounded-lg

                px-3
                py-2.5

                text-sm
                font-medium

                transition-colors

                {{
                    request()->routeIs(
                        'journaliste.documents.index'
                    )

                    ? 'bg-blue-600 text-white'

                    : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                }}
            "
        >

            <span>
                📄
            </span>

            Mes documents

        </a>


        {{-- ====================================================
             ANALYSE
        ==================================================== --}}
        <div
            class="
                px-3
                pb-1
                pt-5
            "
        >

            <p
                class="
                    text-xs
                    font-semibold
                    uppercase
                    tracking-wider
                    text-white/30
                "
            >
                Analyse
            </p>

        </div>


        <a

            href="#"

            class="
                flex
                items-center
                gap-3

                rounded-lg

                px-3
                py-2.5

                text-sm
                font-medium

                text-slate-300

                transition-colors

                hover:bg-slate-800
                hover:text-white
            "
        >

            📊

            Statistiques

        </a>


        <a

            href="#"

            class="
                flex
                items-center
                gap-3

                rounded-lg

                px-3
                py-2.5

                text-sm
                font-medium

                text-slate-300

                transition-colors

                hover:bg-slate-800
                hover:text-white
            "
        >

            💰

            Revenus

            <span
                class="
                    ml-auto

                    rounded

                    bg-white/10

                    px-1.5
                    py-0.5

                    text-xs

                    text-white/40
                "
            >
                bientôt
            </span>

        </a>


    {{-- ========================================================
         PROFIL
    ======================================================== --}}
    <div
        class="
            shrink-0

            border-t
            border-white/10

            px-3
            py-4
        "
    >

        <div
            class="
                mb-2

                flex
                items-center
                gap-3

                rounded-lg

                px-3
                py-2
            "
        >

            {{-- AVATAR --}}
            <div
                class="
                    flex
                    h-9
                    w-9

                    shrink-0

                    items-center
                    justify-center

                    rounded-full

                    bg-emerald-600
                "
            >

                <span
                    class="
                        text-xs
                        font-bold
                        text-white
                    "
                >
                    {{ $initiales }}
                </span>

            </div>


            {{-- INFORMATIONS --}}
            <div class="min-w-0">

                <p
                    class="
                        truncate

                        text-sm
                        font-medium

                        text-white
                    "
                >

                    {{ $staff->prenom ?? $staff->name ?? 'Journaliste' }}

                    {{ $staff->nom ?? '' }}

                </p>


                <p
                    class="
                        truncate

                        text-xs

                        text-slate-400
                    "
                >

                    Journaliste

                </p>

            </div>

        </div>


        {{-- ====================================================
             DÉCONNEXION
        ==================================================== --}}
        <form

            method="POST"

            action="{{ route('logout') }}" >

            @csrf

            <button

                type="submit"

                class=" fle  w-full  items-center  gap-2

                    rounded-lg

                    px-3
                    py-2

                    text-sm
                    font-medium

                    text-red-400

                    transition-colors

                    hover:bg-red-500/10
                    hover:text-red-300
                "
            >

                <svg

                    class="h-4 w-4"

                    fill="none"

                    stroke="currentColor"

                    viewBox="0 0 24 24"
                >

                    <path

                        stroke-linecap="round"

                        stroke-linejoin="round"

                        stroke-width="2"

                        d="
                            M17 16l4-4

                            m0 0l-4-4

                            m4 4H7

                            m6 4v1

                            a3 3 0 01-3 3H6

                            a3 3 0 01-3-3V7

                            a3 3 0 013-3h4

                            a3 3 0 013 3v1
                        "
                    />

                </svg>

                Se déconnecter

            </button>

        </form>

    </div>

</aside>


{{-- ============================================================
     ZONE PRINCIPALE
============================================================ --}}
<div
    class="
        flex
        min-w-0
        flex-1
        flex-col
        overflow-hidden
    "
>


    {{-- ========================================================
         TOPBAR
    ======================================================== --}}
    <header
        class="
            flex
            h-16

            shrink-0

            items-center
            justify-between

            border-b
            border-slate-200

            bg-white

            px-4
            sm:px-6
        "
    >


        {{-- MENU MOBILE --}}
        <button

            type="button"

            @click="sidebarOpen = !sidebarOpen"

            class="
                rounded-lg

                p-2

                text-slate-600

                transition-colors

                hover:bg-slate-100

                lg:hidden
            "
        >

            <svg

                class="h-5 w-5"

                fill="none"

                stroke="currentColor"

                viewBox="0 0 24 24"
            >

                <path

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    stroke-width="2"

                    d="
                        M4 6h16

                        M4 12h16

                        M4 18h16
                    "
                />

            </svg>

        </button>


        {{-- TITRE --}}
        <h1
            class="
                font-heading

                text-base
                font-bold

                text-slate-800
            "
        >

            @yield(
                'page-title',
                'Tableau de bord'
            )

        </h1>


        {{-- SITE --}}
        <a

            href="{{ url('/') }}"

            target="_blank"

            class="
                flex
                items-center
                gap-1.5

                text-xs
                font-medium

                text-slate-500

                transition-colors

                hover:text-blue-600
            "
        >

            <svg

                class="h-4 w-4"

                fill="none"

                stroke="currentColor"

                viewBox="0 0 24 24"
            >

                <path

                    stroke-linecap="round"

                    stroke-linejoin="round"

                    stroke-width="2"

                    d="
                        M10 6H6

                        a2 2 0 00-2 2v10

                        a2 2 0 002 2h10

                        a2 2 0 002-2v-4

                        M14 4h6

                        m0 0v6

                        m0-6L10 14
                    "
                />

            </svg>

            Voir le site

        </a>

    </header>


    {{-- ========================================================
         CONTENU
    ======================================================== --}}
    <main
        class="
            flex-1

            overflow-y-auto

            p-4
            sm:p-6
        "
    >

        {{-- ALERTES --}}
        @if(session('success'))

            <div
                class="
                    mb-6

                    rounded-xl

                    border
                    border-emerald-200

                    bg-emerald-50

                    px-4
                    py-3

                    text-sm

                    text-emerald-700
                "
            >

                {{ session('success') }}

            </div>

        @endif


        @if(session('error'))

            <div
                class="
                    mb-6

                    rounded-xl

                    border
                    border-red-200

                    bg-red-50

                    px-4
                    py-3

                    text-sm

                    text-red-700
                "
            >

                {{ session('error') }}

            </div>

        @endif


        @yield('content')

    </main>

</div>
</div>

{{-- ================================================================
SCRIPTS
================================================================ --}}
@yield('scripts')

@stack('scripts')

</body>

</html>
