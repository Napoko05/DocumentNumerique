@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">

            🎓 {{ $domaine->name }}

        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre formation.
        </p>

    </div>



    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">


        @forelse($formations as $formation)


        <a href="{{ route('vitrine.superieur.filieres',[

            'domaineSlug'=>$domaine->slug,

            'formationSlug'=>$formation->slug

        ]) }}"

        class="bg-white rounded-2xl shadow-md hover:shadow-xl
        transition p-8 border hover:border-blue-500">


            <div class="text-5xl text-center">

                {{ $formation->icon ?? '🎓' }}

            </div>


            <h2 class="text-center mt-5 font-bold text-xl">

                {{ $formation->name }}

            </h2>


            <p class="text-center text-sm text-gray-500 mt-3">

                {{ $formation->documents_count }} document(s)

            </p>


        </a>


        @empty


        <div class="col-span-full bg-white rounded-xl shadow p-10 text-center">

            Aucune formation disponible.

        </div>


        @endforelse


    </div>


</div>


@endsection