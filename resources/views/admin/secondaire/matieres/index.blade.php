@extends('layouts.admin_app')

@section('content')

<div class="container-fluid">


    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title">Gestion des matières</h2>
            <p class="page-subtitle">
                Ajouter, modifier, activer ou supprimer les matières.
            </p>
        </div>


        <a href="{{ route('admin.secondaire.matieres.create') }}"
            class="btn btn-primary">

            + Ajouter une matière

        </a>
    </div>

    {{-- ALERTES --}}

    @if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    @endif


    @if(session('error'))

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>

    @endif




    {{-- LISTE PAR CLASSE --}}

    @forelse($levels as $level)


    <div class="card shadow-sm mb-4">


        <div class="card-header bg-light">


            <strong>

                Classe :
                {{ $level->name }}

            </strong>


        </div>



        <div class="card-body p-0">


            <div class="table-responsive">


                <table class="table table-hover mb-0">


                    <thead>

                        <tr>

                            <th width="80">
                                Ordre
                            </th>


                            <th>
                                Matière
                            </th>


                            <th>
                                Statut
                            </th>


                            <th class="text-end">
                                Actions
                            </th>


                        </tr>


                    </thead>



                    <tbody>


                        @forelse($level->subjects as $subject)



                        <tr>


                            <td>

                                {{ $subject->order }}

                            </td>



                            <td>

                                {{ $subject->name }}

                            </td>



                            <td>


                                @if($subject->is_active)


                                <span class="badge bg-success">

                                    Active

                                </span>


                                @else


                                <span class="badge bg-secondary">

                                    Désactivée

                                </span>


                                @endif


                            </td>




                            <td class="text-end">


                                {{-- Modifier --}}

                                <a href="{{ route(
                                        'admin.secondaire.matieres.edit',
                                        $subject
                                    ) }}"
                                    class="btn btn-sm btn-warning">


                                    Modifier


                                </a>





                                {{-- Activer / Désactiver --}}

                                <form
                                    action="{{ route(
                                            'admin.secondaire.matieres.toggle',
                                            $subject
                                        ) }}"
                                    method="POST"
                                    class="d-inline">


                                    @csrf

                                    @method('PATCH')


                                    <button class="btn btn-sm btn-info">


                                        {{ $subject->is_active
                                                ? 'Désactiver'
                                                : 'Activer'
                                            }}


                                    </button>


                                </form>





                                {{-- Supprimer --}}


                                <form
                                    action="{{ route(
                                            'admin.secondaire.matieres.destroy',
                                            $subject
                                        ) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm(
                                            'Supprimer cette matière ?'
                                        )">


                                    @csrf

                                    @method('DELETE')


                                    <button
                                        class="btn btn-sm btn-danger">

                                        Supprimer

                                    </button>


                                </form>



                            </td>


                        </tr>



                        @empty


                        <tr>

                            <td colspan="4"
                                class="text-center text-muted">


                                Aucune matière pour cette classe.


                            </td>


                        </tr>


                        @endforelse



                    </tbody>


                </table>


            </div>


        </div>


    </div>



    @empty


    <div class="alert alert-info">

        Aucune classe disponible.

    </div>


    @endforelse



</div>


@endsection