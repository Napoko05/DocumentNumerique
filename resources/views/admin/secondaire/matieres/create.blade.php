@extends('layouts.admin_app')

@section('content')

<div class="container-fluid">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>
                Ajouter une matière
            </h2>

            <p class="text-muted">
                Ajouter une nouvelle matière à une classe.
            </p>

        </div>


        <a href="{{ route('admin.secondaire.matieres.index') }}"
           class="btn btn-secondary">

            ← Retour

        </a>


    </div>



    <div class="card shadow-sm">

        <div class="card-body">


            <form method="POST"
                  action="{{ route('admin.secondaire.matieres.store') }}">

                @csrf



                {{-- Classe --}}

                <div class="mb-3">

                    <label class="form-label">
                        Classe
                    </label>


                    <select name="level_id"
                            class="form-select"
                            required>


                        <option value="">
                            -- Choisir une classe --
                        </option>


                        @foreach($levels as $level)

                            <option value="{{ $level->id }}">

                                {{ $level->name }}

                            </option>


                        @endforeach


                    </select>


                </div>




                {{-- Nom --}}

                <div class="mb-3">

                    <label class="form-label">
                        Nom de la matière
                    </label>


                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           placeholder="Ex: Mathématiques"
                           required>


                </div>




                {{-- Ordre --}}

                <div class="mb-3">

                    <label class="form-label">
                        Ordre d'affichage
                    </label>


                    <input type="number"
                           name="order"
                           class="form-control"
                           value="{{ old('order',0) }}">


                </div>




                {{-- Statut --}}

                <div class="mb-3">


                    <label class="form-label">

                        Statut

                    </label>


                    <select name="is_active"
                            class="form-select">


                        <option value="1">
                            Active
                        </option>


                        <option value="0">
                            Désactivée
                        </option>


                    </select>


                </div>




                <button class="btn btn-primary">

                    Enregistrer

                </button>


            </form>


        </div>

    </div>


</div>


@endsection