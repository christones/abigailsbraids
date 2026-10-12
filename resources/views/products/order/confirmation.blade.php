@extends('layouts.app')

@section('title', "Commande enregistrée — Abigail's Braids")
@section('description', "Votre commande sur la boutique Abigail's Braids a bien été enregistrée.")

@section('content')
    <section class="mx-auto max-w-2xl px-4 py-20 text-center sm:px-6 lg:px-8">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-green-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>
        </div>

        <h1 class="section-title mt-6">Merci {{ $order->client_name }} !</h1>
        <p class="mt-4 text-ink-900/70">
            Votre commande a bien été enregistrée et un récapitulatif vous a été envoyé par e-mail.
            Nous vous prévenons dès qu'elle est prête à être récupérée au salon.
        </p>

        <div class="card mt-10 space-y-4 p-8 text-left">
            <h2 class="font-serif text-lg font-semibold text-ink-900">Récapitulatif — {{ $order->reference }}</h2>
            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-ink-900/50">Produit</dt>
                    <dd class="font-medium text-ink-900">{{ $order->product_name }}</dd>
                </div>
                <div>
                    <dt class="text-ink-900/50">Quantité</dt>
                    <dd class="font-medium text-ink-900">{{ $order->quantity }}</dd>
                </div>
                <div>
                    <dt class="text-ink-900/50">Total</dt>
                    <dd class="font-medium text-ink-900">{{ number_format((float) $order->total_price, 2, ',', ' ') }} €</dd>
                </div>
                <div>
                    <dt class="text-ink-900/50">Statut</dt>
                    <dd class="font-medium text-ink-900">{{ $order->statusLabel() }}</dd>
                </div>
                @if ($order->notes)
                    <div class="col-span-2">
                        <dt class="text-ink-900/50">Votre message</dt>
                        <dd class="font-medium text-ink-900">{{ $order->notes }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="mt-10 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('home') }}" class="btn-secondary">Retour à l'accueil</a>
            <a href="{{ route('products.index') }}" class="btn-primary">Continuer mes achats</a>
        </div>
    </section>
@endsection
