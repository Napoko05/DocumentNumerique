@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto px-4 sm:px-6 py-12">

    <div class="mb-8">
        <p class="text-sm font-semibold text-brand-700 uppercase tracking-wider mb-2">Support</p>
        <h1 class="font-heading text-2xl sm:text-3xl font-bold text-ink">Contactez-nous</h1>
        <p class="text-sm text-ink-muted mt-1">Une question ? Écrivez-nous, nous vous répondrons rapidement.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-emerald-50 border border-emerald-200 text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Nom</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required class="input-field" placeholder="Votre nom">
                @error('nom') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="input-field" placeholder="email@exemple.com">
                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Objet</label>
                <input type="text" name="objet" value="{{ old('objet') }}" class="input-field" placeholder="Sujet de votre message">
                @error('objet') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-ink mb-1.5">Message</label>
                <textarea name="message" rows="5" required
                          class="input-field resize-none"
                          placeholder="Votre message...">{{ old('message') }}</textarea>
                @error('message') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                Envoyer le message
            </button>
        </form>
    </div>
</div>

@endsection
