<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, viewport-fit=cover">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description"
        content="YAA'Scientia, bibliothèque numérique scientifique pour étudiants, enseignants, chercheurs et professionnels.">

    <meta name="theme-color" content="#071A33">

    <title>YAA'Scientia — Le savoir sans frontières</title>

    @vite([
        'resources/css/app.css',
        'resources/css/yaascientia-home.css',
        'resources/js/app.js',
        'resources/js/yaascientia-home.js'
    ])
</head>

<body class="yaas-page">

@php
    $dashboardRoute = route('home');

    if (auth()->check()) {

        if (auth()->user()->hasRole('admin')) {
            $dashboardRoute = route('admin.dashboard');

        } elseif (auth()->user()->hasRole('journalist')) {
            $dashboardRoute = route('journalist.dashboard');
        }
    }
@endphp


{{-- ========================================================= --}}
{{-- NAVBAR --}}
{{-- ========================================================= --}}

<header class="yaas-navbar">

    <div class="yaas-container yaas-navbar-inner">

        {{-- LOGO --}}
        <a href="{{ route('home') }}"
           class="yaas-logo">

            <span class="yaas-logo-mark">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="YAA'Scientia">
            </span>

            <span class="yaas-logo-text">
                <strong>YAA'Scientia</strong>
                <small>Bibliothèque scientifique</small>
            </span>

        </a>


        {{-- NAVIGATION DESKTOP --}}
        <nav class="yaas-main-nav">

            <a href="{{ route('home') }}"
               class="yaas-nav-link active">
                Accueil
            </a>


            <div class="yaas-nav-dropdown">

                <button
                    type="button"
                    class="yaas-nav-link yaas-dropdown-trigger">

                    <span>Bibliothèque</span>

                    <svg viewBox="0 0 24 24">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>

                </button>


                <div class="yaas-dropdown-menu">

                    <a href="{{ route('vitrine.secondaire.general.classes') }}"
                       class="yaas-dropdown-item">

                        <span class="yaas-dropdown-icon blue">
                            🎓
                        </span>

                        <span>
                            <strong>Secondaire général</strong>
                            <small>6e à Terminale</small>
                        </span>

                    </a>


                    <a href="{{ route('vitrine.secondaire.technique.classes') }}"
                       class="yaas-dropdown-item">

                        <span class="yaas-dropdown-icon orange">
                            ⚙
                        </span>

                        <span>
                            <strong>Secondaire technique</strong>
                            <small>BT · CAP · BEP</small>
                        </span>

                    </a>


                    <a href="{{ route('vitrine.superieur.domaines') }}"
                       class="yaas-dropdown-item">

                        <span class="yaas-dropdown-icon green">
                            🔬
                        </span>

                        <span>
                            <strong>Enseignement supérieur</strong>
                            <small>Licence · Master · Doctorat</small>
                        </span>

                    </a>


                    <a href="{{ route('vitrine.professionnel.formations') }}"
                       class="yaas-dropdown-item">

                        <span class="yaas-dropdown-icon purple">
                            💼
                        </span>

                        <span>
                            <strong>Formation professionnelle</strong>
                            <small>Formations spécialisées</small>
                        </span>

                    </a>

                </div>

            </div>


            <a href="#documents"
               class="yaas-nav-link">
                Documents
            </a>


            <a href="#apropos"
               class="yaas-nav-link">
                À propos
            </a>


            @auth
                <a href="{{ route('profile.edit') }}"
                   class="yaas-nav-link">
                    Profil
                </a>
            @endauth

        </nav>


        {{-- ACTIONS --}}
        <div class="yaas-navbar-actions">

            @auth

                <a href="{{ $dashboardRoute }}"
                   class="yaas-btn yaas-btn-outline">
                    Tableau de bord
                </a>

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="yaas-btn yaas-btn-dark">
                        Déconnexion
                    </button>

                </form>

            @else

                <a href="{{ route('login') }}"
                   class="yaas-btn yaas-btn-text">
                    Connexion
                </a>

                <a href="{{ route('register') }}"
                   class="yaas-btn yaas-btn-primary">
                    Créer un compte
                </a>

            @endauth

        </div>


        {{-- MOBILE BUTTON --}}
        <button
            type="button"
            class="yaas-mobile-toggle"
            id="yaas-mobile-toggle"
            aria-label="Ouvrir le menu">

            <span></span>
            <span></span>
            <span></span>

        </button>

    </div>


    {{-- MOBILE NAVIGATION --}}
    <div
        class="yaas-mobile-menu"
        id="yaas-mobile-menu">

        <div class="yaas-mobile-inner">

            <a href="{{ route('home') }}"
               class="yaas-mobile-link">
                Accueil
            </a>

            <div class="yaas-mobile-section">

                <span>Bibliothèque</span>

                <a href="{{ route('vitrine.secondaire.general.classes') }}">
                    Secondaire général
                </a>

                <a href="{{ route('vitrine.secondaire.technique.classes') }}">
                    Secondaire technique
                </a>

                <a href="{{ route('vitrine.superieur.domaines') }}">
                    Enseignement supérieur
                </a>

                <a href="{{ route('vitrine.professionnel.formations') }}">
                    Formation professionnelle
                </a>

            </div>


            <a href="#documents"
               class="yaas-mobile-link">
                Documents
            </a>


            <a href="#apropos"
               class="yaas-mobile-link">
                À propos
            </a>


            @auth

                <a href="{{ route('profile.edit') }}"
                   class="yaas-mobile-link">
                    Mon profil
                </a>

                <a href="{{ $dashboardRoute }}"
                   class="yaas-btn yaas-btn-primary yaas-mobile-btn">
                    Tableau de bord
                </a>

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="yaas-btn yaas-btn-danger yaas-mobile-btn">
                        Déconnexion
                    </button>

                </form>

            @else

                <a href="{{ route('login') }}"
                   class="yaas-btn yaas-btn-outline yaas-mobile-btn">
                    Se connecter
                </a>

                <a href="{{ route('register') }}"
                   class="yaas-btn yaas-btn-primary yaas-mobile-btn">
                    Créer un compte
                </a>

            @endauth

        </div>

    </div>

