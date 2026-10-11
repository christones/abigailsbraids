@extends('layouts.app')

@section('title', "Catégories de produits — Espace salon")

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Catégories de produits</h1>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn-secondary text-sm">Retour à la boutique</a>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800 ring-1 ring-green-600/20">
                {{ session('success') }}
            </div>
        @endif

        <p class="mt-6 text-sm text-ink-900/60">
            Les catégories regroupent les produits de la boutique (ex. Soins, Huiles, Accessoires...). Les quatre
            premières catégories (dans l'ordre ci-dessous) qui contiennent au moins un produit visible sont affichées
            sur la page d'accueil. Les produits d'une catégorie supprimée deviennent simplement "Non classés".
        </p>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.product-categories.create') }}" class="btn-primary text-sm">Ajouter une catégorie</a>
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-ink-900/5">
            <table class="min-w-full divide-y divide-ink-900/5 text-sm">
                <thead class="bg-brand-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-900/60">
                    <tr>
                        <th class="px-4 py-3">Ordre</th>
                        <th class="px-4 py-3">Photo</th>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Produits</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-900/5">
                    @forelse ($categories as $category)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="flex flex-col gap-0.5">
                                    <form method="POST" action="{{ route('admin.product-categories.move-up', $category) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-ink-900/50 hover:text-brand-700" title="Monter" aria-label="Monter">&uarr;</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.product-categories.move-down', $category) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-ink-900/50 hover:text-brand-700" title="Descendre" aria-label="Descendre">&darr;</button>
                                    </form>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <img
                                    src="{{ $category->image_path ? asset($category->image_path) : 'https://placehold.co/80x80/faeadb/863f1f?text=%20' }}"
                                    alt="{{ $category->name }}"
                                    class="h-12 w-12 rounded-lg object-cover"
                                >
                            </td>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ $category->products_count }}</td>
                            <td class="px-4 py-3">
                                @if ($category->is_active)
                                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-ink-900/10 px-2 py-0.5 text-xs font-medium text-ink-900/60">Masquée</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.product-categories.edit', $category) }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">Modifier</a>
                                <form method="POST" action="{{ route('admin.product-categories.destroy', $category) }}" class="mt-1" onsubmit="return confirm('Supprimer cette catégorie ? Les produits concernés resteront mais deviendront non classés.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-ink-900/50">Aucune catégorie pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
