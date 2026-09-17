@extends('layouts.app')

@section('title', "Modifier une catégorie — Espace salon")

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Modifier « {{ $category->name }} »</h1>
            </div>
            <a href="{{ route('admin.service-categories.index') }}" class="btn-secondary text-sm">Retour</a>
        </div>

        <form method="POST" action="{{ route('admin.service-categories.update', $category) }}" class="card mt-8 space-y-6 p-8">
            @csrf
            @method('PATCH')
            @include('admin.service-categories._form')

            <button type="submit" class="btn-primary">Enregistrer les modifications</button>
        </form>
    </section>
@endsection
