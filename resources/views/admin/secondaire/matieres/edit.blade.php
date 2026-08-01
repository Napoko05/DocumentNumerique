@extends('layouts.admin_app')

@section('content')


<div class="container-fluid">


    <div class="d-flex justify-content-between align-items-center mb-4">


        <div>

            <h2>
                Modifier une matière
            </h2>


            <p class="text-muted">

                Modifier les informations de la matière.

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
                  action="{{ route(
                    'admin.secondaire.matieres.update',
                    $matiere
                  ) }}">


                @csrf

                @method('PUT')





                {{-- Classe --}}

                <div class="mb-3">


                    <label class="form-label">

                        Classe

                    </label>



                    <select name="level_id"
                            class="form-select"
                            required>



                        @foreach($levels as $level)


                            <option value="{{ $level->id }}"
                                {{ $matiere->level_id == $level->id 
                                    ? 'selected' 
                                    : '' }}>


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
                           value="{{ old(
                                'name',
                                $matiere->name
                           ) }}"
                           required>


                </div>





                {{-- Ordre --}}

                <div class="mb-3">


                    <label class="form-label">

                        Ordre

                    </label>


                    <input type="number"
                           name="order"
                           class="form-control"
                           value="{{ $matiere->order }}">


                </div>





                {{-- Statut --}}

                <div class="mb-3">


                    <label class="form-label">

                        Statut

                    </label>


                    <select name="is_active"
                            class="form-select">



                        <option value="1"
                        {{ $matiere->is_active ? 'selected' : '' }}>

                            Active

                        </option>




                        <option value="0"
                        {{ !$matiere->is_active ? 'selected' : '' }}>

                            Désactivée

                        </option>



                    </select>


                </div>




                <button class="btn btn-success">

                    Mettre à jour

                </button>



            </form>


        </div>


    </div>


</div>


@endsection