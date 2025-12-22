@extends('layouts.app')

@section('content')
<div class="container my-5">
    <!-- Titre principal -->
    <h2 class="fw-bold mb-4">Bienvenue sur <span class="text-primary">Scientia</span></h2>

    <!-- Statut utilisateur -->
    @auth
    <div class="alert alert-success mt-3">
        Vous êtes connecté en tant que
        <strong>{{ auth()->user()->name }}</strong>
        @if(auth()->user()->roles->isNotEmpty())
        <span class="ms-2">
            (Rôle :
            @foreach(auth()->user()->roles as $role)
            <span class="badge bg-info text-dark">{{ ucfirst($role->name) }}</span>
            @endforeach
            )
        </span>
        @endif
    </div>
    @else
    <div class="alert alert-warning mt-3">
         Vous n’êtes pas connecté.
    </div>
    @endauth

    <!-- Section d’introduction -->
    <div class="mt-4">
        <p class="lead">
            Scientia est une plateforme de partage et de consultation de documents numériques
            (gratuits et premium) pour l’enseignement secondaire et supérieur.
        </p>
        <p>
            Explorez les livres disponibles, publiez vos propres documents si vous êtes journaliste,
            ou gérez vos ressources si vous êtes administrateur.
        </p>
    </div>

    <!-- Actions rapides -->
    <div class="mt-5">
        @auth
        @php
        $user = Auth::user();
        if($user->hasRole('admin')){
        $dashboardRoute = route('admin.dashboard');
        } elseif($user->hasRole('journalist')){
        $dashboardRoute = route('journalist.dashboard');
        } else {
        $dashboardRoute = route('home'); // utilisateur standard reste sur accueil
        }
        @endphp

        <a href="{{ $dashboardRoute }}" class="btn btn-outline-success me-2">
            Tableau de bord
        </a>

        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-danger"> Se déconnecter</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="btn btn-primary me-2"> Se connecter</a>
        <a href="{{ route('register') }}" class="btn btn-success">S’inscrire</a>
        @endauth
    </div>
</div>
@endsection