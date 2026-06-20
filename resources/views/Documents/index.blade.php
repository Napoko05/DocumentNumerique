@extends('layouts.journalist_app')

@section('title', 'Mes documents')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mes documents</h2>

        <a href="{{ route('journaliste.documents.create') }}"
           class="btn btn-primary">
            + Nouveau document
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-hover">

                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Niveau</th>
                        <th>Accès</th>
                        <th>Prix</th>
                        <th>Vues</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($documents as $document)

                    <tr>

                        <td>{{ $document->title }}</td>

                        <td>{{ $document->category }}</td>

                        <td>{{ $document->level }}</td>

                        <td>

                            @if($document->access_type == 'free')
                                <span class="badge bg-success">
                                    Gratuit
                                </span>
                            @else
                                <span class="badge bg-warning">
                                    Premium
                                </span>
                            @endif

                        </td>

                        <td>

                            @if($document->access_type == 'premium')
                                {{ number_format($document->price) }} FCFA
                            @else
                                -
                            @endif

                        </td>

                        <td>{{ $document->views }}</td>

                        <td>

                            <a href="{{ route('journaliste.documents.show',$document) }}"
                               class="btn btn-sm btn-info">
                                Voir
                            </a>

                            <a href="{{ route('journaliste.documents.edit',$document) }}"
                               class="btn btn-sm btn-warning">
                                Modifier
                            </a>

                            <form action="{{ route('journaliste.documents.destroy',$document) }}"
                                  method="POST"
                                  class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Supprimer ce document ?')">
                                    Supprimer
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center">
                            Aucun document publié.
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $documents->links() }}

        </div>
    </div>

</div>

@endsection