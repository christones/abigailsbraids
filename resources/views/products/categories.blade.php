@extends('layouts.app')

@section('title', "Catégories de produits — Boutique Abigail's Braids")
@section('description', "Toutes les catégories de produits capillaires de la boutique Abigail's Braids : soins, huiles, accessoires...")

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <p class="section-eyebrow">Boutique</p>
            <h1 class="section-title mt-2">Toutes nos catégories</h1>
            <p class="mx-auto mt-4 max-w-2xl text-ink-900/70">
                Choisissez une catégorie pour découvrir les produits capillaires correspondants.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($categories as $category)
                @include('products.partials.category-card', ['category' => $category])
            @empty
                <p class="col-span-full text-center text-ink-900/60">Les catégories de produits seront bientôt disponibles.</p>
            @endforelse
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('products.index') }}" class="btn-primary">Voir tous les produits</a>
        </div>
    </section>
@endsection
