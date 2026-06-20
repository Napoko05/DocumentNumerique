@extends('layouts.journalist_app')

@section('title', 'Modifier document')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-body">

            <h2 class="mb-4">
                Modifier le document
            </h2>

            <form action="{{ route('journaliste.documents.update',$document) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Titre</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title',$document->title) }}">
                </div>

                <div class="mb-3">
                    <label>Description</label>

                    <textarea name="description"
                              rows="5"
                              class="form-control">{{ old('description',$document->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Catégorie</label>

                    <input type="text"
                           name="category"
                           class="form-control"
                           value="{{ old('category',$document->category) }}">
                </div>

                <div class="mb-3">
                    <label>Niveau</label>

                    <input type="text"
                           name="level"
                           class="form-control"
                           value="{{ old('level',$document->level) }}">
                </div>

                <div class="mb-3">
                    <label>Cycle</label>

                    <input type="text"
                           name="cycle"
                           class="form-control"
                           value="{{ old('cycle',$document->cycle) }}">
                </div>

                <div class="mb-3">
                    <label>Type d'accès</label>

                    <select name="access_type"
                            class="form-select">

                        <option value="free"
                            {{ $document->access_type == 'free' ? 'selected' : '' }}>
                            Gratuit
                        </option>

                        <option value="premium"
                            {{ $document->access_type == 'premium' ? 'selected' : '' }}>
                            Premium
                        </option>

                    </select>
                </div>

                <div class="mb-3">
                    <label>Prix</label>

                    <input type="number"
                           name="price"
                           class="form-control"
                           value="{{ old('price',$document->price) }}">
                </div>

                <button class="btn btn-success">
                    Enregistrer
                </button>

                <a href="{{ route('journaliste.documents.index') }}"
                   class="btn btn-secondary">
                    Annuler
                </a>

            </form>

        </div>

    </div>

</div>

@endsection