@extends('layouts.journalist_app')

@section('title', $document->title)

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-body">

            <h2>{{ $document->title }}</h2>

            <hr>

            <p>
                <strong>Catégorie :</strong>
                {{ $document->category }}
            </p>

            <p>
                <strong>Niveau :</strong>
                {{ $document->level }}
            </p>

            <p>
                <strong>Cycle :</strong>
                {{ $document->cycle }}
            </p>

            <p>
                <strong>Type :</strong>

                @if($document->access_type == 'free')
                    <span class="badge bg-success">
                        Gratuit
                    </span>
                @else
                    <span class="badge bg-warning">
                        Premium
                    </span>
                @endif
            </p>

            @if($document->access_type == 'premium')
                <p>
                    <strong>Prix :</strong>
                    {{ number_format($document->price) }} FCFA
                </p>
            @endif

            <p>
                <strong>Nombre de vues :</strong>
                {{ $document->views }}
            </p>

            <hr>

            <h5>Description</h5>

            <p>
                {{ $document->description }}
            </p>

            <hr>

            <a href="{{ route('journaliste.documents.edit',$document) }}"
               class="btn btn-warning">
                Modifier
            </a>

            <a href="{{ route('journaliste.documents.index') }}"
               class="btn btn-secondary">
                Retour
            </a>

        </div>

    </div>

</div>

@endsection