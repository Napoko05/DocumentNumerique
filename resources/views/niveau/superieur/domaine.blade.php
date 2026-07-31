@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">
            🎓 Enseignement Supérieur
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre domaine académique.
        </p>

    </div>



    <!-- DOMAINES -->
    <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">


        @foreach($domaines as $domaine)


        <a href="{{ route('vitrine.superieur.filieres', [
            'domaineSlug' => $domaine->slug
        ]) }}"
        class="group bg-white rounded-2xl shadow-md
        hover:shadow-xl transition-all duration-300
        p-8 border border-gray-100
        hover:border-blue-500
        hover:-translate-y-1">


            <div class="text-5xl text-center group-hover:scale-110 transition">

                @switch($domaine->slug)

                    @case('sciences-exactes')
                        🔬
                    @break

                    @case('sciences-sociales')
                        🌍
                    @break

                    @case('sciences-langage')
                        📚
                    @break

                    @default
                        🎓

                @endswitch

            </div>



            <div class="mt-5 text-center">


                <h3 class="font-bold text-gray-800 
                    group-hover:text-blue-600 text-xl">

                    {{ $domaine->name }}

                </h3>


                <p class="text-sm text-gray-500 mt-3">

                    Découvrir les formations disponibles

                </p>


            </div>


        </a>


        @endforeach


    </div>
</div>

@endsection