@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    {{-- HEADER --}}
    <div class="max-w-6xl mx-auto text-center mb-12">


        <h1 class="text-3xl font-extrabold text-gray-800">

            📖 {{ $matiere->name }}

        </h1>


        <p class="text-gray-600 mt-2">

            <span class="font-semibold">
                {{ $filiere->name }}
            </span>

            •

            <span>
                {{ $niveau->name }}
            </span>

        </p>


        <p class="text-gray-500 mt-2">

            Choisissez le type de document.

        </p>


    </div>




    {{-- TYPES DOCUMENTS --}}
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">



        @forelse($types as $type)



        <a href="{{ route('vitrine.sup_tech.documents', [

                $filiere->slug,
                $niveau->slug,
                $matiere->slug,
                $type->slug

            ]) }}"


        class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border hover:border-blue-500 text-center">



            <div class="text-5xl">

                {{ $type->icon ?? '📄' }}

            </div>




            <div class="mt-4 font-bold text-gray-800">

                {{ $type->name }}

            </div>




            <p class="text-sm text-gray-500 mt-2">

                📄 {{ $type->documents_count }} document(s)

            </p>




        </a>



        @empty



        <div class="col-span-full">

            <div class="bg-white rounded-xl shadow p-10 text-center">


                <h3 class="font-semibold text-gray-700">

                    Aucun type de document disponible.

                </h3>


            </div>

        </div>



        @endforelse



    </div>


</div>

@endsection