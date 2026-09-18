document.addEventListener('DOMContentLoaded', function () {

    const dropdowns = document.querySelectorAll('.yaas-nav-dropdown');

    if (!dropdowns.length) {
        return;
    }

    dropdowns.forEach(function (dropdown) {

        const trigger = dropdown.querySelector('.yaas-dropdown-trigger');
        const menu = dropdown.querySelector('.yaas-dropdown-menu');

        if (!trigger || !menu) {
            return;
        }

        /*
         * Ouverture / fermeture au clic
         */
        trigger.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            const isOpen = dropdown.classList.contains('open');

            // Fermer tous les autres dropdowns
            dropdowns.forEach(function (otherDropdown) {

                otherDropdown.classList.remove('open');

                const otherTrigger =
                    otherDropdown.querySelector('.yaas-dropdown-trigger');

                if (otherTrigger) {
                    otherTrigger.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                }
            });

            // Ouvrir celui qui vient d'être cliqué
            if (!isOpen) {

                dropdown.classList.add('open');

                trigger.setAttribute(
                    'aria-expanded',
                    'true'
                );
            }

        });


        /*
         * Empêche le clic dans le menu de fermer
         * immédiatement le dropdown
         */
        menu.addEventListener('click', function (event) {

            event.stopPropagation();

        });

    });


    /*
     * Clic en dehors :
     * fermeture de tous les dropdowns
     */
    document.addEventListener('click', function () {

        dropdowns.forEach(function (dropdown) {

            dropdown.classList.remove('open');

            const trigger =
                dropdown.querySelector('.yaas-dropdown-trigger');

            if (trigger) {

                trigger.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

        });

    });


    /*
     * Touche Échap :
     * fermeture des dropdowns
     */
    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        dropdowns.forEach(function (dropdown) {

            dropdown.classList.remove('open');

            const trigger =
                dropdown.querySelector('.yaas-dropdown-trigger');

            if (trigger) {

                trigger.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }

        });

    });

});
