@extends('layouts.app')

@section('title', "Formations — Abigail's Braids")
@section('description', "Formations professionnelles et initiations au tressage africain chez Abigail's Braids à Strasbourg : box braids, knotless, cornrows et plus.")

@section('content')
    <section class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <p class="section-eyebrow">Formations</p>
            <h1 class="section-title mt-2">Apprenez l'art de la tresse</h1>
            <p class="mx-auto mt-4 max-w-2xl text-ink-900/70">
                Ouvertes à toutes, débutantes ou déjà initiées, nos formations vous transmettent les techniques
                du salon dans une ambiance bienveillante et professionnelle.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($trainings as $training)
                <div class="card card-hover flex flex-col overflow-hidden">
                    <img
                        src="{{ $training->image_path ? asset($training->image_path) : 'https://placehold.co/600x400/faeadb/863f1f?text='.urlencode($training->name) }}"
                        alt="{{ $training->name }}"
                        class="h-48 w-full object-cover"
                    >
                    <div class="flex flex-1 flex-col p-6">
                        @if ($training->level)
                            <span class="badge-gold self-start">{{ $training->level }}</span>
                        @endif
                        <h2 class="mt-3 font-serif text-xl font-semibold text-ink-900">{{ $training->name }}</h2>
                        <p class="mt-3 flex-1 text-sm text-ink-900/70">{{ $training->description }}</p>
                        <div class="mt-5 flex items-center justify-between text-sm">
                            <span class="text-base font-semibold text-brand-700">Dès {{ number_format((float) $training->price_from, 0, ',', ' ') }} €</span>
                            <span class="text-ink-900/50">{{ $training->durationLabel() }}</span>
                        </div>
                        <a href="{{ route('training.create', ['formation' => $training->id]) }}" class="btn-primary mt-5 justify-center">
                            S'inscrire à cette formation
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-ink-900/60">Les formations seront bientôt disponibles.</p>
            @endforelse
        </div>
    </section>

    <section class="bg-brand-50 py-16">
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="section-title">Une question sur nos formations ?</h2>
            <p class="mt-4 text-ink-900/70">Contactez-nous, nous serons ravies de vous orienter vers le parcours adapté.</p>
            <a href="{{ route('contact') }}" class="btn-secondary mt-6 inline-flex">Nous contacter</a>
        </div>
    </section>
@endsection
