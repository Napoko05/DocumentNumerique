@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Modifier rôle</h3>

    <form method="POST" action="{{ route('roles.update',$role->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name"
                   value="{{ $role->name }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Permissions</label>
            @foreach($permissions as $permission)
                <div class="form-check">
                    <input type="checkbox" name="permissions[]"
                           value="{{ $permission->name }}"
                           class="form-check-input"
                           {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                    <label class="form-check-label">
                        {{ $permission->name }}
                    </label>
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
