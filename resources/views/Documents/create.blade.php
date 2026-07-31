@extends('layouts.journalist_app')

@section('page-title', 'Publier un document')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-orange-50 py-10 px-4">

    <div class="max-w-5xl mx-auto">

        <!-- HEADER -->

        <div class="text-center mb-10">

            <h1 class="text-4xl font-bold text-blue-700">
                📚 Publier un document
            </h1>

            <p class="text-gray-600 mt-2">
                Publiez un document académique et classez-le correctement afin qu'il soit facilement retrouvé par les utilisateurs.
            </p>

        </div>

        <!-- ERREURS -->

        @if ($errors->any())

        <div class="mb-6 rounded-xl bg-red-100 border border-red-300 p-4">

            <ul class="list-disc pl-5 text-red-700">

                @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif

        <form action="{{ route('journaliste.documents.store') }}"
            method="POST"
            enctype="multipart/form-data"
            class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">

            @csrf

            <!-- ============================= -->
            <!-- INFORMATIONS GENERALES -->
            <!-- ============================= -->

            <div class="border-b pb-6 mb-8">

                <h2 class="text-2xl font-bold text-blue-700 mb-6">
                    📄 Informations générales
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- TITRE -->

                    <div class="md:col-span-2">

                        <label class="font-semibold text-gray-700">
                            Titre du document *
                        </label>

                        <input
                            type="text"
                            name="title"
                            value="{{ old('title') }}"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Ex : Cours complet de Mathématiques"
                            required>

                    </div>

                    <!-- DESCRIPTION -->

                    <div class="md:col-span-2">

                        <label class="font-semibold text-gray-700">
                            Description
                        </label>

                        <textarea
                            name="description"
                            rows="4"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Décrivez brièvement ce document...">{{ old('description') }}</textarea>

                    </div>

                    <!-- RESUME -->

                    <div class="md:col-span-2">

                        <label class="font-semibold text-gray-700">
                            Résumé / Contenu
                        </label>

                        <textarea
                            name="content"
                            rows="5"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            placeholder="Résumé du document...">{{ old('content') }}</textarea>

                    </div>

                </div>

            </div>

            <!-- ============================= -->
            <!-- CLASSIFICATION -->
            <!-- ============================= -->

            <div class="border-b pb-6 mb-8">

                <h2 class="text-2xl font-bold text-orange-600 mb-6">
                    🎓 Classification académique
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- CATEGORIE -->

                    <div>

                        <label class="font-semibold text-gray-700">
                            Catégorie d'enseignement *
                        </label>

                        <select
                            id="teaching_category"
                            name="teaching_category_id"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                            required>

                            <option value="">Sélectionner...</option>

                            @foreach($categories as $categorie)

                            <option value="{{ $categorie->id }}">

                                {{ $categorie->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>
                    <!-- FORMATION -->

                    <div id="formationDiv" class="hidden">

                        <label class="font-semibold text-gray-700">
                            Formation
                        </label>

                        <select
                            id="formation"
                            name="formation_id"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">

                            <option value="">Sélectionner...</option>

                            @foreach($formations as $formation)

                            <option value="{{ $formation->id }}">
                                {{ $formation->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- FILIERE -->

                    <div id="filiereDiv" class="hidden">

                        <label class="font-semibold text-gray-700">
                            Filière
                        </label>

                        <select
                            id="filiere"
                            name="filiere_id"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">

                            <option value="">Sélectionner...</option>

                            @foreach($filieres as $filiere)

                            <option value="{{ $filiere->id }}">
                                {{ $filiere->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- SPECIALITE -->

                    <div id="specialiteDiv" class="hidden">

                        <label class="font-semibold text-gray-700">
                            Spécialité
                        </label>

                        <select
                            id="specialite"
                            name="specialite_id"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">

                            <option value="">Sélectionner...</option>

                            @foreach($specialites as $specialite)

                            <option value="{{ $specialite->id }}">
                                {{ $specialite->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- NIVEAU -->

                    <div id="levelDiv" class="hidden">

                        <label class="font-semibold text-gray-700">
                            Niveau
                        </label>

                        <select
                            id="level"
                            name="level_id"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">

                            <option value="">Sélectionner...</option>

                            @foreach($levels as $level)

                            <option value="{{ $level->id }}">
                                {{ $level->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- MATIERE -->

                    <div id="subjectDiv" class="hidden">

                        <label class="font-semibold text-gray-700">
                            Matière
                        </label>

                        <select
                            id="subject"
                            name="subject_id"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500">

                            <option value="">Sélectionner...</option>

                            @foreach($subjects as $subject)

                            <option value="{{ $subject->id }}">
                                {{ $subject->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                    <!-- TYPE DE DOCUMENT -->

                    <div>

                        <label class="font-semibold text-gray-700">
                            Type de document *
                        </label>

                        <select
                            name="document_type_id"
                            class="mt-2 w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500"
                            required>

                            <option value="">Sélectionner...</option>

                            @foreach($documentTypes as $type)

                            <option value="{{ $type->id }}">
                                {{ $type->name }}
                            </option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>
            <!-- ========================================= -->
            <!-- FICHIERS -->
            <!-- ========================================= -->

            <div class="border-b pb-8 mb-8">

                <h2 class="text-2xl font-bold text-green-700 mb-6">
                    📂 Fichiers
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- IMAGE -->

                    <div>

                        <label class="font-semibold text-gray-700">
                            Image de couverture
                        </label>

                        <input
                            type="file"
                            name="cover_image"
                            accept="image/*"
                            class="mt-2 w-full rounded-xl border border-gray-300 p-3">

                    </div>

                    <!-- DOCUMENT -->

                    <div>

                        <label class="font-semibold text-gray-700">
                            Document (PDF) *
                        </label>

                        <input
                            type="file"
                            name="document_file"
                            accept=".pdf"
                            required
                            class="mt-2 w-full rounded-xl border border-gray-300 p-3">

                    </div>

                </div>

            </div>

            <!-- ========================================= -->
            <!-- TAGS -->
            <!-- ========================================= -->

            <div class="border-b pb-8 mb-8">

                <h2 class="text-2xl font-bold text-purple-700 mb-6">
                    🏷️ Mots-clés
                </h2>

                <label class="font-semibold text-gray-700">
                    Sélectionnez les tags
                </label>

                <select
                    name="tags[]"
                    multiple
                    class="mt-2 w-full rounded-xl border-gray-300 focus:border-purple-500 focus:ring-purple-500 h-48">

                    @foreach($tags as $tag)

                    <option value="{{ $tag->id }}">

                        {{ $tag->name }}

                    </option>

                    @endforeach

                </select>

                <p class="text-sm text-gray-500 mt-2">
                    Maintenez CTRL pour sélectionner plusieurs tags.
                </p>

            </div>

            <!-- ========================================= -->
            <!-- ACCES -->
            <!-- ========================================= -->

            <div class="border-b pb-8 mb-8">

                <h2 class="text-2xl font-bold text-orange-700 mb-6">
                    💰 Publication
                </h2>

                <div class="grid md:grid-cols-2 gap-6">

                    <div>

                        <label class="font-semibold text-gray-700">
                            Type d'accès
                        </label>

                        <select
                            id="access_type"
                            name="access_type"
                            class="mt-2 w-full rounded-xl border-gray-300">

                            <option value="free">🟢 Gratuit</option>

                            <option value="premium">🟠 Premium</option>

                        </select>

                    </div>

                    <div id="priceDiv" class="hidden">

                        <label class="font-semibold text-gray-700">
                            Prix (FCFA)
                        </label>

                        <input
                            type="number"
                            name="price"
                            class="mt-2 w-full rounded-xl border-gray-300"
                            placeholder="500">

                    </div>

                </div>

            </div>

            <!-- ========================================= -->
            <!-- BOUTONS -->
            <!-- ========================================= -->

            <div class="flex flex-col md:flex-row gap-4 justify-end">

                <a href="{{ route('journaliste.documents.index') }}"
                    class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 text-center">

                    Retour

                </a>

                <button
                    type="submit"
                    class="px-8 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold">

                    🚀 Publier le document

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const category = document.getElementById('teaching_category');

        const formationDiv = document.getElementById('formationDiv');
        const filiereDiv = document.getElementById('filiereDiv');
        const specialiteDiv = document.getElementById('specialiteDiv');
        const levelDiv = document.getElementById('levelDiv');
        const subjectDiv = document.getElementById('subjectDiv');

        function hideAll() {

            formationDiv.classList.add('hidden');
            filiereDiv.classList.add('hidden');
            specialiteDiv.classList.add('hidden');
            levelDiv.classList.add('hidden');
            subjectDiv.classList.add('hidden');

        }

        category.addEventListener('change', function() {

            hideAll();

            const text = this.options[this.selectedIndex].text.toLowerCase();

            if (text.includes('secondaire')) {

                levelDiv.classList.remove('hidden');
                subjectDiv.classList.remove('hidden');

            } else if (text.includes('supérieur général')) {

                filiereDiv.classList.remove('hidden');
                levelDiv.classList.remove('hidden');

            } else if (text.includes('supérieur technique')) {

                filiereDiv.classList.remove('hidden');
                levelDiv.classList.remove('hidden');

            } else if (text.includes('professionnel')) {

                formationDiv.classList.remove('hidden');
                specialiteDiv.classList.remove('hidden');
                levelDiv.classList.remove('hidden');

            }

        });

        hideAll();

        const access = document.getElementById('access_type');
        const price = document.getElementById('priceDiv');

        function togglePrice() {

            if (access.value === 'premium') {

                price.classList.remove('hidden');

            } else {

                price.classList.add('hidden');

            }

        }

        access.addEventListener('change', togglePrice);

        togglePrice();

    });
</script>

@endsection