@extends('layouts.app')

@section('title', "Nos prestations — Abigail's Braids")
@section('description', "Découvrez toutes les prestations d'Abigail's Braids : box braids, knotless braids, vanilles, cornrows, faux locs et soins capillaires à Strasbourg.")

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <p class="section-eyebrow">Nos prestations</p>
            <h1 class="section-title mt-2">Un style pour chaque femme, chaque envie</h1>
            <p class="mx-auto mt-4 max-w-2xl text-ink-900/70">
                Toutes nos prestations sont réalisées sur mesure, quelle que soit la texture ou la longueur de
                vos cheveux. Les tarifs ci-dessous sont indicatifs et peuvent varier selon la densité et la
                longueur souhaitées — un devis précis vous sera confirmé lors de la prise de rendez-vous.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($services as $service)
                <div class="card card-hover relative flex flex-col overflow-hidden">
                    @if ($service->slug === 'knotless-braids')
                        <span class="badge-gold absolute left-3 top-3 z-10">Populaire</span>
                    @endif
                    <img
                        src="{{ $service->image_path ? asset($service->image_path) : 'https://placehold.co/600x400/faeadb/863f1f?text='.urlencode($service->name) }}"
                        alt="{{ $service->name }}"
                        class="h-48 w-full object-cover"
                    >
                    <div class="flex flex-1 flex-col p-6">
                        <h2 class="font-serif text-xl font-semibold text-ink-900">{{ $service->name }}</h2>
                        <p class="mt-3 flex-1 text-sm text-ink-900/70">{{ $service->description }}</p>
                        <div class="mt-5 flex items-center justify-between text-sm">
                            <span class="text-base font-semibold text-brand-700">Dès {{ number_format((float) $service->price_from, 0, ',', ' ') }} €</span>
                            <span class="text-ink-900/50">Environ {{ $service->durationLabel() }}</span>
                        </div>
                        <a href="{{ route('booking.create', ['prestation' => $service->id]) }}" class="btn-primary mt-5 justify-center">
                            Réserver cette prestation
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-ink-900/60">Les prestations seront bientôt disponibles.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-brand-50 py-16">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="section-title">Une question avant de réserver ?</h2>
            <p class="mt-4 text-ink-900/70">Contactez-nous, nous serons ravies de vous conseiller sur le style le plus adapté.</p>
            <a href="{{ route('contact') }}" class="btn-secondary mt-6 inline-flex">Nous contacter</a>
        </div>
    </section>
@endsection
