@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">🎓 Filières et Spécialités - Enseignement Supérieur</h2>

    <!-- Supérieur Général -->
    <div class="card shadow-lg border-2 mb-5">
        <div class="card-header bg-primary text-white text-center">
            <h4 class="fw-bold mb-0">Supérieur Général</h4>
        </div>
        <div class="card-body">
            <!-- Texte inspirant défilant -->
            <div class="bg-light p-3 mb-4 rounded shadow-sm">
                <div class="scrolling-text text-primary fw-semibold">
                     "Le savoir est une lumière qui éclaire chaque étape du parcours académique.
                    Explorez les licences pour bâtir vos fondations, les masters pour approfondir vos connaissances,
                    et les doctorats pour repousser les limites de la recherche."
                </div>
            </div>

            <!-- Sous-cartes des niveaux -->
            <div class="row g-4">
                <!-- Licence -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-header bg-light fw-bold">Licence</div>
                        <div class="card-body d-flex flex-wrap gap-2 justify-content-center">
                            <a href="#" class="btn btn-filiere">Licence en Droit</a>
                            <a href="#" class="btn btn-filiere">Licence en Lettres Modernes</a>
                            <a href="#" class="btn btn-filiere">Licence en Sciences Économiques</a>
                            <a href="#" class="btn btn-filiere">Licence en Mathématiques</a>
                            <a href="#" class="btn btn-filiere">Licence en Informatique</a>
                        </div>
                    </div>
                </div>

                <!-- Master -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-header bg-light fw-bold">Master</div>
                        <div class="card-body d-flex flex-wrap gap-2 justify-content-center">
                            <a href="#" class="btn btn-filiere">Master en Droit Public</a>
                            <a href="#" class="btn btn-filiere">Master en Sciences de Gestion</a>
                            <a href="#" class="btn btn-filiere">Master en Informatique</a>
                            <a href="#" class="btn btn-filiere">Master en Mathématiques Appliquées</a>
                            <a href="#" class="btn btn-filiere">Master en Histoire</a>
                        </div>
                    </div>
                </div>

                <!-- Doctorat -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-header bg-light fw-bold">Doctorat</div>
                        <div class="card-body d-flex flex-wrap gap-2 justify-content-center">
                            <a href="#" class="btn btn-filiere">Doctorat en Droit</a>
                            <a href="#" class="btn btn-filiere">Doctorat en Sciences Économiques</a>
                            <a href="#" class="btn btn-filiere">Doctorat en Informatique</a>
                            <a href="#" class="btn btn-filiere">Doctorat en Lettres</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Supérieur Technique -->
    <div class="card shadow-lg border-2">
        <div class="card-header bg-success text-white text-center">
            <h4 class="fw-bold mb-0">Supérieur Technique</h4>
        </div>
        <div class="card-body">
            <!-- Texte inspirant défilant -->
            <div class="bg-light p-3 mb-4 rounded shadow-sm">
                <div class="scrolling-text text-success fw-semibold">
                     "Les filières techniques forgent l’expertise pratique.
                    Les licences professionnelles ouvrent la voie aux métiers spécialisés,
                    tandis que les masters professionnels affinent vos compétences pour devenir acteur du progrès."
                </div>
            </div>

            <!-- Sous-cartes des niveaux -->
            <div class="row g-4">
                <!-- Licence Pro -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-header bg-light fw-bold">Licence Professionnelle</div>
                        <div class="card-body d-flex flex-wrap gap-2 justify-content-center">
                            <a href="#" class="btn btn-filiere">Licence Pro en Réseaux & Télécoms</a>
                            <a href="#" class="btn btn-filiere">Licence Pro en Génie Civil</a>
                            <a href="#" class="btn btn-filiere">Licence Pro en Électronique</a>
                            <a href="#" class="btn btn-filiere">Licence Pro en Comptabilité</a>
                        </div>
                    </div>
                </div>

                <!-- Master Pro -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100 text-center">
                        <div class="card-header bg-light fw-bold">Master Professionnel</div>
                        <div class="card-body d-flex flex-wrap gap-2 justify-content-center">
                            <a href="#" class="btn btn-filiere">Master Pro en Informatique</a>
                            <a href="#" class="btn btn-filiere">Master Pro en Énergie</a>
                            <a href="#" class="btn btn-filiere">Master Pro en Génie Industriel</a>
                            <a href="#" class="btn btn-filiere">Master Pro en Finance</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles personnalisés --}}
<style>
    /* Texte défilant */
    .scrolling-text {
        white-space: nowrap;
        overflow: hidden;
        display: block;
        animation: scroll-left 20s linear infinite;
    }

    @keyframes scroll-left {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    /* Boutons filières compacts */
    .btn-filiere {
        display: inline-block;
        width: auto;
        background-color: #f8f9fa;
        /* blanc sale */
        color: #333;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 6px 14px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-filiere:hover {
        background-color: #0d6efd;
        color: #fff;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-filiere:active,
    .btn-filiere.active {
        background-color: #084298;
        color: #fff;
    }
</style>
@endsection