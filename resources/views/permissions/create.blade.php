@extends('layouts.admin_app')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <a href="{{ route('admin.permissions.index') }}"
           class="btn btn-sm btn-outline-secondary mb-3">

            <i class="bi bi-arrow-left me-1"></i>
            Retour aux permissions

        </a>

        <h1 class="h3 fw-bold mb-1">

            <i class="bi bi-shield-plus me-2"></i>
            Nouvelle permission

        </h1>

        <p class="text-muted mb-0">
            Créez une permission et attribuez-la à un rôle.
        </p>

    </div>


    {{-- Erreurs --}}
    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                <i class="bi bi-exclamation-triangle me-2"></i>
                Vérifiez les informations.
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="row justify-content-center">

        <div class="col-xl-7 col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h5 class="mb-0 fw-semibold">

                        <i class="bi bi-shield-check me-2"></i>
                        Informations de la permission

                    </h5>

                </div>


                <div class="card-body p-4">

                    <form action="{{ route('admin.permissions.store') }}"
                          method="POST">

                        @csrf


                        {{-- Nom --}}
                        <div class="mb-4">

                            <label for="name"
                                   class="form-label fw-semibold">

                                Nom de la permission
                                <span class="text-danger">*</span>

                            </label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Exemple : documents.create"
                                   required>

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                            <div class="form-text">
                                Exemple :
                                <code>users.create</code>,
                                <code>documents.edit</code>,
                                <code>documents.delete</code>.
                            </div>

                        </div>


                        {{-- Rôle --}}
                        <div class="mb-4">

                            <label for="role_id"
                                   class="form-label fw-semibold">

                                Rôle
                                <span class="text-danger">*</span>

                            </label>

                            <select name="role_id"
                                    id="role_id"
                                    class="form-select @error('role_id') is-invalid @enderror"
                                    required>

                                <option value="">
                                    -- Choisir un rôle --
                                </option>

                                @foreach($roles as $role)

                                    <option value="{{ $role->id }}"
                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>

                                        {{ ucfirst($role->name) }}

                                    </option>

                                @endforeach

                            </select>

                            @error('role_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                            <div class="form-text">
                                La permission sera automatiquement attribuée
                                au rôle sélectionné.
                            </div>

                        </div>


                        {{-- Information --}}
                        <div class="alert alert-info">

                            <div class="d-flex gap-2">

                                <i class="bi bi-info-circle fs-5"></i>

                                <div>

                                    <strong>
                                        Attribution automatique
                                    </strong>

                                    <p class="mb-0 small mt-1">
                                        Après création, cette permission sera
                                        directement disponible pour le rôle
                                        sélectionné.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- Boutons --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">

                            <a href="{{ route('admin.permissions.index') }}"
                               class="btn btn-outline-secondary">

                                <i class="bi bi-x-circle me-1"></i>
                                Annuler

                            </a>


                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="bi bi-check-circle me-1"></i>
                                Créer la permission

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection