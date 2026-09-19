import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // =========================================================
                // CSS PRINCIPAUX
                // =========================================================
                'resources/css/app.css',
                'resources/css/layout.css',
                'resources/css/auth.css',
                'resources/css/yaascientia-home.css',

                // =========================================================
                // AUTHENTIFICATION
                // =========================================================
                'resources/css/login/style_register.css',

                // =========================================================
                // ADMIN
                // =========================================================
                'resources/css/admin/layout.css',
                'resources/css/admin/sidebar.css',
                'resources/css/admin/style_dashboard.css',
                'resources/css/admin/style_list_user.css',
                'resources/css/admin/style_agent.css',
                'resources/css/admin/style_edit_journaliste.css',
                'resources/css/admin/style_ajout_matiere.css',
                'resources/css/admin/create_matieres.css',
                'resources/css/admin/edit_user.css',
                'resources/css/profile.css',
                'resources/css/contact.css',

                // =========================================================
                // JOURNALISTE
                // =========================================================
                'resources/css/journaliste/layout.css',
                'resources/css/journaliste/sidebar.css',
                'resources/css/journaliste/document-wizard.css',
                'resources/css/journaliste/style_dashboard.css',
                'resources/css/journaliste/show.css',
                'resources/css/journaliste/journaliste_documents.css',
                'resources/css/journaliste/document_edit.css',
                'resources/css/journaliste/document_index.css',
                'resources/css/journaliste/journale_statistique.css',
                'resources/css/journaliste/edit_profil.css',
                'resources/css/journaliste/password.css',
                'resources/css/journaliste/profile.css',
                

                // =========================================================
                // FORMATION SECONDAIRE
                // =========================================================
                'resources/css/formation/secondaire/vitrine_secondaire.css',

                // =========================================================
                // FORMATION SUPÉRIEURE
                // =========================================================
                'resources/css/formation/superieur/vitrine_superieur.css',

                // =========================================================
                // FORMATION PROFESSIONNELLE
                // =========================================================
                'resources/css/formation/professionnel/formation.css',

                // =========================================================
                // JAVASCRIPT
                // =========================================================
                'resources/js/app.js',
                'resources/js/yaascientia-home.js',
                 'resources/js/scrit_profil_menu.js',
                'resources/js/journaliste/document-wizard.js',
                'resources/js/journaliste/script_journaliste.js',
            ],

            refresh: true,
        }),
    ],
});