@extends('layouts.admin_app')

@section('page-title', 'Modifier le rôle')

@section('content')

<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">

        <div>
            <h2 class="h4 fw-bold text-dark mb-1">
                Modifier le rôle
            </h2>

            <p class="text-muted small mb-0">
                Modifiez le nom du rôle et les permissions qui lui sont associées.
            </p>
        </div>

        <a href="{{ route('admin.roles.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Retour aux rôles

        </a>

    </div>


    {{-- Erreurs de validation --}}
    @if($errors->any())

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            <div class="fw-semibold mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                Veuillez corriger les erreurs suivantes :
            </div>

            <ul class="mb-0 ps-4">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Fermer">
            </button>

        </div>

    @endif


    {{-- Formulaire --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom py-3">

            <div class="d-flex align-items-center gap-3">

                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                     style="width: 42px; height: 42px;">

                    <i class="bi bi-shield-fill"></i>

                </div>

                <div>

                    <h5 class="mb-1 fw-semibold">
                        {{ ucfirst($role->name) }}
                    </h5>

                    <small class="text-muted">
                        ID : {{ $role->id }}
                        ·
                        Guard : {{ $role->guard_name }}
                    </small>

                </div>

            </div>

        </div>


        <div class="card-body p-4 p-md-5">

            <form method="POST"
                  action="{{ route('admin.roles.update', $role->id) }}">

                @csrf

                @method('PUT')


                {{-- Nom du rôle --}}
                <div class="mb-4">

                    <label for="name"
                           class="form-label fw-semibold">

                        Nom du rôle

                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name', $role->name) }}"
                           required
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Exemple : administrateur">

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                    <div class="form-text">
                        Le nom doit identifier clairement le rôle.
                    </div>

                </div>


                {{-- Guard --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Guard
                    </label>

                    <div class="form-control bg-light">

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

                            <span class="badge bg-secondary-subtle text-secondary border">
                                {{ $role->guard_name }}
                            </span>

                        @endif

                    </div>

                    <div class="form-text">
                        Le guard du rôle est conservé automatiquement.
                    </div>

                </div>


                {{-- Permissions --}}
                <div class="mb-4">

                    <div class="d-flex align-items-center justify-content-between mb-3">

                        <label class="form-label fw-semibold mb-0">
                            Permissions
                        </label>

                        <span class="badge bg-light text-dark border">
                            {{ $permissions->count() }} permission(s)
                        </span>

                    </div>


                    @if($permissions->count())

                        <div class="row g-3">

                            @foreach($permissions as $permission)

                                @php
                                    $isChecked = $role->hasPermissionTo(
                                        $permission->name,
                                        $permission->guard_name
                                    );
                                @endphp

                                <div class="col-12 col-md-6">

                                    <label class="permission-card d-flex align-items-start gap-3 p-3 border rounded-3 h-100"
                                           for="permission_{{ $permission->id }}">

                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               id="permission_{{ $permission->id }}"
                                               class="form-check-input mt-1"
                                               {{ $isChecked ? 'checked' : '' }}>

                                        <div class="flex-grow-1">

                                            <div class="fw-semibold text-dark">

                                                {{ $permission->name }}

                                            </div>

                                            <small class="text-muted">

                                                <i class="bi bi-shield me-1"></i>

                                                {{ $permission->guard_name }}

                                            </small>

                                        </div>

                                    </label>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="text-center border rounded-3 p-4 bg-light">

                            <i class="bi bi-key fs-2 text-muted"></i>

                            <p class="text-muted mb-0 mt-2">
                                Aucune permission disponible.
                            </p>

                        </div>

                    @endif

                </div>


                {{-- Actions --}}
                <div class="border-top pt-4 mt-4">

                    <div class="d-flex flex-column flex-sm-row gap-2">

                        <button type="submit"
                                class="btn btn-primary">

                            <i class="bi bi-check-lg me-1"></i>

                            Enregistrer les modifications

                        </button>

                        <a href="{{ route('admin.roles.index') }}"
                           class="btn btn-outline-secondary">

                            <i class="bi bi-x-lg me-1"></i>

                            Annuler

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- Style spécifique à cette page --}}
<style>
    .permission-card {
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .permission-card:hover {
        background-color: #f8f9fa;
        border-color: rgba(13, 110, 253, 0.35) !important;
    }

    .permission-card:has(input:checked) {
        background-color: #f0f6ff;
        border-color: rgba(13, 110, 253, 0.5) !important;
    }

    .permission-card .form-check-input {
        cursor: pointer;
    }
</style>

@endsection