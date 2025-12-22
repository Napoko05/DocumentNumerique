@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center"> Enseignement Secondaire - Général</h2>

    <form class="row g-3 mb-4">
        <!-- Choisir cycle -->
        <div class="col-md-6">
            <label for="cycle" class="form-label">Cycle</label>
            <select id="cycle" class="form-select">
                <option selected>Choisir...</option>
                <option>1er Cycle (6e, 5e, 4e, 3e)</option>
                <option>2nd Cycle (2nde, 1ère, Tle)</option>
            </select>
        </div>

        <!-- Choisir classe -->
        <div class="col-md-6">
            <label for="classe" class="form-label">Classe</label>
            <select id="classe" class="form-select">
                <option selected>Choisir...</option>
                <option>6ème</option>
                <option>5ème</option>
                <option>4ème</option>
                <option>3ème</option>
                <option>2nde</option>
                <option>1ère</option>
                <option>Terminale</option>
            </select>
        </div>
    </form>

    <!-- Liste de livres -->
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/etude.png') }}" class="card-img-top" alt="Livre">
                <div class="card-body text-center">
                    <h5 class="card-title">Physique - 2nde</h5>
                    <a href="#" class="btn btn-primary">Lire</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
