@extends('layouts.journalist_app')

@section('page-title', 'Publier un document')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-orange-50 py-10 px-4">

    <div class="max-w-4xl mx-auto">

        <!-- HEADER -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-blue-700 flex justify-center items-center gap-2">
                📢 Publication d’un document
            </h1>
            <p class="text-gray-600 mt-2">
                Ajoutez un document académique de façon professionnelle
            </p>
        </div>

        <!-- ERRORS -->
        @if($errors->any())
        <div class="mb-4 p-4 rounded-xl bg-red-100 border border-red-300 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- CARD -->
        <div class="bg-white shadow-2xl rounded-2xl border border-gray-100">

            <form action="{{ route('journaliste.documents.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="p-8 space-y-6">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- TITRE -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            📝 Titre du document
                        </label>
                        <input type="text"
                            name="title"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            📄 Description
                        </label>
                        <textarea name="description"
                            rows="4"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                    </div>

                    <!-- CONTENU -->
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            📚 Résumé / Contenu
                        </label>
                        <textarea name="content"
                            rows="5"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm"></textarea>
                    </div>

                    <!-- CATEGORIE -->
                    <div>
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            🏷️ Catégorie
                        </label>
                        <select name="category"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                            <option value="">Choisir...</option>
                            <option value="secondary">Enseignement Secondaire</option>
                            <option value="superior">Enseignement Supérieur</option>
                        </select>
                    </div>

                    <!-- NIVEAU -->
                    <div>
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            🎓 Niveau
                        </label>
                        <input type="text"
                            name="level"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>

                    <!-- CYCLE -->
                    <div>
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            🔄 Cycle
                        </label>
                        <input type="text"
                            name="cycle"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>

                    <!-- ACCESS -->
                    <div>
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            🔐 Type d’accès
                        </label>
                        <select name="access_type"
                            id="access_type"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            <option value="free">🟢 Gratuit</option>
                            <option value="premium">🟠 Premium</option>
                        </select>
                    </div>

                    <!-- PRICE -->
                    <div id="priceDiv" class="hidden">
                        <label class="flex items-center gap-2 text-orange-600 font-semibold">
                            💰 Prix (FCFA)
                        </label>
                        <input type="number"
                            name="price"
                            class="mt-2 w-full rounded-xl border-orange-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm">
                    </div>

                    <!-- IMAGE -->
                    <div>
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            🖼️ Image de couverture
                        </label>
                        <input type="file"
                            name="cover_image"
                            accept="image/*"
                            class="mt-2 w-full text-sm file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:bg-blue-100 file:text-blue-700
                                      hover:file:bg-blue-200">
                    </div>

                    <!-- PDF -->
                    <div>
                        <label class="flex items-center gap-2 text-blue-700 font-semibold">
                            📎 Fichier PDF
                        </label>
                        <input type="file"
                            name="document"
                            accept=".pdf"
                            class="mt-2 w-full text-sm file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:bg-orange-100 file:text-orange-700
                                      hover:file:bg-orange-200">
                    </div>

                </div>

                <!-- BUTTONS -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6">

                    <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-lg transition flex items-center justify-center gap-2">
                        🚀 Publier le document
                    </button>

                    <a href="{{ route('journaliste.documents.index') }}"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-xl text-center transition">
                        ← Retour
                    </a>

                </div>

            </form>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

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