</header>



{{-- ========================================================= --}}
{{-- HERO --}}
{{-- ========================================================= --}}

<main>

<section class="yaas-hero">

    <div class="yaas-hero-grid"></div>

    <div class="yaas-hero-glow yaas-glow-one"></div>
    <div class="yaas-hero-glow yaas-glow-two"></div>


    <div class="yaas-container yaas-hero-container">

        <div class="yaas-hero-content">

            <div class="yaas-eyebrow">

                <span class="yaas-eyebrow-dot"></span>

                Bibliothèque numérique scientifique

            </div>


            <h1>

                Le savoir qui
                <span>transforme</span>
                votre avenir.

            </h1>


            <p class="yaas-hero-description">

                Explorez une nouvelle génération de bibliothèque
                numérique conçue pour les étudiants, enseignants,
                chercheurs et professionnels.

            </p>


            {{-- SEARCH --}}
            <form
                action="{{ route('documents.index') }}"
                method="GET"
                class="yaas-search">

                <div class="yaas-search-icon">

                    <svg viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7"/>
                        <path d="m20 20-4-4"/>
                    </svg>

                </div>


                <input
                    type="search"
                    name="search"
                    placeholder="Rechercher un livre, une matière, un document..."
                    autocomplete="off">


                <button type="submit">
                    Rechercher
                </button>

            </form>


            <div class="yaas-hero-actions">

                <a href="{{ route('documents.index') }}"
                   class="yaas-btn yaas-btn-primary yaas-btn-large">

                    Explorer la bibliothèque

                    <svg viewBox="0 0 24 24">
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>

                </a>


                <a href="#documents"
                   class="yaas-btn yaas-btn-light yaas-btn-large">

                    Découvrir les nouveautés

                </a>

            </div>


            {{-- STATS --}}
            <div class="yaas-hero-stats">

                <div>
                    <strong>1K<span>+</span></strong>
                    <small>Documents</small>
                </div>

                <div>
                    <strong>10<span>+</span></strong>
                    <small>Disciplines</small>
                </div>

                <div>
                    <strong>24<span>/7</span></strong>
                    <small>Accessible</small>
                </div>

            </div>

        </div>


        {{-- HERO VISUAL --}}
        <div class="yaas-hero-visual">

            <div class="yaas-orbit orbit-one"></div>
            <div class="yaas-orbit orbit-two"></div>


            <div class="yaas-book-scene">

                <div class="yaas-floating-card card-top">

                    <span>📚</span>

                    <div>
                        <strong>Bibliothèque</strong>
                        <small>+1 000 ressources</small>
                    </div>

                </div>


                <div class="yaas-book">

                    <div class="yaas-book-page left-page">

                        <span class="book-line large"></span>
                        <span class="book-line"></span>
                        <span class="book-line"></span>
                        <span class="book-line short"></span>

                        <div class="book-formula">
                            ∫ f(x) dx
                        </div>

                    </div>


                    <div class="yaas-book-page right-page">

                        <span class="book-line large"></span>
                        <span class="book-line"></span>
                        <span class="book-line"></span>
                        <span class="book-line short"></span>

                        <div class="book-chart">

                            <i></i>
                            <i></i>
                            <i></i>
                            <i></i>
                            <i></i>

                        </div>

                    </div>

                </div>


                <div class="yaas-floating-card card-bottom">

                    <span>⚡</span>

                    <div>
                        <strong>Accès rapide</strong>
                        <small>Étudiez partout</small>
                    </div>

                </div>


                <div class="yaas-science-symbol symbol-one">
                    ∑
                </div>

                <div class="yaas-science-symbol symbol-two">
                    π
                </div>

                <div class="yaas-science-symbol symbol-three">
                    λ
                </div>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- TRUST BAR --}}
{{-- ========================================================= --}}

