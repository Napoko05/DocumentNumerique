<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YAA'Scientia</title>

    @vite(['resources/scss/app.scss'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    {{-- ======================= NAVBAR ======================= --}}
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background-color: #b7e4c7;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="40" class="me-2">
                YAA'Scientia
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('livres-populaires') ? 'active' : '' }}" href="{{ url('/livres-populaires') }}">
                            Livres populaires
                        </a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="#apropos">À propos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                            profil
                        </a>
                    </li>

                </ul>

                <div class="d-flex ms-lg-3">
                    @auth
                    @php
                    $user = Auth::user();
                    if($user->hasRole('admin')){
                    $dashboardRoute = route('admin.dashboard');
                    } elseif($user->hasRole('journalist')){
                    $dashboardRoute = route('journalist.dashboard');
                    } else {
                
                    $dashboardRoute = route('home'); // utilisateur standard reste sur accueil
                    }

                    }
                    @endphp
                    <a href="{{ $dashboardRoute }}" class="btn btn-outline-success me-2">Tableau de bord</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Se déconnecter</button>
                    </form>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Se connecter</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">S’inscrire</a>
                    @endauth
                </div>

            </div>
        </div>
    </nav>

    {{-- ======================= SECTION BIENVENUE ======================= --}}
    <div class="container-fluid homepage my-5">
        <div class="row align-items-center hero-section">

            <div class="col-md-6">
                <h1 class="fw-bold">Bienvenue sur <span class="text-primary">YAA'Scientia</span></h1>
                <p class="lead">Découvrez, lisez et louez des livres numériques dans une large sélection d’œuvres scientifiques.</p>
                <a href="{{ route('books.index') }}" class="btn btn-primary">Explorer les livres</a>
            </div>

            <div class="col-md-6 text-center">
                <img src="{{ asset('images/etude.png') }}" alt="Books" class="img-fluid" />
            </div>

        </div>

        {{-- ======================= SLIDER ======================= --}}
        <div class="container mt-5">
            <h2 class="fw-bold mb-4">Livres recommandés</h2>

            <div class="d-flex align-items-center">

                <button id="prevBtn" class="btn btn-outline-secondary me-2">
                    <i class="bi bi-chevron-left fs-2"></i>
                </button>

                <div class="overflow-hidden flex-grow-1">
                    <div id="booksRow" class="d-flex gap-3">

                        <div class="card book-card text-center">
                            <img src="{{ asset('images/etude.png') }}" alt="Physique Quantique">
                            <h5 class="mt-2">Physique Quantique</h5>
                        </div>

                        <div class="card book-card text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Physique Organique">
                            <h5 class="mt-2">Physique Organique</h5>
                        </div>

                        <div class="card book-card text-center">
                            <img src="{{ asset('images/etude.png') }}" alt="Astrophysique">
                            <h5 class="mt-2">Astrophysique</h5>
                        </div>

                        <div class="card book-card text-center">
                            <img src="{{ asset('images/logo.png') }}" alt="Chimie Organique">
                            <h5 class="mt-2">Chimie Organique</h5>
                        </div>

                        <div class="card book-card text-center">
                            <img src="{{ asset('images/etude.png') }}" alt="Biologie">
                            <h5 class="mt-2">Biologie</h5>
                        </div>

                    </div>
                </div>

                <button id="nextBtn" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-chevron-right fs-2"></i>
                </button>

            </div>
        </div>
    </div>

    {{-- ======================= À PROPOS (SCROLL) ======================= --}}
    <div id="apropos" class="container py-5">

        <div class="text-center mb-5">
            <h1 class="fw-bold display-5 text-primary">À propos de <span class="text-success">YAA'Scientia</span></h1>
            <p class="lead text-muted">Une plateforme innovante pour partager et explorer le savoir scientifique.</p>
        </div>

        <div class="row align-items-center g-5">

            <div class="col-md-6 text-center">
                <img src="{{ asset('images/etude.png') }}"
                    class="img-fluid rounded-4 shadow-lg"
                    style="max-height: 400px;">
            </div>

            <div class="col-md-6">
                <h3 class="fw-bold mb-3">Notre mission</h3>

                <p class="text-muted">
                    <strong>YAA'Scientia</strong> est une bibliothèque numérique offrant un accès simplifié à des milliers d’ouvrages scientifiques.
                </p>

                <p class="text-muted">Une plateforme intuitive, moderne et évolutive.</p>

                <ul class="list-unstyled mt-4">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Large collection d’ouvrages</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Interface simple et responsive</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Recherche et location de livres</li>
                </ul>

                <div class="mt-4">
                    <a href="{{ route('contact.form') }}" class="btn btn-primary btn-lg rounded-pill shadow">
                        <i class="bi bi-envelope-fill me-2"></i> Nous contacter
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ======================= FOOTER ======================= --}}
    <footer class="footer mt-5 py-4 bg-white">
        <div class="container text-center">
            <small>© {{ date('Y') }} YAA'Scientia. Tous droits réservés.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>