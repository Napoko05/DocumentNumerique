<x-guest-layout>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-10">
        <form method="POST" action="{{ route('register') }}" novalidate>
          @csrf

          <!-- Nom -->
          <div class="mb-3">
            <x-input-label for="name" :value="__('Nom complet')" />
            <x-text-input id="name" class="form-control" type="text" name="name"
              :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="text-danger small mt-1" />
          </div>

          <!-- Email -->
          <div class="mb-3">
            <x-input-label for="email" :value="__('Adresse email')" />
            <x-text-input id="email" class="form-control" type="email" name="email"
              :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
          </div>

          <!-- Mot de passe -->
          <div class="mb-3">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" class="form-control" type="password" name="password"
              required autocomplete="new-password" minlength="8" />
            <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
          </div>

          <!-- Confirmation -->
          <div class="mb-3">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
            <x-text-input id="password_confirmation" class="form-control" type="password"
              name="password_confirmation" required autocomplete="new-password" minlength="8" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger small mt-1" />
          </div>

          <!-- Actions -->
          <div class="d-flex justify-content-between align-items-center mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
              {{ __('Déjà inscrit ?') }}
            </a>
            <x-primary-button>
              {{ __('Inscription') }}
            </x-primary-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</x-guest-layout>