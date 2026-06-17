@extends('layouts.admin_app')

@section('content')
<div class="container">
    <h2>Liste des journalistes</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
            </tr>
        </thead>

        <tbody>
            @foreach($journalistes as $journaliste)
                <tr>
                    <td>{{ $journaliste->id }}</td>
                    <td>{{ $journaliste->nom }}</td>
                    <td>{{ $journaliste->prenom }}</td>
                    <td>{{ $journaliste->email }}</td>
                    <td>{{ $journaliste->tel }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection