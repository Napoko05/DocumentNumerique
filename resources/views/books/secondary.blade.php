@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">📘 Enseignement Secondaire</h2>
    <div class="row g-4">
        <!-- Général -->
        <div class="col-md-6">
            <a href="{{ route('books.secondary.general') }}" class="text-decoration-none">
                <div class="book-card shadow-sm p-4 text-center h-100">
                    <i class="bi bi-journal-text fs-1 text-primary"></i>
                    <h4 class="mt-3 fw-bold">Général</h4>
                    <p class="text-muted">1er cycle et 2nd cycle (toutes classes).</p>
                </div>
            </a>
        </div>

        <!-- Technique -->
        <div class="col-md-6">
             <a href="{{ route('books.secondary.technique') }}" class="text-decoration-none">
                <div class="book-card shadow-sm p-4 text-center h-100">
                    <i class="bi bi-gear fs-1 text-warning"></i>
                    <h4 class="mt-3 fw-bold">Technique</h4>
                    <p class="text-muted">Toutes les séries techniques du secondaire.</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
