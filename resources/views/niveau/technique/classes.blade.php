@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">
            🎓 Enseignement Secondaire Technique
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre classe pour accéder aux ressources pédagogiques
        </p>

    </div>


    <!-- GRID CLASSES -->
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6">


        @forelse($classes as $classe)


        <a href="{{ route('vitrine.secondaire.technique.matieres', $classe->slug) }}"
           class="group bg-white rounded-2xl shadow-md hover:shadow-2xl transition p-8 border hover:border-blue-400">


            <div class="text-4xl text-center group-hover:scale-110 transition">
                🎓
            </div>


            <div class="mt-4 text-center font-bold text-gray-800 group-hover:text-blue-600">

                {{ $classe->name }}

            </div>


            <div class="text-center text-sm text-gray-500 mt-2">

                📄 {{ $classe->documents_count ?? 0 }} document(s)

            </div>


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