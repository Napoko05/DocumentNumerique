@extends('layouts.app')

@section('content')
<style>
    body {
        background: #f4f6f9;
    }

    .admin-wrapper {
        display: flex;
        min-height: 90vh;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
        width: 250px;
        background: #111827;
        color: #fff;
        padding: 20px;
        transition: all .3s;
    }

    .sidebar h4 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .sidebar a {
        display: block;
        color: #cbd5e1;
        padding: 12px 15px;
        border-radius: 8px;
        margin-bottom: 8px;
        text-decoration: none;
        transition: all .3s;
        cursor: pointer;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: #2563eb;
        color: #fff;
    }

    /* ===== CONTENT ===== */
    .content {
        flex: 1;
        padding: 30px;
        animation: fadeIn .4s ease-in-out;
    }

    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 20px rgba(0, 0, 0, .05);
        transition: transform .3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateX(20px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<div class="admin-wrapper">

    <!-- ===== MENU GAUCHE ===== -->
    <div class="sidebar">
        <h4> ADMIN</h4>

        <a class="menu-link active" data-target="dashboard"> Dashboard</a>
        <a class="menu-link" data-target="users">Utilisateurs</a>
        <a class="menu-link" data-target="documents"> Documents</a>
        <a class="menu-link" data-target="settings"> Paramètres</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                 Déconnexion
            </button>
        </form>

    </div>

    <!-- ===== CONTENU DROIT ===== -->
    <div class="content">

        <!-- DASHBOARD -->
        <div class="section" id="dashboard">
            <h3 class="fw-bold mb-4">Tableau de bord </h3>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6>Utilisateurs</h6>
                        <h3>{{ $totalUsers }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6>Journalistes</h6>
                        <h3>{{ $totalJournalists }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6>Documents</h6>
                        <h3>{{ $totalDocuments }}</h3>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h6>Vues</h6>
                        <h3>{{ $totalViews }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- UTILISATEURS -->
        <div class="section d-none" id="users">
            <h3 class="fw-bold mb-3">Gestion des utilisateurs</h3>
            <p>L’admin peut créer, modifier, supprimer et attribuer des rôles.</p>

            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                Gérer les utilisateurs
            </a>
        </div>

        <!-- DOCUMENTS -->
        <div class="section d-none" id="documents">
            <h3 class="fw-bold mb-3">Documents</h3>
            <p>Vue globale sur tous les documents publiés.</p>
        </div>

        <!-- PARAMÈTRES -->
        <div class="section d-none" id="settings">
            <h3 class="fw-bold mb-3">Paramètres système</h3>
            <p>Configuration générale de la plateforme.</p>
        </div>


    </div>
</div>

<script>
    const links = document.querySelectorAll('.menu-link');
    const sections = document.querySelectorAll('.section');

    links.forEach(link => {
        link.addEventListener('click', () => {
            links.forEach(l => l.classList.remove('active'));
            link.classList.add('active');

            sections.forEach(section => section.classList.add('d-none'));

            document.getElementById(link.dataset.target)
                .classList.remove('d-none');
        });
    });
</script>
@endsection