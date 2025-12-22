@extends('layouts.app')

@section('content')
<div class="container-fluid my-5">
    {{-- Grande carte plein écran --}}
    <div class="card shadow-lg border-0 h-100">
        <div class="card-header bg-dark text-white text-center py-4">
            <h2 class="fw-bold mb-0">📘 Enseignement Secondaire - Technique</h2>
        </div>

        <div class="card-body p-5">
            <div class="row g-4 justify-content-center">
                {{-- Sous-cartes pour chaque classe technique --}}
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h4 class="fw-bold">Seconde (BEP)</h4>
                            <p class="text-muted">Classe de Seconde technique (BEP).</p>
                            <a href="{{ route('secondary.technique', ['level' => 'seconde-bep']) }}" class="btn btn-outline-primary btn-sm">
                                Accéder
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h4 class="fw-bold">Première (BAC )</h4>
                            <p class="text-muted">Classe de Première technique (BAC Pro).</p>
                            <a href="{{ route('secondary.technique', ['level' => 'premiere-bacpro']) }}" class="btn btn-outline-primary btn-sm">
                                Accéder
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <h4 class="fw-bold">Terminale (BAC Pro)</h4>
                            <p class="text-muted">Classe de Terminale technique (BAC Pro).</p>
                            <a href="{{ route('secondary.technique', ['level' => 'terminale-bacpro']) }}" class="btn btn-outline-primary btn-sm">
                                Accéder
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tu peux ajouter d’autres sous-cartes ici pour d’autres classes techniques --}}
            </div>
        </div>
    </div>
</div>
@endsection
