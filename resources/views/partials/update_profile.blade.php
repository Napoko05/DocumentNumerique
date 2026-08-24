{{-- ============================================================= --}}
{{-- INFORMATIONS PERSONNELLES --}}
{{-- ============================================================= --}}

<section class="profile-form-section">

    <div class="profile-section-header">

        <div class="profile-section-icon">

            <svg
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path d="M20 21a8 8 0 0 0-16 0"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>

        </div>

        <div>

            <h3>
                Informations personnelles
            </h3>

            <p>
                Mettez à jour vos informations personnelles.
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCÈS --}}
    {{-- ========================================================= --}}

    @if (session('status') === 'profile-information-updated')

        <div class="profile-alert profile-alert-success">

            <svg
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <path d="M20 6 9 17l-5-5"/>
            </svg>

            <span>
                Vos informations ont été mises à jour avec succès.
            </span>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ERREURS --}}
    {{-- ========================================================= --}}

    @if ($errors->updateProfileInformation->any())

        <div class="profile-alert profile-alert-danger">

            <svg
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 8v4"/>
                <path d="M12 16h.01"/>
            </svg>

            <div>

                <strong>
                    Veuillez corriger les erreurs suivantes :
                </strong>

                <ul>

                    @foreach ($errors->updateProfileInformation->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- FORMULAIRE --}}
    {{-- ========================================================= --}}

    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="profile-form"
    >

        @csrf
        @method('PUT')


        <div class="profile-form-grid">


            {{-- NOM --}}
            <div class="profile-field">

                <label for="nom">
                    Nom
                    <span class="required">*</span>
                </label>

                <input
                    id="nom"
                    name="nom"
                    type="text"
                    value="{{ old('nom', $staff->nom) }}"
                    autocomplete="family-name"
                    required
                    class="@error('nom', 'updateProfileInformation') is-invalid @enderror"
                >

                @error('nom', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- PRÉNOM --}}
            <div class="profile-field">

                <label for="prenom">
                    Prénom
                    <span class="required">*</span>
                </label>

                <input
                    id="prenom"
                    name="prenom"
                    type="text"
                    value="{{ old('prenom', $staff->prenom) }}"
                    autocomplete="given-name"
                    required
                    class="@error('prenom', 'updateProfileInformation') is-invalid @enderror"
                >

                @error('prenom', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- SEXE --}}
            <div class="profile-field">

                <label for="sexe">
                    Sexe
                    <span class="required">*</span>
                </label>

                <select
                    id="sexe"
                    name="sexe"
                    required
                    class="@error('sexe', 'updateProfileInformation') is-invalid @enderror"
                >

                    <option value="">
                        Sélectionner
                    </option>

                    <option
                        value="Masculin"
                        @selected(old('sexe', $staff->sexe) === 'Masculin')
                    >
                        Masculin
                    </option>

                    <option
                        value="Féminin"
                        @selected(old('sexe', $staff->sexe) === 'Féminin')
                    >
                        Féminin
                    </option>

                </select>

                @error('sexe', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- DATE DE NAISSANCE --}}
            <div class="profile-field">

                <label for="date_naissance">
                    Date de naissance
                    <span class="required">*</span>
                </label>

                <input
                    id="date_naissance"
                    name="date_naissance"
                    type="date"
                    value="{{ old(
                        'date_naissance',
                        $staff->date_naissance
                            ? \Carbon\Carbon::parse($staff->date_naissance)->format('Y-m-d')
                            : ''
                    ) }}"
                    required
                    class="@error('date_naissance', 'updateProfileInformation') is-invalid @enderror"
                >

                @error('date_naissance', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- LIEU DE NAISSANCE --}}
            <div class="profile-field">

                <label for="lieu_naissance">
                    Lieu de naissance
                    <span class="required">*</span>
                </label>

                <input
                    id="lieu_naissance"
                    name="lieu_naissance"
                    type="text"
                    value="{{ old('lieu_naissance', $staff->lieu_naissance) }}"
                    required
                    class="@error('lieu_naissance', 'updateProfileInformation') is-invalid @enderror"
                >

                @error('lieu_naissance', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- EMAIL --}}
            <div class="profile-field">

                <label for="email">
                    Adresse e-mail
                    <span class="required">*</span>
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $staff->email) }}"
                    autocomplete="email"
                    required
                    class="@error('email', 'updateProfileInformation') is-invalid @enderror"
                >

                @error('email', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- TÉLÉPHONE --}}
            <div class="profile-field">

                <label for="tel">
                    Téléphone
                </label>

                <input
                    id="tel"
                    name="tel"
                    type="text"
                    value="{{ old('tel', $staff->tel) }}"
                    autocomplete="tel"
                    maxlength="20"
                    class="@error('tel', 'updateProfileInformation') is-invalid @enderror"
                >

                @error('tel', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- VILLE --}}
            <div class="profile-field">

                <label for="ville">
                    Ville
                </label>

                <input
                    id="ville"
                    name="ville"
                    type="text"
                    value="{{ old('ville', $staff->ville) }}"
                    class="@error('ville', 'updateProfileInformation') is-invalid @enderror"
                >

                @error('ville', 'updateProfileInformation')

                    <span class="field-error">
                        {{ $message }}
                    </span>

                @enderror

            </div>


            {{-- MATRICULE --}}
            <div class="profile-field">

                <label for="matricule">
                    Matricule
                </label>

                <input
                    id="matricule"
                    type="text"
                    value="{{ $staff->matricule }}"
                    readonly
                    class="profile-readonly"
                >

                <small class="profile-help">
                    Le matricule est attribué par l'administration
                    et ne peut pas être modifié.
                </small>

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

                <svg
                    width="18"
                    height="18"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/>
                    <path d="M17 21v-8H7v8"/>
                    <path d="M7 3v5h8"/>
                </svg>

                Enregistrer les modifications

            </button>

        </div>

    </form>

</section>