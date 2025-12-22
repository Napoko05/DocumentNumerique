@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">📘 Enseignement Secondaire - Général</h2>

    <div class="row g-3 justify-content-center">
        {{-- Carte Enseignement Secondaire --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span>Secondaire - Général</span>
                    <button class="btn btn-light btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClasses" aria-expanded="false" aria-controls="collapseClasses">
                        ▼
                    </button>
                </div>

                {{-- Collapse pour les classes --}}
                <div class="collapse" id="collapseClasses">
                    <div class="card-body">
                        {{-- 1er Cycle --}}
                        <h6 class="fw-semibold">1er Cycle</h6>
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <a href="{{ route('books.secondary.general', ['cycle' => '1er-cycle']) }}" class="btn btn-outline-primary btn-sm">6ème</a>
                            <a href="{{ route('books.secondary.general', ['cycle' => '1er-cycle']) }}" class="btn btn-outline-primary btn-sm">5ème</a>
                            <a href="{{ route('books.secondary.general', ['cycle' => '1er-cycle']) }}" class="btn btn-outline-primary btn-sm">4ème</a>
                            <a href="{{ route('books.secondary.general', ['cycle' => '1er-cycle']) }}" class="btn btn-outline-primary btn-sm">3ème</a>
                        </div>

                        {{-- 2nd Cycle --}}
                        <h6 class="fw-semibold">2nd Cycle</h6>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('books.secondary.general', ['cycle' => '2nd-cycle']) }}" class="btn btn-outline-primary btn-sm">2nde</a>
                            <a href="{{ route('books.secondary.general', ['cycle' => '2nd-cycle']) }}" class="btn btn-outline-primary btn-sm">1ère</a>
                            <a href="{{ route('books.secondary.general', ['cycle' => '2nd-cycle']) }}" class="btn btn-outline-primary btn-sm">Terminale</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
