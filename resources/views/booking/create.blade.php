@extends('layouts.app')

@section('title', "Réserver un rendez-vous — Abigail's Braids")
@section('description', "Réservez votre rendez-vous pour des tresses ou nattes africaines chez Abigail's Braids à Strasbourg.")

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8">
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
                <select id="service_id" name="service_id" class="form-input">
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
                @error('service_id')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="client_name" class="form-label">Nom et prénom</label>
                    <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}" class="form-input" placeholder="Votre nom">
                    @error('client_name')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="client_phone" class="form-label">Téléphone</label>
                    <input type="tel" id="client_phone" name="client_phone" value="{{ old('client_phone') }}" class="form-input" placeholder="06 00 00 00 00">
                    @error('client_phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="client_email" class="form-label">E-mail</label>
                <input type="email" id="client_email" name="client_email" value="{{ old('client_email') }}" class="form-input" placeholder="vous@exemple.com">
                @error('client_email')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label for="preferred_date" class="form-label">Date souhaitée</label>
                    <input
                        type="date"
                        id="preferred_date"
                        name="preferred_date"
                        value="{{ old('preferred_date') }}"
                        min="{{ now()->addDay()->toDateString() }}"
                        class="form-input"
                    >
                    @error('preferred_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="preferred_time" class="form-label">Créneau horaire</label>
                    <select id="preferred_time" name="preferred_time" class="form-input">
                        <option value="">-- Choisissez un créneau --</option>
                        @foreach ($slots as $slot)
                            <option value="{{ $slot }}" @selected(old('preferred_time') === $slot)>{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('preferred_time')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="hair_length" class="form-label">Longueur de cheveux (optionnel)</label>
                <select id="hair_length" name="hair_length" class="form-input">
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
                <textarea id="notes" name="notes" rows="4" class="form-input" placeholder="Modèle souhaité, allergies, disponibilités particulières...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full sm:w-auto">
                Confirmer ma demande de rendez-vous
            </button>

            <p class="text-xs text-ink-900/50">
                Votre rendez-vous sera confirmé par le salon par téléphone ou e-mail dans les meilleurs délais.
            </p>
        </form>
    </section>
@endsection
