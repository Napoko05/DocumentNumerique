@extends('layouts.app')

@section('content')
<style>
    /* ====== CSS Dashboard ====== */

    /* Style général */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    /* Menu vertical bleu */
    .sidebar {
        width: 250px;
        min-height: 100vh;
        background: linear-gradient(180deg, #007bff, #0056b3);
        color: #fff;
        position: fixed;
        top: 60px;
        /* Décalage vers le bas */
        left: 0;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    .sidebar .nav-link {
        color: #fff;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 6px;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(5px);
    }

    .sidebar .nav-link.active {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Contenu principal */
    .main-content {
        margin-left: 250px;
        padding: 30px;
        background: #fff;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        width: calc(100% - 250px);
        /* Prend tout l’espace restant */
    }

    /* Cartes statistiques */
    .card {
        border: none;
        border-radius: 12px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Tableau documents */
    .table-container {
        flex: 1;
        overflow-y: auto;
    }

    .table {
        border-radius: 8px;
        overflow: hidden;
        width: 100%;
    }

    .table thead {
        background: #007bff;
        color: #fff;
    }

    .table-striped tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transition: background 0.3s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            width: 200px;
        }

        .main-content {
            margin-left: 200px;
            width: calc(100% - 200px);
        }
    }

    @media (max-width: 576px) {
        .sidebar {
            position: relative;
            width: 100%;
            min-height: auto;
            top: 0;
        }

        .main-content {
            margin-left: 0;
            width: 100%;
        }
    }
</style>

<div class="d-flex">
    <!-- Menu vertical -->
    <div class="sidebar">
        <ul class="nav flex-column p-3">
            <li class="nav-item mb-3">
                <a class="nav-link" href="#">Utilisateurs Premium</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link" href="#">Mes Documents</a>
            </li>
            <li class="nav-item mb-3">
                <a class="nav-link" href="{{ route('journalist.documents.create') }}">Publier un Document</a>
            </li>
        </ul>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                Déconnexion
            </button>
        </form>
    </div>

    <!-- Contenu principal -->
    <div class="main-content">
        <h2 class="fw-bold mb-4">Dashboard - {{ auth()->user()->name }}</h2>

        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Total documents</h5>
                    <h3>{{ $totalDocuments }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Gratuits</h5>
                    <h3>{{ $totalFree }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Premium</h5>
                    <h3>{{ $totalPremium }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center p-3">
                    <h5>Total vues</h5>
                    <h3>{{ $totalViews }}</h3>
                </div>
            </div>
        </div>

        <!-- Tableau -->
        <div class="table-container">
            <h4 class="mb-3">Mes documents</h4>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Catégorie</th>
                        <th>Classe / Niveau</th>
                        <th>Cycle</th>
                        <th>Statut</th>
                        <th>Vues</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr>
                        <td>{{ $doc->title }}</td>
                        <td>{{ ucfirst($doc->type) }}</td>
                        <td>{{ ucfirst($doc->category) }}</td>
                        <td>{{ $doc->level }}</td>
                        <td>{{ $doc->cycle ?? '-' }}</td>
                        <td>{{ $doc->premium ? 'Premium' : 'Gratuit' }}</td>
                        <td>{{ $doc->views }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Graphique -->
        <canvas id="viewsChart" height="100"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Animation d’apparition des cartes
    document.addEventListener("DOMContentLoaded", () => {
        const cards = document.querySelectorAll(".card");
        cards.forEach((card, i) => {
            card.style.opacity = 0;
            card.style.transform = "translateY(20px)";
            setTimeout(() => {
                card.style.transition = "all 0.6s ease";
                card.style.opacity = 1;
                card.style.transform = "translateY(0)";
            }, i * 200);
        });
    });

    // Menu actif
    const links = document.querySelectorAll(".sidebar .nav-link");
    links.forEach(link => {
        link.addEventListener("click", () => {
            links.forEach(l => l.classList.remove("active"));
            link.classList.add("active");
        });
    });

    // Chart.js
    const ctx = document.getElementById('viewsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {
                !!json_encode($chartLabels ?? []) !!
            },
            datasets: [{
                label: 'Vues',
                data: {
                    !!json_encode($chartData ?? []) !!
                },
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
</script>
@endsection