<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1">

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}">

    <title>
        @yield(
        'title',
        config('app.name', "YAA'Scientia") . ' — Journaliste'
        )
    </title>


    {{-- =========================================================
         POLICES
    ========================================================== --}}

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">


    {{-- =========================================================
         CSS + JS PRINCIPAL
    ========================================================== --}}

    @vite([
    'resources/css/app.css',
    'resources/js/app.js',

    'resources/css/journaliste/layout.css',
    'resources/css/journaliste/sidebar.css',
    'resources/css/journaliste/document-wizard.css',
    'resources/css/journaliste/style_dashboard.css',
    'resources/css/journaliste/show.css',
    'resources/css/journaliste/journaliste_documents.css',
    'resources/css/journaliste/document_edit.css' ,
    'resources/css/journaliste/document_index.css',
     'resources/css/journaliste/journale_statistique.css',
     'resources/css/journaliste/edit_profil.css',
     'resources/css/journaliste/password.css',
    
    ])


    @yield('head')

    @stack('styles')

</head>


<body>


    <div
        id="journaliste-app"
        class="journaliste-app">


        {{-- =========================================================
         OVERLAY MOBILE
    ========================================================== --}}

        <div
            id="sidebarOverlay"
            class="sidebar-overlay"></div>


        {{-- =========================================================
         SIDEBAR
    ========================================================== --}}

        @include('partials.journaliste_sidebar')


        {{-- =========================================================
         ZONE PRINCIPALE
    ========================================================== --}}

        <div class="journaliste-main">


            {{-- =====================================================
             TOPBAR
        ====================================================== --}}

            <header class="journaliste-topbar">


                <div class="topbar-left">


                    {{-- MENU MOBILE --}}

                    <button
                        type="button"
                        class="sidebar-toggle"
                        id="sidebarToggle"
                        aria-label="Ouvrir le menu">

                        <i class="bi bi-list"></i>

                    </button>


                    {{-- TITRE --}}

                    <div class="topbar-title">

                        <h1>
                            @yield(
                            'page-title',
                            'Tableau de bord'
                            )
                        </h1>

                    </div>

                </div>


                {{-- SITE PUBLIC --}}

                <a
                    href="{{ route('home') }}"
                    class="topbar-site-link">

                    <i class="bi bi-box-arrow-up-right"></i>

                    <span>
                        Voir le site
                    </span>

                </a>


            </header>


            {{-- =====================================================
             CONTENU
        ====================================================== --}}

            <main class="journaliste-content">

                <div class="journaliste-content-inner">


                    {{-- SUCCESS --}}

                    @if(session('success'))

                    <div class="alert alert-success journaliste-alert">

                        <i class="bi bi-check-circle-fill"></i>

                        <span>
                            {{ session('success') }}
                        </span>

                    </div>

                    @endif


                    {{-- ERROR --}}

                    @if(session('error'))

                    <div class="alert alert-danger journaliste-alert">

                        <i class="bi bi-exclamation-circle-fill"></i>

                        <span>
                            {{ session('error') }}
                        </span>

                    </div>

                    @endif


                    {{-- WARNING --}}

                    @if(session('warning'))

                    <div class="alert alert-warning journaliste-alert">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        <span>
                            {{ session('warning') }}
                        </span>

                    </div>

                    @endif


                    {{-- PAGE --}}

                    @yield('content')


                </div>

            </main>


        </div>

    </div>


    {{-- =========================================================
     JS JOURNALISTE
========================================================== --}}

    @vite([
    'resources/js/journaliste/script_journaliste.js',

    ])


    @stack('scripts')

</body>

</html>