@extends('layouts.admin_app')

@section('content')

<div class="container-fluid py-4">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h1 class="h3 fw-bold mb-1">
                <i class="bi bi-pencil-square me-2"></i>
                Modifier le module
            </h1>

            <p class="text-muted mb-0">
                Modification du module :
                <strong>{{ $subject->name }}</strong>
            </p>
        </div>

        <a href="{{ route('admin.superieur.modules.index') }}"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Retour aux modules
        </a>

    </div>


    {{-- Formulaire --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-journal-text me-2"></i>
                Informations du module
            </h5>
        </div>

        <div class="card-body p-4">

            <form method="POST"
                  action="{{ route('admin.superieur.modules.update', $subject) }}">

                @csrf
                @method('PUT')


                {{-- Domaine --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Domaine
                    </label>

                    <input
                        type="text"
                        class="form-control bg-light"
                        value="{{ $subject->level?->filiere?->academicDomain?->name ?? 'Non renseigné' }}"
                        readonly
                    >

                </div>


                {{-- Filière --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Filière
                    </label>

                    <input
                        type="text"
                        class="form-control bg-light"
                        value="{{ $subject->level?->filiere?->name ?? 'Non renseignée' }}"
                        readonly
                    >

                </div>


                {{-- Niveau --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Niveau
                    </label>

                    <input
                        type="text"
                        class="form-control bg-light"
                        value="{{ $subject->level?->name ?? 'Non renseigné' }}"
                        readonly
                    >

                </div>


                {{-- Nom du module --}}
                <div class="mb-4">

                    <label for="name" class="form-label fw-semibold">
                        Nom du module
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $subject->name) }}"
                        placeholder="Exemple : Algorithmique"
                        required
                        autofocus
                    >

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Position --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Ordre d'affichage
                    </label>

                    <input
                        type="text"
                        class="form-control bg-light"
                        value="{{ $subject->position ?? 0 }}"
                        readonly
                    >

                </div>


                {{-- Statut --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Statut
                    </label>

                    <input
                        type="text"
                        class="form-control bg-light"
                        value="{{ $subject->is_active ? 'Actif' : 'Inactif' }}"
                        readonly
                    >

                </div>


                {{-- Boutons --}}
                <div class="d-flex justify-content-end gap-2 pt-3 border-top">

                    <a
                        href="{{ route('admin.superieur.modules.index') }}"
                        class="btn btn-outline-secondary"
                    >
                        <i class="bi bi-x-lg me-1"></i>
                        Annuler
                    </a>

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        <i class="bi bi-check-lg me-1"></i>
                        Enregistrer les modifications
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection