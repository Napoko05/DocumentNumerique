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

            <i class="bi bi-pencil-square me-2"></i>
            Modifier la permission

        </h1>

        <p class="text-muted mb-0">
            Modifiez le nom et le rôle associé à cette permission.
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

                    <div class="d-flex align-items-center gap-3">

                        <div class="rounded-circle
                                    bg-primary-subtle
                                    text-primary
                                    d-flex
                                    align-items-center
                                    justify-content-center"
                             style="width:44px;height:44px;">

                            <i class="bi bi-key"></i>

                        </div>

                        <div>

                            <h5 class="mb-0 fw-semibold">
                                Modifier la permission
                            </h5>

                            <small class="text-muted">
                                ID : {{ $permission->id }}
                            </small>

                        </div>

                    </div>

                </div>


                <div class="card-body p-4">

                    <form action="{{ route('admin.permissions.update', $permission->id) }}"
                          method="POST">

                        @csrf
                        @method('PUT')


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
                                   value="{{ old('name', $permission->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   required>

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

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
                                        {{ old(
                                            'role_id',
                                            $currentRole?->id
                                        ) == $role->id ? 'selected' : '' }}>

                                        {{ ucfirst($role->name) }}

                                    </option>

                                @endforeach

                            </select>

                            @error('role_id')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Guard --}}
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Guard
                            </label>

                            <input type="text"
                                   class="form-control"
                                   value="{{ $permission->guard_name }}"
                                   readonly>

                        </div>


                        {{-- Boutons --}}
                        <div class="d-flex justify-content-end gap-2">

                            <a href="{{ route('admin.permissions.index') }}"
                               class="btn btn-outline-secondary">

                                <i class="bi bi-x-circle me-1"></i>
                                Annuler

                            </a>


                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="bi bi-save me-1"></i>
                                Enregistrer

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection