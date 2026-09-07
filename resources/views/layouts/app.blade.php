<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <meta name="csrf-token"
        content="{{ csrf_token() }}">

    <meta name="description"
        content="@yield('meta_description', 'YAA\'Scientia, bibliothèque numérique scientifique pour étudiants, enseignants, chercheurs et professionnels.')">

    <meta name="theme-color"
        content="#071A33">

    <title>
        @yield('title', "YAA'Scientia")
    </title>


    {{-- =========================================================
         FONTS
    ========================================================== --}}

    <link rel="preconnect"
        href="https://fonts.googleapis.com">

    <link rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap"
        rel="stylesheet">


    {{-- =========================================================
         ALPINE
    ========================================================== --}}

    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>


    {{-- =========================================================
         VITE
    ========================================================== --}}

    @vite([
    'resources/css/app.css',
    'resources/css/yaascientia-home.css',
    'resources/css/layout.css',
    'resources/css/auth.css',
    'resources/css/login/style_register.css',
    'resources/js/app.js',
    'resources/js/yaascientia-home.js',
    'resources/css/journaliste/profile.css',
    'resources/css/formation/secondaire/classe.css',
    'resources/css/formation/secondaire/matiere.css',
    'resources/css/formation/secondaire/type_doc.css',
    'resources/css/formation/secondaire/document.css',
    'resources/css/formation/superieur/filiere.css',
    'resources/css/formation/superieur/niveau.css',
    'resources/css/formation/superieur/module.css',
    'resources/css/formation/superieur/accademie.css',
    'resources/css/formation/professionnel/formation.css',
    'resources/css/formation/professionnel/accademie.css',
    ])


    @yield('head')

    @stack('styles')

</head>


