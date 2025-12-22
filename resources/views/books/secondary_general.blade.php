@extends('layouts.app')

@section('content')
<div class="container-fluid my-5">
    <h2 class="fw-bold mb-4 text-center">📘 Enseignement Secondaire - Général</h2>

    <div class="row g-4 justify-content-center">
        <!-- 1er Cycle -->
        <div class="col-md-6">
            <div class="card shadow-lg h-100">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="fw-bold mb-0">1er Cycle</h4>
                    <p class="mb-0">Classes de 6e à 3e</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-sm-12">
                            <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '6e']) }}" class="text-decoration-none">
                                <div class="card shadow-sm p-3 text-center h-100">
                                    <h5 class="fw-bold">6ème</h5>
                                    <p class="text-muted">Classe du 1er cycle</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '5e']) }}" class="text-decoration-none">
                                <div class="card shadow-sm p-3 text-center h-100">
                                    <h5 class="fw-bold">5ème</h5>
                                    <p class="text-muted">Classe du 1er cycle</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '4e']) }}" class="text-decoration-none">
                                <div class="card shadow-sm p-3 text-center h-100">
                                    <h5 class="fw-bold">4ème</h5>
                                    <p class="text-muted">Classe du 1er cycle</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <a href="{{ route('secondary.general', ['cycle' => '1er-cycle', 'classe' => '3e']) }}" class="text-decoration-none">
                                <div class="card shadow-sm p-3 text-center h-100">
                                    <h5 class="fw-bold">3ème</h5>
                                    <p class="text-muted">Classe du 1er cycle</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2nd Cycle -->
        <div class="col-md-6">
            <div class="card shadow-lg h-100">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="fw-bold mb-0">2nd Cycle</h4>
                    <p class="mb-0">Classes de 2nde à Terminale</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-12">
                            <a href="{{ route('secondary.general', ['cycle' => '2nd-cycle', 'classe' => '2nde']) }}" class="text-decoration-none">
                                <div class="card shadow-sm p-3 text-center h-100">
                                    <h5 class="fw-bold">2nde</h5>
                                    <p class="text-muted">Classe du 2nd cycle</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <a href="{{ route('secondary.general', ['cycle' => '2nd-cycle', 'classe' => '1ere']) }}" class="text-decoration-none">
                                <div class="card shadow-sm p-3 text-center h-100">
                                    <h5 class="fw-bold">1ère</h5>
                                    <p class="text-muted">Classe du 2nd cycle</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <a href="{{ route('secondary.general', ['cycle' => '2nd-cycle', 'classe' => 'terminale']) }}" class="text-decoration-none">
                                <div class="card shadow-sm p-3 text-center h-100">
                                    <h5 class="fw-bold">Terminale</h5>
                                    <p class="text-muted">Classe du 2nd cycle</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
