@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Créer produit</h3>

    <form method="POST" action="{{ route('products.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Prix</label>
            <input type="number" name="price" class="form-control" required>
        </div>

        <button class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection
