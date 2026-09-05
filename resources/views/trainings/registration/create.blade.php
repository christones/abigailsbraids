@extends('layouts.app')

@section('title', "Inscription formation — Abigail's Braids")
@section('description', "Inscrivez-vous à une formation de tressage africain chez Abigail's Braids à Strasbourg.")

@section('content')
    <section class="relative overflow-hidden py-16">
        <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-gold-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-rose-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="section-eyebrow">Formations</p>
                <h1 class="section-title mt-2">Inscrivez-vous à une formation</h1>
                <p class="mt-4 text-ink-900/70">
                    Ouvert à toutes, quel que soit votre niveau. Remplissez vos informations, nous vous
                    contacterons pour confirmer votre session.
                </p>
            </div>

            @if ($errors->any())
                <div class="mt-8 rounded-lg bg-red-50 p-4 text-sm text-red-800 ring-1 ring-red-600/20">
                    <p class="font-semibold">Merci de corriger les champs suivants :</p>
                    <ul class="mt-2 list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('training.store') }}" class="card mt-8 space-y-6 p-8">
                @csrf

                <div>
                    <label for="training_id" class="form-label">Formation souhaitée</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </span>
                        <select id="training_id" name="training_id" class="form-input pl-10">
                            <option value="">-- Choisissez une formation --</option>
                            @foreach ($trainings as $training)
                                <option
                                    value="{{ $training->id }}"
                                    @selected((int) old('training_id', $selectedTrainingId) === $training->id)
                                >
                                    {{ $training->name }} — dès {{ number_format((float) $training->price_from, 0, ',', ' ') }} € ({{ $training->durationLabel() }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('training_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="candidate_name" class="form-label">Nom et prénom</label>
                        <div class="relative mt-1">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </span>
                            <input type="text" id="candidate_name" name="candidate_name" value="{{ old('candidate_name') }}" class="form-input pl-10" placeholder="Votre nom">
                        </div>
                        @error('candidate_name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="candidate_phone" class="form-label">Téléphone</label>
                        <div class="relative mt-1">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                            </span>
                            <input type="tel" id="candidate_phone" name="candidate_phone" value="{{ old('candidate_phone') }}" class="form-input pl-10" placeholder="06 00 00 00 00">
                        </div>
                        @error('candidate_phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="candidate_email" class="form-label">E-mail</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input type="email" id="candidate_email" name="candidate_email" value="{{ old('candidate_email') }}" class="form-input pl-10" placeholder="vous@exemple.com">
                    </div>
                    @error('candidate_email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="preferred_date" class="form-label">Date souhaitée</label>
                        <div class="relative mt-1">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                            </span>
                            <input
                                type="text"
                                id="preferred_date"
                                name="preferred_date"
                                value="{{ old('preferred_date') }}"
                                placeholder="Choisissez une date"
                                autocomplete="off"
                                class="form-input pl-10"
                            >
                        </div>
                        <p class="mt-1 text-xs text-ink-900/50">Salon fermé le dimanche et le lundi.</p>
                        @error('preferred_date')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="experience_level" class="form-label">Votre niveau (optionnel)</label>
                        <select id="experience_level" name="experience_level" class="form-input mt-1">
                            <option value="">-- Sélectionnez --</option>
                            @foreach (['Débutante', 'Intermédiaire', 'Confirmée'] as $level)
                                <option value="{{ $level }}" @selected(old('experience_level') === $level)>{{ $level }}</option>
                            @endforeach
                        </select>
                        @error('experience_level')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="message" class="form-label">Message ou précisions (optionnel)</label>
                    <textarea id="message" name="message" rows="4" class="form-input mt-1" placeholder="Votre motivation, vos disponibilités...">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    Confirmer mon inscription
                </button>

                <p class="text-xs text-ink-900/50">
                    Le salon vous contactera par téléphone ou e-mail pour confirmer votre session de formation.
                </p>
            </form>
        </div>
    </section>
@endsection
