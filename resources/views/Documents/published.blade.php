@extends('layouts.journaliste_app')

@section('title', 'Documents publiés')

@section('page-title', 'Documents publiés')

@section('content')

<div class="container-fluid">

    <div class="mb-4">
        <h2>Mes documents publiés</h2>

        <p class="text-muted">
            Retrouvez ici tous vos documents actuellement publiés.
        </p>
    </div>

    @if($documents->count())

        <div class="row g-4">

            @foreach($documents as $document)

                <div class="col-md-6 col-xl-4">

                    <div class="card h-100">

                        @if($document->cover_image)

                            <img
                                src="{{ asset('storage/' . $document->cover_image) }}"
                                class="card-img-top"
                                alt="{{ $document->title }}"
                                style="height:200px; object-fit:cover;"
                            >

                        @endif

                        <div class="card-body">

                            <h5 class="card-title">
                                {{ $document->title }}
                            </h5>

                            @if($document->description)

                                <p class="card-text text-muted">
                                    {{ Str::limit($document->description, 100) }}
                                </p>

                            @endif

                            <div class="small text-muted">

                                @if($document->level)
                                    Niveau :
                                    {{ $document->level->name }}
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-4">

            {{ $documents->links() }}

        </div>

    @else

        <div class="alert alert-info">

            <i class="bi bi-info-circle me-2"></i>

            Vous n'avez encore aucun document publié.

        </div>

    @endif

</div>

@endsection