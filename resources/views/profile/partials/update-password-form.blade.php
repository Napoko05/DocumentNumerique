{{-- ============================================================= --}}
{{-- CHANGEMENT DU MOT DE PASSE --}}
{{-- ============================================================= --}}

<div class="profile-form-header">

    <div>

        <span class="profile-section-label">
            SÉCURITÉ
        </span>

        <h3>
            Modifier mon mot de passe
        </h3>

        <p>
            Utilisez un mot de passe suffisamment long et difficile à deviner.
        </p>

    </div>

</div>


<form
    method="POST"
    action="{{ route('journaliste.password.update') }}"
    class="profile-form"
>

    @csrf
    @method('PUT')


    <div class="profile-form-grid profile-form-grid-single">


        {{-- MOT DE PASSE ACTUEL --}}
        <div class="profile-field">

            <label for="current_password">
                Mot de passe actuel
                <span class="required">*</span>
            </label>

            <input
                id="current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                required
                class="@error('current_password', 'updatePassword') is-invalid @enderror"
            >

            @error('current_password', 'updatePassword')
                <span class="field-error">
                    {{ $message }}
                </span>
            @enderror

        </div>


        {{-- NOUVEAU MOT DE PASSE --}}
        <div class="profile-field">

            <label for="password">
                Nouveau mot de passe
                <span class="required">*</span>
            </label>

            <input
                id="password"
                name="password"
                type="password"
                autocomplete="new-password"
                required
                class="@error('password', 'updatePassword') is-invalid @enderror"
            >

            @error('password', 'updatePassword')
                <span class="field-error">
                    {{ $message }}
                </span>
            @enderror

            <small class="profile-help">
                Minimum 8 caractères.
            </small>

        </div>


        {{-- CONFIRMATION --}}
        <div class="profile-field">

            <label for="password_confirmation">
                Confirmer le nouveau mot de passe
                <span class="required">*</span>
            </label>

            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                required
                class="@error('password_confirmation', 'updatePassword') is-invalid @enderror"
            >

            @error('password_confirmation', 'updatePassword')
                <span class="field-error">
                    {{ $message }}
                </span>
            @enderror

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- ACTION --}}
    {{-- ========================================================= --}}

    <div class="profile-form-actions">

        <button
            type="submit"
            class="profile-btn profile-btn-primary"
        >
            Modifier le mot de passe
        </button>

    </div>

</form>