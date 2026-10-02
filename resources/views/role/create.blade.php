@extends('layouts.admin_app')

@section('page-title', 'Créer un rôle')

@section('content')

<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">

        <div>
            <h2 class="h4 fw-bold text-dark mb-1">
                Créer un rôle
            </h2>

            <p class="text-muted small mb-0">
                Créez un nouveau rôle et attribuez-lui ses permissions.
            </p>
        </div>

        <a href="{{ route('admin.roles.index') }}"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>

            Retour aux rôles

        </a>

    </div>


    {{-- Erreurs --}}
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


    {{-- Carte --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom py-3">

            <div class="d-flex align-items-center gap-3">

                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                     style="width: 42px; height: 42px;">

                    <i class="bi bi-shield-plus"></i>

                </div>

                <div>

                    <h5 class="mb-1 fw-semibold">
                        Nouveau rôle
                    </h5>

                    <small class="text-muted">
                        Définissez le rôle et ses permissions.
                    </small>

                </div>

            </div>

        </div>


        <div class="card-body p-4 p-md-5">

            <form method="POST"
                  action="{{ route('admin.roles.store') }}">

                @csrf


                {{-- Nom --}}
                <div class="mb-4">

                    <label for="name"
                           class="form-label fw-semibold">

                        Nom du rôle

                    </label>

                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Exemple : responsable"
                           required>

                    @error('name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Guard --}}
                <div class="mb-4">

                    <label for="guard_name"
                           class="form-label fw-semibold">

                        Type de rôle / Guard

                    </label>

                    <select name="guard_name"
                            id="guard_name"
                            class="form-select @error('guard_name') is-invalid @enderror"
                            required>

                        <option value="">
                            -- Choisir le guard --
                        </option>

                        <option value="web"
                            {{ old('guard_name') === 'web' ? 'selected' : '' }}>
                            web — Utilisateurs
                        </option>

                        <option value="staff"
                            {{ old('guard_name') === 'staff' ? 'selected' : '' }}>
                            staff — Administration / Personnel
                        </option>

                    </select>

                    @error('guard_name')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                    <div class="form-text">
                        Les permissions doivent utiliser le même guard que le rôle.
                    </div>

                </div>


                {{-- Permissions --}}
                <div class="mb-4">

                    <div class="d-flex align-items-center justify-content-between mb-3">

                        <label class="form-label fw-semibold mb-0">
                            Permissions
                        </label>

                        <span class="badge bg-light text-dark border"
                              id="permissionCounter">

                            0 sélectionnée(s)

                        </span>

                    </div>


                    @if($permissions->count())

                        <div class="row g-3"
                             id="permissionsContainer">

                            @foreach($permissions as $permission)

                                <div class="col-12 col-md-6 permission-item"
                                     data-guard="{{ $permission->guard_name }}">

                                    <label class="permission-card d-flex align-items-start gap-3 p-3 border rounded-3 h-100"
                                           for="permission_{{ $permission->id }}">

                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->name }}"
                                               id="permission_{{ $permission->id }}"
                                               class="form-check-input permission-checkbox mt-1">

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

                            Créer le rôle

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

    .permission-item {
        transition: all 0.2s ease;
    }

    .permission-item.permission-hidden {
        display: none !important;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const guardSelect = document.getElementById('guard_name');
    const permissionItems = document.querySelectorAll('.permission-item');
    const checkboxes = document.querySelectorAll('.permission-checkbox');
    const counter = document.getElementById('permissionCounter');

    function updatePermissions() {

        const selectedGuard = guardSelect.value;
        let selectedCount = 0;

        permissionItems.forEach(function (item) {

            const permissionGuard = item.dataset.guard;

            if (!selectedGuard || permissionGuard === selectedGuard) {

                item.classList.remove('permission-hidden');

            } else {

                item.classList.add('permission-hidden');

                const checkbox = item.querySelector('input[type="checkbox"]');

                if (checkbox) {
                    checkbox.checked = false;
                }
            }
        });


        checkboxes.forEach(function (checkbox) {

            if (checkbox.checked) {
                selectedCount++;
            }

        });


        counter.textContent =
            selectedCount + ' sélectionnée(s)';
    }


    guardSelect.addEventListener('change', updatePermissions);


    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', updatePermissions);

    });


    updatePermissions();

});
</script>

@endsection