@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-b from-blue-50 to-gray-50 py-14 px-4">

```
<!-- HEADER -->
<div class="max-w-6xl mx-auto text-center mb-12">

    <h1 class="text-4xl font-extrabold text-gray-800">
        👨‍🏫 Enseignement Professionnel
    </h1>

    <p class="text-gray-500 mt-2">
        Sélectionnez votre établissement de formation.
    </p>

</div>


<!-- FORMATIONS -->

<div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">

    @foreach($formations as $formation)

        @php

            $url = $formation->slug === 'ens'
                ? route('vitrine.ens.programmes')
                : route(
                    'vitrine.professionnel.niveaux',
                    [
                        'formationSlug' => $formation->slug
                    ]
                );

        @endphp


        <a href="{{ $url }}"
           class="group bg-white rounded-2xl shadow-md hover:shadow-xl
                  transition-all duration-300
                  p-8 border border-gray-100
                  hover:border-green-500 hover:-translate-y-1">


            <!-- ICÔNE -->

            <div class="text-6xl text-center group-hover:scale-110 transition">

                {{ $formation->icon ?? '🎓' }}

            </div>


            <!-- INFORMATIONS -->

            <div class="mt-5 text-center">

                <h2 class="font-bold text-xl text-gray-800
                           group-hover:text-green-600">

                    {{ $formation->name }}

                </h2>


                <p class="text-sm text-gray-500 mt-3">

                    {{ $formation->description }}

                </p>

            </div>

        </a>

    @endforeach

</div>
```

</div>

@endsection
