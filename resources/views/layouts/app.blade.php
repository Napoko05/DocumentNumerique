<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', "YAA'Scientia") }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- ✅ BOOTSTRAP CSS (DOIT ÊTRE AVANT VITE) -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- ✅ VITE (CSS perso APRÈS Bootstrap) -->
    @vite([
    'resources/css/app.css',
    'resources/scss/books.scss',
    'resources/js/app.js'
    ])
</head>

<body class="font-sans antialiased">
    <div class="min-vh-100 d-flex flex-column">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" width="40" class="me-2">
                    YAA'Scientia
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">À propos</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('books*') ? 'active' : '' }}" href="{{ route('secondary.index') }}">
                                Livres numériques
                            </a>
                        </li>

                        @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-link nav-link">Se déconnecter</button>
                            </form>
                        </li>
                        @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Se connecter</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">S’inscrire</a></li>
                        @endauth

                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenu -->
        <main class="flex-grow-1 py-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-light text-center py-3 mt-auto shadow-sm">
            <small>© {{ date('Y') }} YAA'Scientia. Tous droits réservés.</small>
        </footer>

    </div>

    <!-- ✅ BOOTSTRAP JS (AVANT </body>) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous">
    </script>

</body>

</html>