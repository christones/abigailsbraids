@extends('layouts.app')

@section('title', "Abigail's Braids — Salon de tresses africaines à Strasbourg")
@section('description', "Salon de tresses et nattes africaines à Strasbourg. Box braids, knotless braids, vanilles, cornrows... Réservez votre rendez-vous en ligne pour toutes les femmes.")

@section('content')

    {{-- Hero slider --}}
    <section class="relative">
        <div class="hero-swiper swiper relative h-[70vh] min-h-[480px] w-full overflow-hidden">
            <div class="swiper-wrapper">
                @foreach ([
                    ['title' => 'Sublimez vos cheveux', 'subtitle' => 'Tresses et nattes africaines réalisées avec soin, à Strasbourg', 'image' => 'images/braids18.jpg'],
                    ['title' => 'Box Braids & Knotless', 'subtitle' => 'Un style protecteur, élégant et durable', 'image' => 'images/braids1.jpg'],
                    ['title' => 'Pour toutes les femmes', 'subtitle' => 'Chaque texture, chaque longueur, chaque envie mérite un beau résultat', 'image' => 'images/braids22.jpg'],
                ] as $slide)
                    <div class="swiper-slide relative flex items-center justify-center">
                        <img
                            src="{{ asset($slide['image']) }}"
                            alt=""
                            class="absolute inset-0 h-full w-full object-cover"
                            loading="eager"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-900/80 via-ink-900/30 to-ink-900/10"></div>
                        <div class="relative z-10 mx-auto max-w-3xl px-6 text-center text-white">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-200">Abigail's Braids · Strasbourg</p>
                            <h1 class="mt-4 font-serif text-4xl font-semibold sm:text-6xl">{{ $slide['title'] }}</h1>
                            <p class="mt-4 text-lg text-white/90">{{ $slide['subtitle'] }}</p>
                            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                                <a href="{{ route('booking.create') }}" class="btn-primary">Prendre rendez-vous</a>
                                <a href="{{ route('services.index') }}" class="btn-secondary bg-white/10 text-white ring-white/40 hover:bg-white/20">Voir les prestations</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>

    {{-- Seasonal promo: rentrée scolaire --}}
    <section class="bg-brand-900 py-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div class="grid grid-cols-2 gap-4">
                    <img src="{{ asset('images/rentreescolaire.jpg') }}" alt="Promo rentrée scolaire Abigail's Braids" class="col-span-1 rounded-2xl shadow-lg">
                    <img src="{{ asset('images/rentreescolaire1.jpg') }}" alt="Bonne rentrée scolaire Abigail's Braids" class="col-span-1 mt-8 rounded-2xl shadow-lg">
                </div>
                <div class="text-center lg:text-left">
                    <p class="text-sm font-semibold uppercase tracking-widest text-brand-200">Offre de saison</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Spécial rentrée scolaire</h2>
                    <p class="mt-4 text-white/80">
                        2 tresses collées avec rajouts, confortables et légères, parfaites pour l'école — dans
                        toutes les couleurs disponibles. Offrez à votre fille un look qui fait la différence.
                    </p>
                    <a
                        href="{{ route('booking.create', ['prestation' => optional($services->firstWhere('slug', 'coiffure-enfant'))->id]) }}"
                        class="btn-secondary mt-8 inline-flex"
                    >
                        Réserver ce look
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- About teaser --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div>
                <p class="section-eyebrow">Bienvenue</p>
                <h2 class="section-title mt-2">Un salon pensé pour toutes les femmes</h2>
                <p class="mt-5 text-ink-900/70">
                    Chez Abigail's Braids, chaque femme trouve sa place : cheveux courts ou longs, naturels,
                    colorés ou lissés. Nous prenons le temps de comprendre votre chevelure pour vous proposer
                    la tresse ou la natte qui vous correspond, dans une ambiance chaleureuse et bienveillante.
                </p>
                <ul class="mt-6 space-y-3 text-sm text-ink-900/80">
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 flex-none rounded-full bg-brand-500"></span>
                        Produits de qualité et mèches sélectionnées avec soin
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 flex-none rounded-full bg-brand-500"></span>
                        Rendez-vous en ligne, 7j/7, en quelques clics
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1 h-2 w-2 flex-none rounded-full bg-brand-500"></span>
                        Un accueil chaleureux, pour petites et grandes
                    </li>
                </ul>
                <a href="{{ route('about') }}" class="btn-secondary mt-8 inline-flex">En savoir plus</a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <img src="{{ asset('images/braids7.jpg') }}" alt="Vanilles" class="col-span-1 mt-8 rounded-2xl shadow-sm">
                <img src="{{ asset('images/braids8.jpg') }}" alt="Box braids" class="col-span-1 rounded-2xl shadow-sm">
            </div>
        </div>
    </section>

    {{-- Services teaser --}}
    <section class="bg-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="section-eyebrow">Nos prestations</p>
                <h2 class="section-title mt-2">Un style pour chaque envie</h2>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($services->take(4) as $service)
                    <div class="card flex flex-col overflow-hidden">
                        <img
                            src="{{ $service->image_path ? asset($service->image_path) : 'https://placehold.co/480x360/faeadb/863f1f?text='.urlencode($service->name) }}"
                            alt="{{ $service->name }}"
                            class="h-40 w-full object-cover"
                        >
                        <div class="flex flex-1 flex-col p-5">
                            <h3 class="font-serif text-lg font-semibold text-ink-900">{{ $service->name }}</h3>
                            <p class="mt-2 flex-1 text-sm text-ink-900/60">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</p>
                            <div class="mt-4 flex items-center justify-between text-sm">
                                <span class="font-semibold text-brand-700">Dès {{ number_format((float) $service->price_from, 0, ',', ' ') }} €</span>
                                <span class="text-ink-900/50">{{ $service->durationLabel() }}</span>
                            </div>
                            <a href="{{ route('booking.create', ['prestation' => $service->id]) }}" class="btn-secondary mt-4 justify-center text-sm">
                                Réserver
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-ink-900/60">Les prestations seront bientôt disponibles.</p>
                @endforelse
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('services.index') }}" class="btn-primary">Voir toutes les prestations</a>
            </div>
        </div>
    </section>

    {{-- Gallery preview slider --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="section-eyebrow">Galerie</p>
                    <h2 class="section-title mt-2">Nos dernières réalisations</h2>
                </div>
                <a href="{{ route('gallery') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800">Voir toute la galerie &rarr;</a>
            </div>

            <div class="gallery-swiper swiper mt-10 !overflow-hidden">
                <div class="swiper-wrapper">
                    @foreach ([
                        ['images/braids8.jpg', 'Box Braids'],
                        ['images/braids9.jpg', 'Knotless'],
                        ['images/braids7.jpg', 'Vanilles'],
                        ['images/braids4.jpg', 'Cornrows'],
                        ['images/braids5.jpg', 'Faux Locs'],
                        ['images/braids13.jpg', 'Coiffure Enfant'],
                    ] as [$image, $label])
                        <div class="swiper-slide">
                            <img
                                src="{{ asset($image) }}"
                                alt="{{ $label }}"
                                class="h-80 w-full rounded-2xl object-cover"
                            >
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-4 static"></div>
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="bg-brand-900 py-20 text-white">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-widest text-brand-200">Elles nous font confiance</p>
            <h2 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Avis de nos clientes</h2>

            <div class="testimonials-swiper swiper mt-10">
                <div class="swiper-wrapper">
                    @foreach ([
                        ['name' => 'Fatou', 'text' => 'Un accueil incroyable et des tresses impeccables, exactement ce que je voulais.'],
                        ['name' => 'Claire', 'text' => 'Première fois que je fais des knotless braids, résultat magnifique et sans douleur.'],
                        ['name' => 'Aïcha', 'text' => 'Le salon idéal pour prendre soin de mes cheveux et de ceux de ma fille.'],
                        ['name' => 'Léa', 'text' => 'Réservation en ligne super simple, rendez-vous respecté et tresses au top.'],
                    ] as $t)
                        <div class="swiper-slide">
                            <div class="rounded-2xl bg-white/10 p-8">
                                <p class="text-white/90">&laquo; {{ $t['text'] }} &raquo;</p>
                                <p class="mt-4 font-semibold text-brand-100">— {{ $t['name'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-6 static"></div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-5xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <h2 class="section-title">Prête à changer de style ?</h2>
        <p class="mx-auto mt-4 max-w-xl text-ink-900/70">
            Réservez votre rendez-vous en ligne dès maintenant, choisissez votre prestation, votre créneau, et laissez-nous prendre soin de vous.
        </p>
        <a href="{{ route('booking.create') }}" class="btn-primary mt-8 inline-flex">Réserver mon rendez-vous</a>
    </section>

@endsection
