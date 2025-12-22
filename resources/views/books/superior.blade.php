@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold text-center mb-4">🎓 Enseignement Supérieur</h2>

    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('books.superior.general') }}" class="btn btn-outline-primary w-100 p-4">
                Général (Licence, Master, Doctorat)
            </a>
        </div>
        <div class="col-md-6">
            <a href="{{ route('books.superior.technique') }}" class="btn btn-outline-success w-100 p-4">
                Technique (Licence Pro, Master Pro)
            </a>
        </div>
    </div>
</div>
@endsection
