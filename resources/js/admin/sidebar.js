/*
|--------------------------------------------------------------------------
| YAA'SCIENTIA — SIDEBAR ADMIN JAVASCRIPT
|--------------------------------------------------------------------------
| Gestion native JavaScript du sidebar administrateur.
|
| Aucun Alpine.js.
| Compatible avec les classes CSS existantes.
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | ÉLÉMENTS PRINCIPAUX
    |--------------------------------------------------------------------------
    */

    const sidebar = document.getElementById('adminSidebar');
    const mobileToggle = document.getElementById('adminMobileToggle');
    const overlay = document.getElementById('adminSidebarOverlay');

    /*
    |--------------------------------------------------------------------------
    | VÉRIFICATION
    |--------------------------------------------------------------------------
    */

    if (!sidebar) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | SIDEBAR MOBILE
    |--------------------------------------------------------------------------
    */

    function openMobileSidebar() {
        document.body.classList.add('admin-sidebar-open');

        if (mobileToggle) {
            mobileToggle.setAttribute('aria-expanded', 'true');
            mobileToggle.setAttribute('aria-label', 'Fermer le menu');
        }

        if (overlay) {
            overlay.classList.add('active');
        }
    }


    function closeMobileSidebar() {
        document.body.classList.remove('admin-sidebar-open');

        if (mobileToggle) {
            mobileToggle.setAttribute('aria-expanded', 'false');
            mobileToggle.setAttribute('aria-label', 'Ouvrir le menu');
        }

        if (overlay) {
            overlay.classList.remove('active');
        }
    }


    function toggleMobileSidebar() {
        if (document.body.classList.contains('admin-sidebar-open')) {
            closeMobileSidebar();
        } else {
            openMobileSidebar();
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BOUTON HAMBURGER
    |--------------------------------------------------------------------------
    */

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function (event) {
            event.preventDefault();

            toggleMobileSidebar();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | OVERLAY
    |--------------------------------------------------------------------------
    */

    if (overlay) {
        overlay.addEventListener('click', function () {
            closeMobileSidebar();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | TOUCHE ÉCHAP
    |--------------------------------------------------------------------------
    */

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeMobileSidebar();
        }

    });


    /*
    |--------------------------------------------------------------------------
    | FERMER LE SIDEBAR APRÈS CLIC SUR UN LIEN MOBILE
    |--------------------------------------------------------------------------
    */

    const sidebarLinks = sidebar.querySelectorAll('a');

    sidebarLinks.forEach(function (link) {

        link.addEventListener('click', function () {

            /*
            | On ferme uniquement sur mobile/tablette.
            */
            if (window.innerWidth <= 991) {
                closeMobileSidebar();
            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | GESTION DES SOUS-MENUS PRINCIPAUX
    |--------------------------------------------------------------------------
    |
    | Menus concernés :
    |
    | 1. Utilisateurs
    | 2. Journalistes
    | 3. Enseignement secondaire
    | 4. Enseignement supérieur
    |
    |--------------------------------------------------------------------------
    */

    const submenuButtons = sidebar.querySelectorAll(
        '[data-admin-submenu-toggle]'
    );


    /*
    |--------------------------------------------------------------------------
    | OBTENIR LE SOUS-MENU ASSOCIÉ
    |--------------------------------------------------------------------------
    */

    function getSubmenu(menuName) {

        return sidebar.querySelector(
            '[data-admin-submenu="' + menuName + '"]'
        );

    }


    /*
    |--------------------------------------------------------------------------
    | FERMER TOUS LES SOUS-MENUS
    |--------------------------------------------------------------------------
    */

    function closeAllSubmenus(exceptMenu = null) {

        submenuButtons.forEach(function (button) {

            const menuName = button.getAttribute(
                'data-admin-submenu-toggle'
            );

            /*
            | Ne pas fermer le menu demandé.
            */
            if (exceptMenu && menuName === exceptMenu) {
                return;
            }

            const submenu = getSubmenu(menuName);

            if (submenu) {
                submenu.style.display = 'none';
            }


            /*
            | Mettre aria-expanded à false.
            */
            button.setAttribute('aria-expanded', 'false');


            /*
            | Retirer la rotation de la flèche.
            */
            const arrow = button.querySelector('.admin-nav-arrow');

            if (arrow) {
                arrow.classList.remove('rotate');
            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | OUVRIR UN SOUS-MENU
    |--------------------------------------------------------------------------
    */

    function openSubmenu(button, submenu) {

        submenu.style.display = 'block';

        button.setAttribute('aria-expanded', 'true');


        /*
        | Rotation de la flèche.
        */
        const arrow = button.querySelector('.admin-nav-arrow');

        if (arrow) {
            arrow.classList.add('rotate');
        }

    }


    /*
    |--------------------------------------------------------------------------
    | FERMER UN SOUS-MENU
    |--------------------------------------------------------------------------
    */

    function closeSubmenu(button, submenu) {

        submenu.style.display = 'none';

        button.setAttribute('aria-expanded', 'false');


        /*
        | Remettre la flèche dans sa position normale.
        */
        const arrow = button.querySelector('.admin-nav-arrow');

        if (arrow) {
            arrow.classList.remove('rotate');
        }

    }


    /*
    |--------------------------------------------------------------------------
    | CLIQUE SUR LES MENUS PRINCIPAUX
    |--------------------------------------------------------------------------
    */

    submenuButtons.forEach(function (button) {

        button.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();


            /*
            | Nom du menu :
            |
            | users
            | journalistes
            | secondaire
            | superieur
            */
            const menuName = button.getAttribute(
                'data-admin-submenu-toggle'
            );


            /*
            | Récupérer le sous-menu.
            */
            const submenu = getSubmenu(menuName);


            if (!submenu) {
                return;
            }


            /*
            | Vérifier si le menu est actuellement ouvert.
            */
            const isOpen =
                submenu.style.display !== 'none';


            /*
            |--------------------------------------------------------------------------
            | SI LE MENU EST OUVERT
            |--------------------------------------------------------------------------
            |
            | Deuxième clic = fermeture.
            |--------------------------------------------------------------------------
            */

            if (isOpen) {

                closeSubmenu(button, submenu);

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | SI LE MENU EST FERMÉ
            |--------------------------------------------------------------------------
            |
            | On ferme les autres puis on ouvre celui-ci.
            |--------------------------------------------------------------------------
            */

            closeAllSubmenus(menuName);

            openSubmenu(button, submenu);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | INITIALISATION DES SOUS-MENUS
    |--------------------------------------------------------------------------
    |
    | Permet de synchroniser aria-expanded et la flèche avec
    | le display défini dans Blade.
    |--------------------------------------------------------------------------
    */

    submenuButtons.forEach(function (button) {

        const menuName = button.getAttribute(
            'data-admin-submenu-toggle'
        );

        const submenu = getSubmenu(menuName);

        if (!submenu) {
            return;
        }


        /*
        | Si Blade laisse le sous-menu ouvert :
        */
        if (submenu.style.display !== 'none') {

            button.setAttribute('aria-expanded', 'true');

            const arrow = button.querySelector(
                '.admin-nav-arrow'
            );

            if (arrow) {
                arrow.classList.add('rotate');
            }

        } else {

            button.setAttribute('aria-expanded', 'false');

        }

    });


    /*
    |--------------------------------------------------------------------------
    | REDIMENSIONNEMENT DE LA FENÊTRE
    |--------------------------------------------------------------------------
    |
    | Si on passe du mobile au desktop, on retire l'état mobile.
    |--------------------------------------------------------------------------
    */

    window.addEventListener('resize', function () {

        if (window.innerWidth > 991) {
            closeMobileSidebar();
        }

    });


    /*
    |--------------------------------------------------------------------------
    | EMPÊCHER LE SCROLL DE LA PAGE QUAND LE SIDEBAR MOBILE EST OUVERT
    |--------------------------------------------------------------------------
    */

    function updateBodyScroll() {

        if (
            window.innerWidth <= 991 &&
            document.body.classList.contains('admin-sidebar-open')
        ) {

            document.body.style.overflow = 'hidden';

        } else {

            document.body.style.overflow = '';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SURVEILLER L'ÉTAT DU SIDEBAR
    |--------------------------------------------------------------------------
    */

    const sidebarObserver = new MutationObserver(function () {
        updateBodyScroll();
    });


    sidebarObserver.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });


    /*
    |--------------------------------------------------------------------------
    | INITIALISATION
    |--------------------------------------------------------------------------
    */

    updateBodyScroll();

});