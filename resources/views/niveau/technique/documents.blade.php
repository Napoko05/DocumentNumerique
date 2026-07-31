@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-3xl font-extrabold text-gray-800">

            📄 {{ $type->name }} - {{ $matiere->name }}

        </h1>


        <p class="text-gray-500 mt-2">

            Classe : {{ $classe->name }}

        </p>

    </div>



    <!-- DOCUMENTS GRID -->
    <div class="max-w-6xl mx-auto grid md:grid-cols-3 gap-6">


        @forelse($documents as $document)


        <div class="bg-white rounded-2xl shadow-md hover:shadow-2xl transition p-6 border">


            <div class="flex items-center justify-between">


                <h3 class="font-bold text-gray-800">

                    {{ $document->title }}

                </h3>


                <span class="text-blue-500 text-xl">

                    📄

                </span>


            </div>



            <p class="text-sm text-gray-500 mt-3">

                {{ Str::limit($document->description, 100) }}

            </p>



            <div class="text-xs text-gray-400 mt-3">

                Ajouté par :
                {{ $document->staff->name ?? 'Administration' }}

            </div>



            <a href="{{ asset('storage/'.$document->file_path) }}"
               target="_blank"
               class="mt-5 block text-center w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white py-2 rounded-xl hover:opacity-90 transition">

                📖 Ouvrir

            </a>


        </div>


        @empty


        <div class="col-span-full">

            <div class="bg-white rounded-xl shadow p-10 text-center">


                <h3 class="text-lg font-semibold text-gray-700">

                    Aucun document disponible.

                </h3>


            </div>

        </div>


        @endforelse


    </div>


    <div class="mt-8">

        {{ $documents->links() }}

    </div>


</div>



@endsection