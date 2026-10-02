@extends('layouts.admin_app')

@section('page-title', 'Rôles')

@section('content')

<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">

        <div>
            <h2 class="h4 fw-bold mb-1 text-dark">
                Gestion des rôles
            </h2>

            <p class="text-muted mb-0 small">
                Gérez les rôles et les permissions associés.
            </p>
        </div>

        <a href="{{ route('admin.roles.create') }}"
            class="btn btn-primary d-inline-flex align-items-center gap-2">

            <i class="bi bi-plus-lg"></i>

            <span>Nouveau rôle</span>
        </a>

    </div>


    {{-- Message de succès --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <i class="bi bi-check-circle me-2"></i>

        {{ session('success') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fermer">
        </button>

    </div>
    @endif


    {{-- Message d'erreur --}}
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <i class="bi bi-exclamation-triangle me-2"></i>

        {{ session('error') }}

        <button type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Fermer">
        </button>

    </div>
    @endif


    {{-- Carte principale --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom py-3">

            <div class="d-flex align-items-center justify-content-between">

                <div>
                    <h5 class="mb-1 fw-semibold">
                        Rôles disponibles
                    </h5>

                    <small class="text-muted">
                        {{ $roles->count() }} rôle(s)
                    </small>
                </div>

                <i class="bi bi-shield-check fs-4 text-primary"></i>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th class="px-4 py-3 text-muted small text-uppercase">
                                #
                            </th>

                            <th class="px-4 py-3 text-muted small text-uppercase">
                                Nom
                            </th>

                            <th class="px-4 py-3 text-muted small text-uppercase">
                                Guard
                            </th>

                            <th class="px-4 py-3 text-muted small text-uppercase">
                                Permissions
                            </th>

                            <th class="px-4 py-3 text-muted small text-uppercase text-end">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($roles as $role)

                        <tr>

                            {{-- Numéro --}}
                            <td class="px-4 py-3 text-muted">
                                {{ $loop->iteration }}
                            </td>


                            {{-- Nom --}}
                            <td class="px-4 py-3">

                                <div class="d-flex align-items-center gap-2">

                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                        style="width: 38px; height: 38px;">

                                        <i class="bi bi-shield-fill"></i>

                                    </div>

                                    <div>

                                        <div class="fw-semibold text-dark">
                                            {{ ucfirst($role->name) }}
                                        </div>

                                        <small class="text-muted">
                                            ID : {{ $role->id }}
                                        </small>

                                    </div>

                                </div>

                            </td>


                            {{-- Guard --}}
                            <td class="px-4 py-3">

                                @if($role->guard_name === 'staff')

                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">
                                    <i class="bi bi-person-badge me-1"></i>
                                    staff
                                </span>

                                @elseif($role->guard_name === 'web')

                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                    <i class="bi bi-person me-1"></i>
                                    web
                                </span>

                                @else

                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    {{ $role->guard_name }}
                                </span>

                                @endif

                            </td>


                            {{-- Permissions --}}
                            <td class="px-4 py-3">

                                @if($role->permissions->count())

                                <div class="d-flex flex-wrap gap-1">

                                    @foreach($role->permissions as $permission)

                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-key me-1 text-primary"></i>
                                        {{ $permission->name }}
                                    </span>

                                    @endforeach

                                </div>

                                @else

                                <span class="text-muted small">
                                    <i class="bi bi-dash-circle me-1"></i>
                                    Aucune permission
                                </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-4 py-3 text-end">

                             
                                <div class="d-flex gap-2">

                                    {{-- Modifier --}}
                                    <a href="{{ route('admin.roles.edit', ['id' => $role->id]) }}"
                                        class="btn btn-sm btn-outline-primary"
                                        title="Modifier">
                                        <i class="bi bi-pencil-square me-1"></i>
                                        Modifier
                                    </a>

                                    {{-- Supprimer --}}
                                    <form action="{{ route('admin.roles.destroy', ['id' => $role->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer le rôle « {{ $role->name }} » ?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Supprimer">
                                            <i class="bi bi-trash me-1"></i>
                                            Supprimer
                                        </button>
                                    </form>

                                </div>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center py-5">

                                <div class="mb-3">

                                    <i class="bi bi-shield-x fs-1 text-muted"></i>

                                </div>

                                <h6 class="fw-semibold text-dark">
                                    Aucun rôle trouvé
                                </h6>

                                <p class="text-muted small mb-3">
                                    Aucun rôle n'est actuellement enregistré.
                                </p>

                                <a href="{{ route('admin.roles.create') }}"
                                    class="btn btn-primary btn-sm">

                                    <i class="bi bi-plus-lg me-1"></i>

                                    Créer un rôle

                                </a>

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection