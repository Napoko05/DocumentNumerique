@extends('layouts.app')

@section('content')

<div class="container my-5">
    <h2 class="text-center fw-bold mb-5">Livres populaires</h2>

    <p class="text-center mb-4 px-3">
        Vous êtes passionné de littérature ? Rejoignez-nous et retrouvez votre inspiration à travers nos livres soigneusement triés.
    </p>

    <div class="row g-4">

        <!-- ====== Enseignement Secondaire (gauche) ====== -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">

                    <h4 class="fw-bold text-primary mb-2">
                        <i class="bi bi-book me-2"></i>Enseignement Secondaire
                    </h4>
                    <p class="text-muted">Documents et manuels pour le secondaire (général et technique).</p>

                    <!-- Général (sous-carte) -->
                    <div class="mt-4 p-3 rounded border">
                        <h6 class="fw-semibold">Général</h6>
                        <p class="small text-muted mb-2">Cycles :</p>

                        <div class="d-flex gap-2 flex-wrap">

                            <!-- 1er Cycle (Dropdown) -->
                            <div class="dropdown">
                                <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button"
                                   id="dropdown1erCycle" data-bs-toggle="dropdown" aria-expanded="false">
                                    1er cycle
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown1erCycle">
                                    <li><a class="dropdown-item" href="{{ route('books.secondary.general', ['cycle' => '1er-cycle', 'classe' => '6e']) }}">6ème</a></li>
                                    <li><a class="dropdown-item" href="{{ route('books.secondary.general', ['cycle' => '1er-cycle', 'classe' => '5e']) }}">5ème</a></li>
                                    <li><a class="dropdown-item" href="{{ route('books.secondary.general', ['cycle' => '1er-cycle', 'classe' => '4e']) }}">4ème</a></li>
                                    <li><a class="dropdown-item" href="{{ route('books.secondary.general', ['cycle' => '1er-cycle', 'classe' => '3e']) }}">3ème</a></li>
                                </ul>
                            </div>

                            <!-- 2nd Cycle (Dropdown) -->
                            <div class="dropdown">
                                <a class="btn btn-outline-primary btn-sm dropdown-toggle" href="#" role="button"
                                   id="dropdown2ndCycle" data-bs-toggle="dropdown" aria-expanded="false">
                                    2nd cycle
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown2ndCycle">
                                    <li><a class="dropdown-item" href="{{ route('books.secondary.general', ['cycle' => '2nd-cycle', 'classe' => '2nde']) }}">2nde</a></li>
                                    <li><a class="dropdown-item" href="{{ route('books.secondary.general', ['cycle' => '2nd-cycle', 'classe' => '1ere']) }}">1ère</a></li>
                                    <li><a class="dropdown-item" href="{{ route('books.secondary.general', ['cycle' => '2nd-cycle', 'classe' => 'terminale']) }}">Terminale</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Technique (sous-carte) -->
                    <div class="mt-4 p-3 rounded border">
                        <h6 class="fw-semibold">Technique</h6>
                        <p class="small text-muted mb-2">Niveaux professionnels :</p>

                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('books.secondary.technique', ['level' => 'seconde-bep']) }}" class="btn btn-outline-secondary btn-sm">
                                Seconde (BEP)
                            </a>
                            <a href="{{ route('books.secondary.technique', ['level' => 'premiere-bacpro']) }}" class="btn btn-outline-secondary btn-sm">
                                Première (BAC Pro)
                            </a>
                            <a href="{{ route('books.secondary.technique', ['level' => 'terminale-bacpro']) }}" class="btn btn-outline-secondary btn-sm">
                                Terminale (BAC Pro)
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- ====== Enseignement Supérieur (droite) ====== -->
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body">

                    <h4 class="fw-bold text-success mb-2">
                        <i class="bi bi-mortarboard me-2"></i>Enseignement Supérieur
                    </h4>
                    <p class="text-muted">Ressources pour Licence / Master / Doctorat.</p>

                    <div class="mt-3 p-3 rounded border">
                        <div class="d-flex gap-2 flex-wrap">

                            <a href="{{ route('books.superior.general', ['level' => 'licence']) }}" class="btn btn-outline-success btn-sm">
                                Licence
                            </a>
                            <a href="{{ route('books.superior.general', ['level' => 'master']) }}" class="btn btn-outline-success btn-sm">
                                Master
                            </a>
                            <a href="{{ route('books.superior.general', ['level' => 'doctorat']) }}" class="btn btn-outline-success btn-sm">
                                Doctorat
                            </a>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection
