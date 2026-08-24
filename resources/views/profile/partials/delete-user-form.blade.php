{{-- ============================================================= --}}
{{-- SUPPRESSION DU COMPTE JOURNALISTE --}}
{{-- ============================================================= --}}

<div class="profile-form-header">

    <div>

        <span class="profile-section-label profile-section-danger">
            ZONE DANGER
        </span>

        <h3>
            Supprimer mon compte
        </h3>

        <p>
            La suppression de votre compte est définitive.
            Cette action ne peut pas être annulée.
        </p>

    </div>

</div>

<form
    method="POST"
    action="{{ route('journaliste.profil.destroy') }}"
    class="profile-form"
    onsubmit="return confirm('Êtes-vous certain de vouloir supprimer définitivement votre compte ?');"
>

    @csrf
    @method('DELETE')

    <div class="profile-form-grid profile-form-grid-single">

        <div class="profile-field">

            <label for="password">
                Mot de passe
                <span class="required">*</span>
            </label>

            <input
                id="password"
                name="password"
                type="password"
                autocomplete="current-password"
                required
                class="@error('password', 'userDeletion') is-invalid @enderror"
            >

            @error('password', 'userDeletion')
                <span class="field-error">
                    {{ $message }}
                </span>
            @enderror

            <small class="profile-help">
                Saisissez votre mot de passe pour confirmer la suppression.
            </small>

        </div>

    </div>

    <div class="profile-form-actions">

        <button
            type="submit"
            class="profile-btn profile-btn-danger"
        >
            Supprimer définitivement mon compte
        </button>

    </div>

</form>