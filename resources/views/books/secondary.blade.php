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
                    <a href="{{ route('secondary.general', ['cycle' => 'premier', 'classe' => '6e']) }}" class="text-decoration-none">
                        <div class="book-card shadow-sm p-4 text-center h-100 border">
                            <i class="bi bi-journal-text fs-1 text-primary"></i>
                            <h4 class="mt-3 fw-bold">Secondaire Général</h4>
                            <p class="text-muted">1er cycle et 2nd cycle (toutes classes).</p>
                        </div>
                    </a>
                </div>

                <!-- Secondaire Technique -->
                <div class="col-md-6">
                    <a href="{{ route('secondary.technique', ['level' => 'seconde-bep']) }}" class="text-decoration-none">
                        <div class="book-card shadow-sm p-4 text-center h-100 border">
                            <i class="bi bi-gear fs-1 text-warning"></i>
                            <h4 class="mt-3 fw-bold">Secondaire Technique</h4>
                            <p class="text-muted">Toutes les séries techniques du secondaire.</p>
                        </div>
                    </a>
                </div>

                <!-- Supérieur Général -->
                <div class="col-md-6">
                    <a href="{{ route('superior.general', ['level' => 'licence']) }}" class="text-decoration-none">
                        <div class="book-card shadow-sm p-4 text-center h-100 border">
                            <i class="bi bi-mortarboard fs-1 text-success"></i>
                            <h4 class="mt-3 fw-bold">Supérieur Général</h4>
                            <p class="text-muted">Toutes les filières générales du supérieur.</p>
                        </div>
                    </a>
                </div>

                <!-- Supérieur Technique -->
                <div class="col-md-6">
                    <a href="{{ route('superior.technique', ['level' => 'dut']) }}" class="text-decoration-none">
                        <div class="book-card shadow-sm p-4 text-center h-100 border">
                            <i class="bi bi-tools fs-1 text-danger"></i>
                            <h4 class="mt-3 fw-bold">Supérieur Technique</h4>
                            <p class="text-muted">Toutes les filières techniques du supérieur.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
</style>