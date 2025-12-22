@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Modifier utilisateur</h3>

    <form method="POST" action="{{ route('users.update',$user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="name" value="{{ $user->name }}"
                   class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prenom</label>
            <input type="text" name="prenom" value="{{ $user->prenom }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}"
                   class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Téléphone</label>
            <input type="text" name="numero" value="{{ $user->numero }}"
                   class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Rôle</label>
            <select name="role" class="form-select">
                @foreach($roles as $role)
                    <option value="{{ $role->name }}"
                        {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
