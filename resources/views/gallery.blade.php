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
                ['images/braids8.jpg', 'Box Braids'],
                ['images/braids9.jpg', 'Knotless Braids'],
                ['images/braids7.jpg', 'Vanilles / Twists'],
                ['images/braids4.jpg', 'Cornrows'],
                ['images/braids20.jpg', 'Extensions colorées'],
                ['images/braids5.jpg', 'Faux Locs'],
                ['images/braids13.jpg', 'Coiffure Enfant'],
                ['images/braids6.jpg', 'Soin & Démêlage'],
                ['images/braids.jpg', 'Coiffure Enfant'],
                ['images/braids2.jpg', 'Cheveux naturels'],
                ['images/braids3.jpg', 'Box Braids'],
                ['images/braids10.jpg', 'Coiffure Enfant'],
                ['images/braids11.jpg', 'Coiffure Enfant'],
                ['images/braids12.jpg', 'Coiffure Enfant'],
                ['images/braids14.jpg', 'Coiffure Enfant'],
                ['images/braids15.jpg', 'Vanilles / Twists'],
                ['images/braids17.jpg', 'Coiffure Enfant'],
                ['images/braids19.jpg', 'Cornrows'],
                ['images/braids21.jpg', 'Extensions colorées'],
                ['images/braids23.jpg', 'Extensions colorées'],
                ['images/braids24.jpg', 'Extensions colorées'],
                ['images/braids25.jpg', 'Cornrows'],
                ['images/braids26.jpg', 'Cornrows'],
                ['images/braids27.jpg', 'Box Braids'],
            ] as [$image, $label])
                <img
                    src="{{ asset($image) }}"
                    alt="{{ $label }}"
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
