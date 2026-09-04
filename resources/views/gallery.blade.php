@extends('layouts.app')

@section('title', "Galerie — Abigail's Braids")
@section('description', "Galerie de réalisations d'Abigail's Braids : box braids, knotless, vanilles, cornrows et faux locs.")

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <p class="section-eyebrow">Galerie</p>
            <h1 class="section-title mt-2">Nos réalisations</h1>
            <p class="mx-auto mt-4 max-w-2xl text-ink-900/70">
                Un aperçu de nos coiffures. Suivez-nous sur
                <a href="https://www.facebook.com/abigailsbraids" target="_blank" rel="noopener noreferrer" class="font-semibold text-brand-700 hover:underline">Facebook</a>
                et
                <a href="https://www.instagram.com/tresses_africaine_strasbourg/" target="_blank" rel="noopener noreferrer" class="font-semibold text-brand-700 hover:underline">Instagram</a>
                pour découvrir toutes nos dernières créations.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ([
                ['Box+Braids', 'f3d1ae'],
                ['Knotless', 'e9b077'],
                ['Vanilles', 'dd8c49'],
                ['Cornrows', 'c96f2e'],
                ['Extensions+Couleur', 'a95524'],
                ['Faux+Locs', '863f1f'],
                ['Coiffure+Enfant', '5f2c17'],
                ['Soin+%26+Demelage', '3c1c0f'],
            ] as [$label, $color])
                <img
                    src="https://placehold.co/500x600/{{ $color }}/fff?text={{ $label }}"
                    alt="{{ str_replace('+', ' ', $label) }}"
                    class="aspect-[4/5] w-full rounded-xl object-cover shadow-sm"
                    loading="lazy"
                >
            @endforeach
        </div>
    </section>

    <section class="bg-brand-50 py-16 text-center">
        <h2 class="section-title">Envie du même résultat ?</h2>
        <a href="{{ route('booking.create') }}" class="btn-primary mt-6 inline-flex">Prendre rendez-vous</a>
    </section>
@endsection
