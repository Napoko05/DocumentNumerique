document.addEventListener('DOMContentLoaded', () => {

    /* =========================================================
       SIDEBAR MOBILE
    ========================================================= */

    const sidebar = document.getElementById('journalistSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle = document.getElementById('sidebarToggle');
    const close = document.getElementById('sidebarClose');

    const openSidebar = () => {

        if (!sidebar || !overlay) return;

        sidebar.classList.add('is-open');
        overlay.classList.add('is-visible');

        document.body.classList.add('sidebar-open');
    };

    const closeSidebar = () => {

        if (!sidebar || !overlay) return;

        sidebar.classList.remove('is-open');
        overlay.classList.remove('is-visible');

        document.body.classList.remove('sidebar-open');
    };


    toggle?.addEventListener('click', openSidebar);

    close?.addEventListener('click', closeSidebar);

    overlay?.addEventListener('click', closeSidebar);


    /* Fermer avec ESC */
    document.addEventListener('keydown', (event) => {

        if (event.key === 'Escape') {
            closeSidebar();
        }

    });


    /* Fermer automatiquement après clic sur un lien */
    document
        .querySelectorAll('.sidebar-link')
        .forEach(link => {

            link.addEventListener('click', () => {

                if (window.innerWidth < 992) {
                    closeSidebar();
                }

            });

        });


    /* =========================================================
       GRAPHIQUE DES VUES
    ========================================================= */

    const canvas = document.getElementById('viewsChart');

    if (
        canvas &&
        typeof Chart !== 'undefined'
    ) {

        let labels = [];
        let data = [];

        try {

            labels = JSON.parse(
                canvas.dataset.labels || '[]'
            );

            data = JSON.parse(
                canvas.dataset.data || '[]'
            );

        } catch (error) {

            console.error(
                'Erreur lors de la lecture des données du graphique :',
                error
            );

            return;
        }


        const ctx = canvas.getContext('2d');


        new Chart(ctx, {

            type: 'bar',

            data: {

                labels: labels,

                datasets: [{
                    label: 'Vues',

                    data: data,

                    backgroundColor:
                        'rgba(37, 99, 235, 0.75)',

                    borderColor:
                        '#2563eb',

                    borderWidth: 1,

                    borderRadius: 6,

                    maxBarThickness: 42
                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {
                        backgroundColor: '#0f172a',

                        titleFont: {
                            family: 'Inter'
                        },

                        bodyFont: {
                            family: 'Inter'
                        },

                        padding: 10,

                        cornerRadius: 8
                    }

                },

                scales: {

                    x: {
                        grid: {
                            display: false
                        },

                        ticks: {
                            color: '#64748b',

                            font: {
                                family: 'Inter',
                                size: 11
                            }
                        }
                    },

                    y: {

                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        grid: {
                            color: '#e2e8f0'
                        },

                        ticks: {
                            color: '#64748b',

                            precision: 0,

                            font: {
                                family: 'Inter',
                                size: 11
                            }
                        }
                    }

                }

            }

        });

    }

});