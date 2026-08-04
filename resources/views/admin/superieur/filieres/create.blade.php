@extends('layouts.admin_app')


@section('content')


<div class="container">


    <div class="card shadow-sm">


        <div class="card-header">

            <h4>
                Ajouter une filière
            </h4>

        </div>



        <div class="card-body">


            <form action="{{ route(
    'admin.superieur.filieres.store'
) }}"
                method="POST">


                @csrf



                <div class="mb-3">


                    <label class="form-label">

                        Domaine académique

                    </label>


                    <select
                        name="academic_domain_id"
                        class="form-select"
                        required>


                        <option value="">

                            Choisir un domaine

                        </option>



                        @foreach($domaines as $domaine)


                        <option value="{{ $domaine->id }}"
                            @selected(old('academic_domain_id')==$domaine->id)
                            >

                            {{ $domaine->name }}

                        </option>


                        @endforeach


                    </select>


                </div>





                <div class="mb-3">


                    <label class="form-label">

                        Nom de la filière

                    </label>



                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="Exemple : Informatique"
                        required>


                </div>





                <div class="mb-3">


                    <label class="form-label">

                        Description

                    </label>


                    <textarea
                        name="description"
                        class="form-control"
                        rows="4">{{ old('description') }}</textarea>


                </div>





                <a href="{{ route(
'admin.superieur.filieres.index'
) }}"
                    class="btn btn-secondary">

                    Retour

                </a>


                <button class="btn btn-primary">

                    Enregistrer

                </button>



            </form>


        </div>


    </div>


</div>


@endsection