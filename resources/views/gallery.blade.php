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
            @forelse ($images as $image)
                <img
                    src="{{ asset($image->image_path) }}"
                    alt="{{ $image->label ?? 'Réalisation Abigail\'s Braids' }}"
                    class="aspect-[4/5] w-full rounded-xl object-cover shadow-sm"
                    loading="lazy"
                >
            @empty
                <p class="col-span-full text-center text-ink-900/60">La galerie sera bientôt disponible.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-brand-50 py-16 text-center">
        <h2 class="section-title">Envie du même résultat ?</h2>
        <a href="{{ route('booking.create') }}" class="btn-primary mt-6 inline-flex">Prendre rendez-vous</a>
    </section>
@endsection
