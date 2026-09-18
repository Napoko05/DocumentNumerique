/* =========================================================
   YAA'SCIENTIA
   HOMEPAGE JAVASCRIPT
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /* =====================================================
       MOBILE MENU
       ===================================================== */

    const mobileToggle =
        document.getElementById('yaas-mobile-toggle');

    const mobileMenu =
        document.getElementById('yaas-mobile-menu');

    if (mobileToggle && mobileMenu) {

        mobileToggle.addEventListener('click', () => {

            const isOpen =
                mobileMenu.classList.toggle('open');

            mobileToggle.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );

            mobileToggle.setAttribute(
                'aria-label',
                isOpen
                    ? 'Fermer le menu'
                    : 'Ouvrir le menu'
            );

            const bars =
                mobileToggle.querySelectorAll('span');

            if (bars.length >= 3) {

                if (isOpen) {

                    bars[0].style.transform =
                        'translateY(7px) rotate(45deg)';

                    bars[1].style.opacity = '0';

                    bars[2].style.transform =
                        'translateY(-7px) rotate(-45deg)';

                } else {

                    bars[0].style.transform = '';
                    bars[1].style.opacity = '';
                    bars[2].style.transform = '';

                }
            }
        });


        mobileMenu
            .querySelectorAll('a')
            .forEach(link => {

                link.addEventListener('click', () => {

                    mobileMenu.classList.remove('open');

                    mobileToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                    const bars =
                        mobileToggle.querySelectorAll('span');

                    if (bars.length >= 3) {

                        bars[0].style.transform = '';
                        bars[1].style.opacity = '';
                        bars[2].style.transform = '';

                    }
                });
            });
    }


    /* =====================================================
       DROPDOWNS
       BIBLIOTHÈQUE + PROFIL
       ===================================================== */

    const dropdowns =
        document.querySelectorAll('.yaas-nav-dropdown');


    if (dropdowns.length) {

        const closeDropdown = dropdown => {

            dropdown.classList.remove('open');

            const trigger =
                dropdown.querySelector(
                    '.yaas-dropdown-trigger'
                );

            if (trigger) {

                trigger.setAttribute(
                    'aria-expanded',
                    'false'
                );
            }
        };


        const closeAllDropdowns = () => {

            dropdowns.forEach(dropdown => {
                closeDropdown(dropdown);
            });
        };


        const openDropdown = dropdown => {

            dropdowns.forEach(otherDropdown => {

                if (otherDropdown !== dropdown) {
                    closeDropdown(otherDropdown);
                }

            });


            dropdown.classList.add('open');

            const trigger =
                dropdown.querySelector(
                    '.yaas-dropdown-trigger'
                );

            if (trigger) {

                trigger.setAttribute(
                    'aria-expanded',
                    'true'
                );
            }
        };


        dropdowns.forEach(dropdown => {

            const trigger =
                dropdown.querySelector(
                    '.yaas-dropdown-trigger'
                );

            const menu =
                dropdown.querySelector(
                    '.yaas-dropdown-menu'
                );


            if (!trigger || !menu) {
                return;
            }


            trigger.setAttribute(
                'aria-expanded',
                dropdown.classList.contains('open')
                    ? 'true'
                    : 'false'
            );


            /* ---------------------------------------------
               CLIC SUR LE BOUTON
               --------------------------------------------- */

            trigger.addEventListener('click', event => {

                event.preventDefault();
                event.stopPropagation();

                const isOpen =
                    dropdown.classList.contains('open');


                if (isOpen) {

                    closeDropdown(dropdown);

                } else {

                    openDropdown(dropdown);

                }

            });


            /* ---------------------------------------------
               CLIC DANS LE MENU
               --------------------------------------------- */

            menu.addEventListener('click', event => {

                const link =
                    event.target.closest('a');


                if (link) {

                    closeAllDropdowns();

                    return;

                }


                event.stopPropagation();

            });

        });


        /* ---------------------------------------------
           CLIC EN DEHORS
           --------------------------------------------- */

        document.addEventListener('click', event => {

            if (
                !event.target.closest(
                    '.yaas-nav-dropdown'
                )
            ) {

                closeAllDropdowns();

            }

        });


        /* ---------------------------------------------
           TOUCHE ESCAPE
           --------------------------------------------- */

        document.addEventListener('keydown', event => {

            if (event.key === 'Escape') {

                closeAllDropdowns();

            }

        });

    }


    /* =====================================================
       ANIMATION AU SCROLL
       ===================================================== */

    const animatedElements =
        document.querySelectorAll(
            '.yaas-category-card, ' +
            '.yaas-document-card, ' +
            '.yaas-about-content, ' +
            '.yaas-about-visual'
        );


    if (
        animatedElements.length &&
        'IntersectionObserver' in window
    ) {

        const observer =
            new IntersectionObserver(
                entries => {

                    entries.forEach(entry => {

                        if (entry.isIntersecting) {

                            entry.target.classList.add(
                                'yaas-visible'
                            );

                            observer.unobserve(
                                entry.target
                            );

                        }

                    });

                },
                {
                    threshold: 0.12
                }
            );


        animatedElements.forEach(element => {

            element.classList.add(
                'yaas-reveal'
            );

            observer.observe(element);

        });

    }


    /* =====================================================
       SMOOTH SCROLL
       ===================================================== */

    document
        .querySelectorAll('a[href^="#"]')
        .forEach(link => {

            link.addEventListener('click', event => {

                const targetId =
                    link.getAttribute('href');


                if (
                    !targetId ||
                    targetId === '#'
                ) {
                    return;
                }


                const target =
                    document.querySelector(targetId);


                if (!target) {
                    return;
                }


                event.preventDefault();


                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

            });

        });


    /* =====================================================
       SEARCH
       ===================================================== */

    const searchInput =
        document.querySelector(
            '.yaas-search input'
        );


    if (searchInput) {

        searchInput.addEventListener(
            'focus',
            () => {

                searchInput
                    .closest('.yaas-search')
                    ?.classList.add('focused');

            }
        );


        searchInput.addEventListener(
            'blur',
            () => {

                searchInput
                    .closest('.yaas-search')
                    ?.classList.remove('focused');

            }
        );

    }

});