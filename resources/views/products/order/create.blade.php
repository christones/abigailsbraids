@extends('layouts.app')

@section('title', "Commander « {$product->name} » — Boutique Abigail's Braids")
@section('description', "Réservez le produit {$product->name} de la boutique Abigail's Braids et récupérez-le au salon.")

@section('content')
    <section class="relative overflow-hidden py-16">
        <div class="pointer-events-none absolute -top-24 -right-24 h-72 w-72 rounded-full bg-gold-200/40 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-rose-200/40 blur-3xl"></div>

        <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="section-eyebrow">Boutique</p>
                <h1 class="section-title mt-2">Commander un produit</h1>
                <p class="mx-auto mt-4 max-w-2xl text-ink-900/70">
                    Réservez votre produit en ligne : vous recevez un e-mail de confirmation, puis nous vous
                    prévenons dès que votre commande est prête à être récupérée au salon.
                </p>
            </div>

            <div class="mt-10 grid gap-8 lg:grid-cols-5">
                {{-- Produit --}}
                <aside class="card h-fit overflow-hidden lg:col-span-2">
                    <img
                        src="{{ $product->image_path ? asset($product->image_path) : 'https://placehold.co/600x450/faeadb/863f1f?text='.urlencode($product->name) }}"
                        alt="{{ $product->name }}"
                        class="h-60 w-full object-cover"
                    >
                    <div class="p-6">
                        @if ($product->category)
                            <p class="text-xs font-semibold uppercase tracking-widest text-brand-600">{{ $product->category->name }}</p>
                        @endif
                        <h2 class="mt-1 font-serif text-xl font-semibold text-ink-900">{{ $product->name }}</h2>
                        @if ($product->description)
                            <p class="mt-2 text-sm text-ink-900/60">{{ $product->description }}</p>
                        @endif
                        <div class="mt-4 flex items-center justify-between">
                            <span class="font-serif text-2xl font-semibold text-brand-700">{{ number_format((float) $product->price, 2, ',', ' ') }} €</span>
                            @if ($product->inStock())
                                <span class="text-xs font-medium text-green-600">En stock</span>
                            @else
                                <span class="text-xs font-medium text-red-500">Rupture de stock</span>
                            @endif
                        </div>
                    </div>
                </aside>

                {{-- Formulaire --}}
                <div class="lg:col-span-3">
                    @if ($errors->any())
                        <div class="mb-6 rounded-lg bg-red-50 p-4 text-sm text-red-800 ring-1 ring-red-600/20">
                            <p class="font-semibold">Votre commande n'a pas pu être enregistrée :</p>
                            <ul class="mt-2 list-inside list-disc">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($product->inStock())
                        <form method="POST" action="{{ route('product-order.store', $product) }}" class="card space-y-6 p-8">
                            @csrf

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="client_name" class="form-label">Nom et prénom</label>
                                    <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}" class="form-input mt-1" placeholder="Votre nom" required>
                                    @error('client_name') <p class="form-error">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="client_phone" class="form-label">Téléphone</label>
                                    <input type="tel" id="client_phone" name="client_phone" value="{{ old('client_phone') }}" class="form-input mt-1" placeholder="06 12 34 56 78" required>
                                    @error('client_phone') <p class="form-error">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="client_email" class="form-label">E-mail</label>
                                <input type="email" id="client_email" name="client_email" value="{{ old('client_email') }}" class="form-input mt-1" placeholder="vous@exemple.com" required>
                                <p class="mt-1 text-xs text-ink-900/50">Le récapitulatif de votre commande vous est envoyé à cette adresse.</p>
                                @error('client_email') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="sm:w-40">
                                <label for="quantity" class="form-label">Quantité</label>
                                <input type="number" id="quantity" name="quantity" min="1" max="{{ max(1, min(10, $product->stock_quantity)) }}" value="{{ old('quantity', 1) }}" class="form-input mt-1" required>
                                @error('quantity') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="notes" class="form-label">Message (optionnel)</label>
                                <textarea id="notes" name="notes" rows="3" class="form-input mt-1" placeholder="Une précision, un créneau pour passer au salon...">{{ old('notes') }}</textarea>
                                @error('notes') <p class="form-error">{{ $message }}</p> @enderror
                            </div>

                            <div class="rounded-xl bg-brand-50 p-4 text-sm text-ink-900/70">
                                Paiement et retrait au salon. Une seule commande en cours par produit et par cliente :
                                vous pourrez recommander ce produit une fois la commande précédente servie.
                            </div>

                            <button type="submit" class="btn-primary w-full sm:w-auto">Valider ma commande</button>
                        </form>
                    @else
                        <div class="card p-8 text-center">
                            <p class="font-serif text-lg font-semibold text-ink-900">Ce produit est en rupture de stock.</p>
                            <p class="mt-2 text-sm text-ink-900/60">Contactez-nous pour savoir quand il sera de nouveau disponible.</p>
                            <a href="{{ route('contact') }}" class="btn-secondary mt-6 inline-flex">Nous contacter</a>
                        </div>
                    @endif

                    <a href="{{ route('products.index') }}" class="mt-6 inline-block text-sm font-semibold text-brand-700 hover:text-brand-800">&larr; Retour à la boutique</a>
                </div>
            </div>
        </div>
    </section>
@endsection
