/*
|--------------------------------------------------------------------------
| YAA'SCIENTIA — APPLICATION JAVASCRIPT
|--------------------------------------------------------------------------
| Bootstrap + JavaScript natif
| Alpine.js supprimé
|--------------------------------------------------------------------------
*/

import './bootstrap';

/*
|--------------------------------------------------------------------------
| Bootstrap
|--------------------------------------------------------------------------
*/

import 'bootstrap/dist/js/bootstrap.bundle.min.js';

/*
|--------------------------------------------------------------------------
| Bootstrap Icons
|--------------------------------------------------------------------------
*/

import 'bootstrap-icons/font/bootstrap-icons.css';


/*
|--------------------------------------------------------------------------
| DOM READY
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | AFFICHER / MASQUER LE MOT DE PASSE
    |--------------------------------------------------------------------------
    */

    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const passwordIcon = document.getElementById('passwordIcon');

    if (
        passwordInput &&
        togglePassword &&
        passwordIcon
    ) {

        togglePassword.addEventListener('click', function () {

            const isPassword =
                passwordInput.type === 'password';

            passwordInput.type =
                isPassword ? 'text' : 'password';

            passwordIcon.classList.toggle(
                'bi-eye',
                !isPassword
            );

            passwordIcon.classList.toggle(
                'bi-eye-slash',
                isPassword
            );

            togglePassword.setAttribute(
                'aria-label',
                isPassword
                    ? 'Masquer le mot de passe'
                    : 'Afficher le mot de passe'
            );

            togglePassword.setAttribute(
                'aria-pressed',
                isPassword ? 'true' : 'false'
            );

        });

    }

});