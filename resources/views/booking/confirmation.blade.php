@extends('layouts.app')

@section('title', "Demande envoyée — Abigail's Braids")
@section('description', "Votre demande de rendez-vous chez Abigail's Braids a bien été envoyée.")

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>

        <h1 class="section-title mt-6">Merci {{ $booking->client_name }} !</h1>
        <p class="mt-4 text-ink-900/70">
            Votre demande de rendez-vous a bien été enregistrée. Le salon vous contactera prochainement pour
            confirmer votre créneau.
        </p>

        <div class="card mt-10 space-y-4 p-8 text-left">
            <h2 class="font-serif text-lg font-semibold text-ink-900">Récapitulatif de votre demande</h2>
            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-ink-900/50">Prestation</dt>
                    <dd class="font-medium text-ink-900">{{ $booking->service->name }}</dd>
                </div>
                <div>
                    <dt class="text-ink-900/50">Date souhaitée</dt>
                    <dd class="font-medium text-ink-900">{{ $booking->preferred_date->translatedFormat('d F Y') }}</dd>
                </div>
                <div>
                    <dt class="text-ink-900/50">Créneau</dt>
                    <dd class="font-medium text-ink-900">{{ $booking->preferred_time }}</dd>
                </div>
                <div>
                    <dt class="text-ink-900/50">Statut</dt>
                    <dd class="font-medium text-ink-900">{{ \App\Models\Booking::statusLabels()[$booking->status] ?? $booking->status }}</dd>
                </div>
                @if ($booking->notes)
                    <div class="col-span-2">
                        <dt class="text-ink-900/50">Votre message</dt>
                        <dd class="font-medium text-ink-900">{{ $booking->notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('home') }}" class="btn-secondary">Retour à l'accueil</a>
            <a href="{{ route('services.index') }}" class="btn-primary">Voir nos autres prestations</a>
        </div>
    </section>
@endsection
