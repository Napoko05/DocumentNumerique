@extends('layouts.admin_app')

@section('content')

<div class="container-fluid">

    <div class="card users-card">

        <div class="users-header d-flex justify-content-between align-items-center">

            <h4 class="mb-0">

                Liste des utilisateurs

            </h4>

            <a href="{{ route('admin.users.create') }}"
                class="btn btn-light">

                Ajouter utilisateur

            </a>

        </div>

        <div class="card-body">

            @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

            @endif
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                         <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Status</th>
                            <th width="280">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse($users as $user)

                        <tr>
                            <td>

                                {{ $loop->iteration }}

                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                <span class="badge bg-info">
                                    {{ $role->name }}
                                </span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->is_active)
                                <span class="badge bg-success">
                                    Actif
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    Bloqué
                                </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    {{-- EDITION --}}
                                    <a href="{{ route('admin.users.edit',$user) }}"
                                        class="btn btn-warning btn-sm">

                                        <i class="fas fa-edit"></i>
                                        Modifier
                                    </a>
                                    {{-- ACTIVATION / DESACTIVATION --}}

                                    @if($user->is_active)
                                    <form method="POST"
                                        action="{{ route('users.deactivate',$user) }}">
                                        @csrf
                                        <button
                                            class="btn btn-secondary btn-sm">

                                            <i class="fas fa-lock"></i>
                                            Désactiver
                                        </button>
                                    </form>
                                    @else
                                    <form method="POST"
                                        action="{{ route('users.activate',$user) }}">

                                        @csrf

                                        <button
                                            class="btn btn-success btn-sm">

                                            <i class="fas fa-unlock"></i>
                                            Activer
                                        </button>
                                    </form>
                                    @endif

                                    {{-- SUPPRESSION --}}

                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.destroy',$user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            onclick="return confirm('Supprimer cet utilisateur ?')"
                                            class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        @empty
                        <tr>

                            <td colspan="6"
                                class="text-center">

                                Aucun utilisateur trouvé

                            </td>
                        </tr>

                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">

                {{ $users->links() }}

            </div>
        </div>
    </div>
</div>

@endsection