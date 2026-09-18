@extends('layouts.admin_app')

@section('content')

<div class="container-fluid">

<div class="card users-card">

    {{-- HEADER --}}
    <div class="users-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">
            Liste des utilisateurs
        </h4>

        <a
            href="{{ route('admin.users.create') }}"
            class="btn btn-light"
        >
            Ajouter utilisateur
        </a>

    </div>


    {{-- CONTENU --}}
    <div class="card-body">

        {{-- MESSAGE DE SUCCÈS --}}
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
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Status</th>
                        <th width="320">Actions</th>
                    </tr>

                </thead>


                <tbody>

                    @forelse($users as $user)

                        <tr>

                            {{-- NUMÉRO --}}
                            <td>
                                {{ $users->firstItem() + $loop->index }}
                            </td>


                            {{-- NOM --}}
                            <td>
                                <strong>
                                    {{ $user->nom }}
                                </strong>
                            </td>


                            {{-- PRÉNOM --}}
                            <td>
                                {{ $user->prenom }}
                            </td>


                            {{-- EMAIL --}}
                            <td>
                                {{ $user->email }}
                            </td>


                            {{-- RÔLE --}}
                            <td>

                                @forelse($user->roles as $role)

                                    <span class="badge bg-info">
                                        {{ $role->name }}
                                    </span>

                                @empty

                                    <span class="text-muted">
                                        Aucun rôle
                                    </span>

                                @endforelse

                            </td>


                            {{-- STATUS --}}
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


                            {{-- ACTIONS --}}
                            <td>

                                <div class="d-flex gap-2 flex-wrap">

                                    {{-- MODIFICATION --}}
                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        <i class="fas fa-edit"></i>
                                        Modifier
                                    </a>


                                    {{-- ACTIVATION / DÉSACTIVATION --}}
                                    @if($user->is_active)

                                        {{-- DÉSACTIVER --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.deactivate', $user) }}"
                                            class="d-inline"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-secondary btn-sm"
                                                onclick="return confirm('Désactiver cet utilisateur ?')"
                                            >
                                                <i class="fas fa-lock"></i>
                                                Désactiver
                                            </button>

                                        </form>

                                    @else

                                        {{-- ACTIVER --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.activate', $user) }}"
                                            class="d-inline"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="btn btn-success btn-sm"
                                                onclick="return confirm('Activer cet utilisateur ?')"
                                            >
                                                <i class="fas fa-unlock"></i>
                                                Activer
                                            </button>

                                        </form>

                                    @endif


                                    {{-- SUPPRESSION --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        class="d-inline"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Supprimer cet utilisateur ?')"
                                        >
                                            <i class="fas fa-trash"></i>
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
                                class="text-center"
                            >
                                Aucun utilisateur trouvé
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        <div class="mt-3">

            {{ $users->links() }}

        </div>

    </div>

</div>

</div>

@endsection
