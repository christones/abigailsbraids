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
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input pl-10" required autofocus>
                    </div>
                </div>

                <div>
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </span>
                        <input type="password" id="password" name="password" class="form-input pl-10" required>
                    </div>
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
