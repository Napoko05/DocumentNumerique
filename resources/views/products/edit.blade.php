@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Modifier produit</h3>

    <form method="POST" action="{{ route('products.update',$product->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name"
                   value="{{ $product->name }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Prix</label>
            <input type="number" name="price"
                   value="{{ $product->price }}"
                   class="form-control" required>
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
