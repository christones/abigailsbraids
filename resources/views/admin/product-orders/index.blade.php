@extends('layouts.app')

@section('title', "Commandes boutique — Espace salon")

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Commandes de la boutique</h1>
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
        @if (session('error'))
            <div class="mt-6 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-800 ring-1 ring-red-600/20">
                {{ session('error') }}
            </div>
        @endif

        <p class="mt-6 max-w-3xl text-sm text-ink-900/60">
            Chaque changement de statut envoie automatiquement un e-mail à la cliente.
            Une cliente ne peut pas recommander le même produit tant que sa commande est « En attente » ou « Confirmée » :
            passez-la à « Servie » une fois le produit remis, ou à « Annulée » pour lui permettre de recommander.
        </p>

        <div class="mt-6 grid gap-4 sm:grid-cols-4">
            @foreach (\App\Models\ProductOrder::statusLabels() as $value => $label)
                <div class="card p-5">
                    <p class="text-sm text-ink-900/50">{{ $label }}</p>
                    <p class="mt-1 font-serif text-3xl font-semibold {{ $value === 'pending' ? 'text-brand-600' : ($value === 'cancelled' ? 'text-ink-900/40' : 'text-ink-900') }}">{{ $counts[$value] ?? 0 }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-8 flex flex-wrap gap-2">
            <a href="{{ route('admin.product-orders.index') }}" class="rounded-full px-4 py-1.5 text-sm {{ $status === '' ? 'bg-brand-600 text-white' : 'bg-white text-ink-900/70 ring-1 ring-ink-900/10' }}">Toutes</a>
            @foreach (\App\Models\ProductOrder::statusLabels() as $value => $label)
                <a
                    href="{{ route('admin.product-orders.index', ['statut' => $value]) }}"
                    class="rounded-full px-4 py-1.5 text-sm {{ $status === $value ? 'bg-brand-600 text-white' : 'bg-white text-ink-900/70 ring-1 ring-ink-900/10' }}"
                >
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="mt-6 overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-ink-900/5">
            <table class="min-w-full divide-y divide-ink-900/5 text-sm">
                <thead class="bg-brand-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-900/60">
                    <tr>
                        <th class="px-4 py-3">Commande</th>
                        <th class="px-4 py-3">Produit</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Statut</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-900/5">
                    @forelse ($orders as $order)
                        <tr class="{{ $order->status === 'cancelled' ? 'opacity-60' : '' }}">
                            <td class="px-4 py-3">
                                <div class="font-medium text-ink-900">{{ $order->reference }}</div>
                                <div class="text-xs text-ink-900/50">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img
                                        src="{{ $order->product?->image_path ? asset($order->product->image_path) : 'https://placehold.co/80x80/faeadb/863f1f?text=%20' }}"
                                        alt="{{ $order->product_name }}"
                                        class="h-10 w-10 flex-none rounded-lg object-cover"
                                    >
                                    <div>
                                        <div class="font-medium text-ink-900">{{ $order->product_name }}</div>
                                        <div class="text-xs text-ink-900/50">Qté {{ $order->quantity }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-ink-900/70">
                                <div class="font-medium text-ink-900">{{ $order->client_name }}</div>
                                <div><a href="tel:{{ $order->client_phone }}" class="hover:text-brand-700">{{ $order->client_phone }}</a></div>
                                <div class="text-xs text-ink-900/50"><a href="mailto:{{ $order->client_email }}" class="hover:text-brand-700">{{ $order->client_email }}</a></div>
                                @if ($order->notes)
                                    <div class="mt-1 max-w-xs text-xs italic text-ink-900/60">« {{ $order->notes }} »</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-medium text-ink-900">{{ number_format((float) $order->total_price, 2, ',', ' ') }} €</td>
                            <td class="px-4 py-3">
                                <form method="POST" action="{{ route('admin.product-orders.update', $order) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select
                                        name="status"
                                        onchange="this.form.submit()"
                                        aria-label="Statut de la commande {{ $order->reference }}"
                                        class="rounded-lg border-0 bg-brand-50 px-2 py-1 text-xs font-medium text-brand-800 ring-1 ring-inset ring-brand-200"
                                    >
                                        @foreach (\App\Models\ProductOrder::statusLabels() as $value => $label)
                                            <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('admin.product-orders.destroy', $order) }}" onsubmit="return confirm('Supprimer définitivement cette commande ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-600 hover:text-red-700">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-ink-900/50">Aucune commande pour le moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </section>
@endsection
