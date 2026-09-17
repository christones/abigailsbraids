@extends('layouts.app')

@section('title', "Galerie — Espace salon")

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Galerie</h1>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary text-sm">Se déconnecter</button>
            </form>
        </div>

        @include('admin.partials.nav')

        @if (session('success'))
            <div class="mt-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800 ring-1 ring-green-600/20">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.gallery.create') }}" class="btn-primary text-sm">Ajouter une photo</a>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @forelse ($images as $image)
                <div class="card overflow-hidden">
                    <img src="{{ asset($image->image_path) }}" alt="{{ $image->label }}" class="aspect-square w-full object-cover">
                    <div class="p-3">
                        <p class="truncate text-sm font-medium text-ink-900">{{ $image->label ?: 'Sans légende' }}</p>
                        <p class="text-xs text-ink-900/50">
                            {{ $image->is_active ? 'Visible' : 'Masquée' }} · ordre {{ $image->sort_order }}
                        </p>
                        <div class="mt-2 flex items-center justify-between">
                            <a href="{{ route('admin.gallery.edit', $image) }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">Modifier</a>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $image) }}" onsubmit="return confirm('Supprimer cette photo ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-ink-900/60">Aucune photo pour le moment.</p>
            @endforelse
        </div>
    </section>
@endsection
