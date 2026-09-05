@extends('layouts.app')

@section('title', "Réserver un rendez-vous — Abigail's Braids")
@section('description', "Réservez votre rendez-vous pour des tresses ou nattes africaines chez Abigail's Braids à Strasbourg.")

@section('content')
    <section class="relative overflow-hidden py-16">
        <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-rose-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-gold-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="section-eyebrow">Réservation</p>
                <h1 class="section-title mt-2">Prenez rendez-vous en ligne</h1>
                <p class="mt-4 text-ink-900/70">
                    Ce formulaire est ouvert à toutes les femmes, quel que soit votre âge ou votre type de cheveux.
                    Remplissez vos informations, nous confirmerons votre créneau par téléphone ou e-mail.
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

            <form method="POST" action="{{ route('booking.store') }}" class="card mt-8 space-y-6 p-8">
                @csrf

                <div>
                    <label for="service_id" class="form-label">Prestation souhaitée</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                            </svg>
                        </span>
                        <select id="service_id" name="service_id" class="form-input pl-10">
                            <option value="">-- Choisissez une prestation --</option>
                            @foreach ($services as $service)
                                <option
                                    value="{{ $service->id }}"
                                    @selected((int) old('service_id', $selectedServiceId) === $service->id)
                                >
                                    {{ $service->name }} — dès {{ number_format((float) $service->price_from, 0, ',', ' ') }} € ({{ $service->durationLabel() }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('service_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="client_name" class="form-label">Nom et prénom</label>
                        <div class="relative mt-1">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </span>
                            <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}" class="form-input pl-10" placeholder="Votre nom">
                        </div>
                        @error('client_name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="client_phone" class="form-label">Téléphone</label>
                        <div class="relative mt-1">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>
                            </span>
                            <input type="tel" id="client_phone" name="client_phone" value="{{ old('client_phone') }}" class="form-input pl-10" placeholder="06 00 00 00 00">
                        </div>
                        @error('client_phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="client_email" class="form-label">E-mail</label>
                    <div class="relative mt-1">
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-ink-900/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </span>
                        <input type="email" id="client_email" name="client_email" value="{{ old('client_email') }}" class="form-input pl-10" placeholder="vous@exemple.com">
                    </div>
                    @error('client_email')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

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
                    <span class="form-label">Créneau horaire</span>
                    <div class="mt-1 grid grid-cols-3 gap-2 sm:grid-cols-6">
                        @foreach ($slots as $timeSlot)
                            <label class="cursor-pointer rounded-lg border border-ink-900/10 bg-white px-2 py-2.5 text-center text-sm font-medium text-ink-900/80 transition has-[:checked]:border-brand-600 has-[:checked]:bg-brand-600 has-[:checked]:text-white has-[:checked]:shadow-sm hover:border-brand-300">
                                <input type="radio" name="preferred_time" value="{{ $timeSlot }}" class="sr-only" @checked(old('preferred_time') === $timeSlot)>
                                {{ $timeSlot }}
                            </label>
                        @endforeach
                    </div>
                    @error('preferred_time')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="hair_length" class="form-label">Longueur de cheveux (optionnel)</label>
                    <select id="hair_length" name="hair_length" class="form-input mt-1">
                        <option value="">-- Sélectionnez --</option>
                        @foreach (['Courts', 'Mi-longs', 'Longs', 'Très longs'] as $length)
                            <option value="{{ $length }}" @selected(old('hair_length') === $length)>{{ $length }}</option>
                        @endforeach
                    </select>
                    @error('hair_length')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="form-label">Message ou précisions (optionnel)</label>
                    <textarea id="notes" name="notes" rows="4" class="form-input mt-1" placeholder="Modèle souhaité, allergies, disponibilités particulières...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full sm:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                    Confirmer ma demande de rendez-vous
                </button>

                <p class="text-xs text-ink-900/50">
                    Votre rendez-vous sera confirmé par le salon par téléphone ou e-mail dans les meilleurs délais.
                </p>
            </form>
        </div>
    </section>
@endsection
