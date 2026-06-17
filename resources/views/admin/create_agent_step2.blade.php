@extends('layouts.admin_app')

@section('content')

<div class="agent-page">

    <h2 class="agent-main-title">
        Créer un journaliste - Étape 2 : Documents
    </h2>

    <form action="{{ route('admin.staff.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <h4>Récapitulatif</h4>

        <div class="card p-3 mb-4">

            @foreach($data as $key => $value)

                @if(!in_array($key, [
                    'password',
                    'password_confirmation'
                ]))

                    <div class="mb-2">
                        <strong>{{ ucfirst(str_replace('_',' ', $key)) }}</strong>
                        : {{ $value }}
                    </div>

                    <input type="hidden"
                           name="{{ $key }}"
                           value="{{ $value }}">

                @endif

            @endforeach

        </div>

        {{-- Alias système --}}
        <input type="hidden"
               name="role_alias"
               value="journalist">

        <input type="hidden"
               name="role_label"
               value="Journaliste">

        <h4>Documents justificatifs</h4>

        <div class="agent-field">
            <label>CNIB</label>
            <input type="file" name="cnib_file">
        </div>

        <div class="agent-field">
            <label>Attestation de travail</label>
            <input type="file"
                   name="attestation_travail_file">
        </div>

        <div class="agent-field">
            <label>Diplôme</label>
            <input type="file"
                   name="diplome_file">
        </div>

        <div class="agent-field">
            <label>Signature</label>
            <input type="file"
                   name="signature_file">
        </div>

        <div class="mt-4">

            <a href="{{ route('admin.staff.create') }}"
               class="btn btn-secondary">
                Retour
            </a>

            <button type="submit"
                    class="btn btn-primary">
                Créer le journaliste
            </button>

        </div>

    </form>

</div>

@endsection