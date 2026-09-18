@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')

<div class="contact-page">

    <div class="contact-container">

        {{-- En-tête --}}
        <div class="contact-header">

            <span class="contact-kicker">
                Support
            </span>

            <h1 class="contact-title">
                Contactez-nous
            </h1>

            <p class="contact-description">
                Une question ? Écrivez-nous, nous vous répondrons rapidement.
            </p>

        </div>


        {{-- Message de succès --}}
        @if(session('success'))
            <div class="contact-alert contact-alert-success" role="alert">

                <span class="contact-alert-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </span>

                <span>
                    {{ session('success') }}
                </span>

            </div>
        @endif


        {{-- Erreurs de validation --}}
        @if($errors->any())
            <div class="contact-alert contact-alert-danger" role="alert">

                <span class="contact-alert-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </span>

                <div>
                    <strong>
                        Veuillez corriger les erreurs suivantes :
                    </strong>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>

            </div>
        @endif


        {{-- Carte du formulaire --}}
        <div class="contact-card">

            <form
                action="{{ route('contact.submit') }}"
                method="POST"
                class="contact-form"
            >

                @csrf


                {{-- Nom --}}
                <div class="contact-field">

                    <label
                        for="nom"
                        class="contact-label"
                    >
                        Nom & Prenom
                    </label>

                    <input
                        type="text"
                        id="nom"
                        name="nom"
                        value="{{ old('nom') }}"
                        required
                        autocomplete="name"
                        placeholder="Votre nom"
                        class="contact-input @error('nom') is-invalid @enderror"
                    >

                    @error('nom')
                        <small class="contact-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- Email --}}
                <div class="contact-field">

                    <label
                        for="email"
                        class="contact-label"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="email@exemple.com"
                        class="contact-input @error('email') is-invalid @enderror"
                    >

                    @error('email')
                        <small class="contact-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- Objet --}}
                <div class="contact-field">

                    <label
                        for="objet"
                        class="contact-label"
                    >
                        Objet
                    </label>

                    <input
                        type="text"
                        id="objet"
                        name="objet"
                        value="{{ old('objet') }}"
                        placeholder="Sujet de votre message"
                        class="contact-input @error('objet') is-invalid @enderror"
                    >

                    @error('objet')
                        <small class="contact-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- Message --}}
                <div class="contact-field">

                    <label
                        for="message"
                        class="contact-label"
                    >
                        Message
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        rows="5"
                        required
                        placeholder="Votre message..."
                        class="contact-textarea @error('message') is-invalid @enderror"
                    >{{ old('message') }}</textarea>

                    @error('message')
                        <small class="contact-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- Bouton d'envoi --}}
                <button
                    type="submit"
                    class="contact-submit"
                >
                    <i class="bi bi-send-fill"></i>
                    <span>Envoyer le message</span>
                </button>

            </form>

        </div>

    </div>

</div>

@endsection