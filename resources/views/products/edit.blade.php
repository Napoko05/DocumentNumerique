@extends('layouts.admin_app')

@section('page-title', 'Modifier le produit')

@section('content')

<div class="max-w-lg">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <h2 class="font-heading font-bold text-lg text-ink mb-6">Modifier le produit</h2>

        @if($errors->any())
            <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Nom</label>
                <input type="text" name="name" value="{{ $product->name }}" required class="input-field">
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Prix (FCFA)</label>
                <input type="number" name="price" value="{{ $product->price }}" required class="input-field">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm font-medium text-ink-soft hover:text-ink transition-colors">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection
