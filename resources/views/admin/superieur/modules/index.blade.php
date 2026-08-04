@extends('layouts.admin_app')

@section('title', 'Gestion des modules')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-1">
                Gestion des modules
            </h3>

            <p class="text-muted mb-0">
                Domaines → Filières → Niveaux → Modules
            </p>
        </div>

        <a
            href="{{ route('admin.superieur.modules.create') }}"
            class="btn btn-primary"
        >
            <i class="fas fa-plus"></i>
            Ajouter un module
        </a>

    </div>


    {{-- MESSAGE SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif


    {{-- MESSAGE ERROR --}}
    @if(session('error'))

        <div class="alert alert-danger">

            {{ session('error') }}

        </div>

    @endif


    @forelse($domaines as $domaine)

        <div class="card shadow-sm mb-4">

            {{-- DOMAINE --}}
            <div class="card-header bg-dark text-white">

                <strong>

                    {{ $domaine->name }}

                </strong>

            </div>


            <div class="card-body">

                @forelse($domaine->filieres as $filiere)

                    <div class="card border mb-4">

                        {{-- FILIERE --}}
                        <div class="card-header bg-light">

                            <strong>

                                Filière :

                            </strong>

                            {{ $filiere->name }}

                        </div>


                        <div class="card-body p-0">

                            @forelse($filiere->levels as $level)

                                <div class="p-3 border-bottom">

                                    {{-- NIVEAU --}}
                                    <h6 class="mb-3">

                                        Niveau :

                                        <span class="text-primary">

                                            {{ $level->name }}

                                        </span>

                                    </h6>


                                    <div class="table-responsive">

                                        <table class="table table-hover mb-0">

                                            <thead>

                                                <tr>

                                                    <th>

                                                        Ordre

                                                    </th>

                                                    <th>

                                                        Module

                                                    </th>

                                                    <th>

                                                        Statut

                                                    </th>

                                                    <th class="text-end">

                                                        Actions

                                                    </th>

                                                </tr>

                                            </thead>


                                            <tbody>

                                                @forelse($level->subjects as $subject)

                                                    <tr>

                                                        <td>

                                                            {{ $subject->order }}

                                                        </td>


                                                        <td>

                                                            {{ $subject->name }}

                                                        </td>


                                                        <td>

                                                            @if(
                                                                $subject->is_active
                                                            )

                                                                <span
                                                                    class="badge bg-success"
                                                                >

                                                                    Actif

                                                                </span>

                                                            @else

                                                                <span
                                                                    class="badge bg-danger"
                                                                >

                                                                    Désactivé

                                                                </span>

                                                            @endif

                                                        </td>


                                                        <td class="text-end">

                                                            {{-- MODIFIER --}}
                                                            <a
                                                                href="{{ route(
                                                                    'admin.superieur.modules.edit',
                                                                    $subject
                                                                ) }}"
                                                                class="btn btn-sm btn-warning"
                                                            >

                                                                Modifier

                                                            </a>


                                                            {{-- ACTIVER --}}
                                                            <form
                                                                action="{{ route(
                                                                    'admin.superieur.modules.toggle',
                                                                    $subject
                                                                ) }}"
                                                                method="POST"
                                                                class="d-inline"
                                                            >

                                                                @csrf

                                                                @method('PATCH')

                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-sm btn-secondary"
                                                                >

                                                                    {{ $subject->is_active
                                                                        ? 'Désactiver'
                                                                        : 'Activer'
                                                                    }}

                                                                </button>

                                                            </form>


                                                            {{-- SUPPRIMER --}}
                                                            <form
                                                                action="{{ route(
                                                                    'admin.superieur.modules.destroy',
                                                                    $subject
                                                                ) }}"
                                                                method="POST"
                                                                class="d-inline"
                                                                onsubmit="return confirm(
                                                                    'Voulez-vous supprimer ce module ?'
                                                                )"
                                                            >

                                                                @csrf

                                                                @method('DELETE')

                                                                <button
                                                                    type="submit"
                                                                    class="btn btn-sm btn-danger"
                                                                >

                                                                    Supprimer

                                                                </button>

                                                            </form>

                                                        </td>

                                                    </tr>

                                                @empty

                                                    <tr>

                                                        <td
                                                            colspan="4"
                                                            class="text-center text-muted"
                                                        >

                                                            Aucun module
                                                            dans ce niveau.

                                                        </td>

                                                    </tr>

                                                @endforelse

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            @empty

                                <div class="p-3 text-muted">

                                    Aucun niveau dans cette filière.

                                </div>

                            @endforelse

                        </div>

                    </div>

                @empty

                    <div class="alert alert-light">

                        Aucune filière dans ce domaine.

                    </div>

                @endforelse

            </div>

        </div>

    @empty

        <div class="alert alert-info">

            Aucun domaine académique trouvé.

        </div>

    @endforelse

</div>

@endsection