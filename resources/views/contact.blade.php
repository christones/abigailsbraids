@extends('layouts.app')

@section('title', "Contact — Abigail's Braids")
@section('description', "Contactez Abigail's Braids, salon de tresses africaines à Strasbourg, ou réservez votre rendez-vous en ligne.")

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <p class="section-eyebrow">Contact</p>
            <h1 class="section-title mt-2">Une question ? Contactez-nous</h1>
        </div>

        <div class="mt-12 grid gap-10 lg:grid-cols-2">
            <div class="card p-8">
                <h2 class="font-serif text-xl font-semibold text-ink-900">Coordonnées</h2>
                <dl class="mt-6 space-y-4 text-sm text-ink-900/70">
                    <div class="flex items-start gap-3">
                        <dt class="w-24 flex-none font-semibold text-ink-900">Adresse</dt>
                        <dd>Strasbourg, France</dd>
                    </div>
                    <div class="flex items-start gap-3">
                        <dt class="w-24 flex-none font-semibold text-ink-900">Téléphone</dt>
                        <dd><a href="tel:+33600000000" class="hover:text-brand-700">+33 6 00 00 00 00</a></dd>
                    </div>
                    <div class="flex items-start gap-3">
                        <dt class="w-24 flex-none font-semibold text-ink-900">E-mail</dt>
                        <dd><a href="mailto:contact@abigailsbraids.fr" class="hover:text-brand-700">contact@abigailsbraids.fr</a></dd>
                    </div>
                    <div class="flex items-start gap-3">
                        <dt class="w-24 flex-none font-semibold text-ink-900">Horaires</dt>
                        <dd>
                            Mardi – Samedi : 9h – 18h<br>
                            Dimanche &amp; Lundi : fermé
                        </dd>
                    </div>
                </dl>

                <div class="mt-8 flex gap-4">
                    <a href="https://www.facebook.com/abigailsbraids" target="_blank" rel="noopener noreferrer" class="btn-secondary">Facebook</a>
                    <a href="https://www.instagram.com/tresses_africaine_strasbourg/" target="_blank" rel="noopener noreferrer" class="btn-secondary">Instagram</a>
                </div>

                <p class="mt-6 text-xs text-ink-900/40">
                    * Coordonnées à confirmer / mettre à jour par le salon.
                </p>
            </div>

            <div class="card p-8 text-center">
                <h2 class="font-serif text-xl font-semibold text-ink-900">Envie de réserver directement ?</h2>
                <p class="mt-3 text-sm text-ink-900/70">
                    Pas besoin d'appeler : choisissez votre prestation et votre créneau en ligne, en quelques minutes.
                </p>
                <a href="{{ route('booking.create') }}" class="btn-primary mt-6 inline-flex">Réserver un rendez-vous</a>
            </div>
        </div>
    </section>
@endsection
