@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold text-center mb-4">🎓 Enseignement Supérieur</h2>

    <!-- Grande carte englobante -->
    <div class="card shadow-lg border-2">
        <div class="card-header bg-dark text-white text-center py-4">
            <h4 class="fw-bold mb-0">Enseignement Supérieur</h4>
            <p class="mb-0">Filières générales et techniques</p>
        </div>

        <div class="card-body p-5">
            <div class="row g-4 justify-content-center">
                <!-- Supérieur Général : sous-cartes Licence, Master, Doctorat -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white text-center">
                            <h5 class="fw-bold mb-0">Supérieur Général</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <a href="{{ route('superior.general', ['level' => 'licence']) }}" class="text-decoration-none">
                                        <div class="card shadow-sm p-3 text-center h-100 border">
                                            <h6 class="fw-bold">Licence</h6>
                                            <p class="text-muted">Cycle Licence</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('superior.general', ['level' => 'master']) }}" class="text-decoration-none">
                                        <div class="card shadow-sm p-3 text-center h-100 border">
                                            <h6 class="fw-bold">Master</h6>
                                            <p class="text-muted">Cycle Master</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('superior.general', ['level' => 'doctorat']) }}" class="text-decoration-none">
                                        <div class="card shadow-sm p-3 text-center h-100 border">
                                            <h6 class="fw-bold">Doctorat</h6>
                                            <p class="text-muted">Cycle Doctorat</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Supérieur Technique : sous-cartes Licence Pro, Master Pro -->
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white text-center">
                            <h5 class="fw-bold mb-0">Supérieur Technique</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12">
                                    <a href="{{ route('superior.technique', ['level' => 'licence-pro']) }}" class="text-decoration-none">
                                        <div class="card shadow-sm p-3 text-center h-100 border">
                                            <h6 class="fw-bold">Licence Pro</h6>
                                            <p class="text-muted">Cycle Licence Professionnelle</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12">
                                    <a href="{{ route('books.superior.technique', ['level' => 'master-pro']) }}" class="text-decoration-none">
                                        <div class="card shadow-sm p-3 text-center h-100 border">
                                            <h6 class="fw-bold">Master Pro</h6>
                                            <p class="text-muted">Cycle Master Professionnel</p>
                                        </div>
                                    </a>
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
