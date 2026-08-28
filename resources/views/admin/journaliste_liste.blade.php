@extends('layouts.admin_app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Liste des journalistes
            </h2>

            <p class="text-muted mb-0">
                Gérez les comptes des journalistes.
            </p>
        </div>

    </div>


    {{-- MESSAGE SUCCÈS --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- MESSAGE ERREUR --}}

    @if(session('error'))

        <div class="alert alert-danger">
            {{ session('error') }}
        </div>

    @endif


    <div class="table-responsive">

        <table class="table table-bordered table-hover align-middle">

            <thead>

                <tr>

                    <th>ID</th>

                    <th>Matricule</th>

                    <th>Nom</th>

                    <th>Prénom</th>

                    <th>Email</th>

                    <th>Téléphone</th>

                    <th class="text-center">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($journalistes as $journaliste)

                    <tr>

                        <td>
                            {{ $journaliste->id }}
                        </td>

                        <td>
                            {{ $journaliste->matricule ?? '—' }}
                        </td>

                        <td>
                            {{ $journaliste->nom }}
                        </td>

                        <td>
                            {{ $journaliste->prenom }}
                        </td>

                        <td>
                            {{ $journaliste->email }}
                        </td>

                        <td>
                            {{ $journaliste->tel ?? '—' }}
                        </td>


                        {{-- ACTIONS --}}

                        <td>

                            <div class="d-flex justify-content-center gap-2">


                                {{-- MODIFIER --}}

                                <a
                                    href="{{ route(
                                        'admin.staff.journalistes.edit',
                                        $journaliste
                                    ) }}"
                                    class="btn btn-sm btn-primary"
                                    title="Modifier"
                                >
                                    Modifier
                                </a>


                                {{-- SUPPRIMER --}}

                                <form
                                    action="{{ route(
                                        'admin.staff.journalistes.destroy',
                                        $journaliste
                                    ) }}"
                                    method="POST"
                                    onsubmit="return confirm(
                                        'Voulez-vous vraiment supprimer ce journaliste ?'
                                    );"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-danger"
                                        title="Supprimer"
                                    >
                                        Supprimer
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            class="text-center py-4"
                        >
                            Aucun journaliste trouvé.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection