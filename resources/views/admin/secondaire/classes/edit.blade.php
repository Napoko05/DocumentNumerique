@extends('layouts.admin_app')

@section('content')

<div class="container">


<div class="card shadow-sm">

    <div class="card-header">
        <h4 class="mb-0">
            Modifier la classe
        </h4>
    </div>

    <div class="card-body">

        <form
            action="{{ route('admin.secondaire.classes.update', ['class' => $classe->id]) }}"
            method="POST"
        >

            @csrf
            @method('PUT')


            {{-- FORMATION --}}
            <div class="mb-3">

                <label for="formation_id" class="form-label">
                    Formation
                </label>

                <select
                    id="formation_id"
                    name="formation_id"
                    class="form-select @error('formation_id') is-invalid @enderror"
                    required
                >

                    <option value="">
                        -- Sélectionner une formation --
                    </option>

                    @foreach($formations as $formation)

                        <option
                            value="{{ $formation->id }}"
                            @selected(
                                old(
                                    'formation_id',
                                    $classe->formation_id
                                ) == $formation->id
                            )
                        >
                            {{ $formation->name }}
                        </option>

                    @endforeach

                </select>

                @error('formation_id')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- SECTION --}}
            <div class="mb-3">

                <label for="section" class="form-label">
                    Section
                </label>

                <select
                    id="section"
                    name="section"
                    class="form-select @error('section') is-invalid @enderror"
                    required
                >

                    <option value="">
                        -- Sélectionner une section --
                    </option>

                    <option
                        value="general"
                        @selected(
                            old(
                                'section',
                                $classe->section
                            ) === 'general'
                        )
                    >
                        Général
                    </option>

                    <option
                        value="technique"
                        @selected(
                            old(
                                'section',
                                $classe->section
                            ) === 'technique'
                        )
                    >
                        Technique
                    </option>

                </select>

                @error('section')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- NOM --}}
            <div class="mb-3">

                <label for="name" class="form-label">
                    Nom de la classe
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $classe->name) }}"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Exemple : 6ème"
                    required
                >

                @error('name')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- ORDRE --}}
            <div class="mb-4">

                <label for="order" class="form-label">
                    Ordre d'affichage
                </label>

                <input
                    type="number"
                    id="order"
                    name="order"
                    value="{{ old('order', $classe->order) }}"
                    class="form-control @error('order') is-invalid @enderror"
                    min="0"
                >

                @error('order')

                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- BOUTONS --}}
            <div class="d-flex gap-2">

                <a
                    href="{{ route('admin.secondaire.classes.index') }}"
                    class="btn btn-secondary"
                >
                    Annuler
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Mettre à jour
                </button>

            </div>

        </form>

    </div>

</div>


</div>

@endsection
