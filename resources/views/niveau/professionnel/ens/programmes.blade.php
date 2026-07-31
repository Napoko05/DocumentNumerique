@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

    <div class="max-w-6xl mx-auto text-center mb-12">

        <h1 class="text-4xl font-extrabold text-gray-800">
            👨‍🏫 ENS
        </h1>

        <p class="text-gray-500 mt-2">
            Choisissez votre programme.
        </p>

    </div>


    <div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-6">


        @foreach($programmes as $programme)

        <a href="{{ route('vitrine.ens.specialites',[
    'programmeSlug'=>$programme->slug
]) }}"
            class="bg-white rounded-2xl shadow-md p-8 text-center hover:shadow-xl transition">


            <div class="text-6xl">
                🎓
            </div>


            <h2 class="mt-4 font-bold text-xl text-gray-800">
                {{ $programme->name }}
            </h2>


            <p class="text-gray-500 mt-2">
                Accéder aux spécialités
            </p>


        </a>


        @endforeach


    </div>

</div>
<div class="max-w-6xl mx-auto mb-8">

    <a href="{{ route('vitrine.professionnel.formations', [
        'formationSlug' => $formation->slug,

    ]) }}"
    class="inline-flex items-center gap-2 bg-white text-blue-600 px-5 py-3 rounded-xl shadow hover:shadow-lg hover:bg-blue-50 transition">

        ← Retour

    </a>

</div>

@endsection