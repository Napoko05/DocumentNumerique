<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <ul class="navbar-nav ms-auto">
            <!-- Lien Accueil -->
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">Accueil</a>
            </li>

            <!-- Dropdown Profil -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" 
                   data-bs-toggle="dropdown" aria-expanded="false">
                    Profil
                </a>
                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                             Modifier le profil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}#password">
                             Changer le mot de passe
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                Se déconnecter
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
