@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Créer un rôle</h3>

    <form method="POST" action="{{ route('roles.store') }}">
        @csrf

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Permissions</label>
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]"
                           value="{{ $permission->name }}"
                           class="form-check-input">
                    <label class="form-check-label">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button class="btn btn-success">Créer</button>
    </form>
</div>
@endsection
