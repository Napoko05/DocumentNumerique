@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">📘 Enseignement Secondaire - Technique</h2>

    <div class="row g-3 justify-content-center">
        {{-- Carte Enseignement Secondaire --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>Secondaire - Technique</span>
                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTechnique" aria-expanded="false" aria-controls="collapseTechnique">
                        ▼
                    </button>
                </div>

                {{-- Collapse pour les niveaux techniques --}}
                <div class="collapse" id="collapseTechnique">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            <a href="{{ route('books.secondary.technique', ['level' => 'seconde-bep']) }}" class="btn btn-outline-secondary btn-sm">Seconde (BEP)</a>
                            <a href="{{ route('books.secondary.technique', ['level' => 'premiere-bacpro']) }}" class="btn btn-outline-secondary btn-sm">Première (BAC Pro)</a>
                            <a href="{{ route('books.secondary.technique', ['level' => 'terminale-bacpro']) }}" class="btn btn-outline-secondary btn-sm">Terminale (BAC Pro)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
