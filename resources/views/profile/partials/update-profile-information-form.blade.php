{{-- ============================================================= --}}
{{-- INFORMATIONS DU PROFIL JOURNALISTE --}}
{{-- ============================================================= --}}

<section class="profile-section">

    {{-- ========================================================= --}}
    {{-- EN-TÊTE --}}
    {{-- ========================================================= --}}

    <div class="profile-form-header">

        <div>

            <span class="profile-section-label">
                PROFIL
            </span>

            <h3>
                Informations du profil
            </h3>

            <p>
                Modifiez vos informations personnelles et vos coordonnées.
            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- FORMULAIRE DE VÉRIFICATION E-MAIL --}}
    {{-- ========================================================= --}}

    <form
        id="send-verification"
        method="POST"
        action="{{ route('verification.send') }}"
    >
        @csrf
    </form>


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


            {{-- ================================================= --}}
            {{-- NOM --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="nom">
                    Nom
                    <span class="required">*</span>
                </label>

                <input
                    id="nom"
                    name="nom"
                    type="text"
                    value="{{ old('nom', $user->nom) }}"
                    required
                    autocomplete="family-name"
                    class="@error('nom') is-invalid @enderror"
                >

                @error('nom')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- PRÉNOM --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="prenom">
                    Prénom
                    <span class="required">*</span>
                </label>

                <input
                    id="prenom"
                    name="prenom"
                    type="text"
                    value="{{ old('prenom', $user->prenom) }}"
                    required
                    autocomplete="given-name"
                    class="@error('prenom') is-invalid @enderror"
                >

                @error('prenom')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- SEXE --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="sexe">
                    Sexe
                    <span class="required">*</span>
                </label>

                <select
                    id="sexe"
                    name="sexe"
                    required
                    class="@error('sexe') is-invalid @enderror"
                >

                    <option value="">
                        Sélectionner
                    </option>

                    <option
                        value="Masculin"
                        @selected(old('sexe', $user->sexe) === 'Masculin')
                    >
                        Masculin
                    </option>

                    <option
                        value="Féminin"
                        @selected(old('sexe', $user->sexe) === 'Féminin')
                    >
                        Féminin
                    </option>

                </select>

                @error('sexe')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- DATE DE NAISSANCE --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="date_naissance">
                    Date de naissance
                </label>

                <input
                    id="date_naissance"
                    name="date_naissance"
                    type="date"
                    value="{{ old(
                        'date_naissance',
                        $user->date_naissance
                            ? \Carbon\Carbon::parse($user->date_naissance)->format('Y-m-d')
                            : ''
                    ) }}"
                    class="@error('date_naissance') is-invalid @enderror"
                >

                @error('date_naissance')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- LIEU DE NAISSANCE --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="lieu_naissance">
                    Lieu de naissance
                </label>

                <input
                    id="lieu_naissance"
                    name="lieu_naissance"
                    type="text"
                    value="{{ old('lieu_naissance', $user->lieu_naissance) }}"
                    autocomplete="off"
                    class="@error('lieu_naissance') is-invalid @enderror"
                >

                @error('lieu_naissance')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- E-MAIL --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="email">
                    Adresse e-mail
                    <span class="required">*</span>
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="email"
                    class="@error('email') is-invalid @enderror"
                >

                @error('email')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror


                {{-- ================================================= --}}
                {{-- VÉRIFICATION E-MAIL --}}
                {{-- ================================================= --}}

                @if (
                    $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                    && ! $user->hasVerifiedEmail()
                )

                    <div class="profile-verification">

                        <p class="profile-help">
                            Votre adresse e-mail n'est pas encore vérifiée.
                        </p>

                        <button
                            type="submit"
                            form="send-verification"
                            class="profile-btn profile-btn-secondary"
                        >
                            Renvoyer l'e-mail de vérification
                        </button>


                        @if (session('status') === 'verification-link-sent')

                            <p class="profile-success">
                                Un nouveau lien de vérification a été envoyé
                                à votre adresse e-mail.
                            </p>

                        @endif

                    </div>

                @endif

            </div>


            {{-- ================================================= --}}
            {{-- TÉLÉPHONE --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="tel">
                    Téléphone
                </label>

                <input
                    id="tel"
                    name="tel"
                    type="tel"
                    value="{{ old('tel', $user->tel) }}"
                    autocomplete="tel"
                    class="@error('tel') is-invalid @enderror"
                >

                @error('tel')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror

            </div>


            {{-- ================================================= --}}
            {{-- VILLE --}}
            {{-- ================================================= --}}

            <div class="profile-field">

                <label for="ville">
                    Ville
                </label>

                <input
                    id="ville"
                    name="ville"
                    type="text"
                    value="{{ old('ville', $user->ville) }}"
                    autocomplete="address-level2"
                    class="@error('ville') is-invalid @enderror"
                >

                @error('ville')
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
                Enregistrer les modifications
            </button>


            @if (session('status') === 'profile-updated')

                <span class="profile-success">
                    Modifications enregistrées.
                </span>

            @endif

        </div>

    </form>

</section>