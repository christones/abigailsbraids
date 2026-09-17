@extends('layouts.app')

@section('title', "Boutique — Espace salon")

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Boutique</h1>
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
            <a href="{{ route('admin.products.create') }}" class="btn-primary text-sm">Ajouter un produit</a>
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-ink-900/5">
            <table class="min-w-full divide-y divide-ink-900/5 text-sm">
                <thead class="bg-brand-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-900/60">
                    <tr>
                        <th class="px-4 py-3">Photo</th>
                        <th class="px-4 py-3">Nom</th>
                        <th class="px-4 py-3">Prix</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-900/5">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-4 py-3">
                                <img
                                    src="{{ $product->image_path ? asset($product->image_path) : 'https://placehold.co/80x80/faeadb/863f1f?text=%20' }}"
                                    alt="{{ $product->name }}"
                                    class="h-12 w-12 rounded-lg object-cover"
                                >
                            </td>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ $product->name }}</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ number_format((float) $product->price, 2, ',', ' ') }} €</td>
                            <td class="px-4 py-3 text-ink-900/70">{{ $product->stock_quantity }}</td>
                            <td class="px-4 py-3">
                                @if ($product->is_active)
                                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-medium text-green-700">Active</span>
                                @else
                                    <span class="rounded-full bg-ink-900/10 px-2 py-0.5 text-xs font-medium text-ink-900/60">Masqué</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-medium text-brand-700 hover:text-brand-800">Modifier</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="mt-1" onsubmit="return confirm('Supprimer ce produit ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-ink-900/50">Aucun produit pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
