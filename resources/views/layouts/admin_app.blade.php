<!DOCTYPE html>

<html lang="fr">

<head>


<meta charset="UTF-8">

<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0">

<meta
    name="csrf-token"
    content="{{ csrf_token() }}">

<title>
    {{ config('app.name', "YAA'Scientia") }} — Admin
</title>

{{-- =========================================================
     POLICES
========================================================== --}}
<link rel="preconnect" href="https://fonts.googleapis.com">

<link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
    rel="stylesheet">


{{-- =========================================================
     CSS ADMIN
========================================================== --}}
@vite([
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/js/admin/sidebar.js',

    'resources/css/admin/layout.css',
    'resources/css/admin/sidebar.css',
    'resources/css/admin/style_dashboard.css',

    'resources/css/admin/style_list_user.css',
    'resources/css/admin/style_agent.css',
    'resources/css/admin/style_edit_journaliste.css',
    'resources/css/admin/style_ajout_matiere.css',
    'resources/css/admin/create_matieres.css',
    'resources/css/admin/style_list_filiere.css',
    'resources/css/admin/style_list_module.css',
    'resources/css/admin/edit_user.css',
])

@yield('head')


</head>

<body class="admin-body">


{{-- =========================================================
     WRAPPER ADMIN
========================================================== --}}
<div class="admin-layout">


    {{-- =====================================================
         OVERLAY MOBILE
    ====================================================== --}}
    <div
        class="admin-sidebar-overlay"
        id="adminSidebarOverlay">
    </div>


    {{-- =====================================================
         SIDEBAR
    ====================================================== --}}
    @include('partials.sidebar_admin')


    {{-- =====================================================
         ZONE PRINCIPALE
    ====================================================== --}}
    <div class="admin-main">


        {{-- =================================================
             TOPBAR
        ================================================== --}}
        <header class="admin-topbar">


            {{-- =================================================
                 BURGER MOBILE
            ================================================== --}}
            <button
                type="button"
                class="admin-mobile-toggle"
                id="adminMobileToggle"
                aria-label="Ouvrir le menu"
                aria-expanded="false">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16">
                    </path>

                </svg>

            </button>


            {{-- =================================================
                 TITRE
            ================================================== --}}
            <div class="admin-page-title">

                <h1>
                    @yield('page-title', 'Tableau de bord')
                </h1>

            </div>


            {{-- =================================================
                 SITE PUBLIC
            ================================================== --}}
            <a
                href="{{ url('/') }}"
                target="_blank"
                class="admin-public-link">

                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4
                        M14 4h6m0 0v6m0-6L10 14">
                    </path>

                </svg>

                <span>Voir le site</span>

            </a>

        </header>


        {{-- =================================================
             CONTENU
        ================================================== --}}
        <main class="admin-content">

            @yield('content')

        </main>

    </div>

</div>


{{-- =========================================================
     SCRIPTS
========================================================== --}}
@yield('scripts')

@stack('scripts')


</body>

</html>
