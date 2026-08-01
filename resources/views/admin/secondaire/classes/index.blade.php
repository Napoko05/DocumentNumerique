@extends('layouts.admin_app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">Gestion des classes</h2>

            <p class="text-muted">
                Ajouter, modifier, activer ou désactiver les classes.
            </p>
        </div>

        <a href="{{ route('admin.secondaire.classes.create') }}"
           class="btn btn-primary">
            + Ajouter une classe
        </a>

    </div>

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

    @forelse($formations as $formation)

        <div class="card shadow-sm mb-4">

            <div class="card-header">
                <strong>{{ $formation->name }}</strong>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead>
                            <tr>
                                <th>Ordre</th>
                                <th>Classe</th>
                                <th>Statut</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        @forelse($formation->levels as $level)

                            <tr>

                                <td>{{ $level->order }}</td>

                                <td>{{ $level->name }}</td>

                                <td>
                                    @if($level->is_active)
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

                                    <a href="{{ route('admin.secondaire.classes.edit',$level) }}"
                                       class="btn btn-warning btn-sm">
                                        Modifier
                                    </a>

                                    <form action="{{ route('admin.secondaire.classes.toggle',$level) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('PATCH')

                                        <button class="btn btn-info btn-sm">

                                            {{ $level->is_active ? 'Désactiver' : 'Activer' }}

                                        </button>

                                    </form>

                                    <form action="{{ route('admin.secondaire.classes.destroy',$level) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer cette classe ?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">
                                            Supprimer
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center text-muted">
                                    Aucune classe disponible.
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
            Aucune formation disponible.
        </div>

    @endforelse

</div>

@endsection