@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    {{-- HEADER --}}
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">
            🎓 {{ $formation->name }}
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre classe pour accéder aux ressources pédagogiques.
        </p>

    </div>

    {{-- CLASSES --}}
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($classes as $classe)

           <a href="{{ route('vitrine.secondaire.general.matieres', $classe->slug) }}"
               class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-transparent hover:border-blue-500">

                <div class="flex justify-center">
                    <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center text-3xl group-hover:scale-110 transition">
                        🎓
                    </div>
                </div>

                <h3 class="mt-5 text-center text-lg font-bold text-gray-800 group-hover:text-blue-600">
                    {{ $classe->name }}
                </h3>

                <p class="mt-2 text-center text-sm text-gray-500">
                    {{ $classe->documents_count }} document(s)
                </p>

            </a>

        @empty

            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow p-10 text-center">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Aucune classe disponible.
                    </h3>
                </div>
            </div>

        @endforelse

    </div>

</div>



@endsection