<section class="yaas-trust">

    <div class="yaas-container">

        <div class="yaas-trust-inner">

            <span>Une plateforme pensée pour :</span>

            <div>
                🎓 Étudiants
            </div>

            <div>
                👨‍🏫 Enseignants
            </div>

            <div>
                🔬 Chercheurs
            </div>

            <div>
                💼 Professionnels
            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- CATEGORIES --}}
{{-- ========================================================= --}}

<section class="yaas-section yaas-categories">

    <div class="yaas-container">

        <div class="yaas-section-heading">

            <div>

                <span class="yaas-section-label">
                    Explorer
                </span>

                <h2>
                    Un savoir organisé<br>
                    <span>pour chaque parcours.</span>
                </h2>

            </div>


            <p>
                Accédez rapidement aux ressources adaptées
                à votre niveau d'étude et à votre domaine.
            </p>

        </div>


        <div class="yaas-category-grid">


            <a href="{{ route('vitrine.secondaire.general.classes') }}"
               class="yaas-category-card category-blue">

                <div class="category-number">
                    01
                </div>

                <div class="category-icon">
                    🎓
                </div>

                <h3>
                    Secondaire général
                </h3>

                <p>
                    De la 6e à la Terminale
                </p>

                <span class="category-arrow">
                    →
                </span>

            </a>


            <a href="{{ route('vitrine.secondaire.technique.classes', ['level' => 'bt']) }}"
               class="yaas-category-card category-orange">

                <div class="category-number">
                    02
                </div>

                <div class="category-icon">
                    ⚙
                </div>

                <h3>
                    Secondaire technique
                </h3>

                <p>
                    BT · CAP · BEP
                </p>

                <span class="category-arrow">
                    →
                </span>

            </a>


            <a href="{{ route('vitrine.superieur.domaines') }}"
               class="yaas-category-card category-green">

                <div class="category-number">
                    03
                </div>

                <div class="category-icon">
                    🔬
                </div>

                <h3>
                    Enseignement supérieur
                </h3>

                <p>
                    Licence · Master · Doctorat
                </p>

                <span class="category-arrow">
                    →
                </span>

            </a>


            <a href="{{ route('vitrine.professionnel.formations') }}"
               class="yaas-category-card category-purple">

                <div class="category-number">
                    04
                </div>

                <div class="category-icon">
                    💼
                </div>

                <h3>
                    Formation professionnelle
                </h3>

                <p>
                    Développez vos compétences
                </p>

                <span class="category-arrow">
                    →
                </span>

            </a>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- DOCUMENTS RECENTS --}}
{{-- ========================================================= --}}

<section
    id="documents"
    class="yaas-section yaas-documents">

    <div class="yaas-container">

        <div class="yaas-section-heading">

            <div>

                <span class="yaas-section-label">
                    Bibliothèque
                </span>

                <h2>
                    Les dernières
                    <span>publications.</span>
                </h2>

            </div>


            <a href="{{ route('documents.index') }}"
               class="yaas-text-link">

                Voir toute la bibliothèque

                <span>→</span>

            </a>

        </div>


        <div class="yaas-document-grid">

            @forelse($latestDocuments as $document)

                <article class="yaas-document-card">

                    <div class="document-cover">

                        @if($document->cover_image)

                            <img
                                src="{{ asset('storage/'.$document->cover_image) }}"
                                alt="{{ $document->title }}"
                                loading="lazy">

                        @else

                            <div class="document-cover-placeholder">
                                📖
                            </div>

                        @endif


                        <div class="document-type">

                            @if($document->access_type === 'premium')
                                <span class="premium">
                                    PREMIUM
                                </span>
                            @else
                                <span class="free">
                                    GRATUIT
                                </span>
                            @endif

                        </div>

                    </div>


                    <div class="document-content">

                        <div class="document-meta">

                            <span>
                                📄 Document scientifique
                            </span>

                            <span>
                                👁 {{ $document->views }}
                            </span>

                        </div>


                        <h3>
                            {{ $document->title }}
                        </h3>


                        <p>
                            {{ Str::limit($document->description, 110) }}
                        </p>


                        <a href="{{ route('documents.show', $document) }}"
                           class="document-button">

                            Consulter

                            <span>→</span>

                        </a>

                    </div>

                </article>

            @empty

                <div class="yaas-empty-state">

                    <div>
                        📚
                    </div>

                    <h3>
                        Aucun document pour le moment
                    </h3>

                    <p>
                        Les prochaines publications apparaîtront ici.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- PREMIUM --}}
{{-- ========================================================= --}}

<section class="yaas-premium">

    <div class="yaas-container">

        <div class="yaas-premium-box">

            <div class="premium-decoration"></div>

            <div class="premium-content">

                <span class="yaas-section-label light">
                    Collection premium
                </span>

                <h2>
                    Allez plus loin<br>
                    dans votre apprentissage.
                </h2>

                <p>
                    Découvrez des documents spécialisés,
                    des ouvrages avancés et des ressources
                    exclusives pour approfondir vos connaissances.
                </p>

                <a href="{{ route('documents.index') }}"
                   class="yaas-btn yaas-btn-white">

                    Explorer Premium

                    <span>→</span>

                </a>

            </div>


            <div class="premium-visual">

                <div class="premium-card pc-one">
                    📘
                </div>

                <div class="premium-card pc-two">
                    🔬
                </div>

                <div class="premium-card pc-three">
                    📚
                </div>

            </div>

        </div>

    </div>

</section>



{{-- ========================================================= --}}
{{-- A PROPOS --}}
{{-- ========================================================= --}}

<section
    id="apropos"
    class="yaas-section yaas-about">

    <div class="yaas-container">

        <div class="yaas-about-grid">

            <div class="yaas-about-visual">

                <div class="about-image-frame">

                    <img
                        src="{{ asset('images/etude.png') }}"
                        alt="Étude et apprentissage"
                        loading="lazy">

                </div>


                <div class="about-floating-stat">

                    <strong>24/7</strong>

                    <span>
                        Le savoir<br>
                        à portée de main
                    </span>

                </div>

            </div>


            <div class="yaas-about-content">

                <span class="yaas-section-label">
                    Notre vision
                </span>

                <h2>
                    Construire une génération
                    <span>qui apprend.</span>
                </h2>


                <p class="about-lead">

                    YAA'Scientia est une bibliothèque numérique
                    pensée pour rendre le savoir scientifique
                    plus accessible, plus organisé et plus proche
                    de chaque apprenant.

                </p>


                <div class="about-features">

                    <div>
                        <span>✓</span>

                        <div>
                            <strong>
                                Ressources de qualité
                            </strong>

                            <p>
                                Une collection organisée
                                pour faciliter vos recherches.
                            </p>
                        </div>
                    </div>


                    <div>
                        <span>✓</span>

                        <div>
                            <strong>
                                Accessible partout
                            </strong>

                            <p>
                                Étudiez depuis votre téléphone,
                                tablette ou ordinateur.
                            </p>
                        </div>
                    </div>


                    <div>
                        <span>✓</span>

                        <div>
                            <strong>
                                Pensée pour l'avenir
                            </strong>

                            <p>
                                Une plateforme numérique moderne
                                qui évolue avec vos besoins.
                            </p>
                        </div>
                    </div>

                </div>


                <a href="{{ route('contact.form') }}"
                   class="yaas-btn yaas-btn-primary">

                    Nous contacter

                    <span>→</span>

                </a>

            </div>

        </div>

    </div>

</section>

</main>



{{-- ========================================================= --}}
{{-- FOOTER --}}
{{-- ========================================================= --}}

<footer class="yaas-footer">

    <div class="yaas-container">

        <div class="yaas-footer-main">

            <div class="yaas-footer-brand">

                <a href="{{ route('home') }}"
                   class="yaas-logo footer-logo">

                    <span class="yaas-logo-mark">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="YAA'Scientia">
                    </span>

                    <span class="yaas-logo-text">
                        <strong>YAA'Scientia</strong>
                        <small>Bibliothèque scientifique</small>
                    </span>

                </a>


                <p>
                    Démocratiser l'accès au savoir scientifique
                    au Burkina Faso et au-delà.
                </p>

            </div>


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

                <a href="#documents">
                    Publications
                </a>

                <a href="#apropos">
                    À propos
                </a>

            </div>


            <div>

                <h4>
                    Ressources
                </h4>

                <a href="{{ route('vitrine.secondaire.general.classes') }}">
                    Secondaire général
                </a>

                <a href="{{ route('vitrine.superieur.domaines') }}">
                    Enseignement supérieur
                </a>

                <a href="{{ route('vitrine.professionnel.formations') }}">
                    Formation professionnelle
                </a>

            </div>


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


        <div class="yaas-footer-bottom">

            <span>
                © {{ date('Y') }} YAA'Scientia.
                Tous droits réservés.
            </span>

            <span>
                Conçu avec ♥ au Burkina Faso
            </span>

        </div>

    </div>

</footer>

</body>
</html>