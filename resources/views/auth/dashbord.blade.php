<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <h1 class="mb-4">Dashboard Admin</h1>

    <div class="row g-4">

        <!-- Utilisateurs -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Utilisateurs</h5>
                    <p class="card-text fs-3">{{ $totalUsers }}</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">Voir tous</a>
                </div>
            </div>
        </div>

        <!-- Journalistes -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Journalistes</h5>
                    <p class="card-text fs-3">{{ $totalJournalists }}</p>
                    <a href="{{ route('admin.users.index', ['role'=>'journaliste']) }}" class="btn btn-primary btn-sm">Gérer</a>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Documents</h5>
                    <p class="card-text fs-3">{{ $totalDocuments }}</p>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-primary btn-sm">Voir tous</a>
                </div>
            </div>
        </div>

        <!-- Paramètres plateforme -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Paramètres</h5>
                    <p class="card-text fs-5">Configurer la plateforme</p>
                    <a href="{{ route('admin.settings') }}" class="btn btn-warning btn-sm">Accéder</a>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
