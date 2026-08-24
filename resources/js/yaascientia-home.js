/* =========================================================
   YAA'SCIENTIA
   HOMEPAGE JAVASCRIPT
   ========================================================= */

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | MOBILE MENU
    |--------------------------------------------------------------------------
    */

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

        });


        /*
        |--------------------------------------------------------------------------
        | FERME LE MENU APRÈS UN CLIC
        |--------------------------------------------------------------------------
        */

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

                    bars[0].style.transform = '';
                    bars[1].style.opacity = '';
                    bars[2].style.transform = '';

                });

            });

    }


    /*
    |--------------------------------------------------------------------------
    | DROPDOWN BIBLIOTHÈQUE
    |--------------------------------------------------------------------------
    */

    const dropdown =
        document.querySelector('.yaas-nav-dropdown');

    const dropdownTrigger =
        document.querySelector('.yaas-dropdown-trigger');


    if (dropdown && dropdownTrigger) {

        dropdownTrigger.addEventListener('click', event => {

            event.stopPropagation();

            dropdown.classList.toggle('open');

        });


        document.addEventListener('click', event => {

            if (!dropdown.contains(event.target)) {

                dropdown.classList.remove('open');

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | ANIMATION AU SCROLL
    |--------------------------------------------------------------------------
    */

    const animatedElements =
        document.querySelectorAll(
            '.yaas-category-card, .yaas-document-card, .yaas-about-content, .yaas-about-visual'
        );


    if ('IntersectionObserver' in window) {

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


    /*
    |--------------------------------------------------------------------------
    | SMOOTH SCROLL
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | SEARCH — PETIT EFFET
    |--------------------------------------------------------------------------
    */

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