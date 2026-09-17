@extends('layouts.app')

@section('title', "Boutique — Abigail's Braids")
@section('description', "Produits capillaires sélectionnés par Abigail's Braids : huiles, soins et accessoires pour prendre soin de vos cheveux entre deux rendez-vous.")

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <p class="section-eyebrow">Boutique</p>
            <h1 class="section-title mt-2">Nos produits capillaires</h1>
            <p class="mx-auto mt-4 max-w-2xl text-ink-900/70">
                Une sélection de soins et accessoires pour prendre soin de vos cheveux et de vos coiffures au
                quotidien. Envie d'un produit ? Contactez-nous pour le réserver.
            </p>
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
                        <a
                            href="mailto:{{ config('salon.notification_email') }}?subject={{ rawurlencode('Commande : '.$product->name) }}"
                            class="btn-secondary mt-4 justify-center text-sm"
                        >
                            Commander par e-mail
                        </a>
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
