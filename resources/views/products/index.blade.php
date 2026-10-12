@extends('layouts.app')

@section('title', ($currentCategory ? $currentCategory->name.' — ' : '')."Boutique — Abigail's Braids")
@section('description', "Produits capillaires sélectionnés par Abigail's Braids : huiles, soins et accessoires pour prendre soin de vos cheveux entre deux rendez-vous.")

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <p class="section-eyebrow">Boutique</p>
            <h1 class="section-title mt-2">{{ $currentCategory?->name ?? 'Nos produits capillaires' }}</h1>
            <p class="mx-auto mt-4 max-w-2xl text-ink-900/70">
                @if ($currentCategory?->description)
                    {{ $currentCategory->description }}
                @else
                    Une sélection de soins et accessoires pour prendre soin de vos cheveux et de vos coiffures au
                    quotidien. Envie d'un produit ? Contactez-nous pour le réserver.
                @endif
            </p>

            @if ($categories->isNotEmpty())
                <nav class="mt-8 flex flex-wrap justify-center gap-2" aria-label="Catégories de produits">
                    <a
                        href="{{ route('products.index') }}"
                        class="rounded-full px-4 py-1.5 text-sm font-medium ring-1 {{ $currentCategory ? 'text-ink-900/70 ring-ink-900/15 hover:text-brand-700 hover:ring-brand-300' : 'bg-brand-600 text-white ring-brand-600' }}"
                        @if (! $currentCategory) aria-current="page" @endif
                    >
                        Tous les produits
                    </a>
                    @foreach ($categories as $category)
                        <a
                            href="{{ route('products.index', ['categorie' => $category->slug]) }}"
                            class="rounded-full px-4 py-1.5 text-sm font-medium ring-1 {{ $currentCategory?->is($category) ? 'bg-brand-600 text-white ring-brand-600' : 'text-ink-900/70 ring-ink-900/15 hover:text-brand-700 hover:ring-brand-300' }}"
                            @if ($currentCategory?->is($category)) aria-current="page" @endif
                        >
                            {{ $category->name }}
                        </a>
                    @endforeach
                </nav>
            @endif
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($products as $product)
                <div class="card card-hover flex flex-col overflow-hidden">
                    <img
                        src="{{ $product->image_path ? asset($product->image_path) : 'https://placehold.co/480x360/faeadb/863f1f?text='.urlencode($product->name) }}"
                        alt="{{ $product->name }}"
                        class="h-48 w-full object-cover"
                    >
                    <div class="flex flex-1 flex-col p-5">
                        <h2 class="font-serif text-lg font-semibold text-ink-900">{{ $product->name }}</h2>
                        <p class="mt-2 flex-1 text-sm text-ink-900/60">{{ \Illuminate\Support\Str::limit($product->description, 90) }}</p>
                        <div class="mt-4 flex items-center justify-between text-sm">
                            <span class="font-semibold text-brand-700">{{ number_format((float) $product->price, 2, ',', ' ') }} €</span>
                            @if ($product->inStock())
                                <span class="text-xs font-medium text-green-600">En stock</span>
                            @else
                                <span class="text-xs font-medium text-red-500">Rupture</span>
                            @endif
                        </div>
                        @if ($product->inStock())
                            <a href="{{ route('product-order.create', $product) }}" class="btn-primary mt-4 justify-center text-sm">
                                Commander
                            </a>
                        @else
                            <span class="btn-secondary mt-4 cursor-not-allowed justify-center text-sm opacity-60" aria-disabled="true">
                                Indisponible
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-ink-900/60">La boutique sera bientôt disponible.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-brand-50 py-16 text-center">
        <h2 class="section-title">Une question sur un produit ?</h2>
        <a href="{{ route('contact') }}" class="btn-primary mt-6 inline-flex">Nous contacter</a>
    </section>
@endsection
