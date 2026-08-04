```blade
@extends('layouts.journalist_app')

@section('title', 'Modifier le document')

@section('content')

<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">

    <div class="max-w-3xl mx-auto">

        {{-- ===================================================== --}}
        {{-- EN-TÊTE --}}
        {{-- ===================================================== --}}

        <div class="mb-8 text-center">

            <h1 class="text-3xl font-bold text-gray-800">

                ✏️ Modifier le document

            </h1>

            <p class="text-gray-500 mt-2">

                Mettez à jour les informations du document.

            </p>

        </div>


        {{-- ===================================================== --}}
        {{-- ERREURS --}}
        {{-- ===================================================== --}}

        @if ($errors->any())

            <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5">

                <strong class="text-red-700">

                    Des erreurs ont été détectées.

                </strong>

                <ul class="mt-3 list-disc pl-5 text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                        <li>

                            {{ $error }}

                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- CARTE --}}
        {{-- ===================================================== --}}

        <div class="bg-white shadow-xl rounded-2xl border border-gray-100">

            <form

                action="{{ route('journaliste.documents.update', $document) }}"

                method="POST"

                enctype="multipart/form-data"

                class="p-8 space-y-6"

            >

                @csrf

                @method('PUT')


                {{-- ================================================= --}}
                {{-- INFORMATIONS --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                    {{-- TITRE --}}

                    <div class="md:col-span-2">

                        <label
                            for="title"
                            class="text-sm font-semibold text-blue-700"
                        >

                            Titre

                            <span class="text-red-500">

                                *

                            </span>

                        </label>

                        <input

                            type="text"

                            id="title"

                            name="title"

                            value="{{ old('title', $document->title) }}"

                            required

                            class="mt-2 w-full rounded-xl border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500
                                   shadow-sm"

                        >

                    </div>


                    {{-- DESCRIPTION --}}

                    <div class="md:col-span-2">

                        <label
                            for="description"
                            class="text-sm font-semibold text-blue-700"
                        >

                            Description

                        </label>

                        <textarea

                            id="description"

                            name="description"

                            rows="5"

                            class="mt-2 w-full rounded-xl border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500
                                   shadow-sm"

                        >{{ old('description', $document->description) }}</textarea>

                    </div>


                    {{-- TYPE D'ACCÈS --}}

                    <div>

                        <label
                            for="access_type"
                            class="text-sm font-semibold text-blue-700"
                        >

                            Type d’accès

                        </label>

                        <select

                            name="access_type"

                            id="access_type"

                            class="mt-2 w-full rounded-xl border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500
                                   shadow-sm"

                        >

                            <option

                                value="free"

                                @selected(
                                    old(
                                        'access_type',
                                        $document->access_type
                                    ) === 'free'
                                )

                            >

                                🟢 Gratuit

                            </option>


                            <option

                                value="premium"

                                @selected(
                                    old(
                                        'access_type',
                                        $document->access_type
                                    ) === 'premium'
                                )

                            >

                                🟠 Premium

                            </option>

                        </select>

                    </div>


                    {{-- PRIX --}}

                    <div

                        id="priceDiv"

                        class="
                            {{
                                old(
                                    'access_type',
                                    $document->access_type
                                ) === 'premium'
                                    ? ''
                                    : 'hidden'
                            }}
                        "

                    >

                        <label
                            for="price"
                            class="text-sm font-semibold text-orange-600"
                        >

                            💰 Prix (FCFA)

                        </label>

                        <input

                            type="number"

                            id="price"

                            name="price"

                            min="0"

                            step="1"

                            value="{{ old('price', $document->price) }}"

                            class="mt-2 w-full rounded-xl
                                   border-orange-300
                                   focus:border-orange-500
                                   focus:ring-orange-500
                                   shadow-sm"

                        >

                    </div>


                    {{-- NOUVEAU FICHIER --}}

                    <div class="md:col-span-2">

                        <label
                            for="file"
                            class="text-sm font-semibold text-blue-700"
                        >

                            Remplacer le fichier

                        </label>

                        <input

                            type="file"

                            id="file"

                            name="file"

                            class="mt-2 block w-full rounded-xl
                                   border border-gray-300
                                   p-3
                                   shadow-sm"

                        >

                        <p class="mt-2 text-sm text-gray-500">

                            Laissez ce champ vide pour conserver
                            le fichier actuel.

                        </p>

                    </div>


                    {{-- FICHIER ACTUEL --}}

                    @if ($document->file_path)

                        <div class="md:col-span-2">

                            <div
                                class="rounded-xl
                                       border
                                       border-blue-100
                                       bg-blue-50
                                       p-4"
                            >

                                <p class="font-semibold text-blue-800">

                                    📄 Fichier actuel

                                </p>

                                <p class="mt-1 text-sm text-blue-600">

                                    {{ basename($document->file_path) }}

                                </p>

                            </div>

                        </div>

                    @endif

                </div>


                {{-- ================================================= --}}
                {{-- BOUTONS --}}
                {{-- ================================================= --}}

                <div class="flex flex-col sm:flex-row gap-4 pt-6">

                    <button

                        type="submit"

                        class="
                            w-full
                            sm:w-auto
                            px-6
                            py-3
                            bg-green-600
                            hover:bg-green-700
                            text-white
                            font-semibold
                            rounded-xl
                            shadow-md
                            transition
                        "

                    >

                        💾 Enregistrer les modifications

                    </button>


                    <a

                        href="{{ route('journaliste.documents.index') }}"

                        class="
                            w-full
                            sm:w-auto
                            px-6
                            py-3
                            bg-gray-200
                            hover:bg-gray-300
                            text-gray-800
                            font-semibold
                            rounded-xl
                            text-center
                            transition
                        "
                    >

                        ❌ Annuler

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const accessType =
            document.getElementById(
                'access_type'
            );

        const priceDiv =
            document.getElementById(
                'priceDiv'
            );

        const priceInput =
            document.getElementById(
                'price'
            );


        if (
            !accessType
            ||
            !priceDiv
            ||
            !priceInput
        ) {
            return;
        }


        function togglePrice()
        {

            if (
                accessType.value
                ===
                'premium'
            ) {

                priceDiv.classList.remove(
                    'hidden'
                );

                priceInput.required = true;

            } else {

                priceDiv.classList.add(
                    'hidden'
                );

                priceInput.required = false;

                priceInput.value = '';

            }

        }


        accessType.addEventListener(
            'change',
            togglePrice
        );


        togglePrice();

    }
);

</script>

@endpush

