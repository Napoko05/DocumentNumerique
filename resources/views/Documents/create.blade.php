@extends('layouts.journalist_app')

@section('page-title', 'Publier un document')

@section('content')

<div class="container-fluid">

<div class="card shadow-sm border-0">
    <div class="card-body">

        <h4 class="mb-4">
            Publication d'un document
        </h4>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('journaliste.documents.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- Titre -->

            <div class="mb-3">
                <label class="form-label">
                    Titre du document
                </label>

                <input type="text"
                       name="title"
                       class="form-control"
                       value="{{ old('title') }}"
                       required>
            </div>

            <!-- Description -->

            <div class="mb-3">
                <label class="form-label">
                    Description
                </label>

                <textarea name="description"
                          rows="4"
                          class="form-control"
                          required>{{ old('description') }}</textarea>
            </div>

            <!-- Résumé -->

            <div class="mb-3">
                <label class="form-label">
                    Résumé / Contenu
                </label>

                <textarea name="content"
                          rows="6"
                          class="form-control">{{ old('content') }}</textarea>
            </div>

            <!-- Catégorie -->

            <div class="mb-3">
                <label class="form-label">
                    Catégorie
                </label>

                <select name="category"
                        class="form-select"
                        required>

                    <option value="">
                        Choisir...
                    </option>

                    <option value="secondary">
                        Enseignement Secondaire
                    </option>

                    <option value="superior">
                        Enseignement Supérieur
                    </option>

                </select>
            </div>

            <!-- Niveau -->

            <div class="mb-3">
                <label class="form-label">
                    Niveau
                </label>

                <input type="text"
                       name="level"
                       class="form-control"
                       value="{{ old('level') }}"
                       placeholder="Ex : 6e, 5e, Licence 1, Master 2..."
                       required>
            </div>

            <!-- Cycle -->

            <div class="mb-3">
                <label class="form-label">
                    Cycle
                </label>

                <input type="text"
                       name="cycle"
                       class="form-control"
                       value="{{ old('cycle') }}"
                       placeholder="Ex : 1er cycle, 2nd cycle">
            </div>

            <!-- Couverture -->

            <div class="mb-3">
                <label class="form-label">
                    Image de couverture
                </label>

                <input type="file"
                       name="cover_image"
                       class="form-control"
                       accept="image/*">
            </div>

            <!-- PDF -->

            <div class="mb-3">
                <label class="form-label">
                    Fichier PDF
                </label>

                <input type="file"
                       name="document"
                       class="form-control"
                       accept=".pdf"
                       required>
            </div>

            <!-- Type accès -->

            <div class="mb-3">
                <label class="form-label">
                    Type d'accès
                </label>

                <select name="access_type"
                        id="access_type"
                        class="form-select">

                    <option value="free">
                        Gratuit
                    </option>

                    <option value="premium">
                        Premium
                    </option>

                </select>
            </div>

            <!-- Prix -->

            <div class="mb-3"
                 id="priceDiv"
                 style="display:none;">

                <label class="form-label">
                    Prix (FCFA)
                </label>

                <input type="number"
                       name="price"
                       min="0"
                       class="form-control"
                       value="{{ old('price') }}">
            </div>

            <div class="d-flex gap-2">

                <button type="submit"
                        class="btn btn-primary">
                    Publier le document
                </button>

                <a href="{{ route('journaliste.documents.index') }}"
                   class="btn btn-secondary">
                    Retour
                </a>

            </div>

        </form>

    </div>
</div>
</div>

@endsection

@section('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const accessType = document.getElementById('access_type');
    const priceDiv = document.getElementById('priceDiv');

    function togglePrice()
    {
        if(accessType.value === 'premium')
        {
            priceDiv.style.display = 'block';
        }
        else
        {
            priceDiv.style.display = 'none';
        }
    }

    accessType.addEventListener('change', togglePrice);

    togglePrice();
});

</script>

@endsection