<body class="yaas-page">


    {{-- ============================================================
     NAVBAR
============================================================ --}}

    <header class="yaas-navbar">

        <div class="yaas-container yaas-navbar-inner">


            {{-- =====================================================
             LOGO
        ====================================================== --}}

            <a href="{{ route('home') }}"
                class="yaas-logo">

                <span class="yaas-logo-mark">

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="YAA'Scientia">

                </span>


                <span class="yaas-logo-text">

                    <strong>
                        YAA'Scientia
                    </strong>

                    <small>
                        Bibliothèque scientifique
                    </small>

                </span>

            </a>



            {{-- =====================================================
             NAVIGATION DESKTOP
        ====================================================== --}}

            <nav class="yaas-main-nav">


                {{-- ACCUEIL --}}

                <a
                    href="{{ route('home') }}"
                    class="yaas-nav-link
                {{ request()->routeIs('home')
                    ? 'active'
                    : '' }}">

                    Accueil

                </a>



                {{-- =================================================
                 BIBLIOTHÈQUE
            ================================================== --}}

                <div class="yaas-nav-dropdown">

                    <button
                        type="button"
                        class="yaas-nav-link yaas-dropdown-trigger">

                        <span>
                            Bibliothèque
                        </span>

                        <svg viewBox="0 0 24 24">

                            <path d="m6 9 6 6 6-6" />

                        </svg>

                    </button>


                    <div class="yaas-dropdown-menu">


                        {{-- Secondaire général --}}

                        <a
                            href="{{ route('vitrine.secondaire.index') }}"
                            class="yaas-dropdown-item">

                            <span class="yaas-dropdown-icon blue">
                                🎓
                            </span>

                            <span>

                                <strong>
                                    Enseignement Secondaire 
                                </strong>

                                <small>
                                    general & technique
                                </small>

                            </span>

                        </a>



                     



                        {{-- Supérieur --}}

                        <a
                            href="{{ route('vitrine.superieur.domaines') }}"
                            class="yaas-dropdown-item">

                            <span class="yaas-dropdown-icon green">
                                🔬
                            </span>

                            <span>

                                <strong>
                                    Enseignement supérieur
                                </strong>

                                <small>
                                    Licence · Master · Doctorat
                                </small>

                            </span>

                        </a>
                        {{-- Professionnel --}}

                        <a
                            href="{{ route('vitrine.professionnel.formations') }}"
                            class="yaas-dropdown-item">

                            <span class="yaas-dropdown-icon purple">
                                💼
                            </span>

                            <span>

                                <strong>
                                    Formation professionnelle
                                </strong>

                                <small>
                                    Formations spécialisées
                                </small>

                            </span>

                        </a>

                    </div>

                </div>



                {{-- DOCUMENTS --}}

                <a
                    href="{{ route('documents.index') }}"
                    class="yaas-nav-link
                {{ request()->routeIs('documents.*')
                    ? 'active'
                    : '' }}">

                    Documents

                </a>



                {{-- À PROPOS --}}

                <a
                    href="{{ route('home') }}#apropos"
                    class="yaas-nav-link">

                    À propos

                </a>



                {{-- PROFIL --}}

                @auth

                <a
                    href="{{ route('profile.edit') }}"
                    class="yaas-nav-link
                    {{ request()->routeIs('profile.*')
                        ? 'active'
                        : '' }}">
                    Profil
                </a>
                @endauth
            </nav>
            {{-- =====================================================
             ACTIONS DESKTOP
        ====================================================== --}}

            <div class="yaas-navbar-actions">

                @auth
                {{-- Profil rapide --}}
                <a
                    href="{{ route('profile.edit') }}"
                    class="yaas-btn yaas-btn-outline">

                    Mon profil
                </a>
                {{-- Déconnexion --}}

                <form
                    method="POST"
                    action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="yaas-btn yaas-btn-dark">

                        Déconnexion

                    </button>

                </form>
                @else

                {{-- Connexion --}}

                <a
                    href="{{ route('login') }}"
                    class="yaas-btn yaas-btn-text">

                    Connexion

                </a>


                {{-- Inscription --}}

                <a
                    href="{{ route('register') }}"
                    class="yaas-btn yaas-btn-primary">

                    Créer un compte

                </a>

                @endauth

            </div>



            {{-- =====================================================
             MOBILE TOGGLE
        ====================================================== --}}

            <button
                type="button"
                class="yaas-mobile-toggle"
                id="yaas-mobile-toggle"
                aria-label="Ouvrir le menu"
                aria-expanded="false">

                <span></span>
                <span></span>
                <span></span>

            </button>

        </div>



        {{-- =========================================================
         MOBILE MENU
    ========================================================== --}}

        <div
            class="yaas-mobile-menu"
            id="yaas-mobile-menu">

            <div class="yaas-mobile-inner">


                {{-- Accueil --}}

                <a
                    href="{{ route('home') }}"
                    class="yaas-mobile-link">

                    Accueil

                </a>



                {{-- Bibliothèque --}}

                <div class="yaas-mobile-section">

                    <span>
                        Bibliothèque
                    </span>


                    <a href="{{ route('vitrine.secondaire.index') }}">
                        🎓 Secondaire général
                    </a>


                    <a href="{{ route('vitrine.secondaire.index') }}">
                        ⚙ Secondaire technique
                    </a>


                    <a href="{{ route('vitrine.superieur.domaines') }}">
                        🔬 Enseignement supérieur
                    </a>


                    <a href="{{ route('vitrine.professionnel.formations') }}">
                        💼 Formation professionnelle
                    </a>

                </div>
                {{-- Documents --}}
                <a
                    href="{{ route('documents.index') }}"
                    class="yaas-mobile-link">

                    Documents
                </a>
                {{-- À propos --}}

                <a
                    href="{{ route('home') }}#apropos"
                    class="yaas-mobile-link">

                    À propos
                </a>

                @auth

                {{-- Profil --}}

                <a
                    href="{{ route('profile.edit') }}"
                    class="yaas-mobile-link">

                    Mon profil
                </a>

                {{-- Déconnexion --}}

                <form
                    method="POST"
                    action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="yaas-btn yaas-btn-danger yaas-mobile-btn">

                        Déconnexion

                    </button>

                </form>
                @else

                {{-- Connexion --}}

                <a
                    href="{{ route('login') }}"
                    class="yaas-btn yaas-btn-outline yaas-mobile-btn">

                    Se connecter

                </a>


                {{-- Inscription --}}

                <a
                    href="{{ route('register') }}"
                    class="yaas-btn yaas-btn-primary yaas-mobile-btn">

                    Créer un compte

                </a>

                @endauth

            </div>

        </div>

    </header>



    {{-- ============================================================
     ZONE PRINCIPALE
============================================================ --}}

    <main class="yaas-app-main">

        @yield('content')

    </main>

    {{-- ============================================================
     FOOTER
============================================================ --}}

    <footer class="yaas-footer">

        <div class="yaas-container">


            <div class="yaas-footer-main">


                {{-- =================================================
                 BRAND
            ================================================== --}}

                <div class="yaas-footer-brand">

                    <a
                        href="{{ route('home') }}"
                        class="yaas-logo footer-logo">

                        <span class="yaas-logo-mark">

                            <img
                                src="{{ asset('images/logo.png') }}"
                                alt="YAA'Scientia">

                        </span>


                        <span class="yaas-logo-text">

                            <strong>
                                YAA'Scientia
                            </strong>

                            <small>
                                Bibliothèque scientifique
                            </small>

                        </span>

                    </a>
                    <p>
                        Démocratiser l'accès au savoir scientifique
                        au Burkina Faso et au-delà.
                    </p>

                </div>
                {{-- =================================================
                 EXPLORER
            ================================================== --}}

                <div>

                    <h4>
                        Explorer
                    </h4>
                    <a href="{{ route('home') }}">
                        Accueil
                    </a>
                    <a href="{{ route('documents.index') }}">
                        Bibliothèque
                    </a>

                    <a href="{{ route('home') }}#documents">
                        Publications
                    </a>


                    <a href="{{ route('home') }}#apropos">
                        À propos
                    </a>

                </div>

                {{-- =================================================
                 RESSOURCES
            ================================================== --}}
                <div>

                    <h4>
                        Ressources
                    </h4>


                    <a href="{{ route('vitrine.secondaire.index') }}">
                        Secondaire général
                    </a>


                    <a href="{{ route('vitrine.secondaire.index') }}">
                        Secondaire technique
                    </a>


                    <a href="{{ route('vitrine.superieur.domaines') }}">
                        Enseignement supérieur
                    </a>


                    <a href="{{ route('vitrine.professionnel.formations') }}">
                        Formation professionnelle
                    </a>

                </div>



                {{-- =================================================
                 CONTACT
            ================================================== --}}

                <div>

                    <h4>
                        Contact
                    </h4>


                    <p>
                        Burkina Faso
                    </p>


                    <p>
                        contact@yaascientia.bf
                    </p>


                    <a href="{{ route('contact.form') }}">
                        Nous contacter →
                    </a>

                </div>

            </div>



            {{-- =================================================
             FOOTER BOTTOM
        ================================================== --}}

            <div class="yaas-footer-bottom">

                <span>

                    © {{ date('Y') }} YAA'Scientia.
                    Tous droits réservés.

                </span>


                <span>

                    Conçu avec
                    <span class="footer-heart">♥</span>
                    au Burkina Faso

                </span>

            </div>

        </div>

    </footer>



    {{-- ============================================================
     SCRIPTS
============================================================ --}}

    @yield('scripts')

    @stack('scripts')


</body>

</html>