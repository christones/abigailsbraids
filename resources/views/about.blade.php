@extends('layouts.app')

@section('title', "À propos — Abigail's Braids")
@section('description', "Découvrez l'histoire d'Abigail's Braids, salon de tresses et nattes africaines à Strasbourg, pensé pour toutes les femmes.")

@section('content')
    <section class="bg-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <p class="section-eyebrow">Notre histoire</p>
                <h1 class="section-title mt-2">L'art de la tresse, avec passion</h1>
                <p class="mt-5 text-ink-900/70">
                    Abigail's Braids est né d'une passion pour l'art capillaire africain et d'une conviction simple :
                    chaque femme mérite de se sentir belle et confiante dans ses cheveux. Installé à Strasbourg,
                    notre salon accueille une clientèle fidèle et diverse, de tous âges et de toutes origines.
                </p>
                <p class="mt-4 text-ink-900/70">
                    Nous mettons un point d'honneur à travailler avec des mèches de qualité, dans le respect du
                    cuir chevelu, et à prendre le temps nécessaire pour un résultat soigné — que vous veniez pour
                    des box braids, des knotless, des vanilles ou une simple séance de soin.
                </p>
            </div>
            <img src="{{ asset('images/braids16.jpg') }}" alt="Réalisation Abigail's Braids" class="rounded-2xl shadow-sm">
        </div>
    </section>

    <section class="bg-brand-50 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 sm:grid-cols-3">
                <div class="card p-8 text-center">
                    <p class="font-serif text-4xl font-semibold text-brand-700">100%</p>
                    <p class="mt-2 text-sm text-ink-900/70">Pour toutes les femmes, toutes textures de cheveux</p>
                </div>
                <div class="card p-8 text-center">
                    <p class="font-serif text-4xl font-semibold text-brand-700">6j/7</p>
                    <p class="mt-2 text-sm text-ink-900/70">Ouvert du mardi au dimanche sur rendez-vous</p>
                </div>
                <div class="card p-8 text-center">
                    <p class="font-serif text-4xl font-semibold text-brand-700">Strasbourg</p>
                    <p class="mt-2 text-sm text-ink-900/70">Un salon facilement accessible en centre-ville</p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <h2 class="section-title">Venez nous rencontrer</h2>
        <p class="mx-auto mt-4 max-w-xl text-ink-900/70">
            Réservez votre rendez-vous en ligne ou contactez-nous pour toute question sur nos prestations.
        </p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('booking.create') }}" class="btn-primary">Réserver un rendez-vous</a>
            <a href="{{ route('contact') }}" class="btn-secondary">Nous contacter</a>
        </div>
    </section>
@endsection
