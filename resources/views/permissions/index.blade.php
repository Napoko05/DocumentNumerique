@extends('layouts.admin_app')

@section('content')

<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1">
                <i class="bi bi-shield-lock me-2"></i>
                Gestion des permissions
            </h1>

            <p class="text-muted mb-0">
                Gérez les permissions et leur attribution aux rôles.
            </p>
        </div>

        <a href="{{ route('admin.permissions.create') }}"
            class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>
            Nouvelle permission

        </a>

    </div>


    {{-- Messages --}}
    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show"
        role="alert">

        <i class="bi bi-check-circle me-2"></i>

        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    @if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show"
        role="alert">

        <i class="bi bi-exclamation-triangle me-2"></i>

        {{ session('error') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    {{-- Carte --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom py-3">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="mb-1 fw-semibold">
                        Liste des permissions
                    </h5>

                    <small class="text-muted">
                        {{ $permissions->count() }}
                        permission{{ $permissions->count() > 1 ? 's' : '' }}
                    </small>

                </div>

                <span class="badge bg-primary">
                    <i class="bi bi-shield-check me-1"></i>
                    Permissions
                </span>

            </div>

        </div>


        <div class="card-body p-0">

            @if($permissions->count())

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4">
                                #
                            </th>

                            <th>
                                Permission
                            </th>

                            <th>
                                Rôle
                            </th>

                            <th>
                                Guard
                            </th>

                            <th class="text-end px-4">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($permissions as $permission)

                        <tr>

                            {{-- ID --}}
                            <td class="px-4 text-muted">
                                {{ $permission->id }}
                            </td>


                            {{-- Permission --}}
                            <td>

                                <div class="d-flex align-items-center gap-2">

                                    <div class="rounded-circle
                                                        bg-primary-subtle
                                                        text-primary
                                                        d-flex
                                                        align-items-center
                                                        justify-content-center"
                                        style="width:40px;height:40px;">

                                        <i class="bi bi-key"></i>

                                    </div>

                                    <div>

                                        <div class="fw-semibold">
                                            {{ $permission->name }}
                                        </div>

                                        <small class="text-muted">
                                            Permission système
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- Rôle --}}
                            <td>

                                @forelse($permission->roles as $role)

                                <span class="badge bg-success-subtle text-success">
                                    <i class="bi bi-person-badge me-1"></i>
                                    {{ $role->name }}
                                </span>

                                @empty

                                <span class="badge bg-secondary">
                                    Aucun rôle
                                </span>

                                @endforelse

                            </td>


                            {{-- Guard --}}
                            <td>

                                <span class="badge bg-light text-dark border">
                                    {{ $permission->guard_name }}
                                </span>

                            </td>


                            {{-- Actions --}}
                            <td class="text-end px-4">

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.permissions.edit', ['id' => $permission->id]) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Modifier">

                                        <i class="bi bi-pencil"></i>

                                    </a>


                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer cette permission ?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Supprimer">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @else

            <div class="text-center py-5">

                <i class="bi bi-shield-lock text-muted"
                    style="font-size:3rem;"></i>

                <h5 class="mt-3">
                    Aucune permission
                </h5>

                <p class="text-muted">
                    Aucune permission n'a encore été créée.
                </p>

                <a href="{{ route('admin.permissions.create') }}"
                    class="btn btn-primary">

                    <i class="bi bi-plus-circle me-1"></i>
                    Créer une permission

                </a>

            </div>

            @endif

        </div>

    </div>

</div>

@endsection