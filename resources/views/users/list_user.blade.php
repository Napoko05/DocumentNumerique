@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">
            <h4>Liste des utilisateurs standards</h4>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Date création</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($utilisateurs as $user)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $user->nom }}</td>
                        <td>{{ $user->prenom }}</td>

                        <td>{{ $user->email }}</td>

                        <td>{{ $user->telephone }}</td>

                        <td>
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="text-center">
                            Aucun utilisateur trouvé
                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $utilisateurs->links() }}

        </div>

    </div>

</div>

@endsection