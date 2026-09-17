@extends('layouts.app')

@section('title', "Nouvelle option — {$service->name} — Espace salon")

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Nouvelle option — {{ $service->name }}</h1>
            </div>
            <a href="{{ route('admin.services.options.index', $service) }}" class="btn-secondary text-sm">Retour</a>
        </div>

        <form method="POST" action="{{ route('admin.services.options.store', $service) }}" class="card mt-8 space-y-6 p-8">
            @csrf
            @include('admin.services.options._form')

            <button type="submit" class="btn-primary">Ajouter l'option</button>
        </form>
    </section>
@endsection
