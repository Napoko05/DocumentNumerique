@extends('layouts.journalist_app')

@section('title', 'Modifier document')

@section('content')

<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-3xl mx-auto">

        <!-- HEADER -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">
                ✏️ Modifier le document
            </h1>
            <p class="text-gray-500 mt-2">
                Met à jour les informations du document
            </p>
        </div>

        <!-- CARD -->
        <div class="bg-white shadow-xl rounded-2xl border border-gray-100">

            <form action="{{ route('journaliste.documents.update',$document) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="p-8 space-y-6">

                @csrf
                @method('PUT')

                <!-- GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- TITRE -->
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-blue-700">
                            Titre
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title',$document->title) }}"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="md:col-span-2">
                        <label class="text-sm font-semibold text-blue-700">
                            Description
                        </label>
                        <textarea name="description"
                                  rows="5"
                                  class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">{{ old('description',$document->description) }}</textarea>
                    </div>

                    <!-- CATEGORIE -->
                    <div>
                        <label class="text-sm font-semibold text-blue-700">
                            Catégorie
                        </label>
                        <input type="text"
                               name="category"
                               value="{{ old('category',$document->category) }}"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>

                    <!-- NIVEAU -->
                    <div>
                        <label class="text-sm font-semibold text-blue-700">
                            Niveau
                        </label>
                        <input type="text"
                               name="level"
                               value="{{ old('level',$document->level) }}"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>

                    <!-- CYCLE -->
                    <div>
                        <label class="text-sm font-semibold text-blue-700">
                            Cycle
                        </label>
                        <input type="text"
                               name="cycle"
                               value="{{ old('cycle',$document->cycle) }}"
                               class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>

                    <!-- ACCESS TYPE -->
                    <div>
                        <label class="text-sm font-semibold text-blue-700">
                            Type d’accès
                        </label>
                        <select name="access_type"
                                id="access_type"
                                class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">

                            <option value="free" {{ $document->access_type == 'free' ? 'selected' : '' }}>
                                🟢 Gratuit
                            </option>

                            <option value="premium" {{ $document->access_type == 'premium' ? 'selected' : '' }}>
                                🟠 Premium
                            </option>

                        </select>
                    </div>

                    <!-- PRICE -->
                    <div id="priceDiv" class="{{ $document->access_type == 'premium' ? '' : 'hidden' }}">
                        <label class="text-sm font-semibold text-orange-600">
                            💰 Prix (FCFA)
                        </label>
                        <input type="number"
                               name="price"
                               value="{{ old('price',$document->price) }}"
                               class="mt-2 w-full rounded-xl border-orange-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>

                </div>

                <!-- BUTTONS -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">

                    <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl shadow-md transition">
                        💾 Enregistrer
                    </button>

                    <a href="{{ route('journaliste.documents.index') }}"
                       class="w-full sm:w-auto px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-xl text-center transition">
                        ❌ Annuler
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

    function togglePrice() {
        if (accessType.value === 'premium') {
            priceDiv.classList.remove('hidden');
        } else {
            priceDiv.classList.add('hidden');
        }
    }

    accessType.addEventListener('change', togglePrice);
    togglePrice();
});
</script>

@endsection