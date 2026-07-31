@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    {{-- HEADER --}}
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-3xl font-extrabold text-gray-800">
            📚 Classe : {{ $classe->name }}
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez une matière.
        </p>

    </div>

    {{-- MATIÈRES --}}
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6">

        @forelse($matieres as $matiere)

            <a href="{{ route('vitrine.secondaire.general.type_doc', [$classe->slug, $matiere->slug]) }}"
               class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition p-6 border hover:border-green-400">

                <div class="text-4xl text-center">

                    {{ $matiere->icon ?? '📚' }}

                </div>

                <div class="mt-3 text-center font-bold text-gray-800">

                    {{ $matiere->name }}

                </div>

                <div class="text-center text-sm text-gray-500 mt-1">

                    📄 {{ $matiere->documents_count }} document(s)

                </div>

            </a>

        @empty

            <div class="col-span-full">

                <div class="bg-white rounded-xl shadow p-10 text-center">

                    <h3 class="text-lg font-semibold text-gray-700">

                        Aucune matière disponible.

                    </h3>

                </div>

            </div>

        @endforelse

    </div>

</div>



@endsection