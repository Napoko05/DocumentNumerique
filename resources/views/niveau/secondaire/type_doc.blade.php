@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    {{-- HEADER --}}
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-3xl font-extrabold text-gray-800">
            📖 {{ $matiere->name }} - {{ $classe->name }}
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez le type de document.
        </p>

    </div>

    {{-- TYPES DE DOCUMENTS --}}
    <div class="max-w-6xl mx-auto flex gap-5 overflow-x-auto pb-4">

        @forelse($types as $type)

            <a href="{{ route('vitrine.secondaire.general.documents', [
                    $classe->slug,
                    $matiere->slug,
                    $type->slug
                ]) }}"
               class="min-w-[200px] bg-white rounded-2xl shadow-md hover:shadow-2xl transition p-6 border text-center shrink-0">

                <div class="text-4xl">

                    {{ $type->icon ?? '📚' }}

                </div>

                <div class="mt-3 font-bold text-gray-800">

                    {{ $type->name }}

                </div>

                <div class="mt-2 text-sm text-gray-500">

                    {{ $type->documents_count }} document(s)

                </div>

            </a>

        @empty

            <div class="w-full">

                <div class="bg-white rounded-xl shadow p-10 text-center">

                    <h3 class="text-lg font-semibold text-gray-700">

                        Aucun type de document disponible.

                    </h3>

                </div>

            </div>

        @endforelse

    </div>

</div>


@endsection