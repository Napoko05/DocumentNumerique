@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Rôles</h3>

    <a href="{{ route('roles.create') }}" class="btn btn-primary mb-3">
        + Nouveau rôle
    </a>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Permissions</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    @foreach($role->permissions as $perm)
                        <span class="badge bg-info">{{ $perm->name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('roles.edit',$role->id) }}"
                       class="btn btn-sm btn-warning">Modifier</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
