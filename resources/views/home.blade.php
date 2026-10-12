@extends('layouts.app')

@section('title', "Abigail's Braids — Tresses africaines sur rendez-vous à Strasbourg")
@section('description', "Tresses et nattes africaines sur rendez-vous à Strasbourg. Box braids, knotless braids, vanilles, cornrows... Réservez votre rendez-vous en ligne pour toutes les femmes.")

@section('content')

    {{-- Hero slider --}}
    <section class="relative">
        <div class="hero-swiper swiper relative h-[70vh] min-h-[480px] w-full overflow-hidden">
            <div class="swiper-wrapper">
                @php
                    $bookingCta = ['label' => 'Prendre rendez-vous', 'url' => route('booking.create')];
                    $servicesCta = ['label' => 'Voir les prestations', 'url' => route('services.index')];

                    $heroSlides = [
                        ['eyebrow' => "Abigail's Braids · Strasbourg", 'title' => 'Sublimez vos cheveux', 'subtitle' => 'Tresses et nattes africaines réalisées avec soin, à Strasbourg', 'image' => 'images/braids18.jpg', 'primary' => $bookingCta, 'secondary' => $servicesCta],
                        ['eyebrow' => "Abigail's Braids · Strasbourg", 'title' => 'Box Braids & Knotless', 'subtitle' => 'Un style protecteur, élégant et durable', 'image' => 'images/braids1.jpg', 'primary' => $bookingCta, 'secondary' => $servicesCta],
                        ['eyebrow' => 'Formations', 'title' => 'Apprenez l\'art du tressage', 'subtitle' => 'Des formations pratiques, en petit groupe, pour maîtriser les techniques de tresses et nattes africaines — débutantes comme confirmées', 'image' => 'images/braids23.jpg', 'primary' => ['label' => 'Découvrir les formations', 'url' => route('trainings.index')], 'secondary' => ['label' => 'S\'inscrire', 'url' => route('training.create')]],
                        ['eyebrow' => 'Boutique', 'title' => 'Vos produits capillaires', 'subtitle' => 'Huiles, soins et accessoires sélectionnés par Abigail pour prendre soin de vos cheveux et de vos tresses au quotidien', 'image' => 'images/braids3.jpg', 'primary' => ['label' => 'Visiter la boutique', 'url' => route('products.index')], 'secondary' => ['label' => 'Voir les catégories', 'url' => route('products.categories')]],
                        ['eyebrow' => 'Boutique', 'title' => 'Prolongez la beauté de vos tresses', 'subtitle' => 'Hydratez, protégez et faites durer votre coiffure plus longtemps entre deux rendez-vous', 'image' => 'images/braids2.jpg', 'primary' => ['label' => 'Découvrir nos produits', 'url' => route('products.index')], 'secondary' => $bookingCta],
                        ['eyebrow' => "Abigail's Braids · Strasbourg", 'title' => 'Pour toutes les femmes', 'subtitle' => 'Chaque texture, chaque longueur, chaque envie mérite un beau résultat', 'image' => 'images/braids22.jpg', 'primary' => $bookingCta, 'secondary' => $servicesCta],
                    ];
                @endphp

                @foreach ($heroSlides as $slide)
                    <div class="swiper-slide relative flex items-center justify-center">
                        <img
                            src="{{ asset($slide['image']) }}"
                            alt=""
                            class="absolute inset-0 h-full w-full object-cover"
                            loading="{{ $loop->first ? 'eager' : 'lazy' }}"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-ink-900/80 via-ink-900/30 to-ink-900/10"></div>
                        <div class="relative z-10 mx-auto max-w-3xl px-6 text-center text-white">
                            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-200">{{ $slide['eyebrow'] }}</p>
                            @if ($loop->first)
                                <h1 class="mt-4 font-serif text-4xl font-semibold sm:text-6xl">{{ $slide['title'] }}</h1>
                            @else
                                <h2 class="mt-4 font-serif text-4xl font-semibold sm:text-6xl">{{ $slide['title'] }}</h2>
                            @endif
                            <p class="mt-4 text-lg text-white/90">{{ $slide['subtitle'] }}</p>
                            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                                <a href="{{ $slide['primary']['url'] }}" class="btn-primary">{{ $slide['primary']['label'] }}</a>
                                <a href="{{ $slide['secondary']['url'] }}" class="btn-secondary bg-white/10 text-white ring-white/40 hover:bg-white/20">{{ $slide['secondary']['label'] }}</a>
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

    {{-- Trust bar --}}
    <section class="bg-white py-8">
        <div class="mx-auto grid max-w-7xl grid-cols-2 gap-6 px-4 sm:px-6 lg:grid-cols-4 lg:px-8">
            @foreach ([
                ['icon' => 'M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z', 'title' => '100%', 'subtitle' => 'Pour toutes les femmes'],
                ['icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5', 'title' => '6j/7', 'subtitle' => 'Sur rendez-vous'],
                ['icon' => 'M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z', 'title' => 'Strasbourg', 'subtitle' => 'Sur rendez-vous'],
                ['icon' => 'M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 18 4.5h-2.25m-7.5 0h7.5m-7.5 0v13.5a2.25 2.25 0 0 0 2.25 2.25h4.5a2.25 2.25 0 0 0 2.25-2.25V4.5', 'title' => 'En ligne', 'subtitle' => 'Réservation 24/7'],
            ] as $stat)
                <div class="flex items-center gap-3">
                    <span class="flex h-11 w-11 flex-none items-center justify-center rounded-full bg-gold-100 text-gold-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $stat['icon'] }}" />
                        </svg>
                    </span>
                    <div>
                        <p class="font-serif text-lg font-semibold leading-tight text-ink-900">{{ $stat['title'] }}</p>
                        <p class="text-xs text-ink-900/60">{{ $stat['subtitle'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Promo boutique : les catégories de produits enregistrées en base (admin > Boutique > Catégories) --}}
    @php
        $placeholderTiles = [
            'images/boutique/placeholder-huile.svg',
            'images/boutique/placeholder-spray.svg',
            'images/boutique/placeholder-bonnet.svg',
            'images/boutique/placeholder-beurre.svg',
        ];

        // Jusqu'à 4 vignettes, une par catégorie (photo de la catégorie, sinon
        // celle de son premier produit, sinon une image tampon).
        $promoTiles = $promoCategories->take(4)->values()->map(fn ($category, $i) => [
            'label' => $category->name,
            'image' => $category->coverImagePath() ?? $placeholderTiles[$i % 4],
            'url' => $category->products_count > 0
                ? route('products.index', ['categorie' => $category->slug])
                : route('products.index'),
        ]);

        if ($promoTiles->isEmpty()) {
            $promoTiles = collect($placeholderTiles)->map(fn ($image) => [
                'label' => null,
                'image' => $image,
                'url' => route('products.index'),
            ]);
        }

        $promoColumns = [$promoTiles->values()->filter(fn ($t, $i) => $i % 2 === 0), $promoTiles->values()->filter(fn ($t, $i) => $i % 2 === 1)];
    @endphp
    <section class="relative overflow-hidden bg-brand-900 py-20 text-white">
        <div class="pointer-events-none absolute -left-24 -top-24 h-80 w-80 rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 right-0 h-96 w-96 rounded-full bg-gold-500/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div class="grid grid-cols-2 gap-4">
                    @foreach ($promoColumns as $column)
                        <div class="flex flex-col gap-4 {{ $loop->last ? 'mt-10' : '' }}">
                            @foreach ($column as $tile)
                                <a href="{{ $tile['url'] }}" class="group relative block overflow-hidden rounded-2xl shadow-lg ring-1 ring-white/10">
                                    <img
                                        src="{{ asset($tile['image']) }}"
                                        alt="{{ $tile['label'] ?? 'Boutique' }} — boutique Abigail's Braids"
                                        class="aspect-[4/5] w-full object-cover transition duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    >
                                    @if ($tile['label'])
                                        <div class="absolute inset-0 bg-gradient-to-t from-ink-900/80 via-ink-900/10 to-transparent"></div>
                                        <p class="absolute inset-x-0 bottom-0 p-4 font-serif text-lg font-semibold leading-tight">{{ $tile['label'] }}</p>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>

                <div class="text-center lg:text-left">
                    <p class="text-sm font-semibold uppercase tracking-widest text-brand-200">La boutique Abigail's Braids</p>
                    <h2 class="mt-2 font-serif text-3xl font-semibold sm:text-4xl">Tout pour sublimer vos cheveux, au même endroit</h2>
                    <p class="mt-4 text-white/80">
                        Une sélection de produits et d'accessoires choisis par Abigail, pour prendre soin de vos cheveux
                        et de votre style entre deux rendez-vous.
                    </p>

                    @if ($promoCategories->isNotEmpty())
                        <div class="mt-6 flex flex-wrap justify-center gap-2 lg:justify-start">
                            @foreach ($promoCategories as $category)
                                <a
                                    href="{{ $category->products_count > 0 ? route('products.index', ['categorie' => $category->slug]) : route('products.index') }}"
                                    class="rounded-full bg-white/10 px-4 py-1.5 text-sm font-medium text-white ring-1 ring-white/20 transition hover:bg-white/20"
                                >
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <ul class="mx-auto mt-6 max-w-md space-y-3 text-left text-sm text-white/90 lg:mx-0">
                        @foreach ([
                            'Des produits testés et approuvés au salon',
                            'Adaptés à toutes les textures, naturelles ou tressées',
                            'Conseils personnalisés pour choisir le bon produit',
                        ] as $point)
                            <li class="flex items-start gap-3">
                                <span class="mt-0.5 flex h-5 w-5 flex-none items-center justify-center rounded-full bg-gold-400 text-brand-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                </span>
                                {{ $point }}
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row lg:justify-start">
                        <a href="{{ route('products.index') }}" class="btn-primary bg-gold-400 text-brand-900 hover:bg-gold-300">
                            Visiter la boutique
                        </a>
                        <a href="{{ route('products.categories') }}" class="btn-secondary bg-white/10 text-white ring-white/40 hover:bg-white/20">
                            Voir les catégories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- About teaser --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -right-32 top-10 h-80 w-80 rounded-full bg-rose-100/60 blur-3xl"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div>
                <p class="section-eyebrow">Bienvenue</p>
                <h2 class="section-title mt-2">Une activité pensée pour toutes les femmes</h2>
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
                    <div class="card card-hover relative flex flex-col overflow-hidden">
                        @if ($service->slug === 'knotless-braids')
                            <span class="badge-gold absolute left-3 top-3 z-10">Populaire</span>
                        @endif
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

    {{-- Shop categories (boutique) --}}
    @if ($productCategories->isNotEmpty())
        <section class="py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <p class="section-eyebrow">Boutique</p>
                    <h2 class="section-title mt-2">Nos catégories de produits</h2>
                    <p class="mt-4 text-ink-900/70">
                        Tout ce qu’il faut pour vos cheveux et votre beauté, sélectionné par Abigail.
                        Choisissez une catégorie pour découvrir les produits.
                    </p>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($productCategories as $category)
                        @include('products.partials.category-card', ['category' => $category])
                    @endforeach
                </div>

                @if ($hasMoreProductCategories)
                    <div class="mt-10 text-center">
                        <a href="{{ route('products.categories') }}" class="btn-primary">Voir toutes les catégories</a>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- Gallery preview slider --}}
    <section class="{{ $productCategories->isNotEmpty() ? 'bg-white ' : '' }}py-20">
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

    {{-- CTA --}}
    <section class="mx-auto max-w-5xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <h2 class="section-title">Prête à changer de style ?</h2>
        <p class="mx-auto mt-4 max-w-xl text-ink-900/70">
            Réservez votre rendez-vous en ligne dès maintenant, choisissez votre prestation, votre créneau, et laissez-nous prendre soin de vous.
        </p>
        <a href="{{ route('booking.create') }}" class="btn-primary mt-8 inline-flex">Réserver mon rendez-vous</a>
    </section>

@endsection
