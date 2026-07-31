@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">


    <!-- HEADER -->
    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">

            🎓 {{ $filiere->name }}

        </h1>


        <p class="text-gray-500 mt-2">

            Choisissez votre niveau d'étude.

        </p>

    </div>



    <!-- NIVEAUX -->
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">


        @forelse($niveaux as $niveau)


        <a href="{{ route('vitrine.superieur.type_doc', [
                'domaineSlug' => $domaine->slug,
                'filiereSlug' => $filiere->slug,
                'niveauSlug' => $niveau->slug
            ]) }}"
           
           class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100 hover:border-blue-500 hover:-translate-y-1">


            <div class="text-5xl text-center group-hover:scale-110 transition">

                🎓

            </div>



            <div class="mt-5 text-center">


                <h3 class="font-bold text-gray-800 group-hover:text-blue-600">

                    {{ $niveau->name }}

                </h3>



                <p class="text-sm text-gray-500 mt-2">

                    Accéder aux documents

                </p>



                @if(isset($niveau->documents_count))

                <p class="text-xs text-blue-500 mt-3">

                    {{ $niveau->documents_count }} documents

                </p>

                @endif



            </div>



        </a>


        @empty


        <div class="col-span-full bg-white rounded-xl shadow p-10 text-center">

            <div class="text-5xl mb-3">
                📂
            </div>

            <h3 class="text-xl font-bold text-gray-700">
                Aucun niveau disponible
            </h3>

            <p class="text-gray-500 mt-2">
                Aucun niveau n'est enregistré pour cette filière.
            </p>

        </div>


        @endforelse


    </div>


</div>


<!-- BOUTON RETOUR -->
<div class="max-w-6xl mx-auto mb-8">

    <a href="{{ route('vitrine.superieur.domaines') }}"
    class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

        ← Retour aux domaines

    </a>

</div>
@endsection