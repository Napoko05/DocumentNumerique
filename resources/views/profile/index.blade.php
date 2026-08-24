@extends('layouts.app')

@section('title', 'Mon profil | YAA\'Scientia')

@section('page-title', 'Mon profil')

@section('content')

<div class="profile-page">

    <div class="profile-header">

        <div>
            <span class="profile-label">
                MON COMPTE
            </span>

            <h2>
                Paramètres du profil
            </h2>

            <p>
                Gérez vos informations personnelles et la sécurité de votre compte.
            </p>
        </div>

    </div>


    <div class="profile-sections">

        <section class="profile-card">

            <div class="profile-card-content">

                @include('partials.update_profile')

            </div>

        </section>


        <section class="profile-card">

            <div class="profile-card-content">

                @include('profile.partials.update-password-form')

            </div>

        </section>


        <section class="profile-card profile-danger">

            <div class="profile-card-content">

                @include('profile.partials.delete-user-form')

            </div>

        </section>

    </div>

</div>

@endsection