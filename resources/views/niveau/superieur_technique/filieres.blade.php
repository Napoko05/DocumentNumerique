@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    {{-- HEADER --}}
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">

            🛠️ {{ $formation->name }}

        </h1>


        <p class="text-gray-500 mt-2">

            Choisissez votre filière pour accéder aux ressources pédagogiques.

        </p>

    </div>



    {{-- FILIERES --}}
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">


        @forelse($filieres as $filiere)


        <a href="{{ route('vitrine.sup_tech.niveaux', [
                $formation->slug,
                $filiere->slug
            ]) }}"


        class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 hover:border-green-500 hover:-translate-y-1">



            <div class="text-5xl text-center group-hover:scale-110 transition duration-300">

                {{ $filiere->icon ?? '⚙️' }}

            </div>



            <div class="mt-5 text-center">


                <h3 class="font-bold text-gray-800 group-hover:text-green-600 text-lg">

                    {{ $filiere->name }}

                </h3>



                <p class="text-sm text-gray-500 mt-2">

                    📄 {{ $filiere->documents_count }} document(s)

                </p>



            </div>



        </a>


        @empty


        <div class="col-span-full">

            <div class="bg-white rounded-xl shadow p-10 text-center">

                <h3 class="text-lg font-semibold text-gray-700">

                    Aucune filière disponible.

                </h3>

            </div>

        </div>


        @endforelse



    </div>


</div>

@endsection