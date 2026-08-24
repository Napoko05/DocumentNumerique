<footer class="ys-footer">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- =====================================================
                 PRÉSENTATION
            ====================================================== --}}

            <div>

                <div class="ys-footer-logo">

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo YAA'Scientia"
                    >

                    <span class="ys-footer-title">
                        YAA'Scientia
                    </span>

                </div>

                <p class="ys-footer-description">

                    Bibliothèque numérique scientifique.
                    Démocratiser l'accès au savoir au Burkina Faso
                    et au-delà.

                </p>

            </div>


            {{-- =====================================================
                 NAVIGATION
            ====================================================== --}}

            <div>

                <h4 class="ys-footer-heading">
                    Navigation
                </h4>

                <ul class="space-y-2 list-unstyled">

                    <li>
                        <a
                            href="{{ url('/') }}"
                            class="ys-footer-link"
                        >
                            Accueil
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('vitrine.secondaire.general.classes') }}"
                            class="ys-footer-link"
                        >
                            Livres numériques
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ url('/about') }}"
                            class="ys-footer-link"
                        >
                            À propos
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ url('/contact') }}"
                            class="ys-footer-link"
                        >
                            Contact
                        </a>
                    </li>

                </ul>

            </div>


            {{-- =====================================================
                 CONTACT
            ====================================================== --}}

            <div>

                <h4 class="ys-footer-heading">
                    Contact
                </h4>

                <ul class="space-y-2 list-unstyled">

                    <li>
                        Bobo-Dioulasso
                    </li>

                    <li>
                        Burkina Faso
                    </li>

                    <li>

                        <a
                            href="mailto:contact@yaascientia.bf"
                            class="ys-footer-link"
                        >
                            contact@yaascientia.bf
                        </a>

                    </li>

                </ul>

            </div>

        </div>


        {{-- =====================================================
             BAS DU FOOTER
        ====================================================== --}}

        <div class="ys-footer-bottom">

            <div class="flex flex-col sm:flex-row items-center justify-between gap-2">

                <p class="ys-footer-copy">
                    © {{ date('Y') }} YAA'Scientia.
                    Tous droits réservés.
                </p>

                <p class="ys-footer-copy">

                    Fait avec
                    <span aria-hidden="true">♥</span>
                    au Burkina Faso

                </p>

            </div>

        </div>

    </div>

</footer>