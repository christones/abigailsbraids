@extends('layouts.app')

@section('title', "Espace salon — Connexion")

@section('content')
    <section class="mx-auto flex min-h-[60vh] max-w-md items-center px-4 py-16 sm:px-6">
        <div class="card w-full p-8">
            <h1 class="font-serif text-2xl font-semibold text-ink-900">Espace salon</h1>
            <p class="mt-2 text-sm text-ink-900/60">Connectez-vous pour gérer les réservations.</p>

            @if ($errors->any())
                <div class="mt-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 ring-1 ring-red-600/20">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus>
                </div>

                <div>
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                </div>

                <label class="flex items-center gap-2 text-sm text-ink-900/70">
                    <input type="checkbox" name="remember" class="rounded border-ink-900/20 text-brand-600 focus:ring-brand-500">
                    Se souvenir de moi
                </label>

                <button type="submit" class="btn-primary w-full">Se connecter</button>
            </form>
        </div>
    </section>
@endsection
