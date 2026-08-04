@extends('layouts.admin_app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-4">

        <h4>
            Gestion des filières - Supérieur
        </h4>


        <a href="{{ route('admin.superieur.filieres.create') }}"
           class="btn btn-primary">

            Ajouter une filière

        </a>

    </div>



    <div class="card shadow-sm">

        <div class="card-body">


            @foreach($domaines as $domaine)


            <h5 class="mt-3">

                {{ $domaine->name }}

            </h5>



            <div class="table-responsive">


                <table class="table table-bordered">


                    <thead>

                        <tr>

                            <th>
                                Filière
                            </th>


                            <th>
                                Statut
                            </th>


                            <th width="200">
                                Actions
                            </th>

                        </tr>

                    </thead>



                    <tbody>


                    @forelse($domaine->filieres as $filiere)


                        <tr>


                            <td>

                                {{ $filiere->name }}

                            </td>



                            <td>

                                @if($filiere->is_active)

                                    <span class="badge bg-success">
                                        Active
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Désactivée
                                    </span>

                                @endif


                            </td>



                            <td>


                                <a href="{{ route(
                                    'admin.superieur.filieres.edit',
                                    $filiere
                                ) }}"
                                class="btn btn-sm btn-warning">

                                    Modifier

                                </a>



                                <form
                                    action="{{ route(
                                        'admin.superieur.filieres.toggle',
                                        $filiere
                                    ) }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf
                                    @method('PATCH')


                                    <button
                                        class="btn btn-sm btn-secondary">

                                        Activer/Désactiver

                                    </button>


                                </form>



                                <form
                                    action="{{ route(
                                        'admin.superieur.filieres.destroy',
                                        $filiere
                                    ) }}"
                                    method="POST"
                                    class="d-inline"
                                >

                                    @csrf
                                    @method('DELETE')


                                    <button
                                        onclick="return confirm('Supprimer cette filière ?')"
                                        class="btn btn-sm btn-danger">

                                        Supprimer

                                    </button>


                                </form>


                            </td>


                        </tr>



                    @empty


                        <tr>

                            <td colspan="3">

                                Aucune filière

                            </td>

                        </tr>


                    @endforelse


                    </tbody>


                </table>


            </div>


            @endforeach


        </div>

    </div>


</div>

@endsection