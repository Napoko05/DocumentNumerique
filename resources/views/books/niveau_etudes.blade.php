@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">📘 Enseignement</h2>

    <!-- Grande carte englobante -->
    <div class="card shadow-lg border-2">
        <div class="card-header bg-dark text-white text-center py-4">
            <h4 class="fw-bold mb-0">Enseignement - Toutes Sections</h4>
            <p class="mb-0">Secondaire et Supérieur (Général & Technique)</p>
        </div>

        <div class="card-body p-5">
            <div class="row g-4">
                <!-- Secondaire Général -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="fw-bold mb-0">Secondaire Général</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-semibold">1er Cycle</h6>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '6e']) }}" class="btn btn-outline-primary w-100">6ème</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '5e']) }}" class="btn btn-outline-primary w-100">5ème</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '4e']) }}" class="btn btn-outline-primary w-100">4ème</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '3e']) }}" class="btn btn-outline-primary w-100">3ème</a>
                                </div>
                            </div>

                            <h6 class="fw-semibold">2nd Cycle</h6>
                            <div class="row g-2">
                                <div class="col-4">
                                    <a href="{{ route('secondary.general', ['cycle' => '2nd-cycle', 'classe' => '2nde']) }}" class="btn btn-outline-primary w-100">2nde</a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('secondary.general', ['cycle' => '2nd-cycle', 'classe' => '1ere']) }}" class="btn btn-outline-primary w-100">1ère</a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('secondary.general', ['cycle' => '2nd-cycle', 'classe' => 'terminale']) }}" class="btn btn-outline-primary w-100">Terminale</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondaire Technique -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-warning text-dark text-center">
                            <h5 class="fw-bold mb-0">Secondaire Technique</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <a href="{{ route('secondary.technique', ['level' => 'seconde-bep']) }}" class="btn btn-outline-warning w-100">Seconde (BEP)</a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('secondary.technique', ['level' => 'premiere-bacpro']) }}" class="btn btn-outline-warning w-100">Première (BAC Pro)</a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('secondary.technique', ['level' => 'terminale-bacpro']) }}" class="btn btn-outline-warning w-100">Terminale (BAC Pro)</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supérieur Général -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white text-center">
                            <h5 class="fw-bold mb-0">Supérieur Général</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <a href="{{ route('niveau_filiere.superieur', ['level' => 'licence']) }}" class="btn btn-outline-success w-100">Licence</a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('niveau_filiere.superieur', ['level' => 'master']) }}" class="btn btn-outline-success w-100">Master</a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('niveau_filiere.superieur', ['level' => 'doctorat']) }}" class="btn btn-outline-success w-100">Doctorat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supérieur Technique -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-danger text-white text-center">
                            <h5 class="fw-bold mb-0">Supérieur Technique</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <a href="{{ route('niveau_filiere.superieur', ['level' => 'licence-pro']) }}" class="btn btn-outline-danger w-100">Licence Pro</a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('niveau_filiere.superieur', ['level' => 'master-pro']) }}" class="btn btn-outline-danger w-100">Master Pro</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
