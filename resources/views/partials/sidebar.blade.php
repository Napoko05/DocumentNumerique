{{-- =========================================================
     SIDEBAR / NAVIGATION YAA'SCIENTIA
========================================================= --}}

<aside class="ys-sidebar">

    {{-- =====================================================
         HEADER / LOGO
    ====================================================== --}}

    <div class="ys-sidebar-header">

        <a
            href="{{ route('home') }}"
            class="ys-sidebar-logo"
        >

            <span class="ys-sidebar-logo-mark">

                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="YAA'Scientia"
                >

            </span>

            <span class="ys-sidebar-logo-text">

                <strong>
                    YAA'Scientia
                </strong>

                <small>
                    Bibliothèque scientifique
                </small>

            </span>

        </a>

    </div>


    {{-- =====================================================
         NAVIGATION
    ====================================================== --}}

    <nav class="ys-sidebar-nav">


        {{-- =================================================
             ACCUEIL
        ================================================== --}}

        <a
            href="{{ route('home') }}"
            class="ys-sidebar-link
                {{ request()->routeIs('home') ? 'active' : '' }}"
        >

            <span class="ys-sidebar-icon">
                <i class="bi bi-house"></i>
            </span>

            <span>
                Accueil
            </span>

        </a>



        {{-- =================================================
             BIBLIOTHÈQUE
        ================================================== --}}

        <div class="ys-sidebar-section">

            <div class="ys-sidebar-section-title">

                <span>
                    Bibliothèque
                </span>

            </div>


            {{-- Secondaire général --}}

            <a
                href="{{ route('vitrine.secondaire.general.classes') }}"
                class="ys-sidebar-link
                    {{ request()->routeIs('vitrine.secondaire.general.*')
                        ? 'active'
                        : '' }}"
            >

                <span class="ys-sidebar-icon">
                    <i class="bi bi-book"></i>
                </span>

                <span>
                    Secondaire général
                </span>

            </a>


            {{-- Secondaire technique --}}

            <a
                href="{{ route('vitrine.secondaire.technique.classes') }}"
                class="ys-sidebar-link
                    {{ request()->routeIs('vitrine.secondaire.technique.*')
                        ? 'active'
                        : '' }}"
            >

                <span class="ys-sidebar-icon">
                    <i class="bi bi-gear"></i>
                </span>

                <span>
                    Secondaire technique
                </span>

            </a>


            {{-- Supérieur --}}

            <a
                href="{{ route('vitrine.superieur.domaines') }}"
                class="ys-sidebar-link
                    {{ request()->routeIs('vitrine.superieur.*')
                        ? 'active'
                        : '' }}"
            >

                <span class="ys-sidebar-icon">
                    <i class="bi bi-mortarboard"></i>
                </span>

                <span>
                    Enseignement supérieur
                </span>

            </a>


            {{-- Professionnel --}}

            <a
                href="{{ route('vitrine.professionnel.formations') }}"
                class="ys-sidebar-link
                    {{ request()->routeIs('vitrine.professionnel.*')
                        ? 'active'
                        : '' }}"
            >

                <span class="ys-sidebar-icon">
                    <i class="bi bi-briefcase"></i>
                </span>

                <span>
                    Formation professionnelle
                </span>

            </a>

        </div>



        {{-- =================================================
             DOCUMENTS
        ================================================== --}}

        <a
            href="{{ route('documents.index') }}"
            class="ys-sidebar-link
                {{ request()->routeIs('documents.*')
                    ? 'active'
                    : '' }}"
        >

            <span class="ys-sidebar-icon">
                <i class="bi bi-files"></i>
            </span>

            <span>
                Documents
            </span>

        </a>



        {{-- =================================================
             À PROPOS
        ================================================== --}}

        <a
            href="{{ route('home') }}#apropos"
            class="ys-sidebar-link"
        >

            <span class="ys-sidebar-icon">
                <i class="bi bi-info-circle"></i>
            </span>

            <span>
                À propos
            </span>

        </a>



        {{-- =================================================
             ESPACE PERSONNEL
        ================================================== --}}

        @auth

            <div class="ys-sidebar-divider"></div>

            <div class="ys-sidebar-section-title">

                Mon compte

            </div>


            {{-- Profil --}}

            <a
                href="{{ route('profile.edit') }}"
                class="ys-sidebar-link
                    {{ request()->routeIs('profile.*')
                        ? 'active'
                        : '' }}"
            >

                <span class="ys-sidebar-icon">
                    <i class="bi bi-person"></i>
                </span>

                <span>
                    Mon profil
                </span>

            </a>


            {{-- Déconnexion --}}

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="ys-sidebar-form"
            >

                @csrf

                <button
                    type="submit"
                    class="ys-sidebar-link ys-sidebar-logout"
                >

                    <span class="ys-sidebar-icon">
                        <i class="bi bi-box-arrow-right"></i>
                    </span>

                    <span>
                        Se déconnecter
                    </span>

                </button>

            </form>

        @endauth

    </nav>



    {{-- =====================================================
         FOOTER SIDEBAR
    ====================================================== --}}

    <div class="ys-sidebar-footer">

        @guest

            <a
                href="{{ route('login') }}"
                class="ys-sidebar-login"
            >

                <i class="bi bi-box-arrow-in-right"></i>

                Se connecter

            </a>


            <a
                href="{{ route('register') }}"
                class="ys-sidebar-register"
            >

                <i class="bi bi-person-plus"></i>

                Créer un compte

            </a>

        @else

            <div class="ys-sidebar-user">

                <div class="ys-sidebar-user-avatar">

                    <i class="bi bi-person"></i>

                </div>

                <div class="ys-sidebar-user-info">

                    <strong>
                        {{ auth()->user()->prenom ?? auth()->user()->name }}
                    </strong>

                    <small>
                        Compte utilisateur
                    </small>

                </div>

            </div>

        @endguest

    </div>

</aside>